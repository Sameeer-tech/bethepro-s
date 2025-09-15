<?php
// Generate Notifications Script
// This script should be run regularly via cron job to generate notifications for all users

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/NotificationSystem.php';

// Set script timeout to prevent long-running processes
set_time_limit(300); // 5 minutes

echo "Starting notification generation process...\n";
$start_time = microtime(true);

try {
    $notificationSystem = new NotificationSystem($pdo);
    
    // Generate notifications for all active users
    $notificationSystem->generateAllUserNotifications();
    
    // Get statistics
    $stmt = $pdo->query("
        SELECT 
            COUNT(*) as total_notifications,
            COUNT(CASE WHEN is_read = FALSE THEN 1 END) as unread_notifications,
            COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY) THEN 1 END) as recent_notifications
        FROM user_notifications
        WHERE expires_at > NOW()
    ");
    $stats = $stmt->fetch();
    
    // Clean up expired notifications
    $stmt = $pdo->query("DELETE FROM user_notifications WHERE expires_at < NOW()");
    $deleted_count = $stmt->rowCount();
    
    $end_time = microtime(true);
    $execution_time = round($end_time - $start_time, 2);
    
    echo "Notification generation completed successfully!\n";
    echo "Execution time: {$execution_time} seconds\n";
    echo "Statistics:\n";
    echo "- Total active notifications: " . $stats['total_notifications'] . "\n";
    echo "- Unread notifications: " . $stats['unread_notifications'] . "\n";
    echo "- Recent notifications (24h): " . $stats['recent_notifications'] . "\n";
    echo "- Expired notifications deleted: {$deleted_count}\n";
    
} catch (Exception $e) {
    echo "Error generating notifications: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Process completed at: " . date('Y-m-d H:i:s') . "\n";
?>