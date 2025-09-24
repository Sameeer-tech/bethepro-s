<?php
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

// Option to use simple recommendations system
// Change this to true for easier, more user-friendly recommendations
$use_simple_system = true;

if ($use_simple_system) {
    // Redirect to the simple, user-friendly version
    header("Location: simple-recommendations.php");
    exit();
}

// Generate fresh recommendations and notifications for the user (Original Complex System)
try {
    // Check if database connection is available
    if (!isset($pdo) || !$pdo) {
        throw new Exception("Database connection not available");
    }
    
    // Include the required files
    if (file_exists('includes/RecommendationEngine.php')) {
        require_once 'includes/RecommendationEngine.php';
        $recommendationEngine = new RecommendationEngine($pdo);
        
        // Generate recommendations
        $recommendationEngine->generateAllRecommendations($user_id);
    }
    
    // Include notification system if available
    if (file_exists('includes/NotificationSystem.php')) {
        require_once 'includes/NotificationSystem.php';
        $notificationSystem = new NotificationSystem($pdo);
        
        // Generate notifications
        $notificationSystem->generateUserNotifications($user_id);
    }
    
} catch (Exception $e) {
    error_log("Error generating recommendations/notifications: " . $e->getMessage());
    $message = "System is loading your recommendations. Please refresh the page in a moment.";
}

// Handle recommendation actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['enroll_course'])) {
        $course_id = intval($_POST['course_id']);
        $course_title = $_POST['course_title'];
        $course_price = floatval($_POST['course_price']);
        
        // Mark recommendation as enrolled
        $stmt = $pdo->prepare("UPDATE course_recommendations SET status = 'enrolled' WHERE id = ? AND user_id = ?");
        $stmt->execute([$_POST['recommendation_id'], $user_id]);
        
        // Redirect to enrollment
        header("Location: enroll.php?course=" . urlencode($course_title) . "&price=" . $course_price);
        exit();
    }
    
    if (isset($_POST['dismiss_recommendation'])) {
        $rec_id = intval($_POST['rec_id']);
        $rec_type = $_POST['rec_type'];
        
        if ($rec_type === 'course') {
            $stmt = $pdo->prepare("UPDATE course_recommendations SET status = 'dismissed' WHERE id = ? AND user_id = ?");
        } elseif ($rec_type === 'quiz') {
            $stmt = $pdo->prepare("UPDATE quiz_recommendations SET status = 'dismissed' WHERE id = ? AND user_id = ?");
        } elseif ($rec_type === 'career') {
            $stmt = $pdo->prepare("UPDATE career_path_recommendations SET status = 'dismissed' WHERE id = ? AND user_id = ?");
        }
        
        if (isset($stmt)) {
            $stmt->execute([$rec_id, $user_id]);
            $message = "Recommendation dismissed successfully.";
        }
    }
    
    if (isset($_POST['follow_career_path'])) {
        $path_id = intval($_POST['path_id']);
        $stmt = $pdo->prepare("UPDATE career_path_recommendations SET status = 'following' WHERE id = ? AND user_id = ?");
        $stmt->execute([$path_id, $user_id]);
        $message = "You are now following this career path!";
    }
}

// Get user's course recommendations
$course_recommendations = [];
try {
    $stmt = $pdo->prepare("
        SELECT cr.*, c.price, c.duration 
        FROM course_recommendations cr
        LEFT JOIN courses c ON cr.course_id = c.id
        WHERE cr.user_id = ? AND cr.status IN ('pending', 'viewed') AND cr.expires_at > NOW()
        ORDER BY cr.relevance_score DESC, cr.created_at DESC
        LIMIT 6
    ");
    $stmt->execute([$user_id]);
    $course_recommendations = $stmt->fetchAll();
} catch (PDOException $e) {
    // Continue without recommendations
}

// Get user's quiz recommendations
$quiz_recommendations = [];
try {
    $stmt = $pdo->prepare("
        SELECT * FROM quiz_recommendations 
        WHERE user_id = ? AND status IN ('pending', 'viewed') AND expires_at > NOW()
        ORDER BY priority_score DESC, created_at DESC
        LIMIT 4
    ");
    $stmt->execute([$user_id]);
    $quiz_recommendations = $stmt->fetchAll();
} catch (PDOException $e) {
    // Continue without recommendations
}

// Get user's career path recommendations
$career_recommendations = [];
try {
    $stmt = $pdo->prepare("
        SELECT * FROM career_path_recommendations 
        WHERE user_id = ? AND status IN ('suggested', 'following')
        ORDER BY compatibility_score DESC, created_at DESC
        LIMIT 3
    ");
    $stmt->execute([$user_id]);
    $career_recommendations = $stmt->fetchAll();
} catch (PDOException $e) {
    // Continue without recommendations
}

// Get user's learning analytics
$user_analytics = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM user_learning_analytics WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user_analytics = $stmt->fetch() ?: [];
} catch (PDOException $e) {
    // Continue without analytics
}

// Get user's recent notifications
$notifications = [];
try {
    $stmt = $pdo->prepare("
        SELECT * FROM user_notifications 
        WHERE user_id = ? AND expires_at > NOW() AND is_dismissed = FALSE
        ORDER BY priority DESC, created_at DESC
        LIMIT 5
    ");
    $stmt->execute([$user_id]);
    $notifications = $stmt->fetchAll();
} catch (PDOException $e) {
    // Continue without notifications
}

// Generate new recommendations if none exist
if (empty($course_recommendations) && empty($quiz_recommendations) && empty($career_recommendations)) {
    try {
        include 'includes/RecommendationEngine.php';
        $recommendationEngine = new RecommendationEngine($pdo);
        $course_recommendations = $recommendationEngine->generateCourseRecommendations($user_id, 6);
        $quiz_recommendations = $recommendationEngine->generateQuizRecommendations($user_id, 4);
        $career_recommendations = $recommendationEngine->generateCareerPathRecommendations($user_id, 3);
    } catch (Exception $e) {
        // Continue with empty recommendations
    }
}

include 'assets/header.php';
?>

<link rel="stylesheet" href="css/recommendations.css">

<div class="recommendations-container">
    <div class="container">
        <!-- Header Section -->
        <div class="recommendations-header">
            <div class="header-content">
                <h1><i class="fas fa-bullseye"></i> Your Personalized Recommendations</h1>
                <p>AI-powered suggestions tailored to your skills, goals, and learning preferences</p>
            </div>
            <div class="header-actions">
                <a href="skill-assessment.php" class="btn btn-primary">
                    <i class="fas fa-chart-line"></i> Update Skills Assessment
                </a>
            </div>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <!-- Notifications Section -->
        <?php if (!empty($notifications)): ?>
            <div class="notifications-section">
                <h2><i class="fas fa-bell"></i> Latest Notifications</h2>
                <div class="notifications-grid">
                    <?php foreach ($notifications as $notification): ?>
                        <div class="notification-card priority-<?php echo $notification['priority']; ?>">
                            <div class="notification-header">
                                <span class="notification-type"><?php echo ucwords(str_replace('_', ' ', $notification['notification_type'])); ?></span>
                                <span class="notification-time"><?php echo date('M j', strtotime($notification['created_at'])); ?></span>
                            </div>
                            <h3><?php echo htmlspecialchars($notification['title']); ?></h3>
                            <p><?php echo htmlspecialchars($notification['message']); ?></p>
                            <?php if ($notification['action_url']): ?>
                                <a href="<?php echo htmlspecialchars($notification['action_url']); ?>" class="notification-action">
                                    <?php echo htmlspecialchars($notification['action_text'] ?: 'Learn More'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Course Recommendations Section -->
        <div class="recommendations-section">
            <div class="section-header">
                <h2><i class="fas fa-graduation-cap"></i> Recommended Courses</h2>
                <span class="recommendation-count"><?php echo count($course_recommendations); ?> courses found</span>
            </div>
            
            <?php if (empty($course_recommendations)): ?>
                <div class="no-recommendations">
                    <div class="no-recommendations-icon">🎯</div>
                    <h3>No Course Recommendations Yet</h3>
                    <p>Complete your skills assessment to get personalized course recommendations</p>
                    <a href="skill-assessment.php" class="btn btn-primary">Take Assessment</a>
                </div>
            <?php else: ?>
                <div class="recommendations-grid">
                    <?php foreach ($course_recommendations as $course): ?>
                        <div class="recommendation-card course-card">
                            <div class="recommendation-header">
                                <div class="recommendation-score">
                                    <span class="score-label">Match</span>
                                    <span class="score-value"><?php echo round($course['relevance_score'] * 10); ?>%</span>
                                </div>
                                <div class="recommendation-type">Course</div>
                            </div>
                            
                            <div class="recommendation-content">
                                <h3><?php echo htmlspecialchars($course['course_title']); ?></h3>
                                <p class="recommendation-reason">
                                    <i class="fas fa-lightbulb"></i>
                                    <?php echo htmlspecialchars($course['recommendation_reason']); ?>
                                </p>
                                
                                <div class="course-details">
                                    <div class="detail-item">
                                        <i class="fas fa-clock"></i>
                                        <span><?php echo $course['duration'] ?: ($course['estimated_completion_days'] . ' days'); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-layer-group"></i>
                                        <span><?php echo ucfirst($course['difficulty_match']); ?> level</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-dollar-sign"></i>
                                        <span>$<?php echo number_format($course['price'] ?: 99, 0); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="recommendation-actions">
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                                    <input type="hidden" name="course_title" value="<?php echo htmlspecialchars($course['course_title']); ?>">
                                    <input type="hidden" name="course_price" value="<?php echo $course['price'] ?: 99; ?>">
                                    <input type="hidden" name="recommendation_id" value="<?php echo $course['id']; ?>">
                                    <button type="submit" name="enroll_course" class="btn btn-primary">
                                        <i class="fas fa-rocket"></i> Enroll Now
                                    </button>
                                </form>
                                
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="rec_id" value="<?php echo $course['id']; ?>">
                                    <input type="hidden" name="rec_type" value="course">
                                    <button type="submit" name="dismiss_recommendation" class="btn btn-secondary">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Quiz Recommendations Section -->
        <div class="recommendations-section">
            <div class="section-header">
                <h2><i class="fas fa-brain"></i> Recommended Skill Assessments</h2>
                <span class="recommendation-count"><?php echo count($quiz_recommendations); ?> assessments available</span>
            </div>
            
            <?php if (empty($quiz_recommendations)): ?>
                <div class="no-recommendations">
                    <div class="no-recommendations-icon">🧠</div>
                    <h3>No Quiz Recommendations Yet</h3>
                    <p>Complete your skills assessment to get personalized quiz suggestions</p>
                </div>
            <?php else: ?>
                <div class="quiz-grid">
                    <?php foreach ($quiz_recommendations as $quiz): ?>
                        <div class="recommendation-card quiz-card">
                            <div class="quiz-header">
                                <div class="quiz-priority priority-<?php echo str_replace('.', '-', $quiz['priority_score']); ?>">
                                    Priority: <?php echo round($quiz['priority_score'], 1); ?>/10
                                </div>
                                <div class="quiz-duration">
                                    <i class="fas fa-clock"></i> <?php echo $quiz['estimated_duration_minutes']; ?> min
                                </div>
                            </div>
                            
                            <div class="quiz-content">
                                <div class="quiz-category"><?php echo htmlspecialchars($quiz['quiz_category']); ?></div>
                                <h3><?php echo htmlspecialchars($quiz['quiz_title']); ?></h3>
                                <p><?php echo htmlspecialchars($quiz['quiz_description']); ?></p>
                                
                                <div class="skills-assessed">
                                    <span class="skills-label">Skills Assessed:</span>
                                    <?php 
                                    $skills = json_decode($quiz['skills_assessed'], true);
                                    if ($skills): 
                                        foreach ($skills as $skill): 
                                    ?>
                                        <span class="skill-tag"><?php echo ucwords(str_replace('_', ' ', $skill)); ?></span>
                                    <?php 
                                        endforeach;
                                    endif; 
                                    ?>
                                </div>
                                
                                <div class="quiz-reason">
                                    <i class="fas fa-info-circle"></i>
                                    <?php echo htmlspecialchars($quiz['recommendation_reason']); ?>
                                </div>
                            </div>
                            
                            <div class="quiz-actions">
                                <a href="quiz/main.php?category=<?php echo urlencode($quiz['quiz_category']); ?>" class="btn btn-primary">
                                    <i class="fas fa-play"></i> Start Assessment
                                </a>
                                
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="rec_id" value="<?php echo $quiz['id']; ?>">
                                    <input type="hidden" name="rec_type" value="quiz">
                                    <button type="submit" name="dismiss_recommendation" class="btn btn-secondary">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Career Path Recommendations Section -->
        <div class="recommendations-section">
            <div class="section-header">
                <h2><i class="fas fa-route"></i> Recommended Career Paths</h2>
                <span class="recommendation-count"><?php echo count($career_recommendations); ?> paths suggested</span>
            </div>
            
            <?php if (empty($career_recommendations)): ?>
                <div class="no-recommendations">
                    <div class="no-recommendations-icon">🚀</div>
                    <h3>No Career Path Recommendations Yet</h3>
                    <p>Complete your career goals to get personalized path suggestions</p>
                </div>
            <?php else: ?>
                <div class="career-paths-grid">
                    <?php foreach ($career_recommendations as $path): ?>
                        <div class="recommendation-card career-path-card">
                            <div class="career-path-header">
                                <div class="compatibility-score">
                                    <div class="score-circle">
                                        <span><?php echo round($path['compatibility_score'] * 10); ?>%</span>
                                    </div>
                                    <span class="score-label">Compatibility</span>
                                </div>
                                <div class="path-timeline">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php echo $path['estimated_timeline_months']; ?> months
                                </div>
                            </div>
                            
                            <div class="career-path-content">
                                <h3><?php echo htmlspecialchars($path['path_name']); ?></h3>
                                <p class="path-description"><?php echo htmlspecialchars($path['path_description']); ?></p>
                                
                                <div class="path-progression">
                                    <div class="progression-item">
                                        <span class="progression-label">From:</span>
                                        <span class="current-role"><?php echo htmlspecialchars($path['current_role']); ?></span>
                                    </div>
                                    <div class="progression-arrow">→</div>
                                    <div class="progression-item">
                                        <span class="progression-label">To:</span>
                                        <span class="target-role"><?php echo htmlspecialchars($path['target_role']); ?></span>
                                    </div>
                                </div>
                                
                                <div class="path-industry">
                                    <i class="fas fa-industry"></i>
                                    Industry: <?php echo htmlspecialchars($path['industry']); ?>
                                </div>
                                
                                <div class="path-milestones">
                                    <h4>Key Milestones:</h4>
                                    <?php 
                                    $milestones = json_decode($path['milestones'], true);
                                    if ($milestones && is_array($milestones)): 
                                    ?>
                                        <ul class="milestones-list">
                                            <?php foreach (array_slice($milestones, 0, 3) as $milestone): ?>
                                                <li><?php echo htmlspecialchars($milestone); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="career-path-actions">
                                <?php if ($path['status'] !== 'following'): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="path_id" value="<?php echo $path['id']; ?>">
                                        <button type="submit" name="follow_career_path" class="btn btn-primary">
                                            <i class="fas fa-route"></i> Follow This Path
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="following-indicator">
                                        <i class="fas fa-check-circle"></i> Following
                                    </div>
                                <?php endif; ?>
                                
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="rec_id" value="<?php echo $path['id']; ?>">
                                    <input type="hidden" name="rec_type" value="career">
                                    <button type="submit" name="dismiss_recommendation" class="btn btn-secondary">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'assets/footer.php'; ?>

<script>
// Auto-hide success messages
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert-success');
    alerts.forEach(function(alert) {
        alert.style.opacity = '0';
        setTimeout(function() {
            alert.style.display = 'none';
        }, 300);
    });
}, 5000);

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>