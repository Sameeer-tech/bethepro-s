<?php
session_start();

// Include database connection
include '../config/database.php';

// Check if user is admin (modify this logic based on your auth system)
$is_admin_logged_in = isset($_SESSION['user_id']) && isset($_SESSION['is_admin']);
if (!$is_admin_logged_in) {
    // For demo purposes, we'll show the panel. In production, redirect to login
    // header('Location: admin-login.php');
    // exit();
}

// Get messages from database
$messages = [];
try {
    $stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
    $messages = $stmt->fetchAll();
} catch (PDOException $e) {
    // If table doesn't exist or database error, use empty array
    $messages = [];
}

// Get users from database
$users = [];
try {
    $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    // If table doesn't exist or database error, use empty array
    $users = [];
}

// Get courses from database
$courses = [];
try {
    $stmt = $pdo->query("SELECT * FROM courses ORDER BY created_at DESC");
    $courses = $stmt->fetchAll();
} catch (PDOException $e) {
    // If table doesn't exist or database error, use empty array
    $courses = [];
}

// Get enrollments from database
$enrollments = [];
try {
    $stmt = $pdo->query("SELECT * FROM enrollments ORDER BY enrollment_date DESC");
    $enrollments = $stmt->fetchAll();
} catch (PDOException $e) {
    // If table doesn't exist or database error, use empty array
    $enrollments = [];
}

// Get admin notifications from database
$admin_notifications = [];
$unread_notifications_count = 0;
try {
    $stmt = $pdo->query("SELECT * FROM admin_notifications ORDER BY created_at DESC LIMIT 50");
    $admin_notifications = $stmt->fetchAll();
    
    $unread_stmt = $pdo->query("SELECT COUNT(*) as unread_count FROM admin_notifications WHERE is_read = 0");
    $unread_result = $unread_stmt->fetch();
    $unread_notifications_count = $unread_result['unread_count'];
} catch (PDOException $e) {
    // If table doesn't exist or database error, use empty array
    $admin_notifications = [];
    $unread_notifications_count = 0;
}

// Update stats with real data
$user_count = count($users);
$active_users = count(array_filter($users, function($user) { return $user['status'] === 'Active'; }));
$course_count = count($courses);
$enrollment_count = count($enrollments);

$stats = [
    'total_users' => $user_count,
    'total_courses' => $course_count,
    'total_enrollments' => $enrollment_count,
    'monthly_revenue' => $enrollment_count * 99, // Simple calculation
    'new_users_today' => 23,
    'active_sessions' => $active_users,
    'unread_messages' => count(array_filter($messages, function($msg) { return $msg['status'] === 'unread'; })),
    'total_messages' => count($messages)
];

// Use real enrollments data
$recent_enrollments = $enrollments;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BeThePro's</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="fas fa-graduation-cap"></i>
                    <span>BeThePro's Admin</span>
                </div>
            </div>
            
            <div class="sidebar-nav">
                <div class="nav-item">
                    <a href="#" class="nav-link active" data-section="dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-section="users">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-section="courses">
                        <i class="fas fa-book"></i>
                        <span>Courses</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-section="enrollments">
                        <i class="fas fa-user-graduate"></i>
                        <span>Enrollments</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-section="messages">
                        <i class="fas fa-envelope"></i>
                        <span>Messages</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-section="notifications">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                        <?php if ($unread_notifications_count > 0): ?>
                            <span class="notification-badge"><?php echo $unread_notifications_count; ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-section="analytics">
                        <i class="fas fa-chart-bar"></i>
                        <span>Analytics</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" data-section="settings">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="../logout.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="main-header">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <button class="sidebar-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title" id="pageTitle">Dashboard</h1>
                </div>
                
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <i class="fas fa-search"></i>
                    </div>
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="admin-profile">
                        <div class="admin-avatar">A</div>
                        <span>Admin</span>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Dashboard Section -->
                <section id="dashboard" class="content-section active">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon users">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo number_format($stats['total_users']); ?></h3>
                                <div class="stat-label">Total Users</div>
                                <span class="stat-change positive">+<?php echo $stats['new_users_today']; ?> today</span>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon courses">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $stats['total_courses']; ?></h3>
                                <div class="stat-label">Active Courses</div>
                                <span class="stat-change positive">All Active</span>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon enrollments">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo number_format($stats['total_enrollments']); ?></h3>
                                <div class="stat-label">Total Enrollments</div>
                                <span class="stat-change positive">+15% this month</span>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon revenue">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stat-info">
                                <h3>$<?php echo number_format($stats['monthly_revenue']); ?></h3>
                                <div class="stat-label">Monthly Revenue</div>
                                <span class="stat-change positive">+12% vs last month</span>
                            </div>
                        </div>
                    </div>

                    <div class="cards-grid">
                        <div class="dashboard-card">
                            <div class="card-header">
                                <h3 class="card-title">Recent Enrollments</h3>
                                <a href="#" class="btn btn-primary">View All</a>
                            </div>
                            <div class="activity-list">
                                <?php if (empty($recent_enrollments)): ?>
                                <div class="activity-item">
                                    <div class="activity-content">
                                        <div class="activity-title">No enrollments yet</div>
                                        <div style="font-size: 0.9rem; color: var(--gray-dark);">
                                            Enrollments will appear here when students sign up
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <?php foreach ($recent_enrollments as $enrollment): ?>
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-title"><?php echo htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']); ?></div>
                                        <div style="font-size: 0.9rem; color: var(--gray-dark);">
                                            Email: <?php echo htmlspecialchars($enrollment['email']); ?>
                                        </div>
                                        <div class="activity-time"><?php echo date('M j, Y', strtotime($enrollment['enrollment_date'])); ?></div>
                                    </div>
                                    <div style="font-weight: 600; color: var(--success-color);">
                                        $99
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="dashboard-card">
                            <div class="card-header">
                                <h3 class="card-title">Quick Actions</h3>
                            </div>
                            <div style="display: grid; gap: 1rem;">
                                <button class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                    Add New Course
                                </button>
                                <button class="btn btn-secondary">
                                    <i class="fas fa-download"></i>
                                    Export Users
                                </button>
                                <button class="btn btn-secondary">
                                    <i class="fas fa-chart-bar"></i>
                                    Generate Report
                                </button>
                                <button class="btn btn-secondary">
                                    <i class="fas fa-cog"></i>
                                    System Settings
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Users Section -->
                <section id="users" class="content-section">
                    <div class="table-container">
                        <div class="table-header">
                            <h3 class="table-title">User Management</h3>
                            <div style="display: flex; gap: 1rem;">
                                <button class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                    Add User
                                </button>
                                <button class="btn btn-secondary">
                                    <i class="fas fa-download"></i>
                                    Export
                                </button>
                            </div>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 2rem; color: var(--gray-dark);">
                                        <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                                        <strong>No users yet</strong><br>
                                        <small>User registrations will appear here</small>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                <tr data-user-id="<?php echo $user['id']; ?>">
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo $user['role']; ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $user['status'] === 'Active' ? 'status-active' : 'status-inactive'; ?>" 
                                              onclick="toggleUserStatus(<?php echo $user['id']; ?>, '<?php echo $user['status']; ?>')" 
                                              style="cursor: pointer;" title="Click to toggle status">
                                            <?php echo $user['status']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-secondary" style="padding: 0.5rem;" onclick="editUser(<?php echo $user['id']; ?>)" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" style="padding: 0.5rem;" onclick="deleteUser(<?php echo $user['id']; ?>)" title="Delete User">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Courses Section -->
                <section id="courses" class="content-section">
                    <div class="table-container">
                        <div class="table-header">
                            <h3 class="table-title">Course Management</h3>
                            <button class="btn btn-primary" onclick="showAddCourseForm()">
                                <i class="fas fa-plus"></i>
                                Add Course
                            </button>
                        </div>
                        <div style="padding: 2rem;">
                            <div class="cards-grid" id="courses-grid">
                                <?php foreach ($courses as $course): ?>
                                <div class="dashboard-card" id="course-<?php echo $course['id']; ?>">
                                    <h4><?php echo htmlspecialchars($course['title']); ?></h4>
                                    <p style="color: var(--gray-dark); margin: 1rem 0;"><?php echo htmlspecialchars(substr($course['description'], 0, 100)); ?>...</p>
                                    <div style="margin: 0.5rem 0;">
                                        <small><strong>Duration:</strong> <?php echo htmlspecialchars($course['duration']); ?></small><br>
                                        <small><strong>Level:</strong> <?php echo htmlspecialchars($course['level']); ?></small><br>
                                        <small><strong>Status:</strong> <span class="status-badge status-<?php echo strtolower($course['status']); ?>"><?php echo htmlspecialchars($course['status']); ?></span></small>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-weight: 600; color: var(--success-color);">$<?php echo number_format($course['price'], 2); ?></span>
                                        <div>
                                            <button class="btn btn-secondary" style="padding: 0.5rem 1rem;" onclick="editCourse(<?php echo $course['id']; ?>)">Edit</button>
                                            <button class="btn btn-danger" style="padding: 0.5rem 1rem;" onclick="deleteCourse(<?php echo $course['id']; ?>, '<?php echo htmlspecialchars($course['title']); ?>')">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                
                                <?php if (empty($courses)): ?>
                                <div style="text-align: center; grid-column: 1/-1; padding: 2rem;">
                                    <p>No courses found. <a href="#" onclick="showAddCourseForm()" style="color: var(--primary-color);">Add your first course</a></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>














                
                <!-- Enrollments Section -->
                <section id="enrollments" class="content-section">
                    <div class="table-container">
                        <div class="table-header">
                            <h3 class="table-title">Enrollment Management</h3>
                            <button class="btn btn-secondary">
                                <i class="fas fa-download"></i>
                                Export Report
                            </button>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Enrollment ID</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Country</th>
                                    <th>Experience</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recent_enrollments)): ?>
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 2rem; color: var(--gray-dark);">
                                        <i class="fas fa-user-graduate" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                                        <strong>No enrollments yet</strong><br>
                                        <small>Student enrollments will appear here</small>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($recent_enrollments as $enrollment): ?>
                                <tr data-enrollment-id="<?php echo htmlspecialchars($enrollment['enrollment_id']); ?>">
                                    <td><?php echo htmlspecialchars($enrollment['enrollment_id']); ?></td>
                                    <td><?php echo htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($enrollment['email']); ?></td>
                                    <td><?php echo htmlspecialchars($enrollment['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($enrollment['country']); ?></td>
                                    <td><?php echo htmlspecialchars($enrollment['experience_level']); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($enrollment['enrollment_date'])); ?></td>
                                    <td><span class="status-badge status-<?php echo strtolower($enrollment['status']); ?>"><?php echo ucfirst($enrollment['status']); ?></span></td>
                                    <td>
                                        <button class="btn btn-secondary" style="padding: 0.5rem; margin-right: 5px;" 
                                                onclick="showEnrollmentDetails({
                                                    id: '<?php echo htmlspecialchars($enrollment['enrollment_id']); ?>',
                                                    firstName: '<?php echo htmlspecialchars($enrollment['first_name']); ?>',
                                                    lastName: '<?php echo htmlspecialchars($enrollment['last_name']); ?>',
                                                    email: '<?php echo htmlspecialchars($enrollment['email']); ?>',
                                                    phone: '<?php echo htmlspecialchars($enrollment['phone']); ?>',
                                                    country: '<?php echo htmlspecialchars($enrollment['country']); ?>',
                                                    experience: '<?php echo htmlspecialchars($enrollment['experience_level']); ?>',
                                                    schedule: '<?php echo htmlspecialchars($enrollment['schedule_preference'] ?? ''); ?>',
                                                    goals: '<?php echo htmlspecialchars($enrollment['career_goals'] ?? ''); ?>',
                                                    date: '<?php echo date('F j, Y \a\t g:i A', strtotime($enrollment['enrollment_date'])); ?>',
                                                    status: '<?php echo htmlspecialchars($enrollment['status']); ?>'
                                                })" 
                                                title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <?php if ($enrollment['status'] === 'pending'): ?>
                                        <button class="btn btn-primary" style="padding: 0.5rem; background: #28a745; border-color: #28a745; margin-right: 0.5rem;" 
                                                onclick="acceptEnrollment('<?php echo htmlspecialchars($enrollment['enrollment_id']); ?>', '<?php echo htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']); ?>')" 
                                                title="Accept Enrollment">
                                            <i class="fas fa-check"></i> Accept
                                        </button>
                                        <button class="btn btn-danger" style="padding: 0.5rem; background: #dc3545; border-color: #dc3545;" 
                                                onclick="rejectEnrollment('<?php echo htmlspecialchars($enrollment['enrollment_id']); ?>', '<?php echo htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']); ?>')" 
                                                title="Reject Enrollment">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                        <?php elseif ($enrollment['status'] === 'confirmed'): ?>
                                        <span class="status-badge" style="background: #28a745; color: white; padding: 0.3rem 0.6rem; border-radius: 3px;">
                                            <i class="fas fa-check-circle"></i> Accepted
                                        </span>
                                        <?php elseif ($enrollment['status'] === 'rejected'): ?>
                                        <span class="status-badge" style="background: #dc3545; color: white; padding: 0.3rem 0.6rem; border-radius: 3px;">
                                            <i class="fas fa-times-circle"></i> Rejected
                                        </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Messages Section -->
                <section id="messages" class="content-section">
                    <div class="table-container">
                        <div class="table-header">
                            <h3 class="table-title">Contact Messages</h3>
                            <button class="btn btn-secondary" onclick="markAllAsRead()">
                                <i class="fas fa-envelope-open"></i>
                                Mark All Read
                            </button>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Phone</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($messages)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 2rem; color: var(--gray-dark);">
                                        <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                                        <strong>No messages yet</strong><br>
                                        <small>Contact form submissions will appear here</small>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($messages as $message): ?>
                                <tr data-message-id="<?php echo $message['id']; ?>">
                                    <td><?php echo htmlspecialchars($message['name']); ?></td>
                                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                                    <td><?php echo htmlspecialchars($message['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($message['phone'] ?? 'N/A'); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($message['created_at'])); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $message['status'] === 'read' ? 'status-read' : 'status-unread'; ?>">
                                            <?php echo ucfirst($message['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" style="padding: 0.5rem;" onclick="viewMessage(<?php echo htmlspecialchars(json_encode($message)); ?>)" title="View Message">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <?php if ($message['status'] === 'unread'): ?>
                                        <button class="btn btn-info" style="padding: 0.5rem;" onclick="markMessageAsRead(<?php echo $message['id']; ?>)" title="Mark as Read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <?php endif; ?>
                                        <button class="btn btn-success" style="padding: 0.5rem;" onclick="replyToMessage('<?php echo htmlspecialchars($message['email']); ?>', '<?php echo htmlspecialchars($message['subject']); ?>', <?php echo $message['id']; ?>)" title="Reply">
                                            <i class="fas fa-reply"></i>
                                        </button>
                                        <button class="btn btn-danger" style="padding: 0.5rem;" onclick="deleteMessage(<?php echo $message['id']; ?>)" title="Delete Message">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Notifications Section -->
                <section id="notifications" class="content-section">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bell"></i>
                                Admin Notifications
                                <?php if ($unread_notifications_count > 0): ?>
                                    <span class="notification-count">(<?php echo $unread_notifications_count; ?> unread)</span>
                                <?php endif; ?>
                            </h3>
                            <div class="card-actions">
                                <button class="btn btn-primary" onclick="markAllNotificationsRead()">
                                    <i class="fas fa-check-double"></i>
                                    Mark All Read
                                </button>
                            </div>
                        </div>
                        
                        <div class="notifications-container">
                            <?php if (!empty($admin_notifications)): ?>
                                <?php foreach ($admin_notifications as $notification): ?>
                                    <div class="notification-item <?php echo $notification['is_read'] ? 'read' : 'unread'; ?>" data-notification-id="<?php echo $notification['id']; ?>">
                                        <div class="notification-icon">
                                            <?php if ($notification['notification_type'] === 'new_enrollment'): ?>
                                                <i class="fas fa-user-plus"></i>
                                            <?php elseif ($notification['notification_type'] === 'enrollment_accepted'): ?>
                                                <i class="fas fa-check-circle"></i>
                                            <?php elseif ($notification['notification_type'] === 'enrollment_rejected'): ?>
                                                <i class="fas fa-times-circle"></i>
                                            <?php else: ?>
                                                <i class="fas fa-bell"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="notification-content">
                                            <div class="notification-header">
                                                <h4><?php echo htmlspecialchars($notification['title']); ?></h4>
                                                <span class="notification-time"><?php echo date('M j, Y g:i A', strtotime($notification['created_at'])); ?></span>
                                            </div>
                                            <p><?php echo htmlspecialchars($notification['message']); ?></p>
                                            <?php if ($notification['enrollment_id']): ?>
                                                <div class="notification-actions">
                                                    <button class="btn btn-sm btn-primary" onclick="viewEnrollment('<?php echo $notification['enrollment_id']; ?>')">
                                                        <i class="fas fa-eye"></i>
                                                        View Enrollment
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!$notification['is_read']): ?>
                                            <div class="notification-badge">
                                                <button class="btn btn-sm" onclick="markNotificationRead(<?php echo $notification['id']; ?>)">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="empty-state">
                                    <i class="fas fa-bell-slash"></i>
                                    <h3>No Notifications</h3>
                                    <p>All notifications will appear here.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

                <!-- Analytics Section -->
                <section id="analytics" class="content-section">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">Analytics Dashboard</h3>
                        </div>
                        <div style="text-align: center; padding: 3rem;">
                            <i class="fas fa-chart-line" style="font-size: 4rem; color: var(--gray-dark); margin-bottom: 1rem;"></i>
                            <h3>Analytics Coming Soon</h3>
                            <p style="color: var(--gray-dark);">Advanced analytics and reporting features will be available in the next update.</p>
                        </div>
                    </div>
                </section>

                <!-- Settings Section -->
                <section id="settings" class="content-section">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">System Settings</h3>
                        </div>
                        <div style="display: grid; gap: 2rem;">
                            <div>
                                <h4>General Settings</h4>
                                <div style="display: grid; gap: 1rem; margin-top: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Site Name</label>
                                        <input type="text" value="BeThePro's" style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 10px;">
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Contact Email</label>
                                        <input type="email" value="admin@bethepros.com" style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 10px;">
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h4>Course Settings</h4>
                                <div style="display: grid; gap: 1rem; margin-top: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Default Course Duration</label>
                                        <select style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 10px;">
                                            <option>4 Weeks</option>
                                            <option>6 Weeks</option>
                                            <option>8 Weeks</option>
                                            <option>12 Weeks</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div style="display: flex; gap: 1rem;">
                                <button class="btn btn-primary">Save Settings</button>
                                <button class="btn btn-secondary">Reset to Default</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        // Navigation functionality
        document.addEventListener('DOMContentLoaded', function() {
            var navLinks = document.querySelectorAll('.nav-link[data-section]');
            var sections = document.querySelectorAll('.content-section');
            var pageTitle = document.getElementById('pageTitle');
            
            for (var i = 0; i < navLinks.length; i++) {
                navLinks[i].addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    var targetSection = this.getAttribute('data-section');
                    
                    // Remove active class from all nav links
                    for (var j = 0; j < navLinks.length; j++) {
                        navLinks[j].classList.remove('active');
                    }
                    
                    // Add active class to clicked nav link
                    this.classList.add('active');
                    
                    // Hide all sections
                    for (var k = 0; k < sections.length; k++) {
                        sections[k].classList.remove('active');
                    }
                    
                    // Show target section
                    var targetElement = document.getElementById(targetSection);
                    if (targetElement) {
                        targetElement.classList.add('active');
                    }
                    
                    // Update page title
                    if (pageTitle) {
                        pageTitle.textContent = this.textContent.trim();
                    }
                });
            }
        });

        // Sidebar toggle for mobile
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            var sidebar = document.getElementById('sidebar');
            var sidebarToggle = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });

        // Sample notification functionality
        document.querySelector('.notification-btn').addEventListener('click', function() {
            alert('You have 3 new notifications:\n1. New user registration\n2. Course completion\n3. New message received');
        });

        // Message handling functions
        function viewMessage(message) {
            const modal = document.createElement('div');
            modal.className = 'message-modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>${message.subject}</h3>
                        <button class="close-btn" onclick="closeModal(this)">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p><strong>From:</strong> ${message.name} (${message.email})</p>
                        <p><strong>Phone:</strong> ${message.phone || 'N/A'}</p>
                        <p><strong>Date:</strong> ${new Date(message.created_at).toLocaleDateString()}</p>
                        <hr>
                        <p><strong>Message:</strong></p>
                        <div class="message-text">${message.message}</div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" onclick="replyToMessage('${message.email}', '${message.subject}')">Reply</button>
                        <button class="btn btn-secondary" onclick="closeModal(this)">Close</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            // Mark message as read when viewed
            if (message.status === 'unread') {
                markMessageAsRead(message.id);
            }
        }

        function replyToMessage(email, subject, messageId) {
            // Store user email for the reply modal
            window.currentUserEmail = email;
            
            // Set up the reply modal
            document.getElementById('replySubject').value = subject.startsWith('Re:') ? subject : 'Re: ' + subject;
            document.getElementById('replyMessage').value = 'Dear User,\n\nThank you for contacting us.\n\nBest regards,\nBeThePro Admin';
            
            // Show the reply modal
            document.getElementById('replyModal').style.display = 'block';
        }

        function deleteMessage(messageId) {
            if (confirm('Are you sure you want to delete this message?')) {
                fetch('message_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=delete&messageId=${messageId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Message deleted successfully!', 'success');
                        location.reload();
                    } else {
                        showNotification('Error: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while deleting the message', 'error');
                });
            }
        }

        function markMessageAsRead(messageId) {
            fetch('message_actions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=markAsRead&messageId=${messageId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the status badge in the table
                    const statusBadge = document.querySelector(`[data-message-id="${messageId}"] .status-badge`);
                    if (statusBadge) {
                        statusBadge.textContent = 'Read';
                        statusBadge.className = 'status-badge status-read';
                    }
                } else {
                    console.error('Failed to mark message as read:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function markAllAsRead() {
            if (confirm('Are you sure you want to mark all messages as read?')) {
                fetch('message_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=markAllAsRead'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        location.reload();
                    } else {
                        showNotification('Error: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while marking messages as read', 'error');
                });
            }
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 5px;
                color: white;
                font-weight: 500;
                z-index: 2000;
                opacity: 0;
                transition: opacity 0.3s ease;
                ${type === 'success' ? 'background-color: #28a745;' : 'background-color: #dc3545;'}
            `;
            
            document.body.appendChild(notification);
            
            // Fade in
            setTimeout(() => notification.style.opacity = '1', 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        function closeModal(element) {
            const modal = element.closest('.message-modal');
            modal.remove();
        }

        // User Management Functions
        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                fetch('message_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=deleteUser&userId=${userId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        location.reload();
                    } else {
                        showNotification('Error: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while deleting the user', 'error');
                });
            }
        }

        function toggleUserStatus(userId, currentStatus) {
            fetch('message_actions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=toggleUserStatus&userId=${userId}&status=${currentStatus}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    location.reload();
                } else {
                    showNotification('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while updating user status', 'error');
            });
        }

        function editUser(userId) {
            // Simple edit - for now just redirect or show alert
            // You can enhance this with a modal form later
            const newName = prompt('Enter new name:');
            const newEmail = prompt('Enter new email:');
            
            if (newName && newEmail) {
                fetch('message_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=updateUser&userId=${userId}&fullname=${encodeURIComponent(newName)}&email=${encodeURIComponent(newEmail)}&role=Student`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        location.reload();
                    } else {
                        showNotification('Error: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while updating the user', 'error');
                });
            }
        }

        // Add modal styles
        const modalStyles = `
            <style>
            .message-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            }
            .modal-content {
                background: white;
                border-radius: 10px;
                max-width: 600px;
                width: 90%;
                max-height: 80vh;
                overflow-y: auto;
            }
            .modal-header {
                padding: 20px;
                border-bottom: 1px solid #eee;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .modal-body {
                padding: 20px;
            }
            .modal-footer {
                padding: 20px;
                border-top: 1px solid #eee;
                display: flex;
                gap: 10px;
                justify-content: flex-end;
            }
            .message-text {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 5px;
                border-left: 4px solid var(--primary-color);
                white-space: pre-wrap;
            }
            .close-btn {
                background: none;
                border: none;
                font-size: 24px;
                cursor: pointer;
                color: #999;
            }
            .close-btn:hover {
                color: #666;
            }
            .status-read {
                background-color: #28a745 !important;
            }
            .status-unread {
                background-color: #dc3545 !important;
            }
            .btn-info {
                background: linear-gradient(135deg, #17a2b8, #138496);
                color: white;
                border: none;
            }
            .btn-info:hover {
                background: linear-gradient(135deg, #138496, #0e6674);
                transform: translateY(-1px);
            }
        </style>
        `;

        // Course Management Functions
        function showAddCourseForm() {
            const formHtml = `
                <div class="message-modal" id="courseModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Add New Course</h4>
                            <button onclick="closeCourseModal()" style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="courseForm">
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Course Title:</label>
                                    <input type="text" id="courseTitle" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Description:</label>
                                    <textarea id="courseDescription" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required></textarea>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Price ($):</label>
                                    <input type="number" id="coursePrice" step="0.01" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Duration:</label>
                                    <input type="text" id="courseDuration" placeholder="e.g., 4 weeks" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Level:</label>
                                    <select id="courseLevel" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
                                        <option value="Beginner">Beginner</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                    </select>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Features (comma-separated):</label>
                                    <input type="text" id="courseFeatures" placeholder="e.g., Resume Building, Mock Interviews" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" onclick="closeCourseModal()">Cancel</button>
                            <button class="btn btn-primary" onclick="saveCourse()">Save Course</button>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', formHtml);
        }

        function closeCourseModal() {
            const modal = document.getElementById('courseModal');
            if (modal) modal.remove();
        }

        function saveCourse() {
            const title = document.getElementById('courseTitle').value;
            const description = document.getElementById('courseDescription').value;
            const price = document.getElementById('coursePrice').value;
            const duration = document.getElementById('courseDuration').value;
            const level = document.getElementById('courseLevel').value;
            const features = document.getElementById('courseFeatures').value;

            if (!title || !description || !price || !duration || !features) {
                showNotification('Please fill in all fields', 'error');
                return;
            }

            fetch('message_actions.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=add_course&title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&price=${price}&duration=${encodeURIComponent(duration)}&level=${level}&features=${encodeURIComponent(features)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Course added successfully!', 'success');
                    closeCourseModal();
                    location.reload(); // Simple refresh - you asked for simple!
                } else {
                    showNotification('Error adding course: ' + data.error, 'error');
                }
            });
        }

        function editCourse(courseId) {
            // For simplicity, we'll use a prompt - you can make it a modal later
            const newTitle = prompt('Edit course title:');
            if (newTitle) {
                fetch('message_actions.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=edit_course&id=${courseId}&title=${encodeURIComponent(newTitle)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Course updated successfully!', 'success');
                        location.reload();
                    } else {
                        showNotification('Error updating course: ' + data.error, 'error');
                    }
                });
            }
        }

        function deleteCourse(courseId, courseTitle) {
            if (confirm(`Are you sure you want to delete "${courseTitle}"?`)) {
                fetch('message_actions.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=delete_course&id=${courseId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Course deleted successfully!', 'success');
                        // Remove the course card with animation
                        const courseCard = document.getElementById(`course-${courseId}`);
                        if (courseCard) {
                            courseCard.style.opacity = '0';
                            courseCard.style.transform = 'scale(0.8)';
                            courseCard.style.transition = 'all 0.3s ease';
                            setTimeout(() => courseCard.remove(), 300);
                        }
                    } else {
                        showNotification('Error deleting course: ' + data.error, 'error');
                    }
                });
            }
        }

        // Accept Enrollment Function - Make sure it's in global scope
        window.acceptEnrollment = function(enrollmentId, studentName) {
            console.log('Accept enrollment called:', enrollmentId, studentName);
            
            if (confirm(`Accept enrollment for ${studentName}?\n\nThis will update the status to 'Accepted' and notify the student.`)) {
                
                // Show loading state
                const button = event.target;
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                button.disabled = true;
                
                console.log('Sending request to message_actions.php');
                
                fetch('message_actions.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=accept_enrollment&enrollment_id=${encodeURIComponent(enrollmentId)}`
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.text();
                })
                .then(text => {
                    console.log('Raw response:', text);
                    try {
                        const data = JSON.parse(text);
                        console.log('Parsed data:', data);
                        
                        if (data.success) {
                            showNotification(`Enrollment for ${studentName} has been accepted!`, 'success');
                            
                            // Update button appearance
                            button.innerHTML = '<i class="fas fa-check-circle"></i> Accepted';
                            button.style.background = '#28a745';
                            button.style.borderColor = '#28a745';
                            button.disabled = true;
                            
                            // Refresh after 2 seconds
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            throw new Error(data.message || 'Unknown error occurred');
                        }
                    } catch (parseError) {
                        console.error('JSON parse error:', parseError);
                        throw new Error('Invalid response from server: ' + text);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error accepting enrollment: ' + error.message, 'error');
                    
                    // Restore button
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            }
        }
        
        // Reject Enrollment Function
        window.rejectEnrollment = function(enrollmentId, studentName) {
            console.log('Reject enrollment called:', enrollmentId, studentName);
            
            if (confirm(`Reject enrollment for ${studentName}?\n\nThis will update the status to 'Rejected' and notify the student.`)) {
                
                // Show loading state
                const button = event.target;
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                button.disabled = true;
                
                console.log('Sending reject request to message_actions.php');
                
                fetch('message_actions.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=reject_enrollment&enrollment_id=${encodeURIComponent(enrollmentId)}`
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.text();
                })
                .then(text => {
                    console.log('Raw response:', text);
                    try {
                        const data = JSON.parse(text);
                        console.log('Parsed data:', data);
                        
                        if (data.success) {
                            showNotification(`Enrollment for ${studentName} has been rejected!`, 'success');
                            
                            // Update button appearance
                            button.innerHTML = '<i class="fas fa-times-circle"></i> Rejected';
                            button.style.background = '#dc3545';
                            button.style.borderColor = '#dc3545';
                            button.disabled = true;
                            
                            // Refresh after 2 seconds
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            throw new Error(data.message || 'Unknown error occurred');
                        }
                    } catch (parseError) {
                        console.error('JSON parse error:', parseError);
                        throw new Error('Invalid response from server: ' + text);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error rejecting enrollment: ' + error.message, 'error');
                    
                    // Restore button
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            }
        }
        
        // Notification Management Functions
        function markNotificationRead(notificationId) {
            fetch('message_actions.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=mark_notification_read&notification_id=${notificationId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    if (notificationElement) {
                        notificationElement.classList.remove('unread');
                        notificationElement.classList.add('read');
                        const badge = notificationElement.querySelector('.notification-badge');
                        if (badge) badge.remove();
                    }
                    updateNotificationBadge();
                    showNotification('Notification marked as read', 'success');
                } else {
                    showNotification('Error marking notification as read', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error marking notification as read', 'error');
            });
        }
        
        function markAllNotificationsRead() {
            if (confirm('Mark all notifications as read?')) {
                fetch('message_actions.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=mark_all_notifications_read'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Refresh to update UI
                    } else {
                        showNotification('Error marking notifications as read', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error marking notifications as read', 'error');
                });
            }
        }
        
        function viewEnrollment(enrollmentId) {
            // Switch to enrollments tab and highlight the enrollment
            showSection('enrollments');
            
            // Highlight the specific enrollment
            setTimeout(() => {
                const enrollmentRows = document.querySelectorAll(`tr[data-enrollment-id="${enrollmentId}"]`);
                if (enrollmentRows.length > 0) {
                    enrollmentRows[0].style.background = '#fff3cd';
                    enrollmentRows[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, 100);
        }
        
        function showSection(sectionName) {
            // Hide all sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => section.classList.remove('active'));
            
            // Show target section
            const targetSection = document.getElementById(sectionName);
            if (targetSection) {
                targetSection.classList.add('active');
            }
            
            // Update navigation
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => link.classList.remove('active'));
            
            const targetNavLink = document.querySelector(`[data-section="${sectionName}"]`);
            if (targetNavLink) {
                targetNavLink.classList.add('active');
            }
            
            // Update page title
            const pageTitle = document.getElementById('pageTitle');
            if (pageTitle && targetNavLink) {
                pageTitle.textContent = targetNavLink.textContent.trim();
            }
        }
        
        function updateNotificationBadge() {
            // Update notification badge count
            const unreadCount = document.querySelectorAll('.notification-item.unread').length;
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                if (unreadCount > 0) {
                    badge.textContent = unreadCount;
                } else {
                    badge.remove();
                }
            }
        }

        document.head.insertAdjacentHTML('beforeend', modalStyles);
    </script>
    <!-- Professional Enrollment Details Modal -->
    <div id="enrollmentModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-user-graduate"></i>
                    Student Enrollment Details
                </h3>
                <button class="modal-close" onclick="closeEnrollmentModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="enrollment-details">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeEnrollmentModal()">
                    <i class="fas fa-times"></i>
                    Close
                </button>
                <button class="btn btn-primary" onclick="contactStudent()">
                    <i class="fas fa-envelope"></i>
                    Contact Student
                </button>
            </div>
        </div>
    </div>

    <!-- Simple Message View Modal -->
    <div id="messageModal" class="message-modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Message Details</h3>
                <span class="close" onclick="closeMessageModal()">&times;</span>
            </div>
            <div class="modal-body" id="messageContent">
                <!-- Content populated by JavaScript -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeMessageModal()">Close</button>
                <button class="btn btn-primary" onclick="openReplyModal()">Reply</button>
            </div>
        </div>
    </div>

    <!-- Simple Reply Modal -->
    <div id="replyModal" class="message-modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Reply to Message</h3>
                <span class="close" onclick="closeReplyModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="replyForm">
                    <div style="margin-bottom: 15px;">
                        <label>Subject:</label>
                        <input type="text" id="replySubject" name="subject" style="width: 100%; padding: 8px;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label>Message:</label>
                        <textarea id="replyMessage" name="message" rows="6" style="width: 100%; padding: 8px;" placeholder="Type your reply here..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeReplyModal()">Cancel</button>
                <button class="btn btn-primary" onclick="sendReply()">Send Reply</button>
            </div>
        </div>
    </div>

    <script src="admin-simple.js"></script>
    
    <script>
        // Reply modal functions
        function openReplyModal() {
            document.getElementById('replyModal').style.display = 'block';
        }
        
        function closeReplyModal() {
            document.getElementById('replyModal').style.display = 'none';
            document.getElementById('replyForm').reset();
        }
        
        function sendReply() {
            const subject = document.getElementById('replySubject').value;
            const message = document.getElementById('replyMessage').value;
            const userEmail = window.currentUserEmail || '';
            
            if (!subject.trim() || !message.trim()) {
                showNotification('Please fill in subject and message', 'error');
                return;
            }
            
            if (!userEmail.trim()) {
                showNotification('User email is required', 'error');
                return;
            }
            
            fetch('send_reply.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `subject=${encodeURIComponent(subject)}&message=${encodeURIComponent(message)}&userEmail=${encodeURIComponent(userEmail)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('<i class="fas fa-check-circle"></i> ' + data.message);
                    closeReplyModal();
                    location.reload();
                } else {
                    alert('<i class="fas fa-times-circle"></i> ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('<i class="fas fa-times-circle"></i> An error occurred while sending the reply');
            });
        }
        
        // Notification Management Functions
        function markNotificationRead(notificationId) {
            fetch('message_actions.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=mark_notification_read&notification_id=${notificationId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    if (notificationElement) {
                        notificationElement.classList.remove('unread');
                        notificationElement.classList.add('read');
                        const badge = notificationElement.querySelector('.notification-badge');
                        if (badge) badge.remove();
                    }
                    updateNotificationBadge();
                    showNotification('Notification marked as read', 'success');
                } else {
                    showNotification('Error marking notification as read', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error marking notification as read', 'error');
            });
        }
        
        function markAllNotificationsRead() {
            if (confirm('Mark all notifications as read?')) {
                fetch('message_actions.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=mark_all_notifications_read'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Refresh to update UI
                    } else {
                        showNotification('Error marking notifications as read', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error marking notifications as read', 'error');
                });
            }
        }
        
        function viewEnrollment(enrollmentId) {
            // Switch to enrollments tab and highlight the enrollment
            showSection('enrollments');
            
            // Highlight the specific enrollment
            setTimeout(() => {
                const enrollmentRows = document.querySelectorAll(`tr[data-enrollment-id="${enrollmentId}"]`);
                if (enrollmentRows.length > 0) {
                    enrollmentRows[0].style.background = '#fff3cd';
                    enrollmentRows[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, 100);
        }
        
        function updateNotificationBadge() {
            // Update notification badge count
            const unreadCount = document.querySelectorAll('.notification-item.unread').length;
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                if (unreadCount > 0) {
                    badge.textContent = unreadCount;
                } else {
                    badge.remove();
                }
            }
        }
    </script>
</body>
</html>