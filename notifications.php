<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle mark as read action
if (isset($_POST['mark_read']) && isset($_POST['notification_id'])) {
    try {
        $stmt = $pdo->prepare("UPDATE user_notifications SET is_read = 1, read_at = NOW() WHERE id = ? AND user_id = ?");
        $stmt->execute([$_POST['notification_id'], $user_id]);
    } catch (PDOException $e) {
        error_log("Error marking notification as read: " . $e->getMessage());
    }
    header("Location: notifications.php");
    exit();
}

// Handle mark all as read action
if (isset($_POST['mark_all_read'])) {
    try {
        $stmt = $pdo->prepare("UPDATE user_notifications SET is_read = 1, read_at = NOW() WHERE user_id = ? AND is_read = 0");
        $stmt->execute([$user_id]);
    } catch (PDOException $e) {
        error_log("Error marking all notifications as read: " . $e->getMessage());
    }
    header("Location: notifications.php");
    exit();
}

// Get user notifications
$notifications = [];
$unread_count = 0;

try {
    // Get all user notifications ordered by newest first
    $stmt = $pdo->prepare("SELECT * FROM user_notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 50");
    $stmt->execute([$user_id]);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get unread count
    $unread_stmt = $pdo->prepare("SELECT COUNT(*) as count FROM user_notifications WHERE user_id = ? AND is_read = 0");
    $unread_stmt->execute([$user_id]);
    $unread_result = $unread_stmt->fetch(PDO::FETCH_ASSOC);
    $unread_count = $unread_result['count'];
    
} catch (PDOException $e) {
    error_log("Error fetching notifications: " . $e->getMessage());
}

// Create sample notification if user has none (for demo purposes)
if (empty($notifications)) {
    try {
        require_once 'includes/SimpleNotifications.php';
        createSampleNotifications($pdo, $user_id);
        
        // Re-fetch notifications
        $stmt = $pdo->prepare("SELECT * FROM user_notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 50");
        $stmt->execute([$user_id]);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Update unread count
        $unread_stmt = $pdo->prepare("SELECT COUNT(*) as count FROM user_notifications WHERE user_id = ? AND is_read = 0");
        $unread_stmt->execute([$user_id]);
        $unread_result = $unread_stmt->fetch(PDO::FETCH_ASSOC);
        $unread_count = $unread_result['count'];
        
    } catch (Exception $e) {
        error_log("Error creating sample notifications: " . $e->getMessage());
    }
}

// Helper function to get notification icon
function getNotificationIcon($type) {
    switch ($type) {
        case 'message_sent':
            return '<i class="fas fa-paper-plane"></i>';
        case 'enrollment_submitted':
            return '<i class="fas fa-file-alt"></i>';
        case 'enrollment_accepted':
            return '<i class="fas fa-check-circle"></i>';
        case 'enrollment_rejected':
            return '<i class="fas fa-times-circle"></i>';
        case 'enrollment_under_review':
            return '<i class="fas fa-clock"></i>';
        default:
            return '<i class="fas fa-bell"></i>';
    }
}

// Helper function to get notification color class
function getNotificationClass($type) {
    switch ($type) {
        case 'message_sent':
            return 'notification-info';
        case 'enrollment_submitted':
            return 'notification-info';
        case 'enrollment_accepted':
            return 'notification-success';
        case 'enrollment_rejected':
            return 'notification-danger';
        case 'enrollment_under_review':
            return 'notification-warning';
        default:
            return 'notification-info';
    }
}

// Helper function to format time ago
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) return 'Just now';
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
    <title><?php echo $unread_count > 0 ? "({$unread_count}) " : ""; ?>Notifications - BeThePro's</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .notifications-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .notifications-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .notifications-header h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .unread-count {
            background: #e74c3c;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-left: 1rem;
        }
        
        .notifications-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #545b62;
        }
        
        .notifications-list {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
        }
        
        .notifications-list::-webkit-scrollbar {
            width: 8px;
        }
        
        .notifications-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .notifications-list::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
        }
        
        .notifications-list::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
        }
        
        .scroll-indicator {
            position: sticky;
            bottom: 0;
            background: linear-gradient(to top, rgba(255,255,255,1), rgba(255,255,255,0));
            padding: 10px;
            text-align: center;
            font-size: 0.9rem;
            color: #666;
            pointer-events: none;
            z-index: 1;
        }
        
        .notification-item {
            display: flex;
            align-items: flex-start;
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .notification-item:hover {
            background: #f8f9fa;
        }
        
        .notification-item.unread {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.05), rgba(255,255,255,0.05));
            border-left: 4px solid #667eea;
        }
        
        .notification-icon {
            font-size: 1.5rem;
            margin-right: 1rem;
            margin-top: 0.2rem;
        }
        
        .notification-success .notification-icon {
            color: #28a745;
        }
        
        .notification-danger .notification-icon {
            color: #dc3545;
        }
        
        .notification-warning .notification-icon {
            color: #ffc107;
        }
        
        .notification-info .notification-icon {
            color: #17a2b8;
        }
        
        .notification-content {
            flex-grow: 1;
        }
        
        .notification-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        
        .notification-message {
            color: #666;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }
        
        .notification-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            color: #999;
        }
        
        .notification-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            border-radius: 15px;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ddd;
        }
    </style>
</head>
<body>
    <?php include 'assets/header.php'; ?>
    
    <div class="notifications-container">
        <div class="notifications-header">
            <h1>
                <i class="fas fa-bell"></i> 
                Notifications
                <?php if ($unread_count > 0): ?>
                    <span class="unread-count"><?php echo $unread_count; ?> new</span>
                <?php endif; ?>
            </h1>
            <p>Stay updated on your messages, enrollments, and account activities</p>
        </div>

        <?php if (!empty($notifications)): ?>
        <div class="notifications-actions">
            <div>
                <span><strong><?php echo count($notifications); ?></strong> total notifications</span>
                <span id="scrollProgress" class="scroll-progress" style="margin-left: 1rem; color: #666; font-size: 0.9rem;"></span>
            </div>
            <div>
                <?php if ($unread_count > 0): ?>
                <button id="jumpToUnread" class="btn btn-primary btn-sm" style="margin-right: 0.5rem;">
                    <i class="fas fa-arrow-down"></i> Jump to First Unread
                </button>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="mark_all_read" class="btn btn-secondary btn-sm">
                        <i class="fas fa-check-double"></i> Mark All Read
                    </button>
                </form>
                <?php endif; ?>
                <a href="index.php" class="btn btn-primary btn-sm">
                    <i class="fas fa-home"></i> Back to Dashboard
                </a>
            </div>
        </div>

        <div class="notifications-list">
            <?php foreach ($notifications as $notification): ?>
            <div class="notification-item <?php echo !$notification['is_read'] ? 'unread' : ''; ?> <?php echo getNotificationClass($notification['notification_type']); ?>">
                <div class="notification-icon">
                    <?php echo getNotificationIcon($notification['notification_type']); ?>
                </div>
                <div class="notification-content">
                    <div class="notification-title">
                        <?php echo htmlspecialchars($notification['title']); ?>
                        <?php if (!$notification['is_read']): ?>
                            <span style="color: #e74c3c; font-size: 0.8rem;">(New)</span>
                        <?php endif; ?>
                    </div>
                    <div class="notification-message">
                        <?php echo htmlspecialchars($notification['message']); ?>
                    </div>
                    <div class="notification-meta">
                        <span><?php echo timeAgo($notification['created_at']); ?></span>
                        <div class="notification-actions">
                            <?php if (!$notification['is_read']): ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="notification_id" value="<?php echo $notification['id']; ?>">
                                <button type="submit" name="mark_read" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-check"></i> Mark Read
                                </button>
                            </form>
                            <?php else: ?>
                            <span style="color: #28a745; font-size: 0.8rem;">
                                <i class="fas fa-check"></i> Read
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="notifications-list">
            <div class="empty-state">
                <i class="fas fa-bell-slash"></i>
                <h3>No Notifications Yet</h3>
                <p>You'll see notifications here when you send messages, submit enrollments, or receive updates from our team.</p>
                <a href="index.php" class="btn btn-primary">
                    <i class="fas fa-home"></i> Go to Dashboard
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php include 'assets/footer.php'; ?>

    <!-- Scroll to Top Button -->
    <div id="scrollToTop" class="scroll-to-top">
        <i class="fas fa-chevron-up"></i>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationsList = document.querySelector('.notifications-list');
            const scrollToTopBtn = document.getElementById('scrollToTop');
            const scrollProgress = document.getElementById('scrollProgress');
            
            // Show/hide scroll to top button and update progress based on scroll position
            if (notificationsList) {
                notificationsList.addEventListener('scroll', function() {
                    const scrollTop = this.scrollTop;
                    const scrollHeight = this.scrollHeight;
                    const clientHeight = this.clientHeight;
                    const scrollPercent = Math.round((scrollTop / (scrollHeight - clientHeight)) * 100);
                    
                    // Update scroll progress
                    if (scrollProgress && scrollHeight > clientHeight) {
                        scrollProgress.textContent = `• ${scrollPercent}% scrolled`;
                    }
                    
                    // Show/hide scroll to top button
                    if (scrollTop > 200) {
                        scrollToTopBtn.classList.add('show');
                    } else {
                        scrollToTopBtn.classList.remove('show');
                    }
                });
                
                // Smooth scroll to top functionality
                scrollToTopBtn.addEventListener('click', function() {
                    notificationsList.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
            
            // Jump to first unread notification
            const jumpToUnreadBtn = document.getElementById('jumpToUnread');
            if (jumpToUnreadBtn) {
                jumpToUnreadBtn.addEventListener('click', function() {
                    const firstUnread = document.querySelector('.notification-item.unread');
                    if (firstUnread) {
                        firstUnread.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        
                        // Highlight the notification briefly
                        firstUnread.style.boxShadow = '0 0 20px rgba(102, 126, 234, 0.5)';
                        setTimeout(() => {
                            firstUnread.style.boxShadow = '';
                        }, 2000);
                    }
                });
                
                // Add scroll indicator if content overflows
                if (notificationsList.scrollHeight > notificationsList.clientHeight) {
                    const scrollIndicator = document.createElement('div');
                    scrollIndicator.className = 'scroll-indicator';
                    scrollIndicator.innerHTML = '<i class="fas fa-chevron-down"></i> Scroll for more notifications';
                    notificationsList.appendChild(scrollIndicator);
                    
                    // Hide indicator when scrolled to bottom
                    notificationsList.addEventListener('scroll', function() {
                        const isAtBottom = this.scrollTop + this.clientHeight >= this.scrollHeight - 10;
                        scrollIndicator.style.opacity = isAtBottom ? '0' : '1';
                    });
                }
            }
            
            // Smooth scrolling for notification items
            const notificationItems = document.querySelectorAll('.notification-item');
            notificationItems.forEach(function(item, index) {
                item.style.animationDelay = (index * 0.1) + 's';
                item.classList.add('fade-in');
                
                // Add keyboard navigation
                item.setAttribute('tabindex', '0');
                item.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const button = this.querySelector('button[name="mark_read"]');
                        if (button) {
                            button.click();
                        }
                    }
                });
            });
            
            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + Home: Scroll to top
                if ((e.ctrlKey || e.metaKey) && e.key === 'Home' && notificationsList) {
                    e.preventDefault();
                    notificationsList.scrollTo({ top: 0, behavior: 'smooth' });
                }
                
                // Ctrl/Cmd + End: Scroll to bottom
                if ((e.ctrlKey || e.metaKey) && e.key === 'End' && notificationsList) {
                    e.preventDefault();
                    notificationsList.scrollTo({ top: notificationsList.scrollHeight, behavior: 'smooth' });
                }
            });
        });
    </script>

    <style>
        /* Scroll to Top Button */
        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            z-index: 1000;
        }
        
        .scroll-to-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .scroll-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .scroll-to-top i {
            font-size: 1.2rem;
        }
        
        /* Fade in animation for notification items */
        .notification-item {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Enhanced scroll indicator */
        .scroll-indicator {
            transition: opacity 0.3s ease;
            background: linear-gradient(to top, rgba(255,255,255,0.95), rgba(255,255,255,0));
            backdrop-filter: blur(5px);
        }
        
        .scroll-indicator i {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        /* Responsive adjustments for mobile */
        @media (max-width: 768px) {
            .notifications-list {
                max-height: 70vh;
            }
            
            .scroll-to-top {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
            }
            
            .scroll-to-top i {
                font-size: 1rem;
            }
            
            .notifications-container {
                padding: 0 0.5rem;
            }
        }
        
        /* Smooth scrolling for the entire page */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom focus styles for accessibility */
        .scroll-to-top:focus {
            outline: 2px solid #667eea;
            outline-offset: 2px;
        }
        
        .notification-item:focus-within {
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
            border-radius: 8px;
        }
    </style>

</body>
</html>
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
            <div class="empty-icon"><i class="fas fa-bell"></i></div>
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