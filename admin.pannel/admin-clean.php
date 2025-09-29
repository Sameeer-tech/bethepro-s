<?php
/**
 * BeThePro's Admin Dashboard
 * 
 * Main administrative interface for managing users, courses, enrollments,
 * and system notifications. Provides a comprehensive control panel for
 * administrators to monitor and manage the learning platform.
 * 
 * Features:
 * - User Management (view, edit, delete users)
 * - Course Management (create, edit, manage courses)  
 * - Enrollment Processing (accept/reject enrollments)
 * - Message Management (handle contact forms)
 * - Notification System (admin and user notifications)
 * - Basic Analytics and Reporting
 * 
 * @author BeThePro Development Team
 * @version 2.0
 * @since 2025-09-25
 */

// Security: Define constant to prevent direct file access
define('ADMIN_PANEL_ACCESS', true);

// Start session for admin authentication
session_start();

// Include required files
include '../config/database.php';
include 'data-handler.php';

// Authentication check (currently disabled for development)
$is_admin_logged_in = isset($_SESSION['user_id']) && isset($_SESSION['is_admin']);
if (!$is_admin_logged_in) {
    // In production, redirect to login page
    // header('Location: admin-login.php');
    // exit();
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BeThePro's</title>
    
    <!-- External Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom Stylesheets -->
    <link rel="stylesheet" href="admin.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
</head>

<body>
    <!-- Main Container -->
    <div class="admin-container">
        
        <!-- Sidebar Navigation -->
        <?php include 'sidebar.php'; ?>
        
        <!-- Main Content Area -->
        <main class="main-content">
            
            <!-- Header -->
            <?php include 'header.php'; ?>
            
            <!-- Content Sections -->
            <div class="content-area">
                
                <!-- Dashboard Section -->
                <?php include 'sections/dashboard.php'; ?>
                
                <!-- Users Management Section -->
                <?php include 'sections/users.php'; ?>
                
                <!-- Course Management Section -->
                <?php include 'sections/courses.php'; ?>
                
                <!-- Enrollment Management Section -->  
                <?php include 'sections/enrollments.php'; ?>
                
                <!-- Message Management Section -->
                <?php include 'sections/messages.php'; ?>
                
                <!-- Notifications Section -->
                <?php include 'sections/notifications.php'; ?>
                
                <!-- Analytics Section -->
                <?php include 'sections/analytics.php'; ?>
                
                <!-- Settings Section -->
                <?php include 'sections/settings.php'; ?>
                
            </div>
        </main>
    </div>

    <!-- Modals and Overlays -->
    <?php include 'modals.php'; ?>

    <!-- JavaScript Files -->
    <script src="admin-functions.js"></script>
    <script src="admin-simple.js"></script>
    
</body>
</html>