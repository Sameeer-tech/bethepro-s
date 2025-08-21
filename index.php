<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BeThePro's - Master Your Interview Success</title>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/animations.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 
    <style>
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin: 1rem auto;
            max-width: 1200px;
            text-align: center;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .alert-success {
            background-color: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }
    </style>
    <script>
        // Auto-hide alert after 5 seconds
        window.addEventListener('DOMContentLoaded', () => {
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            }
        });
    </script>
  </head>
  <body class="loading ">
<?php
include 'assets/loader.php';
include 'assets/header.php';

if(isset($_SESSION['login_success'])): ?>
    <div class="alert alert-success">
        <?php 
        echo htmlspecialchars($_SESSION['login_success']);
        unset($_SESSION['login_success']);
        ?>
    </div>
<?php endif; ?>
   

    <!-- Hero Section -->
    <section class="hero animate-fade-in" id="home">
      <div class="container">
        <div class="hero-content animate-slide-up">
          <h1 id="animation">Master Your Interview Success</h1>
          <p>
            Comprehensive interview preparation for freshers, mid-level
            professionals, and experts. Build confidence, improve communication,
            and land your dream job.
          </p>
          <div class="hero-buttons animate-scale-in">
            <a href="#features" class="primary-btn">Start Learning</a>
            <a href="courses.php" class="secondary-btn">View Courses</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="features animate-fade-in" id="features">
      <div class="container">
        <h2 class="section-title animate-slide-up">Why Choose BeThePro's?</h2>
        <div class="features-grid">
          <div class="feature-card animate-scale-in">
            <div class="feature-icon">🎯</div>
            <h3>Targeted Preparation</h3>
            <p>
              Customized content for different fields and professions. Get
              specific guidance tailored to your career goals and industry
              requirements.
            </p>
          </div>
          <div class="feature-card animate-scale-in">
            <div class="feature-icon">💼</div>
            <h3>All Experience Levels</h3>
            <p>
              Whether you're a fresher, mid-level professional, or expert, we
              have content designed specifically for your experience level.
            </p>
          </div>
          <div class="feature-card animate-scale-in">
            <div class="feature-icon">🗣️</div>
            <h3>Communication Skills</h3>
            <p>
              Improve your presentation skills, body language, and verbal
              communication to make lasting impressions in interviews.
            </p>
          </div>
          <div class="feature-card animate-scale-in">
            <div class="feature-icon">❓</div>
            <h3>FAQ Database</h3>
            <p>
              Access thousands of frequently asked interview questions with
              detailed answers and explanation strategies.
            </p>
          </div>
          <div class="feature-card animate-scale-in">
            <div class="feature-icon">📊</div>
            <h3>Progress Tracking</h3>
            <p>
              Monitor your preparation progress with detailed analytics and
              personalized recommendations for improvement.
            </p>
          </div>
          <div class="feature-card animate-scale-in">
            <div class="feature-icon">🎓</div>
            <h3>Expert Guidance</h3>
            <p>
              Learn from industry professionals and HR experts who know what
              interviewers are really looking for.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
<?php include 'assets/stats.php'; ?>

    <!-- Testimonials Section -->
    <section class="testimonials animate-fade-in" id="testimonials">
      <div class="container">
        <h2 class="section-title animate-slide-up">Success Stories</h2>
        <div class="testimonial-grid">
          <div class="testimonial animate-scale-in">
            <p class="testimonial-content">
              BeThePro's completely transformed my interview approach. I went
              from nervous and unprepared to confident and articulate. Landed my
              dream job at a Fortune 500 company!
            </p>
            <div class="testimonial-author">
              <div class="author-avatar">SM</div>
              <div>
                <strong>Sarah Miller</strong>
                <p>Software Engineer at Google</p>
              </div>
            </div>
          </div>
          <div class="testimonial animate-scale-in">
            <p class="testimonial-content">
              The targeted preparation for mid-level professionals was exactly
              what I needed. The presentation skills module helped me ace my
              manager interview.
            </p>
            <div class="testimonial-author">
              <div class="author-avatar">RJ</div>
              <div>
                <strong>Raj Patel</strong>
                <p>Project Manager at Microsoft</p>
              </div>
            </div>
          </div>
          <div class="testimonial animate-scale-in">
            <p class="testimonial-content">
              As a fresher, I was completely lost about interview preparation.
              BeThePro's guided me step by step and I got selected in my first
              interview!
            </p>
            <div class="testimonial-author">
              <div class="author-avatar">EW</div>
              <div>
                <strong>Emily Wilson</strong>
                <p>Marketing Analyst at Amazon</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section animate-fade-in">
      <div class="container">
        <h2 class="animate-slide-up">Ready to Ace Your Next Interview?</h2>
        <p class="animate-scale-in">
          Join thousands of professionals who have successfully landed their
          dream jobs with our expert guidance.
        </p>
        <a href="#signup" class="primary-btn animate-scale-in">Start Your Journey Today</a>
      </div>
    </section>

<?php include 'assets/footer.php'; ?>
<script src="js/index.js"></script>
<script src="js/scroll-animations.js"></script>
  </body>
</html>

<script>
        window.addEventListener('load', () => {
    const title = document.getElementById('animation');
    title.classList.add('animate__animated', 'animate__bounce');
  });
</script>
