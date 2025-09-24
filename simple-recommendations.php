<?php
/**
 * Simple Recommendations Page
 * Easy to understand and user-friendly recommendations
 */

session_start();
include 'config/database.php';
include 'assets/loader.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Include our simple recommendation engine
require_once 'includes/SimpleRecommendationEngine.php';
$recommendationEngine = new SimpleRecommendationEngine($pdo);

// Handle user actions (enroll, dismiss, etc.)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Handle course enrollment
    if (isset($_POST['enroll_course'])) {
        $course_title = $_POST['course_title'] ?? '';
        $course_price = $_POST['course_price'] ?? 0;
        
        if ($course_title) {
            // Save the action for learning (optional)
            $recommendationEngine->saveUserAction($user_id, 'enrolled', $course_title, 'course');
            
            // Redirect to enrollment page
            header("Location: enroll.php?course=" . urlencode($course_title) . "&price=" . $course_price);
            exit();
        }
    }
    
    // Handle quiz start
    if (isset($_POST['start_quiz'])) {
        $quiz_title = $_POST['quiz_title'] ?? '';
        
        if ($quiz_title) {
            // Save the action
            $recommendationEngine->saveUserAction($user_id, 'started_quiz', $quiz_title, 'quiz');
            
            // Redirect to quiz (you can modify this URL as needed)
            header("Location: quiz/main.php?quiz=" . urlencode($quiz_title));
            exit();
        }
    }
    
    // Handle dismissing recommendations
    if (isset($_POST['dismiss_item'])) {
        $item_title = $_POST['item_title'] ?? '';
        $item_type = $_POST['item_type'] ?? '';
        
        if ($item_title) {
            $recommendationEngine->saveUserAction($user_id, 'dismissed', $item_title, $item_type);
            $message = "Recommendation hidden successfully.";
        }
    }
}

// Get recommendations from our simple engine
try {
    $course_recommendations = $recommendationEngine->getCourseRecommendations($user_id, 6);
    $quiz_recommendations = $recommendationEngine->getQuizRecommendations($user_id, 4);
    $career_recommendations = $recommendationEngine->getCareerRecommendations($user_id, 3);
} catch (Exception $e) {
    $error = "Unable to load recommendations. Please try again later.";
    $course_recommendations = [];
    $quiz_recommendations = [];
    $career_recommendations = [];
}

include 'assets/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Recommendations - BeThePro's</title>
    <link rel="stylesheet" href="css/simple-recommendations.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="recommendations-container">
        <div class="container">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="header-content">
                    <h1><i class="fas fa-star"></i> Your Personal Recommendations</h1>
                    <p>Courses, quizzes, and career paths picked just for you</p>
                </div>
                <div class="header-actions">
                    <a href="skill-assessment.php" class="btn btn-primary">
                        <i class="fas fa-user-check"></i> Update Your Skills
                    </a>
                </div>
            </div>
            
            <!-- Messages -->
            <?php if ($message): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <!-- Course Recommendations -->
            <section class="recommendation-section">
                <div class="section-header">
                    <h2><i class="fas fa-graduation-cap"></i> Recommended Courses</h2>
                    <p>Courses that match your goals and skill level</p>
                </div>
                
                <?php if (empty($course_recommendations)): ?>
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <h3>No course recommendations yet</h3>
                        <p>Complete your <a href="skill-assessment.php">skills assessment</a> to get personalized course suggestions.</p>
                    </div>
                <?php else: ?>
                    <div class="recommendations-grid">
                        <?php foreach ($course_recommendations as $course): ?>
                            <div class="recommendation-card course-card">
                                <div class="card-header">
                                    <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                                    <span class="level-badge <?php echo strtolower($course['level']); ?>">
                                        <?php echo htmlspecialchars($course['level']); ?>
                                    </span>
                                </div>
                                
                                <div class="card-content">
                                    <p class="description">
                                        <?php echo htmlspecialchars(substr($course['description'], 0, 120)) . '...'; ?>
                                    </p>
                                    
                                    <div class="match-info">
                                        <div class="match-percentage">
                                            <div class="percentage-bar">
                                                <div class="percentage-fill" style="width: <?php echo $course['match_percentage']; ?>%"></div>
                                            </div>
                                            <span><?php echo round($course['match_percentage']); ?>% match</span>
                                        </div>
                                        <p class="reason">
                                            <i class="fas fa-lightbulb"></i>
                                            <?php echo htmlspecialchars($course['reason']); ?>
                                        </p>
                                    </div>
                                    
                                    <div class="course-details">
                                        <span class="price">
                                            <i class="fas fa-tag"></i>
                                            $<?php echo number_format($course['price'], 2); ?>
                                        </span>
                                        <span class="duration">
                                            <i class="fas fa-clock"></i>
                                            <?php echo htmlspecialchars($course['duration']); ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="card-actions">
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="course_title" value="<?php echo htmlspecialchars($course['title']); ?>">
                                        <input type="hidden" name="course_price" value="<?php echo $course['price']; ?>">
                                        <button type="submit" name="enroll_course" class="btn btn-primary">
                                            <i class="fas fa-arrow-right"></i> Enroll Now
                                        </button>
                                    </form>
                                    
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="item_title" value="<?php echo htmlspecialchars($course['title']); ?>">
                                        <input type="hidden" name="item_type" value="course">
                                        <button type="submit" name="dismiss_item" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Not Interested
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
            
            <!-- Quiz Recommendations -->
            <section class="recommendation-section">
                <div class="section-header">
                    <h2><i class="fas fa-brain"></i> Recommended Quizzes</h2>
                    <p>Test your knowledge and identify areas for improvement</p>
                </div>
                
                <?php if (empty($quiz_recommendations)): ?>
                    <div class="empty-state">
                        <i class="fas fa-question-circle"></i>
                        <h3>No quiz recommendations available</h3>
                        <p>Quizzes will be suggested based on your learning progress.</p>
                    </div>
                <?php else: ?>
                    <div class="quiz-grid">
                        <?php foreach ($quiz_recommendations as $quiz): ?>
                            <div class="recommendation-card quiz-card">
                                <div class="card-header">
                                    <h3><?php echo htmlspecialchars($quiz['title']); ?></h3>
                                    <span class="category-badge">
                                        <?php echo htmlspecialchars($quiz['category']); ?>
                                    </span>
                                </div>
                                
                                <div class="card-content">
                                    <p class="reason">
                                        <i class="fas fa-info-circle"></i>
                                        <?php echo htmlspecialchars($quiz['reason']); ?>
                                    </p>
                                    
                                    <div class="quiz-details">
                                        <span class="difficulty">
                                            <i class="fas fa-chart-bar"></i>
                                            <?php echo htmlspecialchars($quiz['difficulty']); ?>
                                        </span>
                                        <span class="duration">
                                            <i class="fas fa-clock"></i>
                                            <?php echo htmlspecialchars($quiz['duration']); ?>
                                        </span>
                                        <span class="questions">
                                            <i class="fas fa-list"></i>
                                            <?php echo $quiz['questions']; ?> questions
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="card-actions">
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="quiz_title" value="<?php echo htmlspecialchars($quiz['title']); ?>">
                                        <button type="submit" name="start_quiz" class="btn btn-primary">
                                            <i class="fas fa-play"></i> Start Quiz
                                        </button>
                                    </form>
                                    
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="item_title" value="<?php echo htmlspecialchars($quiz['title']); ?>">
                                        <input type="hidden" name="item_type" value="quiz">
                                        <button type="submit" name="dismiss_item" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Hide
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
            
            <!-- Career Path Recommendations -->
            <section class="recommendation-section">
                <div class="section-header">
                    <h2><i class="fas fa-route"></i> Career Path Suggestions</h2>
                    <p>Explore career opportunities that match your interests</p>
                </div>
                
                <?php if (empty($career_recommendations)): ?>
                    <div class="empty-state">
                        <i class="fas fa-briefcase"></i>
                        <h3>No career suggestions yet</h3>
                        <p>Set your career goals in the <a href="skill-assessment.php">skills assessment</a> to get career recommendations.</p>
                    </div>
                <?php else: ?>
                    <div class="career-grid">
                        <?php foreach ($career_recommendations as $career): ?>
                            <div class="recommendation-card career-card">
                                <div class="card-header">
                                    <h3><?php echo htmlspecialchars($career['title']); ?></h3>
                                    <span class="growth-badge <?php echo strtolower(str_replace(' ', '-', $career['job_growth'])); ?>">
                                        <?php echo htmlspecialchars($career['job_growth']); ?> Growth
                                    </span>
                                </div>
                                
                                <div class="card-content">
                                    <p class="description">
                                        <?php echo htmlspecialchars($career['description']); ?>
                                    </p>
                                    
                                    <div class="career-stats">
                                        <div class="stat">
                                            <span class="label">Average Salary:</span>
                                            <span class="value"><?php echo htmlspecialchars($career['avg_salary']); ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="skills-needed">
                                        <h4>Skills Needed:</h4>
                                        <div class="skills-list">
                                            <?php foreach ($career['skills_needed'] as $skill): ?>
                                                <span class="skill-tag"><?php echo htmlspecialchars($skill); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    
                                    <p class="match-reason">
                                        <i class="fas fa-thumbs-up"></i>
                                        <?php echo htmlspecialchars($career['match_reason']); ?>
                                    </p>
                                </div>
                                
                                <div class="card-actions">
                                    <a href="courses.php?filter=<?php echo urlencode($career['title']); ?>" 
                                       class="btn btn-primary">
                                        <i class="fas fa-search"></i> Find Related Courses
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
            
        </div>
    </div>

    <script>
        // Simple JavaScript for better user experience
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth animations to cards
            const cards = document.querySelectorAll('.recommendation-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = (index * 0.1) + 's';
                card.classList.add('fade-in');
            });
            
            // Confirm before dismissing recommendations
            const dismissButtons = document.querySelectorAll('button[name="dismiss_item"]');
            dismissButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to hide this recommendation?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php include 'assets/footer.php'; ?>