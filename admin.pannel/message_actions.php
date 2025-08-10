<?php
session_start();

// Include database connection
include '../config/database.php';

// Check if user is admin (basic check - you might want to enhance this)
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

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
