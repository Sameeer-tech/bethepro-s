<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['hasNewReplies' => false]);
    exit;
}

include 'config/database.php';

try {
    $user_id = $_SESSION['user_id'];
    
    // Get user email
    $userStmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
    $userStmt->execute([$user_id]);
    $user = $userStmt->fetch();
    
    if (!$user) {
        echo json_encode(['hasNewReplies' => false]);
        exit;
    }
    
    // Check for replies newer than last visit
    $lastCheck = $_SESSION['last_reply_check'] ?? date('Y-m-d H:i:s', strtotime('-1 hour'));
    
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as new_count 
        FROM admin_replies 
        WHERE user_email = ? 
        AND created_at > ?
    ");
    $stmt->execute([$user['email'], $lastCheck]);
    $result = $stmt->fetch();
    
    $hasNewReplies = $result['new_count'] > 0;
    
    // Update last check time
    $_SESSION['last_reply_check'] = date('Y-m-d H:i:s');
    
    echo json_encode([
        'hasNewReplies' => $hasNewReplies,
        'newCount' => $result['new_count']
    ]);
    
} catch (Exception $e) {
    echo json_encode(['hasNewReplies' => false]);
}
?>