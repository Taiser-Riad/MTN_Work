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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Network BI System | Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #06d6a0;
            --danger: #ef476f;
            --card-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d1b2a, #1b263b);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(67, 97, 238, 0.2) 0%, rgba(67, 97, 238, 0) 70%);
            z-index: 1;
        }
        
        body::after {
            content: '';
            position: absolute;
            bottom: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(76, 201, 240, 0.2) 0%, rgba(76, 201, 240, 0) 70%);
            z-index: 1;
        }
        
        .container {
            display: flex;
            max-width: 1200px;
            width: 100%;
            min-height: 700px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            z-index: 10;
            position: relative;
        }
        
        .graphic-side {
            flex: 1;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .graphic-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxjaXJjbGUgY3g9IjIwIiBjeT0iMjAiIHI9IjEiIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
            opacity: 0.2;
        }
        
        .logo-container {
            position: absolute;
            top: 30px;
            left: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 2;
        }
        
        .logo-circle {
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .logo-circle i {
            font-size: 1.8rem;
            color: var(--primary);
        }
        
        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }
        
        .content-wrapper {
            position: relative;
            z-index: 2;
            max-width: 500px;
            margin: 0 auto;
            width: 100%;
        }
        
        .tagline {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.85);
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            padding: 8px 16px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .graphic-side h1 {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .graphic-side p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 40px;
            line-height: 1.6;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            color: var(--primary);
            font-size: 1.4rem;
        }
        
        .feature-card h3 {
            color: white;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }
        
        .feature-card p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.75);
            margin: 0;
        }
        
        .form-side {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--light);
        }
        
        .form-header {
            margin-bottom: 40px;
        }
        
        .form-header h2 {
            font-size: 2.2rem;
            color: var(--dark);
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .form-header p {
            color: #6c757d;
            font-size: 1rem;
            line-height: 1.6;
        }
        
        .form-content {
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
        }
        
        .input-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .input-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.95rem;
        }
        
        .input-container {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 18px;
            z-index: 2;
        }
        
        .input-field {
            width: 100%;
            padding: 16px 20px 16px 52px;
            border: 2px solid #e9ecef;
            border-radius: 14px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            position: relative;
            z-index: 1;
        }
        
        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
        }
        
        .error-message {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 8px;
            display: block;
        }
        
        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            cursor: pointer;
            z-index: 2;
        }
        
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .remember-checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #dee2e6;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .remember-checkbox.checked {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .remember-checkbox.checked i {
            display: block;
            color: white;
            font-size: 12px;
        }
        
        .remember-checkbox i {
            display: none;
        }
        
        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .forgot-link:hover {
            color: var(--secondary);
            text-decoration: underline;
        }
        
        .login-button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
        }
        
        .login-button::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(rgba(255,255,255,0.1), rgba(255,255,255,0));
            transform: rotate(30deg);
            transition: all 0.5s ease;
        }
        
        .login-button:hover::after {
            transform: rotate(30deg) translate(20%, 20%);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 30px 0;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #dee2e6;
        }
        
        .divider span {
            padding: 0 15px;
        }
        
        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            border: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #495057;
            transition: all 0.3s ease;
            background: white;
        }
        
        .social-btn:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            color: var(--primary);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 1rem;
            color: var(--dark);
        }
        
        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        
        .register-link a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }
        
        .footer {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            z-index: 2;
        }
        
        .footer a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.2s;
        }
        
        .footer a:hover {
            color: var(--accent);
            text-decoration: underline;
        }
        
        /* Animation for floating elements */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .feature-card:nth-child(1) {
            animation: float 6s ease-in-out infinite;
        }
        
        .feature-card:nth-child(2) {
            animation: float 6s ease-in-out infinite 1s;
        }
        
        .feature-card:nth-child(3) {
            animation: float 6s ease-in-out infinite 2s;
        }
        
        .feature-card:nth-child(4) {
            animation: float 6s ease-in-out infinite 3s;
        }
        
        /* Responsive design */
        @media (max-width: 992px) {
            .container {
                flex-direction: column;
                max-width: 600px;
            }
            
            .graphic-side {
                padding: 30px;
            }
            
            .form-side {
                padding: 40px 30px;
            }
            
            .content-wrapper {
                max-width: 100%;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .footer {
                position: relative;
                margin-top: 30px;
                color: var(--dark);
                bottom: 0;
                padding: 20px 0;
            }
            
            .footer a {
                color: var(--primary);
            }
        }
        
        @media (max-width: 576px) {
            .container {
                min-height: auto;
            }
            
            .graphic-side h1 {
                font-size: 2.2rem;
            }
            
            .form-header h2 {
                font-size: 1.8rem;
            }
            
            .options-row {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="graphic-side">
            <div class="logo-container">
                <div class="logo-circle">
                    <i class="fas fa-chart-network"></i>
                </div>
                <div class="logo-text">NetBI</div>
            </div>
            
            <div class="content-wrapper">
                <div class="tagline">Enterprise Network Intelligence</div>
                <h1>Transform Your Network Data into Actionable Insights</h1>
                <p>Advanced analytics platform for optimizing network performance, security, and business intelligence.</p>
                
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Real-time Analytics</h3>
                        <p>Monitor performance metrics in real-time</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <h3>Network Mapping</h3>
                        <p>Visualize your entire infrastructure</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Security Dashboard</h3>
                        <p>Proactive threat detection & prevention</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h3>Smart Alerts</h3>
                        <p>Instant notifications for critical events</p>
                    </div>
                </div>
            </div>
            
            <div class="footer">
                &copy; 2023 Network BI System. All rights reserved. | 
                <a href="#">Privacy Policy</a> | 
                <a href="#">Terms of Service</a>
            </div>
        </div>
        
        <div class="form-side">
            <div class="form-header">
                <h2>Welcome Back</h2>
                <p>Sign in to your account to continue to the Network BI Dashboard</p>
            </div>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-content">
                <div class="input-group">
                    <label for="username" class="input-label">Username</label>
                    <div class="input-container">
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <input type="text" name="username" id="username" class="input-field" placeholder="Enter your username" required>
                    </div>
                    <?php if (!empty($username_err)): ?>
                        <span class="error-message"><?php echo $username_err; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="input-group">
                    <label for="password" class="input-label">Password</label>
                    <div class="input-container">
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input type="password" name="password" id="password" class="input-field" placeholder="Enter your password" required>
                        <div class="password-toggle" id="passwordToggle">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <?php if (!empty($password_err)): ?>
                        <span class="error-message"><?php echo $password_err; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="options-row">
                    <div class="remember-me">
                        <div class="remember-checkbox" id="rememberCheckbox">
                            <i class="fas fa-check"></i>
                        </div>
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>
                
                <button type="submit" class="login-button">
                    Sign In to Dashboard
                </button>
                
                <div class="divider">
                    <span>or continue with</span>
                </div>
                
                <div class="social-login">
                    <a href="#" class="social-btn">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="#" class="social-btn">
                        <i class="fab fa-microsoft"></i>
                    </a>
                    <a href="#" class="social-btn">
                        <i class="fab fa-apple"></i>
                    </a>
                </div>
                
                <div class="register-link">
                    Don't have an account? <a href="register.php">Sign up now</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Password toggle visibility
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordField = document.getElementById('password');
        
        passwordToggle.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
        
        // Remember me checkbox
        const rememberCheckbox = document.getElementById('rememberCheckbox');
        
        rememberCheckbox.addEventListener('click', function() {
            this.classList.toggle('checked');
        });
        
        // Input field focus effect
        const inputFields = document.querySelectorAll('.input-field');
        
        inputFields.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.parentElement.classList.remove('focused');
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
        
        // Animate elements on load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.querySelector('.graphic-side').style.opacity = 1;
                document.querySelector('.form-side').style.opacity = 1;
            }, 300);
        });
    </script>
</body>
</html>