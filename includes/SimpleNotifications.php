<?php
/**
 * Simple function to create test notifications for demonstration
 * This can be called from anywhere to create sample notifications
 */

function createSampleNotifications($pdo, $user_id) {
    try {
        // Check if user already has notifications
        $checkStmt = $pdo->prepare("SELECT COUNT(*) as count FROM user_notifications WHERE user_id = ?");
        $checkStmt->execute([$user_id]);
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] == 0) {
            // Create sample notifications
            $sampleNotifications = [
                [
                    'type' => 'enrollment_under_review',
                    'title' => 'Welcome to BeThePro\'s!',
                    'message' => 'Welcome to our platform! Submit an enrollment or send us a message to start receiving notifications about your activities.',
                    'priority' => 'medium'
                ]
            ];
            
            $stmt = $pdo->prepare("
                INSERT INTO user_notifications (user_id, notification_type, title, message, priority, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            
            foreach ($sampleNotifications as $notification) {
                $stmt->execute([
                    $user_id,
                    $notification['type'],
                    $notification['title'],
                    $notification['message'],
                    $notification['priority']
                ]);
            }
        }
    } catch (Exception $e) {
        error_log("Failed to create sample notifications: " . $e->getMessage());
    }
}

/**
 * Function to create a notification for any user action
 */
function createUserNotification($pdo, $user_id, $type, $title, $message, $priority = 'medium', $enrollment_id = null) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO user_notifications (user_id, notification_type, title, message, enrollment_id, priority, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        
        return $stmt->execute([
            $user_id,
            $type,
            $title,
            $message,
            $enrollment_id,
            $priority
        ]);
    } catch (Exception $e) {
        error_log("Failed to create user notification: " . $e->getMessage());
        return false;
    }
}
?>