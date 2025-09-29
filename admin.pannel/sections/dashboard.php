<?php
/**
 * Dashboard Section - Main Overview
 * 
 * Displays key statistics, recent activities, and quick actions
 * for administrators to get an overview of the platform status.
 * 
 * @author BeThePro Development Team
 * @version 2.0
 */

// Ensure this file is only included
if (!defined('ADMIN_PANEL_ACCESS')) {
    exit('Direct access not allowed');
}
?>

<!-- Dashboard Section -->
<section id="dashboard" class="content-section active">
    
    <!-- Statistics Cards -->
    <div class="stats-grid">
        
        <!-- Total Users -->
        <div class="stat-card users">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo number_format($stats['total_users']); ?></h3>
                <div class="stat-label">Total Users</div>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    +<?php echo $stats['new_users_today']; ?> today
                </span>
            </div>
        </div>
        
        <!-- Active Courses -->
        <div class="stat-card courses">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo $stats['total_courses']; ?></h3>
                <div class="stat-label">Active Courses</div>
                <span class="stat-change neutral">All Active</span>
            </div>
        </div>
        
        <!-- Total Enrollments -->
        <div class="stat-card enrollments">
            <div class="stat-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo number_format($stats['total_enrollments']); ?></h3>
                <div class="stat-label">Total Enrollments</div>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    +15% this month
                </span>
            </div>
        </div>
        
        <!-- Monthly Revenue -->
        <div class="stat-card revenue">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-info">
                <h3>$<?php echo number_format($stats['monthly_revenue']); ?></h3>
                <div class="stat-label">Monthly Revenue</div>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    +12% vs last month
                </span>
            </div>
        </div>
        
    </div>

    <!-- Dashboard Cards -->
    <div class="cards-grid">
        
        <!-- Recent Enrollments -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-graduate"></i>
                    Recent Enrollments
                </h3>
                <a href="#" class="btn btn-primary" onclick="showSection('enrollments')">
                    View All
                </a>
            </div>
            
            <div class="activity-list">
                <?php if (empty($recent_enrollments)): ?>
                    <div class="empty-state">
                        <i class="fas fa-user-graduate"></i>
                        <h4>No enrollments yet</h4>
                        <p>New student enrollments will appear here</p>
                    </div>
                <?php else: ?>
                    <?php foreach (array_slice($recent_enrollments, 0, 5) as $enrollment): ?>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">
                                    <?php echo htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']); ?>
                                </div>
                                <div class="activity-subtitle">
                                    <?php echo htmlspecialchars($enrollment['email']); ?>
                                </div>
                                <div class="activity-time">
                                    <?php echo date('M j, Y g:i A', strtotime($enrollment['enrollment_date'])); ?>
                                </div>
                            </div>
                            <div class="activity-status">
                                <span class="status-badge status-<?php echo strtolower($enrollment['status']); ?>">
                                    <?php echo ucfirst($enrollment['status']); ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt"></i>
                    Quick Actions
                </h3>
            </div>
            
            <div class="quick-actions-grid">
                <button class="action-btn" onclick="showSection('courses')" title="Manage Courses">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add New Course</span>
                </button>
                
                <button class="action-btn" onclick="showSection('users')" title="Export Users">
                    <i class="fas fa-download"></i>
                    <span>Export Users</span>
                </button>
                
                <button class="action-btn" onclick="showSection('analytics')" title="View Analytics">
                    <i class="fas fa-chart-bar"></i>
                    <span>Generate Report</span>
                </button>
                
                <button class="action-btn" onclick="showSection('settings')" title="System Settings">
                    <i class="fas fa-cog"></i>
                    <span>System Settings</span>
                </button>
            </div>
        </div>

        <!-- System Status -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-server"></i>
                    System Status
                </h3>
            </div>
            
            <div class="status-list">
                <div class="status-item">
                    <div class="status-indicator online"></div>
                    <span>Database Connection</span>
                    <span class="status-text success">Online</span>
                </div>
                
                <div class="status-item">
                    <div class="status-indicator online"></div>
                    <span>Email Service</span>
                    <span class="status-text success">Active</span>
                </div>
                
                <div class="status-item">
                    <div class="status-indicator online"></div>
                    <span>File Uploads</span>
                    <span class="status-text success">Working</span>
                </div>
                
                <div class="status-item">
                    <div class="status-indicator warning"></div>
                    <span>Backup System</span>
                    <span class="status-text warning">Pending</span>
                </div>
            </div>
        </div>
        
    </div>
</section>