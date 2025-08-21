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
  <link rel="stylesheet" href="quiz.css">
</head>
<body class="loading">
<?php include '../assets/header.php'; ?>

  <!-- Quiz Banner -->
  <section class="quiz-banner">
    <div class="container text-center">
      <h1>Test Your Skills</h1>
      <p>Challenge yourself with our comprehensive interview preparation quizzes</p>
      <div class="quiz-stats">
        <div class="quiz-stat">
          <span class="quiz-stat-number">6</span>
          <span class="quiz-stat-label">Categories</span>
        </div>
        <div class="quiz-stat">
          <span class="quiz-stat-number">180+</span>
          <span class="quiz-stat-label">Questions</span>
        </div>
        <div class="quiz-stat">
          <span class="quiz-stat-number">3</span>
          <span class="quiz-stat-label">Difficulty Levels</span>
        </div>
      </div>
    </div>
  </section>

  <div class="container py-5">
    <h2 class="text-center mb-5" style="color:var(--primary-color);font-weight:700;">Choose Your Quiz Category</h2>
    <div class="row" id="categoryCards"></div>
  </div>
  <!-- Quiz Modal -->
  <div id="quizModal" class="quiz-modal d-none">
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
</body>
</html>
