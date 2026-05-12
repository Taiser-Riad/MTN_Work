<?php
include "config.php";

// Fallback: If no user is in the URL but the cookie exists, redirect to include the user in the URL
if (!isset($_GET['user']) && isset($_COOKIE['loggedInUser'])) {
    header("location: Mainpage.php?user=" . urlencode($_COOKIE['loggedInUser']));
    exit();
}

if(isset($_GET['user']))
{
    $username = $_GET['user'];
    $sqll= "SELECT * FROM USERS WHERE USERNAME= :username";
    $result = oci_parse($conn,$sqll);
    oci_bind_by_name($result, ':username' ,$username);
    oci_execute($result);
    $row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);
   
    // Check if user exists to prevent undefined index errors
    if($row) {
        $userrname = $row['USERNAME'];
        $dep = $row['DEPARTMENT'];
        $user_id = $row['USER_ID'];
        $encodedUserId = base64_encode($user_id);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/all.min.css">
    <title>MTN Syria | Sites Management Platform</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary-dark: #0a2a44; --primary-hover: #0e3a5f; --accent: #daa520; --accent-light: #f0b82e;
            --text-light: #ffffff; --text-muted: #e2e8f0; --bg-light: #f8fafc;
            --card-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.1);
            --transition-default: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        body { margin: 0; font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif; line-height: 1.5; background-color: var(--bg-light); color: #1e293b; }
        html { scroll-behavior: smooth; }
        header { display: flex; position: sticky; top: 0; justify-content: space-between; align-items: center; background: rgba(10, 42, 68, 0.96); backdrop-filter: blur(12px); color: var(--text-light); padding: 8px 32px; z-index: 1100; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08); transition: var(--transition-default); border-bottom: 1px solid rgba(255, 255, 255, 0.08); }
        .brand-container { display: flex; align-items: center; gap: 16px; }
        header .logo { width: 48px; height: 48px; background: url('MTN_Logo.png') no-repeat center center/contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); transition: transform 0.2s; }
        .brand-title { font-size: 1.55rem; font-weight: 700; letter-spacing: -0.3px; background: linear-gradient(135deg, #fff 70%, var(--accent)); background-clip: text; -webkit-background-clip: text; color: transparent; text-shadow: none; }
        nav.primary-navigation { display: flex; align-items: center; }
        nav.primary-navigation ul { list-style: none; display: flex; gap: 4px; margin: 0; padding: 0; }
        nav.primary-navigation ul li { position: relative; padding: 6px 2px; }
        nav.primary-navigation li a { color: var(--text-light); text-decoration: none; font-weight: 500; font-size: 0.95rem; display: flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 40px; transition: var(--transition-default); letter-spacing: 0.2px; }
        nav.primary-navigation li > a:hover { background: rgba(255, 255, 255, 0.1); color: var(--accent-light); transform: translateY(-1px); }
        nav.primary-navigation li > a::after { content: ''; position: absolute; bottom: 2px; left: 50%; width: 0%; height: 2px; background: var(--accent); transition: width 0.25s ease, left 0.25s ease; border-radius: 2px; }
        nav.primary-navigation li > a:hover::after { width: 70%; left: 15%; }
        nav.primary-navigation ul li ul.dropdown { visibility: hidden; opacity: 0; position: absolute; top: 100%; left: 0; min-width: 260px; background: rgba(10, 42, 68, 0.97); backdrop-filter: blur(12px); border-radius: 20px; padding: 10px 0; box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.3); transition: all 0.25s ease; transform: translateY(12px); z-index: 1200; border: 1px solid rgba(255, 215, 0, 0.2); }
        nav.primary-navigation ul li:hover > ul.dropdown { visibility: visible; opacity: 1; transform: translateY(4px); }
        nav.primary-navigation ul li ul li { width: 100%; padding: 0; }
        nav.primary-navigation ul li ul li a { padding: 12px 22px; border-radius: 0; font-weight: 500; }
        nav.primary-navigation ul li ul li a::after { display: none; }
        nav.primary-navigation ul li ul li a:hover { background: rgba(218, 165, 32, 0.2); padding-left: 28px; color: var(--accent-light); }
        .menu-toggle { display: none; font-size: 28px; cursor: pointer; background: transparent; border: none; color: white; transition: color 0.2s; }
        .menu-toggle:hover { color: var(--accent); }
        @media (max-width: 1150px) {
            header { padding: 10px 20px; flex-wrap: wrap; }
            .menu-toggle { display: block; }
            nav.primary-navigation { width: 100%; order: 3; margin-top: 12px; }
            nav.primary-navigation ul { flex-direction: column; display: none; width: 100%; background: rgba(10, 42, 68, 0.98); backdrop-filter: blur(16px); border-radius: 28px; padding: 16px 12px; gap: 8px; }
            nav.primary-navigation ul.active { display: flex; }
            nav.primary-navigation ul li { width: 100%; }
            nav.primary-navigation li a { padding: 12px 18px; border-radius: 60px; justify-content: flex-start; }
            nav.primary-navigation li > a::after { display: none; }
            nav.primary-navigation ul li ul.dropdown { position: static; visibility: visible; opacity: 1; transform: none; display: none; background: rgba(0, 0, 0, 0.3); margin-top: 5px; margin-left: 24px; border: none; box-shadow: none; backdrop-filter: none; }
            nav.primary-navigation ul li:hover > ul.dropdown { display: block; }
            .user-action-group { margin-left: 0 !important; margin-top: 8px; flex-wrap: wrap; }
        }
        .hero { min-height: 85vh; background: linear-gradient(105deg, rgba(10, 42, 68, 0.75) 0%, rgba(0, 20, 40, 0.8) 100%), url('NewHomePage.png') no-repeat center center/cover; display: flex; align-items: center; justify-content: center; text-align: center; position: relative; }
        .hero-content { max-width: 860px; padding: 0 24px; animation: fadeUp 0.9s ease-out; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .hero h1 { font-size: 3.6rem; font-weight: 800; margin-bottom: 20px; background: linear-gradient(to right, #ffffff, #ffe6b3); background-clip: text; -webkit-background-clip: text; color: transparent; letter-spacing: -0.02em; }
        .hero p { font-size: 1.3rem; color: rgba(255, 255, 245, 0.92); font-weight: 400; margin-bottom: 28px; }
        .about { background: white; padding: 70px 24px; text-align: center; border-bottom: 1px solid #eef2f6; }
        .about h2 { font-size: 2.3rem; font-weight: 700; color: var(--primary-dark); letter-spacing: -0.3px; }
        .about p { font-size: 1.2rem; max-width: 700px; margin: 16px auto 0; color: #334155; }
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 32px; background: linear-gradient(145deg, #f1f5f9 0%, #ffffff 100%); padding: 70px 32px; }
        .feature { background: rgba(255, 255, 255, 0.92); backdrop-filter: blur(2px); padding: 32px 24px; border-radius: 36px; box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.08); transition: var(--transition-default); border: 1px solid rgba(218, 165, 32, 0.2); text-align: center; }
        .feature:hover { transform: translateY(-8px); box-shadow: 0 25px 40px -14px rgba(0, 0, 0, 0.18); border-color: rgba(218, 165, 32, 0.5); }
        .feature i { font-size: 2.4rem; color: var(--accent); margin-bottom: 1rem; display: inline-block; }
        .feature h3 { font-size: 1.5rem; margin: 16px 0 12px; color: var(--primary-dark); }
        .feature p { color: #475569; line-height: 1.5; }
        .testimonials { background: var(--primary-dark); padding: 70px 24px; text-align: center; color: white; }
        .testimonials h2 { font-size: 2rem; margin-bottom: 20px; font-weight: 600; }
        .testimonials p { max-width: 720px; margin: 0 auto; font-size: 1.1rem; color: #cbd5e6; }
        footer { background: #0f172a; color: #a0afc3; padding: 28px 16px; text-align: center; font-size: 0.9rem; border-top: 1px solid #1e2a44; }
        footer p i { margin-right: 6px; color: var(--accent); }
        
        /* --- ENHANCED USER ICON AND LOGOUT BUTTON --- */
        .user-action-group { display: flex; align-items: center; gap: 12px; margin-left: 10px; }
        .user-welcome { display: flex; align-items: center; gap: 10px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 40px; padding: 4px 16px 4px 4px; font-weight: 600; color: #ffffff; font-size: 0.9rem; backdrop-filter: blur(8px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .user-avatar { display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: var(--accent); color: var(--primary-dark); border-radius: 50%; font-size: 0.9rem; box-shadow: 0 2px 6px rgba(218, 165, 32, 0.4); }
        .logout-button { display: flex; align-items: center; gap: 6px; background: rgba(239, 68, 68, 0.15) !important; border: 1px solid rgba(239, 68, 68, 0.4) !important; color: #fca5a5 !important; border-radius: 40px !important; padding: 8px 20px !important; font-weight: 600; font-size: 0.9rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important; text-decoration: none; }
        .logout-button:hover { background: #ef4444 !important; color: #ffffff !important; border-color: #ef4444 !important; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(239, 68, 68, 0.3); }
        .login-button { display: flex; align-items: center; gap: 6px; background: var(--accent) !important; color: var(--primary-dark) !important; border-radius: 40px !important; padding: 8px 24px !important; font-weight: 700; font-size: 0.9rem; transition: all 0.3s ease !important; text-decoration: none; border: none; }
        .login-button:hover { background: #ffcc00 !important; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(218, 165, 32, 0.4); }
        
        @media (max-width: 640px) { .hero h1 { font-size: 2.4rem; } .hero p { font-size: 1rem; } .features { padding: 40px 20px; gap: 24px; } .brand-title { font-size: 1.1rem; } }
    </style>
</head>
<body>
    <header>
        <div class="brand-container">
            <div class="logo"></div>
            <div class="brand-title">MTN SYRIA</div>
        </div>

        <nav role="navigation" class="primary-navigation">
            <ul id="navMenu">
                <li><a href="#features"><i class="fas fa-home"></i> Home & Features</a></li>
               
                <li class="dropdown-trigger"><a href="#"><i class="fas fa-search"></i> Search</a>
                    <ul class="dropdown">
                        <li><a href='advancedsearch.php?user=<?php echo isset($userrname) ? htmlspecialchars($userrname) : ''; ?>'><i class='fas fa-filter'></i> Advanced Radio Filters</a></li>
                        <li><a href='power_advancedsearch..php?user=<?php echo isset($userrname) ? htmlspecialchars($userrname) : ''; ?>'><i class='fa fa-power-off'></i> Advanced Power Filters</a></li>
                    </ul>
                </li>

                <li class="dropdown-trigger"><a href="#"><i class="fas fa-broadcast-tower"></i> Radio Section</a>
                    <ul class="dropdown">
                        <li><a href="Tech_config.php?user_id=<?php echo isset($encodedUserId) ? $encodedUserId : ''; ?>"><i class="fas fa-cogs"></i> Tech Config</a></li>
                        <li><a href="V2_uploadssr.php?user_id=<?php echo isset($encodedUserId) ? $encodedUserId : ''; ?>"><i class="fas fa-upload"></i> Upload SSR</a></li>
                    </ul>
                </li>

                <li><a href="searchpower.php?user=<?php echo isset($userrname) ? htmlspecialchars($userrname) : ''; ?>"><i class='fa fa-power-off'></i> Power Section</a></li>
               
                <?php
                if (isset($_COOKIE['loggedInUser'])) {
                    $loggedInUser = htmlspecialchars($_COOKIE['loggedInUser']);
                    echo '<li class="user-action-group">
                            <span class="user-welcome">
                                <span class="user-avatar"><i class="fas fa-user-astronaut"></i></span>
                                ' . $loggedInUser . '
                            </span>
                            <a href="logout.php" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
                          </li>';
                } else {
                    echo '<li class="user-action-group">
                            <a href="index.php" class="login-button"><i class="fas fa-sign-in-alt"></i> Login</a>
                          </li>';
                }
                ?>
            </ul>
        </nav>
        <div class="menu-toggle" onclick="toggleMenu()"><i class="fas fa-bars"></i></div>
    </header>

    <section class="hero" id="hero">
        <div class="hero-content">
            <h1>Sites Management Platform</h1>
            <p>"A unified, centralized network database designed for operations giving technical teams faster access, clearer insights, and more efficient workflows.”</p>
        </div>
    </section>

    <section class="about" id="about">
        <h2><i class="far fa-question-circle" style="color:var(--accent); margin-right: 10px;"></i> About Us</h2>
        <p>We Are Quality & Performance Team in Network Division — driving excellence, automation and reliability.</p>
    </section>

    <section class="features" id="features">
        <div class="feature">
            <i class="fa fa-plus-circle"></i>
            <h3>Add New Site</h3>
            <p>Quickly add sites with all technologies and cells through an intuitive step-by-step interface.</p>
        </div>
        <div class="feature">
            <i class="fas fa-search-location"></i>
            <h3>Intelligent Search</h3>
            <p>Search for any site using "SITE CODE" and get full details instantly with advanced filters.</p>
        </div>
        <div class="feature">
            <i class="fas fa-trash-alt"></i>
            <h3>Cancellation of Sites</h3>
            <p>Easily cancel sites or individual cells after search, keeping database clean & updated.</p>
        </div>
        <div class="feature">
            <i class="fa fa-file-excel"></i>
            <h3>Import & Export </h3>
            <p>Batch import/export data from Excel files (*.CSV, *.xlsx) to streamline mass updates.</p>
        </div>
    </section>

    <section class="testimonials" id="testimonials">
        <h2><i class="fas fa-comment-dots"></i> Suggestions & Feedback</h2>
        <p>We truly value your insights to enhance our platform. Reach out via the emails below — your voice shapes our innovation.</p>
        <div style="margin-top: 2rem; font-size: 1rem;">
            <p><i class="far fa-envelope"></i> hwahby@mtn.com.sy &nbsp;|&nbsp; <i class="fas fa-phone-alt"></i> 3117</p>
            <p style="margin-top: 8px;"><i class="far fa-envelope"></i> tkadilo@mtn.com.sy &nbsp;|&nbsp; <i class="fas fa-phone-alt"></i> 3118</p>
        </div>
    </section>

    <footer>
        <p><i class="far fa-copyright"></i> MTN Syria - Network Quality & Performance Team | Empowering connectivity</p>
    </footer>

    <script>
        function toggleMenu() {
            const navUl = document.querySelector('.primary-navigation ul');
            if (navUl) { navUl.classList.toggle('active'); }
        }
        document.querySelectorAll('.primary-navigation ul li a').forEach(link => {
            link.addEventListener('click', (e) => {
                const navUl = document.querySelector('.primary-navigation ul');
                if (window.innerWidth <= 1150 && navUl && navUl.classList.contains('active')) {
                    if (!e.target.closest('.dropdown')) { navUl.classList.remove('active'); }
                }
            });
        });
        window.addEventListener('resize', function() {
            const navUl = document.querySelector('.primary-navigation ul');
            if (window.innerWidth > 1150 && navUl) {
                navUl.classList.remove('active');
                navUl.style.display = '';
            }
            if (window.innerWidth <= 1150 && navUl && !navUl.classList.contains('active')) {
                navUl.style.display = '';
            }
        });
    </script>
</body>
</html>


