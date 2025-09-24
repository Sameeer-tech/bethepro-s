<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

try {
    include '../config/database.php';
    
    // Get POST data
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    $userEmail = $_POST['userEmail'] ?? '';
    
    // Validate input
    if (empty($subject) || empty($message) || empty($userEmail)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }
    
    // Find user
    $userStmt = $pdo->prepare("SELECT id, fullname FROM users WHERE email = ? LIMIT 1");
    $userStmt->execute([$userEmail]);
    $user = $userStmt->fetch();
    
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit;
    }
    
    // Create admin_replies table (bulletproof)
    $pdo->exec("CREATE TABLE IF NOT EXISTS admin_replies (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_email VARCHAR(255) NOT NULL,
        user_id INT NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insert reply
    $replyStmt = $pdo->prepare("INSERT INTO admin_replies (user_email, user_id, subject, message) VALUES (?, ?, ?, ?)");
    $replyResult = $replyStmt->execute([$userEmail, $user['id'], $subject, $message]);
    
    if (!$replyResult) {
        echo json_encode(['success' => false, 'message' => 'Failed to save reply']);
        exit;
    }
    
    // Handle notifications - check if table exists first
    try {
        // Try to check if user_notifications table exists
        $pdo->query("SELECT 1 FROM user_notifications LIMIT 1");
        
        // Table exists, try to insert
        $notifyStmt = $pdo->prepare("INSERT INTO user_notifications (user_id, notification_type, title, message, priority) VALUES (?, ?, ?, ?, ?)");
        $notifyStmt->execute([
            $user['id'],
            'admin_reply', 
            'New Reply from BeThePro',
            'You have received a reply to your message.',
            'high'
        ]);
        
    } catch (PDOException $e) {
        // Table doesn't exist or has different structure - create simple notifications table
        $pdo->exec("CREATE TABLE IF NOT EXISTS simple_notifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_email VARCHAR(255) NOT NULL,
            title VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        $pdo->prepare("INSERT INTO simple_notifications (user_email, title, message) VALUES (?, ?, ?)")
            ->execute([$userEmail, 'New Reply from BeThePro', 'You have received a reply to your message.']);
    }
    
    echo json_encode(['success' => true, 'message' => 'Reply sent successfully to ' . $user['fullname']]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}
?>