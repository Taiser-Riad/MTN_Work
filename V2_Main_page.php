<?php 
include "config.php";
?>
<?php

if(isset($_GET['user']))
{
$username =$_GET['user'];
$sqll= "SELECT * FROM USERS WHERE USERNAME= :username";
$result = oci_parse($conn,$sqll);
oci_bind_by_name($result, ':username' ,$username);
oci_execute($result);
$row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);
$userrname = $row['USERNAME'];
$dep = $row['DEPARTMENT'];
//echo $userrname;

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>MTN Syria | Sites Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #1c355c;
            --secondary: #ff6600;
            --accent: #f0b52d;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #28a745;
            --card-shadow: 0 8px 30px rgba(0,0,0,0.12);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            position: sticky;
            top: 0;
            background: var(--primary);
            color: white;
            padding: 15px 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: #fff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .logo-text span {
            color: var(--accent);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--primary);
        }

        #welcome {
            font-size: 0.95rem;
        }

        .logout-button {
            padding: 8px 15px;
            background-color: var(--secondary);
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: var(--transition);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .logout-button:hover {
            background-color: #e55a00;
            transform: translateY(-2px);
        }

        /* Navigation */
        .primary-navigation {
            display: flex;
            gap: 5px;
        }

        .nav-link {
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.15);
        }

        .dropdown {
            position: relative;
        }

        .dropdown-content {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            min-width: 220px;
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: var(--transition);
            z-index: 100;
        }

        .dropdown:hover .dropdown-content {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-content a {
            display: block;
            padding: 12px 20px;
            color: var(--dark);
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .dropdown-content a:hover {
            background: #f0f4ff;
            color: var(--primary);
        }

        .dropdown-content a i {
            width: 20px;
            text-align: center;
            margin-right: 8px;
            color: var(--primary);
        }

        .menu-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
        }

        /* Hero Section */
        .hero {
            height: 85vh;
            background: linear-gradient(135deg, var(--primary) 0%, #0d1a30 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80') no-repeat center center/cover;
            opacity: 0.15;
        }

        .hero-content {
            position: relative;
            max-width: 700px;
            padding: 0 20px;
            color: white;
        }

        .hero h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 30px;
            opacity: 0.9;
            max-width: 600px;
        }

        .cta-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 14px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--secondary);
            color: white;
        }

        .btn-primary:hover {
            background: #e55a00;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(230, 90, 0, 0.2);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .btn-secondary:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-3px);
        }

        /* Stats Section */
        .stats {
            padding: 70px 0;
            background: var(--light);
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-10px);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
            font-family: 'Poppins', sans-serif;
        }

        .stat-title {
            font-size: 1.1rem;
            color: var(--gray);
            font-weight: 500;
        }

        /* Features Section */
        .features {
            padding: 100px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .section-header p {
            font-size: 1.2rem;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .feature-icon {
            height: 150px;
            background: linear-gradient(135deg, var(--primary) 0%, #0d1a30 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: white;
        }

        .feature-content {
            padding: 30px;
        }

        .feature-content h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--primary);
        }

        .feature-content p {
            color: var(--gray);
            margin-bottom: 20px;
        }

        .feature-link {
            display: inline-flex;
            align-items: center;
            color: var(--secondary);
            font-weight: 500;
            text-decoration: none;
            gap: 5px;
            transition: var(--transition);
        }

        .feature-link:hover {
            gap: 10px;
        }

        /* About Section */
        .about {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--primary) 0%, #0d1a30 100%);
            color: white;
        }

        .about-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .about-image {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .about-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .about-content h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 25px;
        }

        .about-content p {
            margin-bottom: 20px;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Testimonials */
        .testimonials {
            padding: 100px 0;
            background: var(--light);
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .testimonial-card {
            background: white;
            border-radius: 12px;
            padding: 35px;
            box-shadow: var(--card-shadow);
            position: relative;
        }

        .testimonial-card::before {
            content: """;
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 5rem;
            color: rgba(28, 53, 92, 0.05);
            font-family: Georgia, serif;
            line-height: 1;
        }

        .testimonial-content {
            margin-bottom: 25px;
            font-style: italic;
            color: var(--dark);
            position: relative;
            z-index: 2;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--primary);
        }

        .author-info h4 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .author-info p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Footer */
        footer {
            background: var(--primary);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-logo {
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .footer-logo span {
            color: var(--accent);
        }

        .footer-about {
            max-width: 300px;
            opacity: 0.8;
            line-height: 1.7;
        }

        .footer-heading {
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-links a:hover {
            color: white;
            gap: 12px;
        }

        .contact-info {
            list-style: none;
        }

        .contact-info li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            color: rgba(255,255,255,0.8);
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
        }

        /* Charts */
        .charts {
            padding: 70px 0;
            background: white;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 30px;
        }

        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--card-shadow);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-header h3 {
            font-size: 1.4rem;
            color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .about-container {
                grid-template-columns: 1fr;
            }

            .about-image {
                max-width: 600px;
                margin: 0 auto;
            }

            .hero h1 {
                font-size: 3rem;
            }
        }

        @media (max-width: 900px) {
            .primary-navigation {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: var(--primary);
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }

            .primary-navigation.active {
                display: flex;
            }

            .menu-toggle {
                display: block;
            }

            .dropdown-content {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                box-shadow: none;
                background: transparent;
                padding: 10px 0 0 20px;
            }

            .dropdown-content a {
                color: white;
                padding: 10px 0;
            }

            .dropdown-content a:hover {
                background: transparent;
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .user-info span {
                display: none;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .section-header h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo-container">
                <div class="logo">
                    <i class="fas fa-tower-cell" style="font-size: 2rem; color: var(--primary);"></i>
                </div>
                <div class="logo-text">MTN <span>Syria</span></div>
            </div>
            
            <nav class="primary-navigation">
                <a href="#features" class="nav-link active"><i class="fas fa-home"></i> Home</a>
                <div class="dropdown">
                    <a href="#" class="nav-link"><i class="fas fa-search"></i> Search</a>
                    <div class="dropdown-content">
                        <?php    
                        echo"
                        <a href='Search.php?user=$username'><i class='fas fa-code'></i> By Code</a>
                        <a href='advancedsearch.php?user=$username'><i class='fas fa-filter'></i> By Filters</a>";
                        ?>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="#" class="nav-link"><i class="fas fa-plus"></i> Add New Site</a>
                    <div class="dropdown-content">
                        <a href="Add new 2G.php" class="disabled"><span>Add New 2G</span></a>
                        <a href="Add new 3G.php" class="disabled"><span>Add New 3G</span></a>
                        <a href="Add new 4G.php" class="disabled"><span>Add New 4G</span></a>
                    </div>
                </div>
                <?php
                if (isset($_COOKIE['loggedInUser'])) {
                    $username = htmlspecialchars($_COOKIE['loggedInUser']);
                    echo '<a href="logout.php" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>';
                } else {
                    echo '<a href="index.php" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>';
                }
                ?>
            </nav>
            
            <div class="user-info">
                <?php
                if (isset($_COOKIE['loggedInUser'])) {
                    $initial = strtoupper(substr($username, 0, 1));
                    echo "<div class='user-avatar'>$initial</div>";
                    echo "<span id='welcome'>Welcome, <strong>$username</strong></span>";
                }
                ?>
                <div class="menu-toggle" id="menuToggle">?</div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Advanced Sites Management Platform</h1>
                <p>Streamline your network operations with our comprehensive site management solution designed for MTN Syria's Quality & Performance Team</p>
                <div class="cta-buttons">
                    <a href="#features" class="btn btn-primary"><i class="fas fa-rocket"></i> Explore Features</a>
                    <a href="#contact" class="btn btn-secondary"><i class="fas fa-play-circle"></i> Watch Demo</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-tower-cell"></i>
                    </div>
                    <div class="stat-number" id="siteCounter">2,587</div>
                    <div class="stat-title">Managed Sites</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">48</div>
                    <div class="stat-title">Active Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-number">99.7%</div>
                    <div class="stat-title">Network Uptime</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="stat-number">12.4k</div>
                    <div class="stat-title">Daily Operations</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <h2>Powerful Management Features</h2>
                <p>Streamline your site management with our comprehensive set of tools designed for telecom professionals</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Add New Sites</h3>
                        <p>Easily add new sites with all technologies (2G, 3G, 4G) and cells through an intuitive interface with validation checks.</p>
                        <a href="#" class="feature-link">Learn more <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Advanced Search</h3>
                        <p>Quickly find any site using site codes or advanced filters. Access all site data with a single search.</p>
                        <a href="#" class="feature-link">Learn more <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Site Management</h3>
                        <p>Decommission sites or cells after searching. Maintain a clean and accurate database with audit trails.</p>
                        <a href="#" class="feature-link">Learn more <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-export"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Data Import/Export</h3>
                        <p>Import or export data from Excel files (CSV, XLSX). Schedule automatic exports and maintain data integrity.</p>
                        <a href="#" class="feature-link">Learn more <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Charts Section -->
    <section class="charts">
        <div class="container">
            <div class="section-header">
                <h2>Network Performance Insights</h2>
                <p>Real-time analytics and performance metrics for informed decision-making</p>
            </div>
            
            <div class="charts-grid">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3>Site Distribution by Technology</h3>
                    </div>
                    <canvas id="techChart"></canvas>
                </div>
                
                <div class="chart-container">
                    <div class="chart-header">
                        <h3>Monthly Operations</h3>
                    </div>
                    <canvas id="opsChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="about-container">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80" alt="Network Operations">
                </div>
                
                <div class="about-content">
                    <h2>About Our Team</h2>
                    <p>We are the Quality & Performance Team within MTN Syria's Network Division, dedicated to maintaining the highest standards of network reliability and performance across the country.</p>
                    <p>Our mission is to provide innovative solutions that streamline site management, enhance operational efficiency, and ensure seamless connectivity for all MTN customers.</p>
                    <p>With over 15 years of combined experience in telecommunications, our team brings expertise in network optimization, site management, and data analytics to deliver exceptional results.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>What Our Users Say</h2>
                <p>Feedback from our network professionals</p>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <p class="testimonial-content">This platform has transformed how we manage our sites. The search functionality alone has saved us countless hours each week.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">A</div>
                        <div class="author-info">
                            <h4>Ahmed Hassan</h4>
                            <p>Network Engineer, Damascus</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <p class="testimonial-content">The intuitive interface makes site management accessible to our entire team. Adding new sites is now a matter of minutes rather than hours.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">L</div>
                        <div class="author-info">
                            <h4>Lina Mahmoud</h4>
                            <p>Quality Assurance Lead, Aleppo</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <p class="testimonial-content">As someone who works with multiple sites daily, the advanced filtering options have been a game-changer for my productivity.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">M</div>
                        <div class="author-info">
                            <h4>Mohammed Ali</h4>
                            <p>Field Operations Manager, Homs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-container">
                <div class="footer-about">
                    <div class="footer-logo">MTN <span>Syria</span></div>
                    <p>Providing cutting-edge telecommunications services across Syria with a commitment to quality, innovation, and customer satisfaction.</p>
                </div>
                
                <div>
                    <h3 class="footer-heading">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#hero"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="#features"><i class="fas fa-chevron-right"></i> Features</a></li>
                        <li><a href="#about"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="#testimonials"><i class="fas fa-chevron-right"></i> Testimonials</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="footer-heading">Resources</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Documentation</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> API Reference</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Support Center</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Release Notes</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="footer-heading">Contact Us</h3>
                    <ul class="contact-info">
                        <li><i class="fas fa-envelope"></i> hwahby@mtn.com.sy</li>
                        <li><i class="fas fa-phone"></i> Ext. 3369</li>
                        <li><i class="fas fa-envelope"></i> tkadilo@mtn.com.sy</li>
                        <li><i class="fas fa-phone"></i> Ext. 3368</li>
                        <li><i class="fas fa-map-marker-alt"></i> Damascus, Syria</li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 MTN Syria. All rights reserved. | Quality & Performance Team, Network Division</p>
            </div>
        </div>
    </footer>

    <script>
        // Menu toggle functionality
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.querySelector('.primary-navigation').classList.toggle('active');
        });
        
        // Counter animation
        const counters = document.querySelectorAll('.stat-number');
        const speed = 200;
        
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.innerText.replace(/,/g, '');
                const count = +counter.innerText.replace(/,/g, '');
                
                const inc = target / speed;
                
                if(count < target) {
                    counter.innerText = Math.ceil(count + inc).toLocaleString();
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target.toLocaleString();
                }
            }
            
            updateCount();
        });
        
        // Charts
        // Technology Distribution Chart
        const techCtx = document.getElementById('techChart').getContext('2d');
        const techChart = new Chart(techCtx, {
            type: 'doughnut',
            data: {
                labels: ['2G Sites', '3G Sites', '4G Sites', '5G Sites'],
                datasets: [{
                    data: [32, 28, 35, 5],
                    backgroundColor: [
                        '#1c355c',
                        '#ff6600',
                        '#f0b52d',
                        '#28a745'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Operations Chart
        const opsCtx = document.getElementById('opsChart').getContext('2d');
        const opsChart = new Chart(opsCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Site Operations',
                    data: [850, 920, 1100, 1050, 1200, 1350, 1420, 1500, 1300, 1450, 1600, 1750],
                    backgroundColor: '#1c355c',
                    borderWidth: 0,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Header shadow on scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if(window.scrollY > 50) {
                header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.1)';
            } else {
                header.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
            }
        });
    </script>
</body>

</html>

<!-- this Main page is the Next Step of our Vesion -->