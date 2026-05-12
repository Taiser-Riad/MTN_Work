<?php
include "config.php";


// If already logged in, redirect them immediately to the Mainpage.
if (isset($_COOKIE['loggedInUser'])) {
    header("location: Mainpage.php?user=" . urlencode($_COOKIE['loggedInUser']));
    exit();
}


$username = $password = "";
$username_err = $password_err = "";
$login_error = "";


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
        $sql = "SELECT * FROM USERS WHERE USERNAME = :userr";
        $result = oci_parse($conn, $sql);
        oci_bind_by_name($result, ':userr', $username);
        oci_execute($result);
       
        // Fetch user data
        if ($row = oci_fetch_array($result)) {
            $db_userr = $row['USERNAME'];
            $db_dep = $row['DEPARTMENT'];
            $db_password = $row['PASS']; // This should now be a hashed password
           
            // Use password_verify() to check the password against the hash
            if (password_verify($password, $db_password)) {
                
                // --- SETS THE COOKIE SO THE BROWSER REMEMBERS THE LOGIN ---
                setcookie('loggedInUser', $db_userr, time() + (86400 * 30), "/"); // Expires in 30 days
                
                // Password is correct - redirect with username in URL only
                header("location: Mainpage.php?user=" . urlencode($db_userr));
                exit();
            } else {
                // Password incorrect
                $login_error = "Wrong Password";
                echo '<script>alert("Wrong Password")</script>';
            }
        } else {
            // No user found
            $login_error = "User Not Found";
            echo '<script>alert("User Not Found!!")</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MTN Syria Sites Management</title>
   
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;700;800&display=swap" rel="stylesheet">
   
    <style>
        :root {
            --primary: #1c355c; --primary-blue: #2563eb; --secondary: #ff6600; --accent: #f0b52d;
            --bg-body: #f8fafc; --bg-card: #ffffff; --text-main: #334155; --text-muted: #64748b;
            --border-color: #e2e8f0; --input-bg: #ffffff;
            --card-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        [data-theme="dark"] {
            --primary: #60a5fa; --primary-blue: #3b82f6; --secondary: #ff8533; --accent: #fcd34d;
            --bg-body: #0f172a; --bg-card: #1e293b; --text-main: #f8fafc; --text-muted: #94a3b8;
            --border-color: #334155; --input-bg: #0f172a;
            --card-shadow: 0 20px 25px -5px rgba(0,0,0,0.5);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: #daa520; color: var(--text-main); min-height: 100vh; display: flex; align-items: center; justify-content: center; transition: var(--transition); position: relative; overflow: hidden; }
        .bg-pattern { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: radial-gradient(var(--border-color) 1px, transparent 1px); background-size: 40px 40px; opacity: 0.4; z-index: 0; }
        .theme-toggle { position: absolute; top: 24px; right: 24px; background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: var(--transition); z-index: 10; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .theme-toggle:hover { filter: brightness(0.9); transform: scale(1.05); }
        .login-container { width: 100%; max-width: 440px; padding: 20px; z-index: 1; }
        .login-card { background: var(--bg-card); border-radius: 16px; box-shadow: var(--card-shadow); overflow: hidden; border: 1px solid var(--border-color); transition: var(--transition); animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .card-header { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 40px 30px 30px; text-align: center; border-bottom: 4px solid var(--primary-blue); }
        .logo-circle { width: 72px; height: 72px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
        .logo-circle i { font-size: 32px; color: var(--primary-blue); }
        .card-header h2 { color: white; font-family: 'Poppins', sans-serif; font-size: 1.4rem; font-weight: 700; margin: 0; letter-spacing: -0.5px; }
        .card-header p { color: #94a3b8; font-size: 0.9rem; margin-top: 6px; }
        .card-body { padding: 35px 30px; }
        .input-group { margin-bottom: 20px; position: relative; }
        .input-group label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; }
        .input-wrapper { position: relative; }
        
        /* Updated Input & Icon Styles for Show Password feature */
        .form-control { width: 100%; padding: 12px 45px 12px 45px; font-size: 1rem; border: 1px solid var(--border-color); border-radius: 8px; background-color: var(--input-bg); color: var(--text-main); transition: var(--transition); }
        .form-control:focus { outline: none; border-color: var(--primary-blue); box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }
        
        .input-wrapper .icon-left { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 1.1rem; transition: var(--transition); }
        .input-wrapper .toggle-password { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: var(--transition); }
        .input-wrapper .toggle-password:hover { color: var(--primary-blue); }
        
        .form-control:focus + .icon-left, 
        .input-wrapper:focus-within .icon-left,
        .input-wrapper:focus-within .toggle-password { color: var(--primary-blue); }


        .error-text { color: #ef4444; font-size: 0.8rem; font-weight: 500; margin-top: 6px; display: block; }
        .btn-submit { width: 100%; padding: 13px; background-color: var(--primary-blue); color: white; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: var(--transition); margin-top: 15px; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-submit:hover { background-color: #1d4ed8; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(37, 99, 235, 0.25); }
        .signup-text { text-align: center; margin-top: 25px; font-size: 0.9rem; color: var(--text-muted); }
        .signup-text a { color: var(--primary-blue); text-decoration: none; font-weight: 600; transition: var(--transition); }
        .signup-text a:hover { text-decoration: underline; }
    </style>
</head>
<body>


    <div class="bg-pattern"></div>


    <button id="themeToggle" class="theme-toggle" title="Toggle Dark Mode">
        <i class="fas fa-moon"></i>
    </button>


    <div class="login-container">
        <div class="login-card">
           
            <div class="card-header">
                <div class="logo-circle">
                    <i class="fas fa-network-wired"></i>
                </div>
                <h2>Network Database System</h2>
                <p>Sign in to manage your site architecture</p>
            </div>


            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                   
                    <div class="input-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" value="<?php echo htmlspecialchars($username); ?>">
                            <i class="fas fa-user icon-left"></i>
                        </div>
                        <?php if(!empty($username_err)): ?>
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> <?php echo $username_err; ?></span>
                        <?php endif; ?>
                    </div>


                    <div class="input-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" class="form-control password-input" placeholder="Enter your password">
                            <i class="fas fa-lock icon-left"></i>
                            <i class="fas fa-eye toggle-password" id="togglePassword" title="Show/Hide Password"></i>
                        </div>
                        <?php if(!empty($password_err)): ?>
                            <span class="error-text"><i class="fas fa-exclamation-circle"></i> <?php echo $password_err; ?></span>
                        <?php endif; ?>
                    </div>


                    <button type="submit" name="submit" class="btn-submit">
                        Secure Login <i class="fas fa-arrow-right"></i>
                    </button>


                    <div class="signup-text">
                        Don't have an account? <a href="register.php">Request Access</a>
                    </div>


                </form>
            </div>
           
        </div>
    </div>


    <script>
        // Theme Toggle Logic
        const themeToggleBtn = document.getElementById('themeToggle');
        const themeIcon = themeToggleBtn.querySelector('i');
        const htmlElement = document.documentElement;


        const savedTheme = localStorage.getItem('site-manager-theme') || 'light';
        applyTheme(savedTheme);


        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            applyTheme(currentTheme);
        });


        function applyTheme(theme) {
            htmlElement.setAttribute('data-theme', theme);
            localStorage.setItem('site-manager-theme', theme);
           
            if (theme === 'dark') {
                themeIcon.classList.replace('fa-moon', 'fa-sun');
                themeIcon.style.color = '#fcd34d';
            } else {
                themeIcon.classList.replace('fa-sun', 'fa-moon');
                themeIcon.style.color = '';
            }
        }


        // Show/Hide Password Logic
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');


        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the eye / eye-slash icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>



