<?php
/**
 * Admin Dashboard Header
 * 
 * Contains the main header with navigation toggle, page title,
 * search functionality, and admin profile information.
 * 
 * @author BeThePro Development Team  
 * @version 2.0
 */

// Ensure this file is only included
if (!defined('ADMIN_PANEL_ACCESS')) {
    exit('Direct access not allowed');
}
?>

<!-- Main Header -->
<header class="main-header">
    
    <!-- Left Side: Menu Toggle and Page Title -->
    <div class="header-left">
        <button class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title" id="pageTitle">Dashboard</h1>
    </div>
    
    <!-- Right Side: Search and Admin Profile -->
    <div class="header-actions">
        
        <!-- Search Box -->
        <div class="search-box">
            <input type="text" placeholder="Search users, courses..." id="globalSearch">
            <i class="fas fa-search"></i>
        </div>
        
        <!-- Notification Button -->
        <button class="notification-btn" title="View Notifications">
            <i class="fas fa-bell"></i>
            <?php if ($unread_notifications_count > 0): ?>
                <span class="notification-badge"><?php echo $unread_notifications_count; ?></span>
            <?php endif; ?>
        </button>
        
        <!-- Admin Profile -->
        <div class="admin-profile">
            <div class="admin-avatar">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="admin-info">
                <span class="admin-name">Admin</span>
                <span class="admin-role">Administrator</span>
            </div>
        </div>
        
    </div>
    
</header>