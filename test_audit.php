<?php
// test_audit.php
require 'logAuditAction.php';

// Simulate authenticated user
session_start();
$_SESSION['user_id'] = 'test_user';

// Simulate changes
$changes = [
    'power_backup' => ['old' => 'Generator', 'new' => 'Solar'],
    'status' => ['old' => 'Active', 'new' => 'Maintenance'],
    'notes' => [
        'old' => 'Old notes', 
        'new' => 'New detailed notes with more information'
    ]
];

// Log test action
$result = logAuditAction($conn, 'UPDATE', 'sites', 123, $changes);

if ($result) {
    echo "Audit logged successfully!<br><br>";
    
    // Display audit log
    echo "<h2>Audit Log</h2>";
    displayAuditLog($conn);
    
    // Get and display details for the first audit entry
    $sql = "SELECT audit_id FROM audit_log ORDER BY action_time DESC";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    $row = oci_fetch_array($stmt, OCI_ASSOC);
    
    if ($row) {
        $details = getAuditDetails($conn, $row['AUDIT_ID']);
        echo "<h2>Audit Details</h2>";
        echo "<pre>" . print_r($details, true) . "</pre>";
    }
} else {
    echo "Audit logging failed!";
}
?>