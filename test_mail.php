<?php
include "config.php"; // Database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

// Function to fetch today's changes from audit tables
function getTodaysChanges($conn) {
    $changes = [];
    $today = date('Y-m-d');
    
    $auditTables = [
        'ELECTRICAL_AUDIT' => [
            'name' => 'Electrical Counter',
            'fields' => [
                'TYPE' => 'Type',
                'OWNER_SHIP' => 'Ownership',
                'STATUS' => 'Status',
                'CIRCUIT_BREAKER' => 'Circuit Breaker',
                'SERIAL_NUMBER' => 'Serial Number',
                'ATS_INSTALLER' => 'ATS Installer'
            ]
        ],
        'CABINET_AUDIT' => [
            'name' => 'Cabinet',
            'fields' => [
                'CABINET_TYPE' => 'Cabinet Type',
                'RECTIFIER_TYPE' => 'Rectifier Type',
                'AC_MODULE_QUANTITY' => 'AC Module Quantity',
                'SOLAR_MOUDULE_QUANTITY' => 'Solar Module Quantity',
                'DELTA_IP' => 'Delta IP',
                'HWAUEI_IP' => 'Huawei IP',
                'ELTEK_IP' => 'Eltek IP',
                'CABINET_CAGE' => 'Cabinet Cage',
                'MAIN' => 'Main Cabinet'
            ]
        ],
        // Add configurations for other audit tables similarly...
    ];

    foreach ($auditTables as $table => $config) {
        $sql = "SELECT CHANGED_BY, SITE_CODE, CHANGE_AT ";
        
        // Select all old and new fields
        $fields = [];
        foreach ($config['fields'] as $field => $label) {
            $fields[] = "OLD_$field, NEW_$field";
        }
        $sql .= implode(', ', $fields);
        
        $sql .= " FROM $table WHERE TRUNC(CHANGE_AT) = TO_DATE(:today, 'YYYY-MM-DD')";
        
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':today', $today);
        oci_execute($stmt);
        
        while ($row = oci_fetch_assoc($stmt)) {
            $changedBy = $row['CHANGED_BY'];
            $siteCode = $row['SITE_CODE'];
            $changeTime = $row['CHANGE_AT']->format('Y-m-d H:i:s');
            
            foreach ($config['fields'] as $field => $label) {
                $oldKey = "OLD_$field";
                $newKey = "NEW_$field";
                
                if (isset($row[$oldKey]) && isset($row[$newKey]) && $row[$oldKey] != $row[$newKey]) {
                    $changes[] = [
                        'changed_by' => $changedBy,
                        'site_code' => $siteCode,
                        'change' => $config['name'] . ' - ' . $label,
                        'old_value' => $row[$oldKey],
                        'new_value' => $row[$newKey],
                        'change_time' => $changeTime
                    ];
                }
            }
        }
    }
    return $changes;
}

// ============ MAIN EXECUTION ============
$changes = getTodaysChanges($conn);
$testMode = true; // Set to false in production

if ($testMode || !empty($changes)) {
    $subject = ($testMode ? "[TEST] " : "") . "Daily Power Backup Audit Report - " . date('Y-m-d');
    
    // Build HTML content
    $htmlContent = "<html><head><style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #dddddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style></head><body>";
    
    $htmlContent .= "<h2>Daily Power Backup Audit Report" . ($testMode ? " (TEST)" : "") . "</h2>";
    
    if (empty($changes)) {
        $htmlContent .= "<p>No changes recorded today.</p>";
    } else {
        $htmlContent .= "<table>
            <tr>
                <th>Changed By</th>
                <th>Site Code</th>
                <th>Component - Field</th>
                <th>Old Value</th>
                <th>New Value</th>
                <th>Date/Time</th>
            </tr>";
        
        foreach ($changes as $change) {
            $htmlContent .= "<tr>
                <td>{$change['changed_by']}</td>
                <td>{$change['site_code']}</td>
                <td>{$change['change']}</td>
                <td>{$change['old_value']}</td>
                <td>{$change['new_value']}</td>
                <td>{$change['change_time']}</td>
            </tr>";
        }
        $htmlContent .= "</table>";
    }
    $htmlContent .= "</body></html>";

    // Configure mailer
    $mail = new PHPMailer(true);
    try {
        // MTN Syria SMTP Configuration
        $mail->isSMTP();
        $mail->Host = '10.11.200.212';
        $mail->Port = 25;
        $mail->SMTPAuth = false;
        $mail->SMTPSecure = false;
        
        // Sender
        $mail->setFrom('Database@NTQuality.com', 'Power Backup System');
        
        // Recipients
        $mail->addAddress('tkadilo@mtn.com.sy');
        if (!$testMode) {
            $mail->addCC('hwahby@mtn.com.sy');
            // $mail->addCC('other-recipient@mtn.com.sy');
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlContent;
        $mail->AltBody = strip_tags($htmlContent);

        // Send email
        if ($mail->send()) {
            echo "SUCCESS: Email sent";
            if ($testMode) echo " (TEST MODE)";
        }
    } catch (Exception $e) {
        echo "Email sending failed. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "No changes to report today.";
}
?>