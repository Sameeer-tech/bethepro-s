<?php
// Set JSON header first
header('Content-Type: application/json');

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors in output (breaks JSON)

session_start();

// Include database connection
try {
    include '../config/database.php';
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Check if user is admin (basic check - you might want to enhance this)
// Temporarily disabled for demo purposes - enable this in production
/*
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}
*/

// Get the action and data
$action = $_POST['action'] ?? '';
$messageId = $_POST['messageId'] ?? '';
$userId = $_POST['userId'] ?? '';
$status = $_POST['status'] ?? '';
$fullname = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$role = $_POST['role'] ?? '';

try {
    switch ($action) {
        case 'delete':
            if (empty($messageId)) {
                throw new Exception('Message ID is required');
            }
            
            $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
            $result = $stmt->execute([$messageId]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Message deleted successfully']);
            } else {
                throw new Exception('Failed to delete message');
            }
            break;
            
        case 'markAsRead':
            if (empty($messageId)) {
                throw new Exception('Message ID is required');
            }
            
            $stmt = $pdo->prepare("UPDATE contact_messages SET status = 'read', updated_at = NOW() WHERE id = ?");
            $result = $stmt->execute([$messageId]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Message marked as read']);
            } else {
                throw new Exception('Failed to mark message as read');
            }
            break;
            
        case 'markAllAsRead':
            $stmt = $pdo->prepare("UPDATE contact_messages SET status = 'read', updated_at = NOW() WHERE status = 'unread'");
            $result = $stmt->execute();
            
            if ($result) {
                $affectedRows = $stmt->rowCount();
                echo json_encode(['success' => true, 'message' => "Marked $affectedRows messages as read"]);
            } else {
                throw new Exception('Failed to mark all messages as read');
            }
            break;
            
        // User Management Actions
        case 'deleteUser':
            if (empty($userId)) {
                throw new Exception('User ID is required');
            }
            
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $result = $stmt->execute([$userId]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
            } else {
                throw new Exception('Failed to delete user');
            }
            break;
            
        case 'toggleUserStatus':
            if (empty($userId)) {
                throw new Exception('User ID is required');
            }
            
            $newStatus = ($status === 'Active') ? 'Inactive' : 'Active';
            $stmt = $pdo->prepare("UPDATE users SET status = ?, updated_at = NOW() WHERE id = ?");
            $result = $stmt->execute([$newStatus, $userId]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => "User status changed to $newStatus", 'newStatus' => $newStatus]);
            } else {
                throw new Exception('Failed to update user status');
            }
            break;
            
        case 'updateUser':
            if (empty($userId) || empty($fullname) || empty($email)) {
                throw new Exception('User ID, name, and email are required');
            }
            
            $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ?, role = ?, updated_at = NOW() WHERE id = ?");
            $result = $stmt->execute([$fullname, $email, $role, $userId]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'User updated successfully']);
            } else {
                throw new Exception('Failed to update user');
            }
            break;
            
        // Course Management Actions
        case 'add_course':
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $duration = $_POST['duration'] ?? '';
            $level = $_POST['level'] ?? '';
            $features = $_POST['features'] ?? '';
            
            if (empty($title) || empty($description) || empty($price) || empty($duration) || empty($features)) {
                throw new Exception('All course fields are required');
            }
            
            $stmt = $pdo->prepare("INSERT INTO courses (title, description, price, duration, level, features, status) VALUES (?, ?, ?, ?, ?, ?, 'Active')");
            $result = $stmt->execute([$title, $description, $price, $duration, $level, $features]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Course added successfully']);
            } else {
                throw new Exception('Failed to add course');
            }
            break;
            
        case 'edit_course':
            $courseId = $_POST['id'] ?? '';
            $title = $_POST['title'] ?? '';
            
            if (empty($courseId) || empty($title)) {
                throw new Exception('Course ID and title are required');
            }
            
            $stmt = $pdo->prepare("UPDATE courses SET title = ?, updated_at = NOW() WHERE id = ?");
            $result = $stmt->execute([$title, $courseId]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Course updated successfully']);
            } else {
                throw new Exception('Failed to update course');
            }
            break;
            
        case 'get_course_data':
            $courseId = $_POST['id'] ?? '';
            
            if (empty($courseId)) {
                throw new Exception('Course ID is required');
            }
            
            $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
            $stmt->execute([$courseId]);
            $course = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($course) {
                echo json_encode(['success' => true, 'data' => $course]);
            } else {
                throw new Exception('Course not found');
            }
            break;
            
        case 'update_course_full':
            $courseId = $_POST['id'] ?? '';
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $duration = $_POST['duration'] ?? '';
            $level = $_POST['level'] ?? '';
            $features = $_POST['features'] ?? '';
            
            if (empty($courseId) || empty($title) || empty($description) || empty($price) || empty($duration) || empty($features)) {
                throw new Exception('All course fields are required for update');
            }
            
            $stmt = $pdo->prepare("UPDATE courses SET title = ?, description = ?, price = ?, duration = ?, level = ?, features = ?, updated_at = NOW() WHERE id = ?");
            $result = $stmt->execute([$title, $description, $price, $duration, $level, $features, $courseId]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Course updated successfully with all information']);
            } else {
                throw new Exception('Failed to update course');
            }
            break;
            
        case 'delete_course':
            $courseId = $_POST['id'] ?? '';
            
            if (empty($courseId)) {
                throw new Exception('Course ID is required');
            }
            
            $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
            $result = $stmt->execute([$courseId]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Course deleted successfully']);
            } else {
                throw new Exception('Failed to delete course');
            }
            break;
            
        case 'send_reply':
            try {
                $subject = $_POST['subject'] ?? '';
                $message = $_POST['message'] ?? '';
                $userEmail = $_POST['userEmail'] ?? '';
                
                // Simple validation
                if (empty($subject) || empty($message) || empty($userEmail)) {
                    echo json_encode(['success' => false, 'message' => 'Subject, message, and user email are required']);
                    exit();
                }
                
                // Verify user exists
                $userCheckStmt = $pdo->prepare("SELECT id, fullname FROM users WHERE email = ?");
                $userCheckStmt->execute([$userEmail]);
                $userData = $userCheckStmt->fetch();
                
                if (!$userData) {
                    echo json_encode(['success' => false, 'message' => 'User not found with email: ' . $userEmail]);
                    exit();
                }
                
                // Create admin_replies table if needed (simple version)
                $pdo->exec("CREATE TABLE IF NOT EXISTS admin_replies (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_email VARCHAR(255) NOT NULL,
                    user_id INT,
                    subject VARCHAR(255) NOT NULL,
                    message TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )");
                
                // Insert admin reply
                $stmt = $pdo->prepare("INSERT INTO admin_replies (user_email, user_id, subject, message) VALUES (?, ?, ?, ?)");
                $result = $stmt->execute([$userEmail, $userData['id'], $subject, $message]);
                
                if ($result) {
                    // Create notification (simple version)
                    $notificationStmt = $pdo->prepare("INSERT INTO user_notifications (user_id, notification_type, title, message, priority) VALUES (?, ?, ?, ?, ?)");
                    $notificationStmt->execute([
                        $userData['id'], 
                        'admin_reply', 
                        'New Reply from BeThePro Admin', 
                        'You have received a reply to your message.',
                        'high'
                    ]);
                    
                    echo json_encode(['success' => true, 'message' => 'Reply sent successfully!']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to save reply']);
                }
                
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
            break;
            
        case 'accept_enrollment':
            $enrollment_id = $_POST['enrollment_id'] ?? '';
            
            if (empty($enrollment_id)) {
                throw new Exception('Enrollment ID is required');
            }
            
            try {
                // First check if enrollment exists
                $checkStmt = $pdo->prepare("SELECT * FROM enrollments WHERE enrollment_id = ?");
                $checkStmt->execute([$enrollment_id]);
                $enrollment = $checkStmt->fetch();
                
                if (!$enrollment) {
                    throw new Exception('Enrollment not found with ID: ' . $enrollment_id);
                }
                
                // Check if enrollment is already processed
                if ($enrollment['status'] === 'confirmed') {
                    throw new Exception('Enrollment is already confirmed');
                }
                if ($enrollment['status'] === 'rejected') {
                    throw new Exception('Cannot accept a rejected enrollment');
                }
                
                // Update enrollment status to confirmed and mark as admin viewed
                $stmt = $pdo->prepare("UPDATE enrollments SET status = 'confirmed', admin_viewed = 1, updated_at = NOW() WHERE enrollment_id = ?");
                $result = $stmt->execute([$enrollment_id]);
                
                if (!$result) {
                    throw new Exception('Failed to update enrollment status');
                }
                
                // Verify the update was successful
                $verifyStmt = $pdo->prepare("SELECT status FROM enrollments WHERE enrollment_id = ?");
                $verifyStmt->execute([$enrollment_id]);
                $updatedStatus = $verifyStmt->fetchColumn();
                
                if ($updatedStatus !== 'confirmed') {
                    throw new Exception('Failed to verify enrollment status update');
                }
                
                // Find the user by email to send notification
                $userStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                $userStmt->execute([$enrollment['email']]);
                $user = $userStmt->fetch();
                
                if ($user) {
                    // Ensure user_notifications table exists
                    try {
                        $pdo->query("SELECT 1 FROM user_notifications LIMIT 1");
                    } catch (PDOException $e) {
                        // Create user_notifications table if it doesn't exist
                        $createTableSQL = "
                            CREATE TABLE user_notifications (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                user_id INT NOT NULL,
                                notification_type VARCHAR(50) NOT NULL,
                                title VARCHAR(200) NOT NULL,
                                message TEXT NOT NULL,
                                priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
                                is_read TINYINT(1) DEFAULT 0,
                                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                INDEX idx_user_id (user_id)
                            )
                        ";
                        $pdo->exec($createTableSQL);
                    }
                    
                    // Send notification to user
                    try {
                        $notificationMessage = "Congratulations! Your enrollment has been accepted by the admin. You will be contacted within 24 hours with course details. Welcome to BeThePro!";
                        
                        $notificationStmt = $pdo->prepare("
                            INSERT INTO user_notifications (user_id, notification_type, title, message, priority, created_at) 
                            VALUES (?, ?, ?, ?, ?, NOW())
                        ");
                        $notificationStmt->execute([
                            $user['id'],
                            'enrollment_accepted',
                            'Enrollment Accepted!',
                            $notificationMessage,
                            'high'
                        ]);
                        
                        $notification_sent = true;
                    } catch (Exception $e) {
                        // Notification failed but enrollment still accepted
                        error_log("Failed to send notification: " . $e->getMessage());
                        $notification_sent = false;
                    }
                } else {
                    $notification_sent = false;
                }
                
                // Mark related admin notification as read
                try {
                    $markReadStmt = $pdo->prepare("UPDATE admin_notifications SET is_read = 1, updated_at = NOW() WHERE enrollment_id = ? AND notification_type = 'new_enrollment'");
                    $markReadStmt->execute([$enrollment_id]);
                } catch (Exception $e) {
                    error_log("Failed to mark admin notification as read: " . $e->getMessage());
                }
                
                echo json_encode(['success' => true, 'message' => 'Enrollment accepted successfully!']);
                
            } catch (Exception $e) {
                throw new Exception('Error accepting enrollment: ' . $e->getMessage());
            }
            break;
            
        case 'reject_enrollment':
            $enrollment_id = $_POST['enrollment_id'] ?? '';
            
            if (empty($enrollment_id)) {
                throw new Exception('Enrollment ID is required');
            }
            
            try {
                // First check if enrollment exists
                $checkStmt = $pdo->prepare("SELECT * FROM enrollments WHERE enrollment_id = ?");
                $checkStmt->execute([$enrollment_id]);
                $enrollment = $checkStmt->fetch();
                
                if (!$enrollment) {
                    throw new Exception('Enrollment not found with ID: ' . $enrollment_id);
                }
                
                // Check if enrollment is already processed
                if ($enrollment['status'] === 'rejected') {
                    throw new Exception('Enrollment is already rejected');
                }
                if ($enrollment['status'] === 'confirmed') {
                    throw new Exception('Cannot reject an already confirmed enrollment');
                }
                
                // Update enrollment status to rejected and mark as admin viewed
                $stmt = $pdo->prepare("UPDATE enrollments SET status = 'rejected', admin_viewed = 1, updated_at = NOW() WHERE enrollment_id = ?");
                $result = $stmt->execute([$enrollment_id]);
                
                if (!$result) {
                    throw new Exception('Failed to update enrollment status');
                }
                
                // Verify the update was successful
                $verifyStmt = $pdo->prepare("SELECT status FROM enrollments WHERE enrollment_id = ?");
                $verifyStmt->execute([$enrollment_id]);
                $updatedStatus = $verifyStmt->fetchColumn();
                
                if ($updatedStatus !== 'rejected') {
                    throw new Exception('Failed to verify enrollment status update');
                }
                
                // Find the user by email to send notification
                $userStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                $userStmt->execute([$enrollment['email']]);
                $user = $userStmt->fetch();
                
                $notification_sent = false;
                if ($user) {
                    // Ensure user_notifications table exists
                    try {
                        $pdo->query("SELECT 1 FROM user_notifications LIMIT 1");
                    } catch (PDOException $e) {
                        // Create user_notifications table if it doesn't exist
                        $createUserNotificationSQL = "
                            CREATE TABLE user_notifications (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                user_id INT NOT NULL,
                                notification_type VARCHAR(50) NOT NULL,
                                title VARCHAR(200) NOT NULL,
                                message TEXT NOT NULL,
                                enrollment_id VARCHAR(50),
                                priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
                                is_read TINYINT(1) DEFAULT 0,
                                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                INDEX idx_user_id (user_id),
                                INDEX idx_enrollment_id (enrollment_id),
                                INDEX idx_is_read (is_read)
                            )
                        ";
                        $pdo->exec($createUserNotificationSQL);
                    }
                    
                    // Send notification to user about rejection
                    try {
                        $notificationMessage = "We regret to inform you that your enrollment (ID: {$enrollment_id}) has been rejected. Please contact our support team for more information or to submit a new application.";
                        
                        $userNotificationStmt = $pdo->prepare("
                            INSERT INTO user_notifications (user_id, notification_type, title, message, enrollment_id, priority, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, NOW())
                        ");
                        $userNotificationStmt->execute([
                            $user['id'],
                            'enrollment_rejected',
                            'Enrollment Application Rejected',
                            $notificationMessage,
                            $enrollment_id,
                            'high'
                        ]);
                        
                        $notification_sent = true;
                    } catch (Exception $e) {
                        // Notification failed but enrollment still rejected
                        error_log("Failed to send notification: " . $e->getMessage());
                        $notification_sent = false;
                    }
                } else {
                    $notification_sent = false;
                }
                
                // Mark related admin notification as read
                try {
                    $markReadStmt = $pdo->prepare("UPDATE admin_notifications SET is_read = 1, updated_at = NOW() WHERE enrollment_id = ? AND notification_type = 'new_enrollment'");
                    $markReadStmt->execute([$enrollment_id]);
                } catch (Exception $e) {
                    error_log("Failed to mark admin notification as read: " . $e->getMessage());
                }
                
                // Create admin notification for rejection action
                try {
                    $rejectionMessage = "Enrollment rejected for {$enrollment['first_name']} {$enrollment['last_name']} ({$enrollment['email']}). Enrollment ID: {$enrollment_id}. Student has been notified of the rejection.";
                    
                    $adminRejectionStmt = $pdo->prepare("
                        INSERT INTO admin_notifications (notification_type, title, message, enrollment_id, priority, created_at) 
                        VALUES (?, ?, ?, ?, ?, NOW())
                    ");
                    $adminRejectionStmt->execute([
                        'enrollment_rejected',
                        'Enrollment Rejected',
                        $rejectionMessage,
                        $enrollment_id,
                        'medium'
                    ]);
                } catch (Exception $e) {
                    error_log("Failed to create admin rejection notification: " . $e->getMessage());
                }
                
                echo json_encode(['success' => true, 'message' => 'Enrollment rejected successfully!']);
                
            } catch (Exception $e) {
                throw new Exception('Error rejecting enrollment: ' . $e->getMessage());
            }
            break;
            
        case 'mark_notification_read':
            $notification_id = $_POST['notification_id'] ?? '';
            
            if (empty($notification_id)) {
                throw new Exception('Notification ID is required');
            }
            
            try {
                $stmt = $pdo->prepare("UPDATE admin_notifications SET is_read = 1, updated_at = NOW() WHERE id = ?");
                $result = $stmt->execute([$notification_id]);
                
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Notification marked as read']);
                } else {
                    throw new Exception('Failed to update notification');
                }
            } catch (Exception $e) {
                throw new Exception('Error marking notification as read: ' . $e->getMessage());
            }
            break;
            
        case 'mark_all_notifications_read':
            try {
                $stmt = $pdo->prepare("UPDATE admin_notifications SET is_read = 1, updated_at = NOW() WHERE is_read = 0");
                $result = $stmt->execute();
                
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'All notifications marked as read']);
                } else {
                    throw new Exception('Failed to update notifications');
                }
            } catch (Exception $e) {
                throw new Exception('Error marking all notifications as read: ' . $e->getMessage());
            }
            break;
            
        default:
            throw new Exception('Invalid action');
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
