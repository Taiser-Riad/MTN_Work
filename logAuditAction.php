<?php
session_start(); // Required for user tracking

// Database connection
$username = "C##Hadeel";
$password = "MTN";
$connection_string = "//localhost/sitem";

$conn = oci_connect($username, $password, $connection_string, 'AL32UTF8');
if (!$conn) {
    $e = oci_error();
    die("Connection failed: " . $e['message']);
}

/**
 * Logs audit actions to the database
 * 
 * @param resource $conn Oracle connection
 * @param string $actionType UPDATE, INSERT, DELETE
 * @param string $tableName Table being modified
 * @param int $recordId ID of modified record
 * @param array $changes Associative array of field changes
 * @return bool True on success, false on failure
 */
function logAuditAction($conn, $actionType, $tableName, $recordId, $changes = []) {
    try {
        // Get user info
        $userId = $_SESSION['user_id'] ?? 'system';
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        
        // Insert main audit log
        $auditSql = "INSERT INTO audit_log (user_id, action_type, table_name, record_id, ip_address)
                     VALUES (:user_id, :action_type, :table_name, :record_id, :ip_address)
                     RETURNING audit_id INTO :audit_id";
        
        $auditStmt = oci_parse($conn, $auditSql);
        $auditId = null;
        
        oci_bind_by_name($auditStmt, ':user_id', $userId);
        oci_bind_by_name($auditStmt, ':action_type', $actionType);
        oci_bind_by_name($auditStmt, ':table_name', $tableName);
        oci_bind_by_name($auditStmt, ':record_id', $recordId);
        oci_bind_by_name($auditStmt, ':ip_address', $ipAddress);
        oci_bind_by_name($auditStmt, ':audit_id', $auditId, -1, SQLT_INT);
        
        if (!oci_execute($auditStmt)) {
            throw new Exception("Audit log failed: " . oci_error($auditStmt));
        }
        
        // Insert audit details if changes exist
        if (!empty($changes)) {
            $detailSql = "INSERT INTO audit_details (audit_id, field_name, old_value, new_value)
                          VALUES (:audit_id, :field_name, :old_value, :new_value)";
            
            $detailStmt = oci_parse($conn, $detailSql);
            
            foreach ($changes as $field => $values) {
                $oldValue = is_array($values) ? $values['old'] : null;
                $newValue = is_array($values) ? $values['new'] : $values;
                
                // Handle CLOB values if needed
                if (is_string($oldValue) && strlen($oldValue) > 4000) {
                    $oldLob = oci_new_descriptor($conn, OCI_D_LOB);
                    $oldLob->writeTemporary($oldValue, OCI_TEMP_CLOB);
                    oci_bind_by_name($detailStmt, ':old_value', $oldLob, -1, OCI_B_CLOB);
                } else {
                    oci_bind_by_name($detailStmt, ':old_value', $oldValue);
                }
                
                if (is_string($newValue) && strlen($newValue) > 4000) {
                    $newLob = oci_new_descriptor($conn, OCI_D_LOB);
                    $newLob->writeTemporary($newValue, OCI_TEMP_CLOB);
                    oci_bind_by_name($detailStmt, ':new_value', $newLob, -1, OCI_B_CLOB);
                } else {
                    oci_bind_by_name($detailStmt, ':new_value', $newValue);
                }
                
                oci_bind_by_name($detailStmt, ':audit_id', $auditId);
                oci_bind_by_name($detailStmt, ':field_name', $field);
                
                if (!oci_execute($detailStmt, OCI_NO_AUTO_COMMIT)) {
                    error_log("Audit detail failed: " . oci_error($detailStmt));
                }
                
                // Free LOB descriptors if used
                if (isset($oldLob)) $oldLob->free();
                if (isset($newLob)) $newLob->free();
            }
            
            oci_commit($conn); // Commit all detail inserts
        }
        
        return true;
    } catch (Exception $e) {
        error_log($e->getMessage());
        oci_rollback($conn);
        return false;
    }
}

/**
 * Displays audit log in HTML table format
 * 
 * @param resource $conn Oracle connection
 * @param array $filters Associative array of filters
 */
function displayAuditLog($conn, $filters = []) {
    $sql = "SELECT a.*, u.username 
            FROM audit_log a
            LEFT JOIN users u ON a.user_id = u.user_id
            WHERE 1=1";
    
    $params = [];
    
    if (!empty($filters['start_date'])) {
        $sql .= " AND a.action_time >= TO_DATE(:start_date, 'YYYY-MM-DD')";
        $params[':start_date'] = $filters['start_date'];
    }
    if (!empty($filters['end_date'])) {
        $sql .= " AND a.action_time <= TO_DATE(:end_date, 'YYYY-MM-DD')";
        $params[':end_date'] = $filters['end_date'];
    }
    if (!empty($filters['user_id'])) {
        $sql .= " AND a.user_id = :user_id";
        $params[':user_id'] = $filters['user_id'];
    }
    if (!empty($filters['action_type'])) {
        $sql .= " AND a.action_type = :action_type";
        $params[':action_type'] = $filters['action_type'];
    }
    if (!empty($filters['table_name'])) {
        $sql .= " AND a.table_name = :table_name";
        $params[':table_name'] = $filters['table_name'];
    }
    
    $sql .= " ORDER BY a.action_time DESC";
    
    $stmt = oci_parse($conn, $sql);
    
    // Bind filters
    foreach ($params as $key => $value) {
        oci_bind_by_name($stmt, $key, $value);
    }
    
    if (!oci_execute($stmt)) {
        echo "<p>Error loading audit log: " . oci_error($stmt) . "</p>";
        return;
    }
    
    echo '<table class="audit-table" style="width:100%;border-collapse:collapse;">';
    echo '<thead><tr style="background-color:#f2f2f2;">
            <th style="padding:10px;border:1px solid #ddd;">Timestamp</th>
            <th style="padding:10px;border:1px solid #ddd;">User</th>
            <th style="padding:10px;border:1px solid #ddd;">Action</th>
            <th style="padding:10px;border:1px solid #ddd;">Table</th>
            <th style="padding:10px;border:1px solid #ddd;">Record ID</th>
            <th style="padding:10px;border:1px solid #ddd;">IP Address</th>
            <th style="padding:10px;border:1px solid #ddd;">Details</th>
          </tr></thead><tbody>';
    
    $counter = 0;
    while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
        $bgColor = ($counter++ % 2 == 0) ? '#ffffff' : '#f9f9f9';
        echo '<tr style="background-color:'.$bgColor.';">';
        echo '<td style="padding:8px;border:1px solid #ddd;">' . $row['ACTION_TIME'] . '</td>';
        echo '<td style="padding:8px;border:1px solid #ddd;">' . htmlspecialchars($row['USERNAME'] ?? $row['USER_ID']) . '</td>';
        echo '<td style="padding:8px;border:1px solid #ddd;">' . $row['ACTION_TYPE'] . '</td>';
        echo '<td style="padding:8px;border:1px solid #ddd;">' . $row['TABLE_NAME'] . '</td>';
        echo '<td style="padding:8px;border:1px solid #ddd;">' . $row['RECORD_ID'] . '</td>';
        echo '<td style="padding:8px;border:1px solid #ddd;">' . $row['IP_ADDRESS'] . '</td>';
        echo '<td style="padding:8px;border:1px solid #ddd;">
                <button class="view-details" data-audit-id="' . $row['AUDIT_ID'] . '" 
                        style="padding:5px 10px;background:#4CAF50;color:white;border:none;border-radius:4px;cursor:pointer;">
                  View
                </button>
              </td>';
        echo '</tr>';
    }
    
    if ($counter === 0) {
        echo '<tr><td colspan="7" style="padding:20px;text-align:center;">No audit records found</td></tr>';
    }
    
    echo '</tbody></table>';
}

/**
 * Gets audit details for a specific audit log entry
 * 
 * @param resource $conn Oracle connection
 * @param int $auditId Audit log ID
 * @return array Array of detail records
 */
function getAuditDetails($conn, $auditId) {
    $sql = "SELECT field_name, old_value, new_value 
            FROM audit_details 
            WHERE audit_id = :audit_id";
    
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':audit_id', $auditId);
    
    if (!oci_execute($stmt)) {
        return [];
    }
    
    $details = [];
    while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
        $details[] = $row;
    }
    
    return $details;
}

// Test function - REMOVE IN PRODUCTION
function testAuditSystem($conn) {
    $_SESSION['user_id'] = 'test_user';
    
    // Simulate changes
    $changes = [
        'power_backup' => ['old' => 'Generator', 'new' => 'Solar'],
        'status' => ['old' => 'Active', 'new' => 'Maintenance']
    ];
    
    // Log test action
    $result = logAuditAction($conn, 'UPDATE', 'sites', 123, $changes);
    
    echo $result ? "Audit test successful!" : "Audit test failed";
}

// Uncomment to run test
testAuditSystem($conn);
?>