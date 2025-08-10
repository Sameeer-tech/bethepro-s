<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - BeThePro's</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/About.css">

   
</head>
<body class="loading">
   <?php
include 'assets/loader.php';


include 'assets/header.php';

?>
        <nav class="container">
            <div class="logo">BeThePro's</div>
            <ul class="nav-links">
                <li><a href="index1.html">Home</a></li>
                <li><a href="index1.html#features">Features</a></li>
                <li><a href="index1.html#courses">Courses</a></li>
                <li><a href="index1.html#testimonials">Success Stories</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
            <a href="#signup" class="cta-btn">Get Started</a>
        </nav>
    </header>

    <!-- About Hero Section -->
    <section class="about-hero">
        <div class="container">
            <h1>About BeThePro's</h1>
            <p>Empowering careers through expert interview preparation and professional development since 2020</p>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="mission-section">
        <div class="container">
            <div class="mission-grid">
                <div class="mission-content">
                    <h2>Our Mission & Vision</h2>
                    <p>At BeThePro's, we believe everyone deserves the opportunity to showcase their true potential in interviews. Our mission is to transform interview preparation from a source of stress into a journey of growth and confidence-building.</p>
                    <br>
                    <p>Founded by industry experts with over 20 years of combined experience in recruitment and professional development, we understand what employers look for and how to help candidates present their best selves.</p>
                </div>
                <div class="mission-image">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" 
                         alt="Team collaboration">
                </div>
            </div>
        </div>
    </section>
  
    <!-- Core Values Section -->
    <section class="values-section">
        <div class="container">
            <h2 class="section-title" style="color: white;">Our Core Values</h2>
            <div class="values-grid">
                <div class="value-card">
                    <i class="fas fa-star"></i>
                    <h3>Excellence</h3>
                    <p>We strive for excellence in everything we do, ensuring our candidates receive the highest quality preparation resources.</p>
                </div>
                <div class="value-card">
                    <i class="fas fa-users"></i>
                    <h3>Community</h3>
                    <p>Building a supportive community where professionals can learn, grow, and succeed together.</p>
                </div>
                <div class="value-card">
                    <i class="fas fa-lightbulb"></i>
                    <h3>Innovation</h3>
                    <p>Continuously innovating our methods and resources to meet the evolving needs of the job market.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <h2 class="section-title">Meet Our Expert Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                         alt="John Mitchell">
                    <h3>John Mitchell</h3>
                    <p>Founder & CEO</p>
                    <p>15+ years in HR consulting</p>
                </div>
                <div class="team-member">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                         alt="Sarah Anderson">
                    <h3>Sarah Anderson</h3>
                    <p>Head of Training</p>
                    <p>Expert in career development</p>
                </div>
                <div class="team-member">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                         alt="Michael Chen">
                    <h3>Michael Chen</h3>
                    <p>Technical Director</p>
                    <p>10+ years in tech recruitment</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <?php include 'assets/stats.php'; ?>
    <!-- Footer -->
   <?php include 'assets/footer.php'; ?>

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="js/About.js"></script>
</body>
</html>
