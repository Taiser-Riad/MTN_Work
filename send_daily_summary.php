<?php
date_default_timezone_set('Asia/Damascus');
include "config.php"; // Database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

function getTodaysChanges($conn) {
    $changes = [];
    $today = date('Y-m-d');
    $auditMaps = [
        'ELECTRICAL_AUDIT'  => 'Electrical Counter',
        'CABINET_AUDIT'     => 'Cabinet',
        'GENERTAOR_AUDIT'   => 'Generator',
        'TANK_AUDIT'        => 'Tank',
        'AMPERE_AUDIT'      => 'Ampere',
        'HYPRID_AUDIT'      => 'Hybrid/Solar',
        'BATTERIES_AUDIT'   => 'Batteries',
        'LINES_AUDIT'       => 'Power Lines'
    ];

    foreach ($auditMaps as $table => $componentName) {
        $sql = "SELECT * FROM $table WHERE TRUNC(CHANGE_AT) = TO_DATE(:today, 'YYYY-MM-DD')";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':today', $today);
        oci_execute($stmt);

        while ($row = oci_fetch_assoc($stmt)) {
            $site = $row['SITE_CODE'] ?? 'Unknown';
            $changeAt = $row['CHANGE_AT'] ?? null;
            $datetime  = $row['CHANGE_AT'] ?? 'N/A';
            
            // Extract username from common audit columns
            $user = 'System';
            $userColumns = ['USERNAME', 'CHANGED_BY', 'UPDATED_BY', 'MODIFIED_BY'];
            foreach ($userColumns as $col) {
                if (isset($row[$col])) {
                    $user = $row[$col];
                    break;
                }
            }

            foreach ($row as $col => $oldVal) {
                if (strpos($col, 'OLD_') !== 0) continue;
                
                $field = substr($col, 4);
                $newCol = 'NEW_' . $field;
                $newVal = $row[$newCol] ?? null;
                
                if ($newVal === null || $oldVal === $newVal) continue;
                
                $fieldName = ucwords(strtolower(str_replace('_', ' ', $field)));
                
                $changes[] = [
                    'site'      => $site,
                    'user'      => $user,
                    'component' => $componentName,
                    'field'     => $fieldName,
                    'old'       => $oldVal,
                    'new'       => $newVal,
                    'datetime'  => $datetime
                ];
            }
        }
        oci_free_statement($stmt);
    }
    return $changes;
}

// ============ MAIN EXECUTION ============
$changes = getTodaysChanges($conn);
$testMode = false; // Set to false in production

if ($testMode || !empty($changes)) {
    $subject = ($testMode ? "[TEST] " : "") 
             . "Daily Database Updates – " . date('Y-m-d');

    $html = "<h2>Power Backup System Daily Updates"
          . ($testMode ? " (TEST)" : "") . "</h2>";

    if (empty($changes)) {
        $html .= "<p>No changes detected today. This is a test notification.</p>";
    } else {
        $html .= "<table border='1' style='width:100%;border-collapse:collapse;'>
                    <tr style='background:#f2f2f2;'>
                      <th style='padding:8px;'>Site Code</th>
                      <th style='padding:8px;'>User</th>
                      <th style='padding:8px;'>Component</th>
                      <th style='padding:8px;'>Field</th>
                      <th style='padding:8px;'>Old Value</th>
                      <th style='padding:8px;'>New Value</th>
                      <th style='padding:8px;'>Change Time</th>
                    </tr>";

        foreach ($changes as $c) {
            $html .= "<tr>
                        <td style='padding:8px;'>{$c['site']}</td>
                        <td style='padding:8px;'>{$c['user']}</td>
                        <td style='padding:8px;'>{$c['component']}</td>
                        <td style='padding:8px;'>{$c['field']}</td>
                        <td style='padding:8px;'>{$c['old']}</td>
                        <td style='padding:8px;'>{$c['new']}</td>
                        <td style='padding:8px;'>{$c['datetime']}</td>
                      </tr>";
        }
        $html .= "</table>";
    }

    $mail = new PHPMailer(true);
    try {
        // MTN Syria SMTP Configuration
        $mail->isSMTP();
        $mail->Host = '10.11.200.212';
        $mail->Port = 25;
        $mail->SMTPAuth = false;
        $mail->SMTPSecure = false;
        $mail->SMTPAutoTLS = false;
        
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
        
        $mail->setFrom('Database@NTQuality.com', 'Network Database - power update');
        
        if ($testMode) {
            $mail->addAddress('NTQuality&Performance2@mtn.com.sy');
            $mail->addCC('tkadilo@mtn.com.sy');
        } else {
            $mail->addAddress('NTQuality&Performance2@mtn.com.sy');
            $mail->addCC('MObeid@mtn.com.sy');
            $mail->addCC('oeljarrah@mtn.com.sy');
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $html;
        $mail->Timeout = 30;
        $mail->AltBody = strip_tags($html);

        if ($mail->send()) {
            echo "SUCCESS: Email sent" . ($testMode ? " (TEST MODE)" : "");
        }
    } catch (Exception $e) {
        echo "<h3>Email Delivery Failed</h3>";
        echo "<p>Error: {$mail->ErrorInfo}</p>";
        
        echo "<h4>Troubleshooting Steps:</h4>";
        echo "<ol>
                <li>Verify SMTP server accessibility: <code>telnet 10.11.200.212 25</code></li>
                <li>Check network/firewall configurations</li>
                <li>Validate recipient email addresses</li>
                <li>Contact MTN IT department with error details</li>
              </ol>";
    }
} else {
    echo "No database changes to report today.";
}
?>