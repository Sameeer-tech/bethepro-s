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
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['email'] = $email;
                    
                    $message = "Profile updated successfully!";
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
                        
                        $message = "Profile picture updated successfully!";
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
                    
                    $message = "Password changed successfully!";
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
} catch (PDOException $e) {
    $error = "Error fetching user data: " . $e->getMessage();
}

// Get user's contact messages with admin view status
$contact_messages = [];
try {
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
} catch (PDOException $e) {
    // Table might not exist yet, continue with empty array
    $contact_messages = [];
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
    
    if ($admin_viewed_exists) {
        $stmt = $pdo->prepare("
            SELECT e.*, c.course_name, c.description, c.duration, c.price, c.instructor, c.level,
            CASE 
                WHEN e.admin_viewed = 1 THEN 'Viewed' 
                ELSE 'Pending' 
            END as admin_status
            FROM enrollments e 
            LEFT JOIN courses c ON e.course_id = c.id 
            WHERE e.user_id = ? OR e.email = ?
            ORDER BY e.enrollment_date DESC
        ");
        $stmt->execute([$user_id, $user['email']]);
    } else {
        $stmt = $pdo->prepare("
            SELECT e.*, c.course_name, c.description, c.duration, c.price, c.instructor, c.level,
            'Unknown' as admin_status
            FROM enrollments e 
            LEFT JOIN courses c ON e.course_id = c.id 
            WHERE e.user_id = ? OR e.email = ?
            ORDER BY e.enrollment_date DESC
        ");
        $stmt->execute([$user_id, $user['email']]);
    }
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
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <div class="profile-header">
            <div class="profile-info">
                <div class="profile-avatar">
                    <?php if($user['profile_picture'] && file_exists($user['profile_picture'])): ?>
                        <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="profile-avatar-img">
                    <?php else: ?>
                        <div class="profile-avatar-initial">
                            <?php echo strtoupper(substr($user['fullname'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="profile-details">
                    <h1><?php echo htmlspecialchars($user['fullname']); ?></h1>
                    <p>📧 <?php echo htmlspecialchars($user['email']); ?></p>
                    <p>👤 <?php echo htmlspecialchars($user['role'] ?? 'Student'); ?></p>
                    <p>📅 Member since <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
                </div>
                <div class="profile-actions">
                    <button class="btn btn-primary" onclick="openEditModal('profile')">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                    <button class="btn btn-secondary" onclick="openEditModal('password')">
                        <i class="fas fa-lock"></i> Change Password
                    </button>
                    <button class="btn btn-outline" onclick="openEditModal('picture')">
                        <i class="fas fa-camera"></i> Change Picture
                    </button>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📚</div>
                <div class="stat-number"><?php echo $enrollment_stats['total_enrollments']; ?></div>
                <div class="stat-label">Total Enrollments</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-number"><?php echo $enrollment_stats['completed_courses']; ?></div>
                <div class="stat-label">Completed Courses</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🎯</div>
                <div class="stat-number"><?php echo $enrollment_stats['in_progress']; ?></div>
                <div class="stat-label">In Progress</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-number">$<?php echo number_format($enrollment_stats['total_spent'], 2); ?></div>
                <div class="stat-label">Total Invested</div>
            </div>
        </div>

        <div class="section">
            <h2>Personal Information</h2>
            <div class="personal-info-grid">
                <div class="info-item">
                    <div class="info-icon">👤</div>
                    <div class="info-content">
                        <h4>Full Name</h4>
                        <p><?php echo htmlspecialchars($user['fullname']); ?></p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">📧</div>
                    <div class="info-content">
                        <h4>Email Address</h4>
                        <p><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">🎓</div>
                    <div class="info-content">
                        <h4>Role</h4>
                        <p><?php echo htmlspecialchars($user['role'] ?? 'Student'); ?></p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">⚡</div>
                    <div class="info-content">
                        <h4>Account Status</h4>
                        <p><?php echo htmlspecialchars($user['status'] ?? 'Active'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommendations Section -->
        <div class="section">
            <div class="section-header">
                <h2>Your Personalized Recommendations</h2>
                <a href="recommendations.php" class="view-all-link">View All Recommendations →</a>
            </div>
            
            <?php if ($recommendations_data['total_count'] === 0): ?>
                <div class="no-recommendations">
                    <div class="no-recommendations-icon">🎯</div>
                    <h3>Get Personalized Recommendations</h3>
                    <p>Complete your skill assessment to unlock AI-powered course, quiz, and career path recommendations tailored specifically for you!</p>
                    <a href="skill-assessment.php" class="cta-button">Take Skill Assessment</a>
                </div>
            <?php else: ?>
                <!-- Course Recommendations -->
                <?php if (!empty($recommendations_data['courses'])): ?>
                    <div class="recommendation-category">
                        <h3><span class="category-icon">📚</span> Recommended Courses</h3>
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
                                            <span class="meta-item">📈 <?php echo htmlspecialchars($course['level']); ?></span>
                                        <?php endif; ?>
                                        <?php if ($course['duration']): ?>
                                            <span class="meta-item">⏱️ <?php echo htmlspecialchars($course['duration']); ?></span>
                                        <?php endif; ?>
                                        <?php if ($course['price']): ?>
                                            <span class="meta-item">💰 $<?php echo number_format($course['price'], 2); ?></span>
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
                        <h3><span class="category-icon">🎯</span> Recommended Quizzes</h3>
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
                                        <span class="meta-item">📝 <?php echo ucfirst($quiz['quiz_category']); ?></span>
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
                        <h3><span class="category-icon">🚀</span> Career Path Guidance</h3>
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
                                        <span class="meta-item">🎯 <?php echo htmlspecialchars($career['target_role']); ?></span>
                                        <span class="meta-item">🏢 <?php echo htmlspecialchars($career['industry']); ?></span>
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
                    <div class="no-enrollments-icon">📚</div>
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
                                    <?php echo htmlspecialchars($enrollment['course_name'] ?: 'Course #' . $enrollment['course_id']); ?>
                                </div>
                                <?php if ($enrollment['instructor']): ?>
                                    <div class="course-instructor">Instructor: <?php echo htmlspecialchars($enrollment['instructor']); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="status-badges">
                                <span class="enrollment-status status-<?php echo strtolower($enrollment['status']); ?>">
                                    <?php echo htmlspecialchars($enrollment['status']); ?>
                                </span>
                                <span class="admin-status status-<?php echo strtolower(str_replace(' ', '-', $enrollment['admin_status'])); ?>">
                                    Admin: <?php echo htmlspecialchars($enrollment['admin_status']); ?>
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
            <h2>My Contact Messages</h2>
            <?php if (empty($contact_messages)): ?>
                <div class="no-messages">
                    <div class="no-messages-icon">💬</div>
                    <h3>No Messages Sent</h3>
                    <p>You haven't sent any contact messages yet.</p>
                    <a href="contact.php" class="cta-button">Contact Us</a>
                </div>
            <?php else: ?>
                <?php foreach ($contact_messages as $message_item): ?>
                    <div class="message-card">
                        <div class="message-header">
                            <div class="message-info">
                                <div class="message-subject">
                                    <strong><?php echo htmlspecialchars($message_item['subject'] ?: 'No Subject'); ?></strong>
                                </div>
                                <div class="message-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php echo date('M d, Y \a\t g:i A', strtotime($message_item['message_date'])); ?>
                                </div>
                            </div>
                            <span class="admin-status status-<?php echo strtolower(str_replace(' ', '-', $message_item['admin_status'])); ?>">
                                Admin: <?php echo htmlspecialchars($message_item['admin_status']); ?>
                            </span>
                        </div>
                        <div class="message-content">
                            <div class="message-text">
                                <?php echo nl2br(htmlspecialchars($message_item['message'])); ?>
                            </div>
                            <?php if ($message_item['admin_status'] === 'Replied'): ?>
                                <div class="reply-indicator">
                                    <i class="fas fa-reply"></i>
                                    <span>This message has been replied to by our team.</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Profile Edit Modal -->
<div id="profileModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Profile</h3>
            <span class="close" onclick="closeModal('profileModal')">&times;</span>
        </div>
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
</div>

<!-- Password Change Modal -->
<div id="passwordModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Change Password</h3>
            <span class="close" onclick="closeModal('passwordModal')">&times;</span>
        </div>
        <form method="POST">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" minlength="6" required>
                <small class="form-hint">Password must be at least 6 characters long</small>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('passwordModal')">Cancel</button>
                <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
            </div>
        </form>
    </div>
</div>

<!-- Profile Picture Change Modal -->
<div id="pictureModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Change Profile Picture</h3>
            <span class="close" onclick="closeModal('pictureModal')">&times;</span>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="profile_picture">Choose New Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required>
                <small class="form-hint">Supported formats: JPG, PNG, GIF. Maximum size: 5MB</small>
            </div>
            <div class="profile-picture-preview" id="picturePreview" style="display: none;">
                <img id="previewImage" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 50%; object-fit: cover;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('pictureModal')">Cancel</button>
                <button type="submit" name="upload_profile_picture" class="btn btn-primary">Upload Picture</button>
            </div>
        </form>
    </div>
</div>

<?php include 'assets/footer.php'; ?>

<script src="js/profile.js"></script>

<script>
function openEditModal(type) {
    if (type === 'profile') {
        document.getElementById('profileModal').style.display = 'block';
    } else if (type === 'password') {
        document.getElementById('passwordModal').style.display = 'block';
    } else if (type === 'picture') {
        document.getElementById('pictureModal').style.display = 'block';
    }
    document.body.style.overflow = 'hidden';
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

// Confirm password validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (newPassword !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
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

// Profile picture preview
document.getElementById('profile_picture').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('picturePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('picturePreview').style.display = 'none';
    }
});
</script>