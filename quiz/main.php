<?php
// Loader
include '../assets/loader.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BeThePros Quiz Categories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="quiz.css">
  <link rel="stylesheet" href="../css/animations.css">
</head>
<body class="loading">
<?php include '../assets/header.php'; ?>

  <!-- Professional Quiz Banner -->
  <section class="quiz-banner-professional animate-fade-in">
    <div class="banner-container">
      <div class="banner-content">
        <div class="banner-text">
          <div class="banner-badge">
            <i class="fas fa-trophy"></i>
            <span>Interactive Quiz Platform</span>
          </div>
          <h1 class="banner-title animate-slide-up">
            Challenge Your <span class="highlight">Knowledge</span>
            <br>Ace Your Interviews
          </h1>
          <p class="banner-description animate-scale-in">
            Test your skills with our comprehensive quiz platform. Get instant feedback, 
            track your progress, and identify areas for improvement across multiple career domains.
          </p>
          <div class="banner-stats animate-fade-in">
            <div class="stat-item">
              <div class="stat-number stats-number">6</div>
              <div class="stat-label">Quiz Categories</div>
            </div>
            <div class="stat-item">
              <div class="stat-number stats-number">180+</div>
              <div class="stat-label">Practice Questions</div>
            </div>
            <div class="stat-item">
              <div class="stat-number stats-number">3</div>
              <div class="stat-label">Difficulty Levels</div>
            </div>
            <div class="stat-item">
              <div class="stat-number stats-number">95%</div>
              <div class="stat-label">Accuracy Rate</div>
            </div>
          </div>
          <div class="banner-cta">
            <button class="btn-primary" onclick="document.querySelector('#categoryCards').scrollIntoView({behavior: 'smooth'})">
              <i class="fas fa-play-circle"></i>
              Start Quiz Challenge
            </button>
            <button class="btn-secondary" onclick="window.location.href='../preparation.php'">
              <i class="fas fa-book-open"></i>
              Study First
            </button>
          </div>
        </div>
        <div class="banner-visual">
          <div class="visual-container">
            <div class="floating-elements">
              <div class="element element-1">
                <i class="fas fa-question-circle"></i>
              </div>
              <div class="element element-2">
                <i class="fas fa-check-circle"></i>
              </div>
              <div class="element element-3">
                <i class="fas fa-chart-line"></i>
              </div>
              <div class="element element-4">
                <i class="fas fa-star"></i>
              </div>
              <div class="element element-5">
                <i class="fas fa-lightbulb"></i>
              </div>
              <div class="element element-6">
                <i class="fas fa-target"></i>
              </div>
            </div>
            <div class="central-quiz-icon">
              <i class="fas fa-brain"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="banner-background">
      <div class="bg-shape shape-1"></div>
      <div class="bg-shape shape-2"></div>
      <div class="bg-shape shape-3"></div>
    </div>
  </section>

  <div class="container py-5 animate-fade-in">
    <h2 class="text-center mb-5 animate-slide-up" style="color:var(--primary-color);font-weight:700;">Choose Your Quiz Category</h2>
    <div class="row" id="categoryCards"></div>
  </div>
  <!-- Quiz Modal -->
  <div id="quizModal" class="quiz-modal d-none animate-scale-in">
    <div class="quiz-modal-content">
      <button class="close-btn" onclick="closeQuizModal()">&times;</button>
      <div class="level-select mb-3">
        <label for="levelSelect" class="form-label">Select Level:</label>
        <select id="levelSelect" class="form-select">
          <option value="junior">Junior</option>
          <option value="mid">Mid-level</option>
          <option value="senior">Senior</option>
        </select>
      </div>
      <div id="quizProgress" class="mb-3"></div>
      <h4 id="quizTitle"></h4>
      <div id="quizQuestions"></div>
      <button id="nextBtn" class="btn btn-primary w-100 mt-3 d-none" onclick="nextQuestion()">Next</button>
      <button id="submitBtn" class="btn btn-success w-100 mt-3 d-none" onclick="submitQuiz()">Submit Quiz</button>
      <div id="quizResult" class="result"></div>
    </div>
  </div>
<?php include '../assets/footer.php'; ?>
<script src="quiz.js"></script>
<script src="../js/scroll-animations.js"></script>
</body>
</html>
