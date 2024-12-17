<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Home Page</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      line-height: 1.6;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #333;
      color: white;
      padding: 10px 20px;
    }
    header .logo {
      font-size: 24px;
      font-weight: bold;
    }
    nav ul {
      list-style: none;
      padding: 0;
      display: flex;
    }
    nav ul li {
      margin: 0 10px;
    }
    nav ul li a {
      color: white;
      text-decoration: none;
    }
    .hero {
      height: 80vh;
      background: url('https://via.placeholder.com/1920x800') no-repeat center center/cover;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
    }
    .hero h1 {
      font-size: 3rem;
      margin-bottom: 10px;
    }
    .hero p {
      font-size: 1.2rem;
      margin-bottom: 20px;
    }
    .hero a {
      background: #ff6600;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
    }
    .about, .features, .testimonials, .footer {
      padding: 20px;
      text-align: center;
    }
    .about img {
      max-width: 100%;
      height: auto;
    }
    .features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
    }
    .feature {
      background: #f4f4f4;
      padding: 20px;
      border-radius: 8px;
    }
    .testimonials {
      background: #333;
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
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="logo">MyWebsite</div>
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>
    <nav>
      <ul>
        <li><a href="#hero">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero" id="hero">
    <h1>Welcome to My Website</h1>
    <p>We make your ideas come to life</p>
    <a href="#features">Learn More</a>
  </section>

  <!-- About Section -->
  <section class="about" id="about">
    <h2>About Us</h2>
    <p>We are a team dedicated to providing excellent service.</p>
    <img src="https://via.placeholder.com/600x400" alt="About us">
  </section>

  <!-- Features Section -->
  <section class="features" id="features">
    <h2>Our Features</h2>
    <div class="feature">
      <h3>Feature 1</h3>
      <p>Details about feature 1.</p>
    </div>
    <div class="feature">
      <h3>Feature 2</h3>
      <p>Details about feature 2.</p>
    </div>
    <div class="feature">
      <h3>Feature 3</h3>
      <p>Details about feature 3.</p>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="testimonials" id="testimonials">
    <h2>What Our Clients Say</h2>
    <p>"Amazing service and support!"</p>
    <p>"Truly transformed our business."</p>
  </section>

  <!-- Footer -->
  <footer>
    <p>© 2024 MyWebsite. All Rights Reserved.</p>
  </footer>

  <script>
    function toggleMenu() {
      document.querySelector('nav ul').classList.toggle('active');
    }
  </script>
</body>
</html>
