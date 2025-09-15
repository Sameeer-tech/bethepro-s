<?php
session_start();
require_once 'config/database.php';
require_once 'includes/NotificationSystem.php';
include 'assets/loader.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$notificationSystem = new NotificationSystem($pdo);

// Handle notification actions
if ($_POST) {
    if (isset($_POST['action'])) {
        $notification_id = isset($_POST['notification_id']) ? (int)$_POST['notification_id'] : 0;
        
        switch ($_POST['action']) {
            case 'mark_read':
                $notificationSystem->markAsRead($notification_id, $user_id);
                break;
            case 'dismiss':
                $notificationSystem->dismissNotification($notification_id, $user_id);
                break;
            case 'mark_all_read':
                // Mark all unread notifications as read
                try {
                    $stmt = $pdo->prepare("
                        UPDATE user_notifications 
                        SET is_read = TRUE, read_at = NOW() 
                        WHERE user_id = ? AND is_read = FALSE
                    ");
                    $stmt->execute([$user_id]);
                } catch (PDOException $e) {
                    error_log("Error marking all as read: " . $e->getMessage());
                }
                break;
        }
        
        // Redirect to prevent form resubmission
        header("Location: notifications.php");
        exit();
    }
}

// Generate fresh notifications for the user
$notificationSystem->generateUserNotifications($user_id);

// Get notifications
$recent_notifications = $notificationSystem->getRecentNotifications($user_id, 50);
$unread_count = $notificationSystem->getUnreadCount($user_id);

// Group notifications by type
$grouped_notifications = [];
foreach ($recent_notifications as $notification) {
    $type = $notification['notification_type'];
    if (!isset($grouped_notifications[$type])) {
        $grouped_notifications[$type] = [];
    }
    $grouped_notifications[$type][] = $notification;
}

// Get user info for header
try {
    $stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    $user_name = $user ? $user['name'] : 'User';
} catch (PDOException $e) {
    $user_name = 'User';
}

function getNotificationIcon($type) {
    $icons = [
        'course_recommendation' => '📚',
        'quiz_recommendation' => '🎯',
        'skill_assessment' => '📊',
        'progress_update' => '📈',
        'career_opportunity' => '🚀',
        'milestone_achieved' => '🏆',
        'system_update' => '🔔',
        'reminder' => '⏰'
    ];
    return isset($icons[$type]) ? $icons[$type] : '📌';
}

function getNotificationTypeLabel($type) {
    $labels = [
        'course_recommendation' => 'Course Recommendations',
        'quiz_recommendation' => 'Quiz Suggestions',
        'skill_assessment' => 'Skill Assessment',
        'progress_update' => 'Progress Updates',
        'career_opportunity' => 'Career Opportunities',
        'milestone_achieved' => 'Achievements',
        'system_update' => 'System Updates',
        'reminder' => 'Reminders'
    ];
    return isset($labels[$type]) ? $labels[$type] : 'Notifications';
}

function getPriorityClass($priority) {
    switch (strtolower($priority)) {
        case 'urgent': return 'priority-urgent';
        case 'high': return 'priority-high';
        case 'medium': return 'priority-medium';
        case 'low': return 'priority-low';
        default: return 'priority-medium';
    }
}

function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) return 'just now';
    if ($time < 3600) return floor($time/60) . ' minutes ago';
    if ($time < 86400) return floor($time/3600) . ' hours ago';
    if ($time < 2592000) return floor($time/86400) . ' days ago';
    return date('M j, Y', strtotime($datetime));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - BeThePro</title>
    <link rel="stylesheet" href="css/notifications.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'assets/header.php'; ?>
    
    <div class="notifications-container">
        <div class="notifications-header">
            <div class="header-content">
                <h1>Your Notifications</h1>
                <p>Stay updated on your learning journey and career progress</p>
            </div>
            
            <div class="notification-stats">
                <div class="stat-item">
                    <span class="stat-number"><?php echo count($recent_notifications); ?></span>
                    <span class="stat-label">Total Notifications</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number unread-count"><?php echo $unread_count; ?></span>
                    <span class="stat-label">Unread</span>
                </div>
            </div>
            
            <div class="header-actions">
                <?php if ($unread_count > 0): ?>
                <form method="POST" class="inline-form">
                    <input type="hidden" name="action" value="mark_all_read">
                    <button type="submit" class="btn btn-secondary">
                        Mark All as Read
                    </button>
                </form>
                <?php endif; ?>
                
                <a href="recommendations.php" class="btn btn-primary">
                    View Recommendations
                </a>
            </div>
        </div>
        
        <?php if (empty($recent_notifications)): ?>
        <div class="empty-state">
            <div class="empty-icon">🔔</div>
            <h3>No Notifications Yet</h3>
            <p>Complete your skill assessment to start receiving personalized notifications about courses, quizzes, and career opportunities!</p>
            <a href="skill-assessment.php" class="btn btn-primary">Take Skill Assessment</a>
        </div>
        <?php else: ?>
        
        <div class="notifications-content">
            <?php foreach ($grouped_notifications as $type => $notifications): ?>
            <div class="notification-group">
                <div class="group-header">
                    <h2>
                        <span class="group-icon"><?php echo getNotificationIcon($type); ?></span>
                        <?php echo getNotificationTypeLabel($type); ?>
                        <span class="group-count">(<?php echo count($notifications); ?>)</span>
                    </h2>
                </div>
                
                <div class="notifications-list">
                    <?php foreach ($notifications as $notification): ?>
                    <div class="notification-card <?php echo !$notification['is_read'] ? 'unread' : ''; ?> <?php echo getPriorityClass($notification['priority']); ?>">
                        <div class="notification-content">
                            <div class="notification-main">
                                <h3 class="notification-title"><?php echo htmlspecialchars($notification['title']); ?></h3>
                                <p class="notification-message"><?php echo htmlspecialchars($notification['message']); ?></p>
                                
                                <div class="notification-meta">
                                    <span class="notification-time"><?php echo timeAgo($notification['created_at']); ?></span>
                                    <span class="priority-badge priority-<?php echo strtolower($notification['priority']); ?>">
                                        <?php echo ucfirst($notification['priority']); ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="notification-actions">
                                <?php if ($notification['action_url']): ?>
                                <a href="<?php echo htmlspecialchars($notification['action_url']); ?>" 
                                   class="btn btn-primary btn-sm notification-cta">
                                    <?php echo htmlspecialchars($notification['action_text'] ?: 'View'); ?>
                                </a>
                                <?php endif; ?>
                                
                                <div class="action-buttons">
                                    <?php if (!$notification['is_read']): ?>
                                    <form method="POST" class="inline-form">
                                        <input type="hidden" name="action" value="mark_read">
                                        <input type="hidden" name="notification_id" value="<?php echo $notification['id']; ?>">
                                        <button type="submit" class="btn-icon" title="Mark as Read">
                                            ✓
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    
                                    <form method="POST" class="inline-form">
                                        <input type="hidden" name="action" value="dismiss">
                                        <input type="hidden" name="notification_id" value="<?php echo $notification['id']; ?>">
                                        <button type="submit" class="btn-icon dismiss-btn" title="Dismiss">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (!$notification['is_read']): ?>
                        <div class="unread-indicator"></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php endif; ?>
    </div>
    
    <?php include 'assets/footer.php'; ?>
    
    <script>
        // Auto-refresh notifications every 5 minutes
        setTimeout(() => {
            window.location.reload();
        }, 5 * 60 * 1000);
        
        // Mark notification as read when CTA is clicked
        document.querySelectorAll('.notification-cta').forEach(cta => {
            cta.addEventListener('click', function(e) {
                const card = this.closest('.notification-card');
                if (card.classList.contains('unread')) {
                    // Auto-mark as read when user clicks the action
                    const notificationId = card.querySelector('input[name="notification_id"]').value;
                    
                    fetch('', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=mark_read&notification_id=${notificationId}`
                    });
                    
                    card.classList.remove('unread');
                    card.querySelector('.unread-indicator')?.remove();
                    
                    // Update unread count
                    const countElement = document.querySelector('.unread-count');
                    const currentCount = parseInt(countElement.textContent);
                    countElement.textContent = Math.max(0, currentCount - 1);
                }
            });
        });
        
        // Smooth animations for form submissions
        document.querySelectorAll('.inline-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button');
                button.style.opacity = '0.5';
                button.disabled = true;
            });
        });
        
        // Add click animation to notification cards
        document.querySelectorAll('.notification-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.closest('.notification-actions')) {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 100);
                }
            });
        });
    </script>
</body>
</html>