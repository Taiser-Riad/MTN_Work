<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/all.min.css">
    <title>Responsive Home Page</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        header {
            display: flex;
            position: sticky;
            top: 0;
            justify-content: space-between;
            align-items: flex-start;
            background: #1c355c;
            color: white;
            padding: 10px 20px;
            /* z-index: 1000; */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        header .logo {
            font-size: 24px;
            font-weight: bold;
            width: 8%;
            height: 90px;
            min-width: 90px;
            background: url('MTN-Logo.jpg') no-repeat center center/cover;
        }

        .hero {
            height: 80vh;
            background: url('img.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            opacity: 1;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            color: #1c355c;
            opacity: 1;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #1c355c;
            opacity: 1;
        }

        .hero a {
            background: #ff6600;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .about,
        .features,
        .testimonials,
        .footer {
            padding: 20px;
            text-align: center;
        }

        .about img {
            max-width: 100%;
            height: auto;
        }

        .about {
            background-color: goldenrod;
            color: #1c355c;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            background-color: goldenrod;
            color: #1c355c;
        }

        .feature {
            background: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
        }

        .testimonials {
            background: #1c355c;
            color: white;
        }

        footer {
            background: #222;
            color: white;
            padding: 10px;
        }

        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                display: none;
            }

            nav ul.active {
                display: flex;
            }

            .menu-toggle {
                display: block;
                cursor: pointer;
            }
        }

        nav.primary-navigation {
            margin: 10 auto;
            display: block;
            padding: 16px 0 0 0 ;
            text-align: center;
            font-size: 18px;
        }

        nav.primary-navigation ul li {
            list-style: none;
            margin: 0 auto;
            border-left: 2px solid #3ca0e7;
            display: inline-block;
            padding: 0 30px;
            position: relative;
            text-decoration: none;
            text-align: center;
            font-family: arvo;
        }

        nav.primary-navigation li a {
            color: white;
            text-decoration: none;
        }

        nav.primary-navigation li a:hover {
            color: goldenrod;
        }

        nav.primary-navigation li:hover {
            cursor: pointer;
        }

        nav.primary-navigation ul li ul {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            padding-left: 0;
            left: 0;
            display: none;
            background: #1c355c;
        }

        nav.primary-navigation ul li:hover>ul,
        nav.primary-navigation ul li ul:hover {
            visibility: visible;
            opacity: 1;
            display: block;
            min-width: 250px;
            text-align: left;
            padding-top: 20px;
            box-shadow: 0px 3px 5px -1px #ccc;
        }

        nav.primary-navigation ul li ul li {
            clear: both;
            width: 100%;
            text-align: left;
            margin-bottom: 20px;
            border-style: none;
        }

        nav.primary-navigation ul li ul li a:hover {
            padding-left: 10px;
            border-left: 2px solid #3ca0e7;
            transition: all 0.3s ease;
        }

        a {
            text-decoration: none;
            transition: all 1s ease;
        }

        a:hover {
            color: #3CA0E7;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="logo"></div>
        <nav role="navigation" class="primary-navigation">
            <ul>
                <li><a href="#hero"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="#features"><i class="fas fa-braille"></i> Features</a></li>
                <li><a href="Search.php" target="_blank"><i class="fas fa-search"></i> Search Date</a></li>
                <li class="dropdown-trigger"><a href="#"><i class="fas fa-plus"></i> Add New Site</a>
                    <ul class="dropdown">
                        <li><a href="Add new 2G.php">Add New 2G</a></li>
                        <li><a href="Add new 3G.php">Add New 3G</a></li>
                        <li><a href="Add new 4G.php">Add New 4G</a></li>
                    </ul>
                </li>
            </ul>
            
        </nav>
        <div class="menu-toggle" onclick="toggleMenu()">☰</div>
    </header>
    <!-- Hero Section -->
    <section class="hero" id="hero">
        <h1>Sites Management Website</h1>
        <p></p>
        <!-- <a href="#features">Learn More</a> -->
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <h2><i class="far fa-question-circle"></i> About Us</h2>
        <p>We Are Quality & Performance Team in Network Department.</p>
        <!-- <img src="https://via.placeholder.com/600x400" alt="About us"> -->
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <h2><i class="fas fa-braille"></i> Our Features</h2>
        <div class="feature">
            <h3><i class="fa fa-plus"></i> Add New Site</h3>
            <p>Now you can add new site with all technologies and cells by easy steps.</p>
        </div>
        <div class="feature">
            <h3><i class="fas fa-search"></i> Search</h3>
            <p>You can search for any site you need by using the "SITE CODE" and all data will appear.</p>
        </div>
        <div class="feature">
            <h3><i class="fas fa-trash"></i> Cancellation of Sites</h3>
            <p>You can cancel any site or any cell after searching.</p>
        </div>
        <div class="feature">
            <h3><i class="fa fa-file-excel"></i> Coming Soon! Import & Export Data</h3>
            <p>Here you can import or export your data sheet from any Excel file with (*.CSV, *.xlsm).</p>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <h2>Suggestions and Feedback</h2>
        <p>We are so glad to receive your feedback and experiences to enhance the quality of our services. <br>Please do
            not hesitate to contact us via the provided email and phone.</p>
    </section>

    <!-- Footer -->
<footer>
    <p><i class="far fa-envelope-open"></i> hwahby@mtn.com.sy &nbsp; <i class="fa fa-phone" style="font-size:15px"></i> 3369.
        &nbsp;&nbsp;&nbsp;&nbsp;
        <i class="far fa-envelope-open"></i> tkadilo@mtn.com.sy &nbsp; <i class="fa fa-phone" style="font-size:15px"></i> 3368.
    </p>
</footer>

<script>
    function toggleMenu() {
        const nav = document.querySelector('.primary-navigation ul');
        nav.classList.toggle('active');
    }
</script>
</body>
</html>
