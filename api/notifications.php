<?php
// Notifications API
// Handles AJAX requests for notification operations

session_start();
require_once 'config/database.php';
require_once 'includes/NotificationSystem.php';

// Set JSON response header
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];
$notificationSystem = new NotificationSystem($pdo);

// Handle different API actions
$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'get_unread_count':
        try {
            $count = $notificationSystem->getUnreadCount($user_id);
            echo json_encode(['success' => true, 'count' => $count]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to get notification count']);
        }
        break;
    
    case 'get_recent':
        try {
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
            $notifications = $notificationSystem->getRecentNotifications($user_id, $limit);
            
            // Format notifications for display
            $formatted = [];
            foreach ($notifications as $notification) {
                $formatted[] = [
                    'id' => $notification['id'],
                    'title' => $notification['title'],
                    'message' => $notification['message'],
                    'type' => $notification['notification_type'],
                    'priority' => $notification['priority'],
                    'is_read' => (bool)$notification['is_read'],
                    'action_url' => $notification['action_url'],
                    'action_text' => $notification['action_text'],
                    'created_at' => $notification['created_at'],
                    'time_ago' => timeAgo($notification['created_at'])
                ];
            }
            
            echo json_encode(['success' => true, 'notifications' => $formatted]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to get notifications']);
        }
        break;
    
    case 'mark_read':
        try {
            $notification_id = $_POST['notification_id'] ?? 0;
            $result = $notificationSystem->markAsRead($notification_id, $user_id);
            echo json_encode(['success' => $result]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to mark notification as read']);
        }
        break;
    
    case 'mark_all_read':
        try {
            $stmt = $pdo->prepare("
                UPDATE user_notifications 
                SET is_read = TRUE, read_at = NOW() 
                WHERE user_id = ? AND is_read = FALSE
            ");
            $result = $stmt->execute([$user_id]);
            echo json_encode(['success' => $result]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to mark all notifications as read']);
        }
        break;
    
    case 'dismiss':
        try {
            $notification_id = $_POST['notification_id'] ?? 0;
            $result = $notificationSystem->dismissNotification($notification_id, $user_id);
            echo json_encode(['success' => $result]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to dismiss notification']);
        }
        break;
    
    case 'generate':
        try {
            // Generate fresh notifications for current user
            $notificationSystem->generateUserNotifications($user_id);
            $count = $notificationSystem->getUnreadCount($user_id);
            echo json_encode(['success' => true, 'new_count' => $count]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to generate notifications']);
        }
        break;
    
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
        break;
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