<?php
include "config.php";
session_start();

$username = $password = "";
$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql= "SELECT * FROM USERS WHERE USERNAME = :userr";
        $result = oci_parse($conn,$sql);
        oci_bind_by_name($result ,':userr' ,$username);
        oci_execute($result);
        $results = [];
        
        if ($row = oci_fetch_array($result)) {
            $results[] = $row;
            $db_userr = $results[0]['USERNAME'];
            $db_dep = $results[0]['DEPARTMENT'];
            $db_password = $results[0]['PASS'];
            
            if ($row['PASS'] == $password) {
                setcookie("loggedInUser", $db_userr, time() + 3600, "/");
                header("location:Mainpage.php?user=$db_userr");
            }
        }
        
        if (count($results) === 1) {
            if($db_userr == trim($_POST["username"]) && trim($_POST["password"]) == $db_password ){
                header("location:Mainpage.php?user=$db_userr");
            } elseif ($_POST["username"] == $db_userr && $_POST["password"] != $db_password) {
                echo '<script>alert("Wrong Password")</script>';
            }
        } else {
            echo '<script>alert("User Not Found!!")</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Network BI System - Login</title>
    <style>
        :root {
            --primary: #1c355c;
            --secondary: #2c5282;
            --accent: #ecc94b;
            --light: #f7fafc;
            --dark: #2d3748;
            --success: #48bb78;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1c355c, #0d1b2a);
            padding: 20px;
flex-wrap: wrap;
        }
        
        .system-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 0 20px;
        }
        
        .system-header h1 {
            font-size: 2.8rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            letter-spacing: 1px;
        }
        
        .system-header p {
            font-size: 1.2rem;
            color: var(--accent);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        .system-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .logo-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent), #d69e2e);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        
        .logo-circle i {
            font-size: 2.5rem;
            color: var(--primary);
        }
        
        .container {
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column;
        }
        
        .dashboard-preview {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            padding: 25px;
            color: white;
            text-align: center;
        }
        
        .dashboard-title {
            font-size: 1.8rem;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .dashboard-features {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        
        .feature {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(5px);
            padding: 15px;
            border-radius: 8px;
            width: 160px;
            transition: all 0.3s ease;
        }
        
        .feature:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.25);
        }
        
        .feature i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--accent);
        }
        
        .feature h3 {
            font-size: 1rem;
            margin-bottom: 5px;
        }
        
        .feature p {
            font-size: 0.85rem;
            opacity: 0.9;
        }
        
        .form-section {
            padding: 40px;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-header h2 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
        }
        
        .form-header p {
            color: var(--dark);
            font-size: 1rem;
        }
        
        .form-content {
            max-width: 400px;
            margin: 0 auto;
        }
        
        .input-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .input-box {
            position: relative;
        }
        
        .input-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 18px;
        }
        
        .input-box input {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .input-box input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(44, 82, 130, 0.2);
        }
        
        .error-message {
            color: #e53e3e;
            font-size: 0.9rem;
            margin-top: 5px;
            display: block;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 0.95rem;
        }
        
        .remember {
            display: flex;
            align-items: center;
        }
        
        .remember input {
            margin-right: 8px;
        }
        
        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .login-button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0,0,0,0.15);
            background: linear-gradient(to right, #152a4d, #1e4a82);
        }
        
        .register-link {
            text-align: center;
            margin-top: 25px;
            font-size: 1rem;
            color: var(--dark);
        }
        
        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            background: #f7fafc;
            color: var(--dark);
            font-size: 0.9rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        .quote {
            font-style: italic;
            margin-top: 15px;
            color: #4a5568;
            text-align: center;
            font-size: 0.95rem;
            padding: 0 20px;
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .dashboard-preview {
                padding: 20px;
            }
            
            .form-section {
                padding: 30px 20px;
            }
            
            .system-header h1 {
                font-size: 2.2rem;
            }
            
            .dashboard-title {
                font-size: 1.5rem;
            }
            
            .dashboard-features {
                gap: 10px;
            }
            
            .feature {
                width: 140px;
                padding: 12px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="system-header">
        <div class="system-logo">
            <div class="logo-circle">
                <i class="fas fa-chart-network"></i>
            </div>
        </div>
        <h1>Network BI System</h1>
        <p>Advanced business intelligence platform for network analytics and performance insights</p>
    </div>
    
    <div class="container">
        
        <div class="form-section">
            <div class="form-header">
                <h2>Login to Your Account</h2>
                <p>Enter your credentials to access the dashboard</p>
            </div>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-content">
                <div class="input-group">
                    <label for="username">Username</label>
                    <div class="input-box">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" id="username" placeholder="Enter your username" required>
                    </div>
                    <?php if (!empty($username_err)): ?>
                        <span class="error-message"><?php echo $username_err; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-box">
                        <i class="fas fa-key"></i>
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <?php if (!empty($password_err)): ?>
                        <span class="error-message"><?php echo $password_err; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="remember-forgot">
                    <div class="remember">
                        <input type="checkbox" id="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>
                
                <button type="submit" class="login-button">Login to Dashboard</button>
                
                <div class="register-link">
                    Don't have an account? <a href="register.php">Sign up now</a>
                </div>
            </form>
            
            <div class="quote">
                "Success is liking yourself, liking what you do, and liking how you do it. It always seems impossible until it's done."
            </div>
        </div>
        
        <div class="footer">
            &copy; 2023 Network BI System. All rights reserved. | 
            <a href="#">Privacy Policy</a> | 
            <a href="#">Terms of Service</a>
        </div>
    </div>
    
    <script>
        // Simple animation for input focus
        document.querySelectorAll('.input-box input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.border = '2px solid #2c5282';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.border = '2px solid #e2e8f0';
            });
        });
        
        // Button hover effect
        const loginButton = document.querySelector('.login-button');
        loginButton.addEventListener('mouseover', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        loginButton.addEventListener('mouseout', function() {
            this.style.transform = 'translateY(0)';
        });
    </script>
</body>
</html>