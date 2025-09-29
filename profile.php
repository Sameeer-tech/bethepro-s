<?php
session_start();
include 'config/database.php';
include 'assets/loader.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Check for session-based success message
if (isset($_SESSION['success_message'])) {
    $message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Clear the message after displaying
}

// Handle profile updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        
        // Validate input
        if (empty($fullname) || empty($email)) {
            $error = "Name and email are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email address.";
        } else {
            try {
                // Check if email is already taken by another user
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
                $stmt->execute([$email, $user_id]);
                if ($stmt->fetch()) {
                    $error = "This email is already registered to another account.";
                } else {
                    // Update profile
                    $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                    $stmt->execute([$fullname, $email, $user_id]);
                    
                    // Update session data
                    $_SESSION['user_fullname'] = $fullname;
                    $_SESSION['user_email'] = $email;
                    
                    // Set success message in session and redirect to prevent form resubmission
                    $_SESSION['success_message'] = "Profile updated successfully!";
                    header("Location: profile.php");
                    exit();
                }
            } catch (PDOException $e) {
                $error = "Error updating profile: " . $e->getMessage();
            }
        }
    }
    
    if (isset($_POST['upload_profile_picture'])) {
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
            $file = $_FILES['profile_picture'];
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 5MB
            
            // Validate file type
            if (!in_array($file['type'], $allowed_types)) {
                $error = "Only JPG, PNG, and GIF images are allowed.";
            } elseif ($file['size'] > $max_size) {
                $error = "File size must be less than 5MB.";
            } else {
                // Generate unique filename
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_filename = 'profile_' . $user_id . '_' . time() . '.' . $file_extension;
                $upload_path = 'uploads/profiles/' . $new_filename;
                
                // Create uploads directory if it doesn't exist
                if (!is_dir('uploads/profiles')) {
                    mkdir('uploads/profiles', 0755, true);
                }
                
                // Move uploaded file
                if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                    try {
                        // Get current profile picture to delete old one
                        $stmt = $pdo->prepare("SELECT profile_picture FROM users WHERE id = ?");
                        $stmt->execute([$user_id]);
                        $old_picture = $stmt->fetchColumn();
                        
                        // Update profile picture in database
                        $stmt = $pdo->prepare("UPDATE users SET profile_picture = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                        $stmt->execute([$upload_path, $user_id]);
                        
                        // Update session variable for navbar
                        $_SESSION['user_profile_picture'] = $upload_path;
                        
                        // Delete old profile picture if it exists
                        if ($old_picture && file_exists($old_picture) && $old_picture !== $upload_path) {
                            unlink($old_picture);
                        }
                        
                        // Set success message in session and redirect to prevent form resubmission
                        $_SESSION['success_message'] = "Profile picture updated successfully!";
                        header("Location: profile.php");
                        exit();
                    } catch (PDOException $e) {
                        $error = "Error updating profile picture: " . $e->getMessage();
                        // Delete uploaded file if database update failed
                        if (file_exists($upload_path)) {
                            unlink($upload_path);
                        }
                    }
                } else {
                    $error = "Failed to upload file. Please try again.";
                }
            }
        } else {
            $error = "Please select an image file to upload.";
        }
    }
    
    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Validate input
        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $error = "All password fields are required.";
        } elseif ($new_password !== $confirm_password) {
            $error = "New passwords do not match.";
        } elseif (strlen($new_password) < 6) {
            $error = "New password must be at least 6 characters long.";
        } else {
            try {
                // Verify current password
                $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
                $stmt->execute([$user_id]);
                $user_data = $stmt->fetch();
                
                if (!password_verify($current_password, $user_data['password'])) {
                    $error = "Current password is incorrect.";
                } else {
                    // Update password
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE users SET password = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                    $stmt->execute([$hashed_password, $user_id]);
                    
                    // Set success message in session and redirect to prevent form resubmission
                    $_SESSION['success_message'] = "Password changed successfully!";
                    header("Location: profile.php");
                    exit();
                }
            } catch (PDOException $e) {
                $error = "Error changing password: " . $e->getMessage();
            }
        }
    }
}

// Get user information
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    
    // Ensure user is found and is an array
    if (!$user || !is_array($user)) {
        $error = "User not found or invalid user data.";
        $user = ['fullname' => 'Unknown', 'email' => 'unknown@email.com', 'role' => 'Student', 'created_at' => date('Y-m-d H:i:s')];
    }
} catch (PDOException $e) {
    $error = "Error fetching user data: " . $e->getMessage();
    $user = ['fullname' => 'Unknown', 'email' => 'unknown@email.com', 'role' => 'Student', 'created_at' => date('Y-m-d H:i:s')];
}

// Get user's contact messages with replies (enhanced conversation view)
$contact_conversations = [];
try {
    // Get all user's contact messages
    $stmt = $pdo->prepare("
        SELECT cm.*, 
        cm.name,
        cm.email,
        cm.subject,
        cm.message,
        CASE 
            WHEN cm.status = 'read' THEN 'Viewed' 
            WHEN cm.status = 'replied' THEN 'Replied'
            ELSE 'Pending' 
        END as admin_status,
        cm.created_at as message_date
        FROM contact_messages cm
        WHERE cm.email = ?
        ORDER BY cm.created_at DESC
    ");
    $stmt->execute([$user['email']]);
    $contact_messages = $stmt->fetchAll();
    
    // Get admin replies for each message and create conversations
    foreach ($contact_messages as $message) {
        $conversation = [
            'original_message' => $message,
            'replies' => []
        ];
        
        // Get replies to this message (match by subject or email/time proximity)
        try {
            $replyStmt = $pdo->prepare("
                SELECT * FROM admin_replies 
                WHERE user_email = ? 
                AND (subject LIKE ? OR subject LIKE ?)
                ORDER BY created_at ASC
            ");
            $replyStmt->execute([
                $user['email'], 
                'Re: ' . $message['subject'] . '%',
                '%' . $message['subject'] . '%'
            ]);
            $conversation['replies'] = $replyStmt->fetchAll();
            
            // Mark message as replied if there are replies
            if (count($conversation['replies']) > 0) {
                $conversation['original_message']['admin_status'] = 'Replied';
            }
        } catch (PDOException $e) {
            $conversation['replies'] = [];
        }
        
        $contact_conversations[] = $conversation;
    }
    
    // Keep original format for backward compatibility
    $contact_messages = $contact_messages;
} catch (PDOException $e) {
    $contact_conversations = [];
    $contact_messages = [];
}

// Get admin replies to user's messages
$admin_replies = [];
try {
    $stmt = $pdo->prepare("
        SELECT * FROM admin_replies 
        WHERE user_email = ?
        ORDER BY created_at DESC
    ");
    $stmt->execute([$user['email']]);
    $admin_replies = $stmt->fetchAll();
} catch (PDOException $e) {
    // Table might not exist yet, continue with empty array
    $admin_replies = [];
}

// Get user's notifications (bulletproof)
$notifications = [];
try {
    // Try user_notifications first
    $stmt = $pdo->prepare("SELECT * FROM user_notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $notifications = $stmt->fetchAll();
    
    // Add notification_type if missing for compatibility
    foreach ($notifications as &$notification) {
        if (!isset($notification['notification_type'])) {
            $notification['notification_type'] = 'general';
        }
    }
} catch (PDOException $e) {
    // Try simple_notifications as fallback
    try {
        $stmt = $pdo->prepare("SELECT *, 'admin_reply' as notification_type FROM simple_notifications WHERE user_email = ? ORDER BY created_at DESC");
        $stmt->execute([$user['email']]);
        $notifications = $stmt->fetchAll();
    } catch (PDOException $e) {
        $notifications = [];
    }
}

// Get user's enrollments with admin view tracking
$enrollments = [];
try {
    // First, let's check if admin_viewed column exists in enrollments table
    try {
        $pdo->query("SELECT admin_viewed FROM enrollments LIMIT 1");
        $admin_viewed_exists = true;
    } catch (PDOException $e) {
        $admin_viewed_exists = false;
    }
    
    $stmt = $pdo->prepare("
        SELECT e.*, 
        COALESCE(e.course_name, 'General Course') as course_name,
        COALESCE(e.career_goals, 'Professional course enrollment') as description,
        '4-6 weeks' as duration,
        COALESCE(e.course_price, 0) as price,
        'BeThePro Expert Team' as instructor,
        COALESCE(e.experience_level, 'All Levels') as level,
        CASE 
            WHEN e.admin_viewed = 1 THEN 'Viewed' 
            ELSE 'Pending' 
        END as admin_status
        FROM enrollments e 
        WHERE e.user_id = ? OR e.email = ?
        ORDER BY e.enrollment_date DESC
    ");
    $stmt->execute([$user_id, $user['email']]);
    $enrollments = $stmt->fetchAll();
} catch (PDOException $e) {
    // Table might not exist yet, continue with empty array
    $enrollments = [];
}

// Get enrollment statistics
$enrollment_stats = [
    'total_enrollments' => count($enrollments),
    'completed_courses' => 0,
    'in_progress' => 0,
    'total_spent' => 0
];

foreach ($enrollments as $enrollment) {
    if ($enrollment['status'] === 'Completed') {
        $enrollment_stats['completed_courses']++;
    } elseif ($enrollment['status'] === 'Active') {
        $enrollment_stats['in_progress']++;
    }
    $enrollment_stats['total_spent'] += (float)$enrollment['price'];
}

// Get recommendations for this user
$recommendations_data = [
    'courses' => [],
    'quizzes' => [],
    'career_paths' => [],
    'total_count' => 0
];

try {
    // Get course recommendations (top 3)
    $stmt = $pdo->prepare("
        SELECT cr.*, c.course_name, c.description, c.duration, c.level, c.price
        FROM course_recommendations cr
        LEFT JOIN courses c ON cr.course_id = c.id
        WHERE cr.user_id = ? AND cr.status = 'pending'
        ORDER BY cr.relevance_score DESC
        LIMIT 3
    ");
    $stmt->execute([$user_id]);
    $recommendations_data['courses'] = $stmt->fetchAll();
    
    // Get quiz recommendations (top 2)
    $stmt = $pdo->prepare("
        SELECT * FROM quiz_recommendations 
        WHERE user_id = ? AND status = 'pending'
        ORDER BY priority_score DESC
        LIMIT 2
    ");
    $stmt->execute([$user_id]);
    $recommendations_data['quizzes'] = $stmt->fetchAll();
    
    // Get career path recommendations (top 2) - fix column names
    $stmt = $pdo->prepare("
        SELECT *, path_name, path_description as description, target_job_role as target_role 
        FROM career_path_recommendations 
        WHERE user_id = ? AND status IN ('pending', 'following')
        ORDER BY compatibility_score DESC
        LIMIT 2
    ");
    $stmt->execute([$user_id]);
    $recommendations_data['career_paths'] = $stmt->fetchAll();
    
    $recommendations_data['total_count'] = count($recommendations_data['courses']) + 
                                          count($recommendations_data['quizzes']) + 
                                          count($recommendations_data['career_paths']);
} catch (Exception $e) {
    error_log("Error fetching recommendations: " . $e->getMessage());
}

include 'assets/header.php';
?>
<link rel="stylesheet" href="css/profile.css">

<div class="profile-container">
    <div class="container">
        <!-- Success/Error Messages -->
        <?php if ($message): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars(is_array($message) ? implode(', ', $message) : $message); ?>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars(is_array($error) ? implode(', ', $error) : $error); ?>
            </div>
        <?php endif; ?>
        
        <div class="profile-header">
            <div class="profile-info">
                <div class="profile-avatar">
                    <?php if($user['profile_picture'] && file_exists($user['profile_picture'])): ?>
                        <img src="<?php echo htmlspecialchars($user['profile_picture'] ?? 'uploads/profiles/default.jpg'); ?>" alt="Profile Picture" class="profile-avatar-img">
                    <?php else: ?>
                        <div class="profile-avatar-initial">
                            <?php echo strtoupper(substr($user['fullname'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="profile-details">
                    <h1><?php echo htmlspecialchars($user['fullname'] ?? 'User'); ?></h1>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($user['email'] ?? 'No email'); ?></p>
                    <p><i class="fas fa-user"></i> <?php echo htmlspecialchars($user['role'] ?? 'Student'); ?></p>
                    <p><i class="fas fa-calendar-alt"></i> Member since <?php echo $user['created_at'] ? date('F Y', strtotime($user['created_at'])) : 'Unknown'; ?></p>
                </div>
                <div class="profile-actions">
                    <button class="btn btn-primary" onclick="openEditModal('profile')">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-book"></i></div>
                <div class="stat-number"><?php echo $enrollment_stats['total_enrollments']; ?></div>
                <div class="stat-label">Total Enrollments</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-number"><?php echo $enrollment_stats['completed_courses']; ?></div>
                <div class="stat-label">Completed Courses</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-bullseye"></i></div>
                <div class="stat-number"><?php echo $enrollment_stats['in_progress']; ?></div>
                <div class="stat-label">In Progress</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                <div class="stat-number">$<?php echo number_format($enrollment_stats['total_spent'], 2); ?></div>
                <div class="stat-label">Total Invested</div>
            </div>
        </div>

        <div class="section">
            <h2>Personal Information</h2>
            <div class="personal-info-grid">
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-user"></i></div>
                    <div class="info-content">
                        <h4>Full Name</h4>
                        <p><?php echo htmlspecialchars($user['fullname'] ?? 'User'); ?></p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <div class="info-content">
                        <h4>Email Address</h4>
                        <p><?php echo htmlspecialchars($user['email'] ?? 'No email'); ?></p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-graduation-cap"></i></div>
                    <div class="info-content">
                        <h4>Role</h4>
                        <p><?php echo htmlspecialchars($user['role'] ?? 'Student'); ?></p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-bolt"></i></div>
                    <div class="info-content">
                        <h4>Account Status</h4>
                        <p><?php echo htmlspecialchars($user['status'] ?? 'Active'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications Section -->
        <?php if (!empty($notifications)): ?>
        <div class="section">
            <h2><i class="fas fa-bell"></i> New Notifications</h2>
            <?php foreach ($notifications as $notification): ?>
                <div class="notification-card" data-notification-id="<?php echo $notification['id']; ?>" data-notification-type="<?php echo htmlspecialchars($notification['notification_type']); ?>">
                    <div class="notification-header">
                        <div class="notification-icon">
                            <?php if ($notification['notification_type'] === 'admin_reply'): ?>
                                <i class="fas fa-reply" style="color: var(--primary-color);"></i>
                            <?php elseif ($notification['notification_type'] === 'enrollment_accepted'): ?>
                                <i class="fas fa-check-circle" style="color: #22c55e;"></i>
                            <?php else: ?>
                                <i class="fas fa-bell" style="color: var(--secondary-color);"></i>
                            <?php endif; ?>
                        </div>
                        <div class="notification-content">
                            <h4><?php echo htmlspecialchars($notification['title']); ?></h4>
                            <p><?php echo htmlspecialchars($notification['message']); ?></p>
                            <div class="notification-date">
                                <i class="fas fa-clock"></i>
                                <?php echo date('M d, Y \a\t g:i A', strtotime($notification['created_at'])); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Recommendations Section -->
        <div class="section">
            <div class="section-header">
                <h2>Your Personalized Recommendations</h2>
                <a href="recommendations.php" class="view-all-link">View All Recommendations →</a>
            </div>
            
            <?php if ($recommendations_data['total_count'] === 0): ?>
                <div class="no-recommendations">
                    <div class="no-recommendations-icon"><i class="fas fa-bullseye"></i></div>
                    <h3>Get Personalized Recommendations</h3>
                    <p>Complete your skill assessment to unlock AI-powered course, quiz, and career path recommendations tailored specifically for you!</p>
                    <a href="skill-assessment.php" class="cta-button">Take Skill Assessment</a>
                </div>
            <?php else: ?>
                <!-- Course Recommendations -->
                <?php if (!empty($recommendations_data['courses'])): ?>
                    <div class="recommendation-category">
                        <h3><span class="category-icon"><i class="fas fa-book"></i></span> Recommended Courses</h3>
                        <div class="recommendations-grid">
                            <?php foreach ($recommendations_data['courses'] as $course): ?>
                                <div class="recommendation-card course-recommendation">
                                    <div class="recommendation-header">
                                        <h4><?php echo htmlspecialchars($course['course_name'] ?: $course['course_title'] ?: 'Course #' . $course['course_id']); ?></h4>
                                        <div class="relevance-score">
                                            <?php echo round($course['relevance_score'] * 10); ?>% Match
                                        </div>
                                    </div>
                                    
                                    <?php if ($course['description'] || $course['recommendation_reason']): ?>
                                        <p class="recommendation-description">
                                            <?php echo htmlspecialchars(substr(($course['description'] ?: $course['recommendation_reason']), 0, 100)) . '...'; ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <div class="recommendation-meta">
                                        <?php if ($course['level']): ?>
                                            <span class="meta-item"><i class="fas fa-chart-line"></i> <?php echo htmlspecialchars($course['level']); ?></span>
                                        <?php endif; ?>
                                        <?php if ($course['duration']): ?>
                                            <span class="meta-item">⏱️ <?php echo htmlspecialchars($course['duration']); ?></span>
                                        <?php endif; ?>
                                        <?php if ($course['price']): ?>
                                            <span class="meta-item"><i class="fas fa-dollar-sign"></i> $<?php echo number_format($course['price'], 2); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="recommendation-actions">
                                        <a href="enroll.php?course_id=<?php echo $course['course_id']; ?>" class="btn btn-primary btn-sm">Enroll Now</a>
                                        <a href="courses.php#course-<?php echo $course['course_id']; ?>" class="btn btn-secondary btn-sm">Learn More</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Quiz Recommendations -->
                <?php if (!empty($recommendations_data['quizzes'])): ?>
                    <div class="recommendation-category">
                        <h3><span class="category-icon"><i class="fas fa-bullseye"></i></span> Recommended Quizzes</h3>
                        <div class="recommendations-grid">
                            <?php foreach ($recommendations_data['quizzes'] as $quiz): ?>
                                <div class="recommendation-card quiz-recommendation">
                                    <div class="recommendation-header">
                                        <h4><?php echo htmlspecialchars($quiz['quiz_title']); ?></h4>
                                        <div class="priority-score">
                                            Priority: <?php echo round($quiz['priority_score'] * 10); ?>/10
                                        </div>
                                    </div>
                                    
                                    <p class="recommendation-description">
                                        <?php echo htmlspecialchars($quiz['recommendation_reason'] ?? $quiz['quiz_description']); ?>
                                    </p>
                                    
                                    <div class="recommendation-meta">
                                        <span class="meta-item"><i class="fas fa-edit"></i> <?php echo ucfirst($quiz['quiz_category']); ?></span>
                                        <span class="meta-item">⭐ <?php echo ucfirst($quiz['difficulty_level']); ?></span>
                                        <?php if ($quiz['estimated_duration_minutes']): ?>
                                            <span class="meta-item">⏱️ <?php echo $quiz['estimated_duration_minutes']; ?> min</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="recommendation-actions">
                                        <a href="quiz/main.php?topic=<?php echo urlencode($quiz['quiz_category']); ?>" class="btn btn-primary btn-sm">Take Quiz</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Career Path Recommendations -->
                <?php if (!empty($recommendations_data['career_paths'])): ?>
                    <div class="recommendation-category">
                        <h3><span class="category-icon"><i class="fas fa-rocket"></i></span> Career Path Guidance</h3>
                        <div class="recommendations-grid">
                            <?php foreach ($recommendations_data['career_paths'] as $career): ?>
                                <div class="recommendation-card career-recommendation">
                                    <div class="recommendation-header">
                                        <h4><?php echo htmlspecialchars($career['path_name']); ?></h4>
                                        <div class="compatibility-score">
                                            <?php echo round($career['compatibility_score'] * 10); ?>% Compatible
                                        </div>
                                    </div>
                                    
                                    <p class="recommendation-description">
                                        <?php echo htmlspecialchars($career['description']); ?>
                                    </p>
                                    
                                    <div class="recommendation-meta">
                                        <span class="meta-item"><i class="fas fa-bullseye"></i> <?php echo htmlspecialchars($career['target_role']); ?></span>
                                        <span class="meta-item"><i class="fas fa-building"></i> <?php echo htmlspecialchars($career['industry']); ?></span>
                                        <?php if ($career['estimated_duration']): ?>
                                            <span class="meta-item">📅 <?php echo htmlspecialchars($career['estimated_duration']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="recommendation-actions">
                                        <?php if ($career['status'] === 'following'): ?>
                                            <span class="btn btn-success btn-sm">Following Path</span>
                                        <?php else: ?>
                                            <a href="recommendations.php#career-paths" class="btn btn-primary btn-sm">Follow Path</a>
                                        <?php endif; ?>
                                        <a href="recommendations.php#career-paths" class="btn btn-secondary btn-sm">View Details</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="recommendations-footer">
                    <p>💡 <strong>Get more personalized suggestions:</strong> Update your skills and career goals regularly for better recommendations!</p>
                    <div class="recommendation-links">
                        <a href="skill-assessment.php" class="btn btn-outline">Update Skills</a>
                        <a href="recommendations.php" class="btn btn-primary">View All Recommendations</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="section">
            <h2>My Enrollments</h2>
            <?php if (empty($enrollments)): ?>
                <div class="no-enrollments">
                    <div class="no-enrollments-icon"><i class="fas fa-book"></i></div>
                    <h3>No Enrollments Yet</h3>
                    <p>You haven't enrolled in any courses yet. Start your learning journey today!</p>
                    <a href="courses.php" class="cta-button">Browse Courses</a>
                </div>
            <?php else: ?>
                <?php foreach ($enrollments as $enrollment): ?>
                    <div class="enrollment-card">
                        <div class="enrollment-header">
                            <div>
                                <div class="course-title">
                                    <?php 
                                    $courseTitle = $enrollment['course_name'];
                                    if (empty($courseTitle) || $courseTitle === 'General Course') {
                                        $courseTitle = 'Professional Development Course';
                                    }
                                    echo htmlspecialchars($courseTitle); 
                                    ?>
                                </div>
                                <?php if ($enrollment['instructor']): ?>
                                    <div class="course-instructor">Instructor: <?php echo htmlspecialchars($enrollment['instructor']); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="status-badges">
                                <span class="enrollment-status status-<?php echo strtolower($enrollment['status']); ?>">
                                    <?php 
                                    $statusText = ucfirst($enrollment['status']);
                                    if ($enrollment['status'] === 'confirmed') {
                                        $statusText = '<i class="fas fa-check-circle"></i> Accepted by Admin';
                                    } elseif ($enrollment['status'] === 'pending') {
                                        $statusText = '<i class="fas fa-clock"></i> Under Review';
                                    }
                                    echo $statusText;
                                    ?>
                                </span>
                                <span class="admin-status status-<?php echo strtolower(str_replace(' ', '-', $enrollment['admin_status'])); ?>">
                                    <?php 
                                    $adminStatusText = $enrollment['admin_status'];
                                    if ($enrollment['admin_viewed'] == 1 || $enrollment['status'] === 'confirmed') {
                                        $adminStatusText = '<i class="fas fa-eye"></i> Admin Reviewed';
                                    } else {
                                        $adminStatusText = '<i class="fas fa-clipboard"></i> ' . $adminStatusText;
                                    }
                                    echo $adminStatusText;
                                    ?>
                                </span>
                            </div>
                        </div>

                        <div class="course-details">
                            <div class="detail-item">
                                <div class="detail-label">Enrolled Date</div>
                                <div class="detail-value"><?php echo date('M d, Y', strtotime($enrollment['enrollment_date'])); ?></div>
                            </div>
                            <?php if ($enrollment['duration']): ?>
                                <div class="detail-item">
                                    <div class="detail-label">Duration</div>
                                    <div class="detail-value"><?php echo htmlspecialchars($enrollment['duration']); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($enrollment['level']): ?>
                                <div class="detail-item">
                                    <div class="detail-label">Level</div>
                                    <div class="detail-value"><?php echo htmlspecialchars($enrollment['level']); ?></div>
                                </div>
                            <?php endif; ?>
                            <div class="detail-item">
                                <div class="detail-label">Price</div>
                                <div class="detail-value">$<?php echo number_format($enrollment['course_price'] ?? $enrollment['price'] ?? 0, 2); ?></div>
                            </div>
                        </div>

                        <?php if ($enrollment['description']): ?>
                            <div class="course-description">
                                <strong>About this course:</strong><br>
                                <?php echo htmlspecialchars($enrollment['description']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Contact Messages Section -->
        <div class="section">
            <div class="section-header">
                <h2>💬 My Contact Messages</h2>
                <a href="contact.php" class="view-all-link">Send New Message →</a>
            </div>
            
            <?php if (empty($contact_conversations)): ?>
                <div class="no-messages">
                    <div class="no-messages-icon">💬</div>
                    <h3>No Messages Sent</h3>
                    <p>You haven't sent any contact messages yet. Start a conversation with our team!</p>
                    <a href="contact.php" class="cta-button">Contact Us Now</a>
                </div>
            <?php else: ?>
                <div id="messageNotification" class="message-notification" style="display:none;">
                    <div class="notification-content">
                        <i class="fas fa-bell"></i>
                        <span>You have new reply(s) from our admin team!</span>
                        <button onclick="closeNotification()" class="close-notification">×</button>
                    </div>
                </div>
                
                <?php foreach ($contact_conversations as $conversation): ?>
                    <?php $original = $conversation['original_message']; ?>
                    <?php $replies = $conversation['replies']; ?>
                    
                    <div class="conversation-card <?php echo count($replies) > 0 ? 'has-replies' : ''; ?>">
                        <!-- Original Message -->
                        <div class="original-message">
                            <div class="message-header">
                                <div class="message-info">
                                    <div class="message-subject">
                                        <i class="fas fa-envelope" style="color: var(--primary-color);"></i>
                                        <strong><?php echo htmlspecialchars($original['subject'] ?: 'No Subject'); ?></strong>
                                    </div>
                                    <div class="message-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        <?php echo date('M d, Y \a\t g:i A', strtotime($original['message_date'])); ?>
                                    </div>
                                </div>
                                <div class="status-badges">
                                    <span class="admin-status status-<?php echo strtolower(str_replace(' ', '-', $original['admin_status'])); ?>">
                                        <?php echo htmlspecialchars($original['admin_status']); ?>
                                    </span>
                                    <?php if (count($replies) > 0): ?>
                                        <span class="reply-count">
                                            <i class="fas fa-reply"></i>
                                            <?php echo count($replies); ?> Reply<?php echo count($replies) > 1 ? 'ies' : ''; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="message-content">
                                <div class="sender-info">
                                    <strong>You wrote:</strong>
                                </div>
                                <div class="message-text">
                                    <?php echo nl2br(htmlspecialchars($original['message'])); ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Admin Replies -->
                        <?php if (count($replies) > 0): ?>
                            <div class="replies-section">
                                <?php foreach ($replies as $reply): ?>
                                    <div class="admin-reply new-reply">
                                        <div class="reply-header">
                                            <div class="reply-info">
                                                <div class="admin-avatar">
                                                    <i class="fas fa-user-shield"></i>
                                                </div>
                                                <div class="reply-details">
                                                    <div class="admin-name">BeThePro Admin</div>
                                                    <div class="reply-date">
                                                        <i class="fas fa-clock"></i>
                                                        <?php echo date('M d, Y \a\t g:i A', strtotime($reply['created_at'])); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="reply-badge">Reply</span>
                                        </div>
                                        <div class="reply-content">
                                            <div class="reply-text">
                                                <?php echo nl2br(htmlspecialchars($reply['message'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Profile Edit Modal with Tabs -->
<div id="profileModal" class="modal">
    <div class="modal-content modal-large">
        <div class="modal-header">
            <h3>Edit Profile</h3>
            <span class="close" onclick="closeModal('profileModal')">&times;</span>
        </div>
        
        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <button type="button" class="tab-btn active" onclick="switchTab(event, 'profile-info')">
                <i class="fas fa-user"></i> Profile Info
            </button>
            <button type="button" class="tab-btn" onclick="switchTab(event, 'change-password')">
                <i class="fas fa-lock"></i> Change Password
            </button>
            <button type="button" class="tab-btn" onclick="switchTab(event, 'change-picture')">
                <i class="fas fa-camera"></i> Change Picture
            </button>
        </div>
        
        <!-- Profile Info Tab -->
        <div id="profile-info" class="tab-content active">
            <form method="POST">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('profileModal')">Cancel</button>
                    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
        
        <!-- Change Password Tab -->
        <div id="change-password" class="tab-content">
            <form method="POST">
                <div class="form-group">
                    <label for="current_password_tab">Current Password</label>
                    <input type="password" id="current_password_tab" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password_tab">New Password</label>
                    <input type="password" id="new_password_tab" name="new_password" minlength="6" required>
                    <small class="form-hint">Password must be at least 6 characters long</small>
                </div>
                <div class="form-group">
                    <label for="confirm_password_tab">Confirm New Password</label>
                    <input type="password" id="confirm_password_tab" name="confirm_password" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('profileModal')">Cancel</button>
                    <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
        
        <!-- Change Picture Tab -->
        <div id="change-picture" class="tab-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="profile_picture_tab">Choose New Profile Picture</label>
                    <input type="file" id="profile_picture_tab" name="profile_picture" accept="image/*" required>
                    <small class="form-hint">Supported formats: JPG, PNG, GIF. Maximum size: 5MB</small>
                </div>
                <div class="profile-picture-preview" id="picturePreviewTab" style="display: none;">
                    <img id="previewImageTab" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 50%; object-fit: cover; margin-top: 15px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('profileModal')">Cancel</button>
                    <button type="submit" name="upload_profile_picture" class="btn btn-primary">Upload Picture</button>
                </div>
            </form>
        </div>
    </div>
</div>





<?php include 'assets/footer.php'; ?>

<script src="js/profile.js"></script>

<script>
function openEditModal(type) {
    if (type === 'profile') {
        document.getElementById('profileModal').style.display = 'block';
        // Reset to first tab when opening
        switchTab(null, 'profile-info');
    }
    document.body.style.overflow = 'hidden';
}

// Tab switching functionality
function switchTab(event, tabName) {
    // Remove active class from all tabs and tab buttons
    const tabContents = document.getElementsByClassName('tab-content');
    const tabBtns = document.getElementsByClassName('tab-btn');
    
    for (let i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.remove('active');
    }
    
    for (let i = 0; i < tabBtns.length; i++) {
        tabBtns[i].classList.remove('active');
    }
    
    // Show the selected tab and mark button as active
    document.getElementById(tabName).classList.add('active');
    if (event) {
        event.currentTarget.classList.add('active');
    } else {
        // If no event (called programmatically), find and activate the first tab
        document.querySelector('.tab-btn').classList.add('active');
    }
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
});

// Confirm password validation for the new tab-based form
document.addEventListener('DOMContentLoaded', function() {
    const confirmPasswordField = document.getElementById('confirm_password_tab');
    if (confirmPasswordField) {
        confirmPasswordField.addEventListener('input', function() {
            const newPassword = document.getElementById('new_password_tab').value;
            const confirmPassword = this.value;
            
            if (newPassword !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    }
});

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        alert.style.opacity = '0';
        setTimeout(function() {
            alert.style.display = 'none';
        }, 300);
    });
}, 5000);

// Profile picture preview for the new tab
document.addEventListener('DOMContentLoaded', function() {
    const profilePictureInput = document.getElementById('profile_picture_tab');
    if (profilePictureInput) {
        profilePictureInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImageTab').src = e.target.result;
                    document.getElementById('picturePreviewTab').style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('picturePreviewTab').style.display = 'none';
            }
        });
    }
});

// Mark notifications as read when page loads
document.addEventListener('DOMContentLoaded', function() {
    const notifications = document.querySelectorAll('.notification-card[data-notification-id]');
    
    notifications.forEach(function(notification) {
        const notificationId = notification.getAttribute('data-notification-id');
        
        // Mark as read after 3 seconds of viewing
        setTimeout(function() {
            markNotificationAsRead(notificationId);
        }, 3000);
    });
});

function markNotificationAsRead(notificationId) {
    fetch('mark_notification_read.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `notification_id=${encodeURIComponent(notificationId)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notification) {
                notification.style.opacity = '0.7';
                notification.classList.add('read');
            }
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

// Enhanced Contact Messages functionality
document.addEventListener('DOMContentLoaded', function() {
    // Check for new replies and show notification
    checkForNewReplies();
    
    // Add smooth scroll animation to new replies
    const newReplies = document.querySelectorAll('.new-reply');
    newReplies.forEach(function(reply, index) {
        setTimeout(function() {
            reply.style.animation = `slideIn 0.5s ease-out ${index * 0.1}s both`;
        }, 500);
    });
    
    // Add click handlers for conversation cards
    const conversationCards = document.querySelectorAll('.conversation-card');
    conversationCards.forEach(function(card) {
        card.addEventListener('click', function(e) {
            // Don't trigger if clicking on links or buttons
            if (e.target.tagName !== 'A' && e.target.tagName !== 'BUTTON') {
                card.classList.toggle('expanded');
            }
        });
    });
});

function checkForNewReplies() {
    // Count total replies
    const replyCount = document.querySelectorAll('.admin-reply').length;
    
    if (replyCount > 0) {
        // Check if user has seen these replies before
        const lastSeenReplies = localStorage.getItem('lastSeenReplies') || '0';
        
        if (parseInt(replyCount) > parseInt(lastSeenReplies)) {
            showNewReplyNotification(replyCount - parseInt(lastSeenReplies));
            
            // Update the last seen count after showing notification
            setTimeout(function() {
                localStorage.setItem('lastSeenReplies', replyCount.toString());
            }, 3000);
        }
    }
}

function showNewReplyNotification(newCount) {
    const notification = document.getElementById('messageNotification');
    if (notification) {
        const message = newCount === 1 ? 
            'You have a new reply from our admin team!' : 
            `You have ${newCount} new replies from our admin team!`;
        
        notification.querySelector('span').textContent = message;
        notification.style.display = 'block';
        
        // Auto-hide after 10 seconds
        setTimeout(function() {
            closeNotification();
        }, 10000);
        
        // Play notification sound if available
        try {
            const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmAeCD2Uy/LNeSsFJYHI8N2QQAoUX7Dp66hVFApGn+DyvmAeCD2Uy/LNeSsFJYHI8N2QQAoUX7Dp66hVFApGn+DyvmAeCD2Uy/LNeSsFJYHI8N2QQAoUX7Dp66hVFApGn+DyvmAeCD2Uy/LNeSsFJYHI8N2QQAoUX7Dp66hVFApGn+DyvmAeCw==');
            audio.volume = 0.3;
            audio.play().catch(() => {}); // Ignore if audio fails
        } catch(e) {}
    }
}

function closeNotification() {
    const notification = document.getElementById('messageNotification');
    if (notification) {
        notification.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(function() {
            notification.style.display = 'none';
            notification.style.animation = '';
        }, 300);
    }
}

// Add slideOut animation to CSS if not present
if (!document.querySelector('style[data-message-animations]')) {
    const style = document.createElement('style');
    style.setAttribute('data-message-animations', 'true');
    style.textContent = `
        @keyframes slideOut {
            from { transform: translateY(0); opacity: 1; }
            to { transform: translateY(-20px); opacity: 0; }
        }
        
        .conversation-card.expanded {
            transform: scale(1.02);
            z-index: 10;
            position: relative;
        }
        
        .conversation-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }
    `;
    document.head.appendChild(style);
}

// Real-time notification check (optional - polls every 30 seconds)
setInterval(function() {
    // Only check if page is visible
    if (!document.hidden) {
        fetch('check_new_replies.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.hasNewReplies) {
                // Reload page to show new replies
                location.reload();
            }
        })
        .catch(() => {}); // Ignore errors for polling
    }
}, 30000); // Check every 30 seconds
</script>