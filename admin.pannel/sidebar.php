<?php
/**
 * Admin Dashboard Sidebar Navigation
 * 
 * Contains the main navigation menu for the admin dashboard.
 * Displays navigation links with icons and notification badges.
 * 
 * @author BeThePro Development Team
 * @version 2.0
 */

// Ensure this file is only included
if (!defined('ADMIN_PANEL_ACCESS')) {
    exit('Direct access not allowed');
}
?>

<!-- Sidebar Navigation -->
<nav class="sidebar" id="sidebar">
    
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-graduation-cap"></i>
            <span>BeThePro's Admin</span>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <div class="sidebar-nav">
        
        <!-- Dashboard -->
        <div class="nav-item">
            <a href="#" class="nav-link active" data-section="dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </div>
        
        <!-- Users Management -->
        <div class="nav-item">
            <a href="#" class="nav-link" data-section="users">
                <i class="fas fa-users"></i>
                <span>Users</span>
                <?php if (count($users) > 0): ?>
                    <span class="nav-badge"><?php echo count($users); ?></span>
                <?php endif; ?>
            </a>
        </div>
        
        <!-- Course Management -->
        <div class="nav-item">
            <a href="#" class="nav-link" data-section="courses">
                <i class="fas fa-book"></i>
                <span>Courses</span>
                <?php if (count($courses) > 0): ?>
                    <span class="nav-badge"><?php echo count($courses); ?></span>
                <?php endif; ?>
            </a>
        </div>
        
        <!-- Enrollment Management -->
        <div class="nav-item">
            <a href="#" class="nav-link" data-section="enrollments">
                <i class="fas fa-user-graduate"></i>
                <span>Enrollments</span>
                <?php 
                $pending_enrollments = array_filter($enrollments, function($e) { 
                    return $e['status'] === 'pending'; 
                });
                if (count($pending_enrollments) > 0): ?>
                    <span class="nav-badge pending"><?php echo count($pending_enrollments); ?></span>
                <?php endif; ?>
            </a>
        </div>
        
        <!-- Message Management -->
        <div class="nav-item">
            <a href="#" class="nav-link" data-section="messages">
                <i class="fas fa-envelope"></i>
                <span>Messages</span>
                <?php if ($stats['unread_messages'] > 0): ?>
                    <span class="nav-badge unread"><?php echo $stats['unread_messages']; ?></span>
                <?php endif; ?>
            </a>
        </div>
        
        <!-- Notifications -->
        <div class="nav-item">
            <a href="#" class="nav-link" data-section="notifications">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
                <?php if ($unread_notifications_count > 0): ?>
                    <span class="notification-badge"><?php echo $unread_notifications_count; ?></span>
                <?php endif; ?>
            </a>
        </div>
        
        <!-- Analytics -->
        <div class="nav-item">
            <a href="#" class="nav-link" data-section="analytics">
                <i class="fas fa-chart-bar"></i>
                <span>Analytics</span>
            </a>
        </div>
        
        <!-- Settings -->
        <div class="nav-item">
            <a href="#" class="nav-link" data-section="settings">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </div>
        
        <!-- Logout -->
        <div class="nav-item">
            <a href="../logout.php" class="nav-link logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
        
    </div>
</nav>