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
    <title>Thank You | MTN Syria</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
    :root {
        --primary: #1c355c;
        --secondary: #ff6600;
        --accent: #f0b52d;
        --light: #f5f7fb;
        --dark: #212529;
        --gray: #6c757d;
        --success: #28a745;
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
        font-size: 2.5rem;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .header p {
        font-size: 1.1rem;
        max-width: 500px;
        margin: 0 auto 30px;
        opacity: 0.9;
    }

    /* Success Icon */
    .success-icon {
        font-size: 5rem;
        color: var(--success);
        margin: 20px 0;
        animation: bounce 1s ease;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
        40% {transform: translateY(-20px);}
        60% {transform: translateY(-10px);}
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
        margin-top: 10px;
    }

    .btn:hover {
        background: #f0f4ff;
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .btn:active {
        transform: translateY(1px);
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
            font-size: 2rem;
        }
        
        .header p {
            font-size: 1rem;
        }
        
        .success-icon {
            font-size: 4rem;
        }
        
        .btn {
            padding: 10px 25px;
        }
    }

    @media (max-width: 480px) {
        .header {
            padding: 30px 15px;
        }
        
        .header h1 {
            font-size: 1.8rem;
        }
        
        .success-icon {
            font-size: 3.5rem;
        }
    }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Thank You!</h1>
            <p>Your power backup data has been updated successfully</p>
         
            <!-- <button class="btn"  onclick="window.location.href='addpower.php?id='.$siteid.'&user_id='.$user_id;"> -->
            <button class="btn" onclick="window.location.href='addpower.php?id=<?php echo $siteid; ?>&user_id=<?php echo $user_id; ?>';">
            <!-- <button class="btn"  onclick="window.history()"> -->
  OK
</button>


        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> MTN Syria - Network Division</p>
        </div>
    </div>

    <script>
    // Add a slight delay to the bounce animation for better effect
    document.addEventListener('DOMContentLoaded', function() {
        const icon = document.querySelector('.success-icon');
        setTimeout(() => {
            icon.style.animation = 'bounce 1s ease';
        }, 100);
    });
    </script>
</body>
</html>