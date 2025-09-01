<?php
// Database configuration
$username = "C##Hadeel";
$password = "MTN";
$connection_string = "//localhost/sitem";

// Connect to Oracle
$conn = oci_connect($username, $password, $connection_string, 'AL32UTF8');

if (!$conn) {
    $e = oci_error();
    die("Connection failed: " . $e['message']);
}

// Load PHPMailer (adjust path as needed)
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load configuration from secure file
require_once 'secure_config.php';

// Function to send email
function sendUpdateEmail($site_id, $site_code, $changes) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings for MTN Outlook
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;
        
        // Recipients
        $mail->setFrom(FROM_EMAIL, SITE_NAME);
        $mail->addAddress(ADMIN_EMAIL);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = "Database Update Notification: $site_code";
        
        $message = "<html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                h2 { color: #1a2a6c; }
                table { border-collapse: collapse; width: 100%; margin: 15px 0; }
                th { background-color: #2c3e50; color: white; padding: 10px; text-align: left; }
                td { padding: 8px; border: 1px solid #ddd; }
                tr:nth-child(even) { background-color: #f2f2f2; }
                .notification { background-color: #e8f4fc; border-left: 4px solid #3498db; padding: 15px; margin: 15px 0; }
            </style>
        </head>
        <body>
            <h2>Database Update Notification</h2>
            <div class='notification'>
                <p>A site in the database has been updated:</p>
                <table>
                    <tr><td><strong>Site ID:</strong></td><td>$site_id</td></tr>
                    <tr><td><strong>Site Code:</strong></td><td>$site_code</td></tr>
                    <tr><td><strong>Updated At:</strong></td><td>" . date('Y-m-d H:i:s') . "</td></tr>
                </table>
            </div>";
        
        if (!empty($changes)) {
            $message .= "<h3>Changes Detected:</h3>
                <table>
                    <tr>
                        <th>Field</th>
                        <th>Old Value</th>
                        <th>New Value</th>
                    </tr>";
            
            foreach ($changes as $field => $values) {
                $message .= "<tr>
                    <td>$field</td>
                    <td>" . htmlspecialchars($values['old']) . "</td>
                    <td>" . htmlspecialchars($values['new']) . "</td>
                </tr>";
            }
            
            $message .= "</table>";
        }
        
        $message .= "<p>This is an automated notification. Please do not reply.</p>
            <p><strong>MTN Database Management System</strong></p>
        </body>
        </html>";
        
        $mail->Body = $message;
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email Error: " . $e->getMessage());
        return false;
    }
}

// Simulate update
if (isset($_POST['simulate_update'])) {
    $site_id = 123;
    $site_code = 'SITE-001';
    
    $changes = [
        'site_name' => ['old' => 'Old Site Name', 'new' => 'New Site Name'],
        'power_backup' => ['old' => 'Generator', 'new' => 'Solar'],
        'coordinates' => ['old' => '40.7128° N, 74.0060° W', 'new' => '40.7128° N, 74.0060° E'],
    ];
    
    $email_sent = sendUpdateEmail($site_id, $site_code, $changes);
    $message = $email_sent ? 
        "<div class='notification success'>Email notification sent successfully!</div>" : 
        "<div class='notification error'>Failed to send email notification. Check server logs.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTN - Database Update Tracker</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 900px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .header {
            background: #1a2a6c;
            background: linear-gradient(to right, #1a2a6c, #b21f1f);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .mtn-logo {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 2rem;
            color: #ffcc00;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .notification-bell {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2rem;
            color: #ffcc00;
            animation: ring 2s infinite;
        }
        
        @keyframes ring {
            0% { transform: rotate(0); }
            5% { transform: rotate(30deg); }
            10% { transform: rotate(-30deg); }
            15% { transform: rotate(30deg); }
            20% { transform: rotate(-30deg); }
            25% { transform: rotate(0); }
            100% { transform: rotate(0); }
        }
        
        .content {
            padding: 30px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #1a2a6c;
        }
        
        .card h2 {
            color: #1a2a6c;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-weight: 600;
        }
        
        .card h2 i {
            margin-right: 10px;
            color: #1a2a6c;
        }
        
        .card p {
            line-height: 1.6;
            color: #444;
            margin-bottom: 15px;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 25px 0;
        }
        
        .feature {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s;
            border: 1px solid #e1e6ed;
        }
        
        .feature:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .feature i {
            font-size: 2.5rem;
            color: #1a2a6c;
            margin-bottom: 15px;
        }
        
        .feature h3 {
            color: #1a2a6c;
            margin-bottom: 10px;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(to right, #1a2a6c, #b21f1f);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            margin-top: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }
        
        .btn-block {
            display: block;
            width: 100%;
            text-align: center;
        }
        
        .notification {
            background: #e8f4fc;
            border-left: 4px solid #1a2a6c;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .notification.success {
            border-left-color: #2ecc71;
            background-color: #e8f8ef;
        }
        
        .notification.error {
            border-left-color: #e74c3c;
            background-color: #fceae9;
        }
        
        .notification h3 {
            color: #1a2a6c;
            margin-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #1a2a6c;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            background-color: #f8f9fa;
        }
        
        .footer {
            background: #1a2a6c;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
        }
        
        .email-preview {
            background: #f8f9fa;
            border: 1px solid #1a2a6c;
            border-radius: 8px;
            padding: 20px;
            margin-top: 25px;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .db-status {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            background: #e8f4fc;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #1a2a6c;
        }
        
        .db-status .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 10px;
            background-color: #2ecc71;
        }
        
        .db-status .status-text {
            font-weight: 500;
            color: #1a2a6c;
        }
        
        .security-note {
            background-color: #fff8e6;
            border-left: 4px solid #ffcc00;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .header {
                padding: 20px;
            }
            
            .content {
                padding: 20px;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="mtn-logo">
                <i class="fas fa-tower-cell"></i> MTN
            </div>
            <div class="notification-bell">
                <i class="fas fa-bell"></i>
            </div>
            <h1>Database Update Tracker</h1>
            <p>Get notified immediately when changes occur in MTN's Oracle database</p>
        </div>
        
        <div class="content">
            <div class="db-status">
                <div class="status-indicator"></div>
                <div class="status-text">Connected to Oracle Database: <?php echo $connection_string; ?></div>
            </div>
            
            <div class="security-note">
                <i class="fas fa-shield-alt"></i> <strong>Security Note:</strong> Email credentials are stored securely outside the web root. Never store passwords in source code.
            </div>
            
            <div class="card">
                <h2><i class="fas fa-info-circle"></i> How It Works</h2>
                <p>This system automatically sends email notifications to administrators whenever updates occur in MTN's Oracle database. The email includes details of what was changed, when it was changed, and which record was affected.</p>
                
                <div class="features">
                    <div class="feature">
                        <i class="fas fa-database"></i>
                        <h3>Oracle Integration</h3>
                        <p>Seamlessly connects to your Oracle database</p>
                    </div>
                    
                    <div class="feature">
                        <i class="fas fa-envelope"></i>
                        <h3>Instant Alerts</h3>
                        <p>Receive Outlook email notifications immediately after changes</p>
                    </div>
                    
                    <div class="feature">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Enhanced Security</h3>
                        <p>Secure credential management and encrypted connections</p>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-cogs"></i> Implementation</h2>
                <p>To implement this in your application, follow these steps:</p>
                
                <div class="notification">
                    <h3>Step 1: Add tracking to your update script</h3>
                    <p>In your database update code, add logic to capture changes:</p>
                    <pre style="background: #1a2a6c; color: white; padding: 15px; border-radius: 5px; overflow-x: auto;">
// Before updating, get current values
$sql_old = "SELECT * FROM NEW_SITES WHERE ID = :siteid";
$stmt_old = oci_parse($conn, $sql_old);
oci_bind_by_name($stmt_old, ':siteid', $siteid);
oci_execute($stmt_old);
$old_row = oci_fetch_array($stmt_old, OCI_ASSOC);

// Perform the update
// ... your update code ...

// Compare old and new values to detect changes
$changes = [];
foreach ($new_values as $field => $new_value) {
    if ($old_row[$field] != $new_value) {
        $changes[$field] = [
            'old' => $old_row[$field],
            'new' => $new_value
        ];
    }
}

// If there are changes, send notification
if (!empty($changes)) {
    sendUpdateEmail($siteid, $old_row['SITE_CODE'], $changes);
}</pre>
                </div>
                
                <div class="notification">
                    <h3>Step 2: Configure email settings</h3>
                    <p>Set up your SMTP credentials in a secure configuration file:</p>
                    <pre style="background: #1a2a6c; color: white; padding: 15px; border-radius: 5px; overflow-x: auto;">
// File: secure_config.php (outside web root)
&lt;?php
// Secure configuration for MTN Outlook
define('SMTP_HOST', 'smtp.office365.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tkadilo@mtn.com');
define('SMTP_PASS', 'your_password');
define('FROM_EMAIL', 'tkadilo@mtn.com');
define('ADMIN_EMAIL', 'admin@mtn.com');
define('SITE_NAME', 'MTN Database Tracker');
?></pre>
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-envelope"></i> Test Notification</h2>
                <p>Verify the notification system by simulating an update:</p>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="site_id">Site ID</label>
                        <input type="text" id="site_id" name="site_id" value="123" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="site_code">Site Code</label>
                        <input type="text" id="site_code" name="site_code" value="SITE-001" readonly>
                    </div>
                    
                    <button type="submit" name="simulate_update" class="btn btn-block">
                        <i class="fas fa-paper-plane"></i> Simulate Update and Send Test Email
                    </button>
                </form>
                
                <?php if (isset($message)): ?>
                    <?php echo $message; ?>
                <?php endif; ?>
                
                <div class="email-preview">
                    <h3>Sample Email Notification</h3>
                    <p><strong>Subject:</strong> Database Update Notification: SITE-001</p>
                    <p><strong>To:</strong> <?php echo ADMIN_EMAIL; ?></p>
                    <p><strong>From:</strong> <?php echo FROM_EMAIL; ?></p>
                    <hr style="margin: 15px 0; border-color: #ddd;">
                    <div style="font-family: Arial, sans-serif; line-height: 1.6;">
                        <h2 style="color: #1a2a6c;">Database Update Notification</h2>
                        <div style="background-color: #e8f4fc; border-left: 4px solid #3498db; padding: 15px; margin: 15px 0;">
                            <p>A site in the database has been updated:</p>
                            <table style="border-collapse: collapse; width: 100%;">
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Site ID:</strong></td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">123</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Site Code:</strong></td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">SITE-001</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Updated At:</strong></td>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><?php echo date('Y-m-d H:i:s'); ?></td>
                                </tr>
                            </table>
                        </div>
                        <h3>Changes Detected:</h3>
                        <table style="border-collapse: collapse; width: 100%;">
                            <tr style="background-color: #1a2a6c; color: white;">
                                <th style="padding: 10px; text-align: left;">Field</th>
                                <th style="padding: 10px; text-align: left;">Old Value</th>
                                <th style="padding: 10px; text-align: left;">New Value</th>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd;">site_name</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">Old Site Name</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">New Site Name</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 8px; border: 1px solid #ddd;">power_backup</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">Generator</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">Solar</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd;">coordinates</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">40.7128° N, 74.0060° W</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">40.7128° N, 74.0060° E</td>
                            </tr>
                        </table>
                        <p>This is an automated notification. Please do not reply.</p>
                        <p><strong>MTN Database Management System</strong></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>MTN Database Update Notification System &copy; <?php echo date('Y'); ?></p>
            <p>Securely connected as: <?php echo $username; ?></p>
        </div>
    </div>
</body>
</html>