<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web\css\all.min.css">
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #1c355c;
        color: white;
        padding: 10px 20px;
        z-index: 1000;
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

    nav ul {
        list-style: none;
        padding: 0;
        display: flex;
    }

    nav ul li {
        margin: 0 12px;
    }

    nav ul li a {
        color: white;
        text-decoration: none;
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
            display: block;
        }

    }

    a:hover {
        text-decoration: underline;
    }

    .dropbtn {
        background-color: #4CAF50;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #f1f1f1
    }

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="logo"></div>
        <div class="menu-toggle" onclick="toggleMenu()">☰</div>
        <nav>
            <ul>
                <li><i class="fa fa-home"></i><a href="#hero"> Home</a></li>
                <li><i class='far fa-question-circle'></i><a href="#about"> About</a></li>
                <li><i class='fas fa-braille'></i><a href="#features"> Features</a></li>
                <li><i class='far fa-comments'></i><a href="#contact"> Contact</a></li>
                <!-- <li><i class="fa fa-plus"></i><a href="Add New 2G.php" target="_blank"> Add New Site</a></li> -->
                <li><i class="fas fa-search"></i><a href="Search.php" target="_blank"> Search Date</a></li>
                <li><i class="fa fa-file-excel"></i><a href="#contact" target="_blank"> Import & Export Data</a></li>
            </ul>
        </nav>
        <div class="dropdown">
            <button class="dropbtn">Add New Site</button>
                <div class="dropdown-content">
                    <a href="Add new 2G.php">Add New 2G</a>
                    <a href="Add new 3G.php">Add New 3G</a>
                    <a href="Add new 4G.php">Add New 4G</a>
                    
                </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <h1> Sites Mangement Website</h1>
        <p></p>
        <a href="#features">Learn More</a>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <h2><i class='far fa-question-circle'></i> About Us</h2>
        <p>We Are Quality & Performance Team in Network Department.</p>
        <!-- <img src="https://via.placeholder.com/600x400" alt="About us"> -->
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <h2><i class='fas fa-braille'></i> Our Features</h2>
        <div class="feature">
            <h3><i class="fa fa-plus"></i> Add New Site</h3>
            <p>Now you can add new site with all technologies and cells by easy steps.</p>
        </div>
        <div class="feature">
            <h3><i class="fas fa-search"></i> Search</h3>
            <p>You can search about any site you need by using "SITE CODE" and all data will appear.</p>
        </div>
        <div class="feature">
            <h3><i class="fas fa-trash"></i> Cancellation of Sites </h3>
            <p>You can cancell any site or any cell after searching.</p>
        </div>
        <div class="feature">
            <h3><i class="fa fa-file-excel"></i> Import & Export Data</h3>
            <p>Here you can Import or Export your data sheet from any Excel file with (*CSV, *xlsm).</p>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <h2>Suggestion and Feedback</h2>
        <p>We are so glad to receive your feedback and experiences to enhance the quality of our services. </br>Please
            do not hesitate to contact us via the provided email and phone.</p>
        <p> <br /> </p>
    </section>

    <!-- Footer -->
    <footer>
        <p><i class='far fa-envelope-open'></i>
            hwahby@mtn.com.sy &nbsp; <i class="fa fa-phone" style="font-size:15px"></i> 3369.
            &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class='far fa-envelope-open'></i>

            tkadilo@mtn.com.sy &nbsp; <i class="fa fa-phone" style="font-size:15px"></i> 3368.
        </p>
    </footer>

    <script>
    function toggleMenu() {
        document.querySelector('nav ul').classList.toggle('active');
    }
    </script>
</body>

</html>