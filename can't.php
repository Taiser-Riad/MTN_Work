
<?php 
include "config.php";
?>
<?php
  if(isset($_GET['user_id']))
  {
  $userid =$_GET['user_id'];
  $sqll= "SELECT * FROM USERS WHERE USER_ID= :userid";
  $result = oci_parse($conn,$sqll);
  oci_bind_by_name($result, ':userid' ,$userid);
  oci_execute($result);
  $row112 = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);
  $userrname = $row112['USERNAME'];
  $dep = $row112['DEPARTMENT'];
  $user_id =  $row112['USER_ID'];
  }


if(isset($_GET['id']))
{
$siteid =$_GET['id'];
$sqll= "SELECT * FROM NEW_SITES WHERE ID= :siteid";
$result = oci_parse($conn,$sqll);
oci_bind_by_name($result, ':siteid' ,$siteid);
oci_execute($result);
$row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);

$orginal_sitecode = $row['SITE_CODE'];
//$original_PID     = $row['SID'];
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied | MTN Syria</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
    :root {
        --primary: #1c355c;
        --secondary: #ff6600;
        --accent: #f0b52d;
        --error: #dc3545;
        --light: #f5f7fb;
        --dark: #212529;
        --gray: #6c757d;
        --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: goldenrod;
        color: var(--dark);
        line-height: 1.6;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .container {
        max-width: 600px;
        width: 90%;
        background: white;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        text-align: center;
    }

    /* Header Styles */
    .header {
        background: linear-gradient(135deg, var(--primary) 0%, #0d1a30 100%);
        color: white;
        padding: 40px 20px;
        position: relative;
    }

    .header h1 {
        font-size: 2.2rem;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .header p {
        font-size: 1.1rem;
        max-width: 500px;
        margin: 0 auto 30px;
        opacity: 0.9;
    }

    /* Error Icon */
    .error-icon {
        font-size: 5rem;
        color: var(--error);
        margin: 20px 0;
        animation: pulse 1.5s ease infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* Message Box */
    .message-box {
        background: rgba(220, 53, 69, 0.1);
        border-left: 4px solid var(--error);
        padding: 20px;
        margin: 0 20px 30px;
        border-radius: 0 8px 8px 0;
        text-align: left;
    }

    .message-box p {
        margin-bottom: 10px;
    }

    .message-box strong {
        color: var(--error);
    }

    /* Button Styles */
    .btn {
        display: inline-block;
        padding: 12px 30px;
        background: white;
        color: var(--primary);
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin: 10px 5px;
    }

    .btn:hover {
        background: #f0f4ff;
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: #152a50;
    }

    /* Footer */
    .footer {
        background: var(--primary);
        color: white;
        padding: 15px;
        text-align: center;
        font-size: 0.9rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header h1 {
            font-size: 1.8rem;
        }
        
        .header p {
            font-size: 1rem;
        }
        
        .error-icon {
            font-size: 4rem;
        }
    }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1>Access Denied</h1>
            <p>Update request could not be processed</p>
        </div>

        <!-- Message Box -->
        <div class="message-box">
            <p><strong>Restricted Update</strong></p>
            <p>You cannot update this site's information because it is outside your authorized province.</p>
            <p>Please contact your supervisor or the regional administrator if you need access to this site.</p>
        </div>

        <!-- Action Buttons -->
        <div>
            <button class="btn btn-primary" onclick="window.close();">
                <i class="fas fa-times"></i> Close
            </button>
           
            <button class="btn" onclick="window.location.href='addpower.php?id=<?php echo $siteid; ?>&user_id=<?php echo $user_id; ?>';">
                <i class="fas fa-arrow-left"></i> Go Back
            </button>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> MTN Syria - Network Division</p>
        </div>
    </div>

    <script>
    // Add animation delay for better effect
    document.addEventListener('DOMContentLoaded', function() {
        const icon = document.querySelector('.error-icon');
        setTimeout(() => {
            icon.style.animation = 'pulse 1.5s ease infinite';
        }, 100);
    });
    </script>
</body>
</html>