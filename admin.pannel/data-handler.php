<?php
/**
 * Admin Dashboard Data Handler
 * 
 * This file handles all database queries and data preparation for the admin dashboard.
 * It fetches data from various tables and prepares statistics for display.
 * 
 * @author BeThePro Development Team
 * @version 2.0
 * @since 2025-09-25
 */

// Ensure this file is only included, not accessed directly
if (!defined('ADMIN_PANEL_ACCESS')) {
    exit('Direct access not allowed');
}

/**
 * Fetch contact messages from database
 * @return array Array of contact messages
 */
function getContactMessages($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching contact messages: " . $e->getMessage());
        return [];
    }
}

/**
 * Fetch users from database
 * @return array Array of user records
 */
function getUsers($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching users: " . $e->getMessage());
        return [];
    }
}

/**
 * Fetch courses from database
 * @return array Array of course records
 */
function getCourses($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM courses ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching courses: " . $e->getMessage());
        return [];
    }
}

/**
 * Fetch enrollments from database
 * @return array Array of enrollment records
 */
function getEnrollments($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM enrollments ORDER BY enrollment_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching enrollments: " . $e->getMessage());
        return [];
    }
}

/**
 * Fetch admin notifications from database
 * @return array Array containing notifications and unread count
 */
function getAdminNotifications($pdo) {
    $notifications = [];
    $unread_count = 0;
    
    try {
        // Get recent notifications
        $stmt = $pdo->query("SELECT * FROM admin_notifications ORDER BY created_at DESC LIMIT 50");
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get unread count
        $unread_stmt = $pdo->query("SELECT COUNT(*) as unread_count FROM admin_notifications WHERE is_read = 0");
        $unread_result = $unread_stmt->fetch(PDO::FETCH_ASSOC);
        $unread_count = $unread_result['unread_count'];
        
    } catch (PDOException $e) {
        error_log("Error fetching admin notifications: " . $e->getMessage());
    }
    
    return [
        'notifications' => $notifications,
        'unread_count' => $unread_count
    ];
}

/**
 * Calculate dashboard statistics
 * @param array $users User data
 * @param array $courses Course data  
 * @param array $enrollments Enrollment data
 * @param array $messages Contact messages
 * @return array Calculated statistics
 */
function calculateStats($users, $courses, $enrollments, $messages) {
    $active_users = count(array_filter($users, function($user) { 
        return isset($user['status']) && $user['status'] === 'Active'; 
    }));
    
    $unread_messages = count(array_filter($messages, function($msg) { 
        return isset($msg['status']) && $msg['status'] === 'unread'; 
    }));
    
    return [
        'total_users' => count($users),
        'total_courses' => count($courses),
        'total_enrollments' => count($enrollments),
        'monthly_revenue' => count($enrollments) * 99, // Simple calculation
        'new_users_today' => 23, // This could be calculated based on today's registrations
        'active_sessions' => $active_users,
        'unread_messages' => $unread_messages,
        'total_messages' => count($messages)
    ];
}

// Fetch all data for the dashboard
$messages = getContactMessages($pdo);
$users = getUsers($pdo);
$courses = getCourses($pdo);
$enrollments = getEnrollments($pdo);
$notification_data = getAdminNotifications($pdo);
$admin_notifications = $notification_data['notifications'];
$unread_notifications_count = $notification_data['unread_count'];

// Calculate statistics
$stats = calculateStats($users, $courses, $enrollments, $messages);

// Use enrollments as recent enrollments for display
$recent_enrollments = $enrollments;

?>