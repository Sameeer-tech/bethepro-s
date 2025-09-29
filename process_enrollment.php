<?php
// Simple enrollment processing
session_start();
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get form data
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $country = $_POST['country'] ?? '';
    $experience = $_POST['experience'] ?? 'fresh-graduate';
    $schedule = $_POST['schedule'] ?? 'weekdays';
    $goals = $_POST['goals'] ?? '';
    $paymentMethod = $_POST['paymentMethod'] ?? 'card';
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    
    // Basic validation
    if (empty($firstName) || empty($lastName) || empty($email)) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Validation Error - BeThePro's</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <style>
                body {
                    margin: 0;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 2rem;
                }
                .warning-card {
                    background: white;
                    border-radius: 20px;
                    padding: 3rem;
                    max-width: 400px;
                    width: 100%;
                    text-align: center;
                    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
                    animation: slideUp 0.6s ease-out;
                }
                @keyframes slideUp {
                    from { opacity: 0; transform: translateY(30px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .warning-icon {
                    width: 80px;
                    height: 80px;
                    background: linear-gradient(135deg, #f59e0b, #d97706);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 2rem;
                    animation: pulse 1s ease-in-out infinite alternate;
                }
                @keyframes pulse {
                    from { transform: scale(1); }
                    to { transform: scale(1.05); }
                }
                .warning-icon i {
                    font-size: 2.5rem;
                    color: white;
                }
                .warning-title {
                    font-size: 1.8rem;
                    font-weight: 700;
                    color: #1F2937;
                    margin-bottom: 1rem;
                }
                .warning-message {
                    font-size: 1.1rem;
                    color: #6B7280;
                    line-height: 1.6;
                    margin-bottom: 2rem;
                }
                .btn {
                    padding: 12px 24px;
                    border-radius: 10px;
                    text-decoration: none;
                    font-weight: 600;
                    transition: all 0.3s ease;
                    background: linear-gradient(135deg, #667eea, #764ba2);
                    color: white;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    border: none;
                    cursor: pointer;
                }
                .btn:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
                }
            </style>
        </head>
        <body>
            <div class="warning-card">
                <div class="warning-icon">
                    <i class="fas fa-exclamation"></i>
                </div>
                
                <h1 class="warning-title">⚠️ Missing Information</h1>
                
                <p class="warning-message">
                    Please fill in all required fields (First Name, Last Name, and Email) to complete your enrollment.
                </p>
                
                <button onclick="window.history.back()" class="btn">
                    <i class="fas fa-arrow-left"></i> Go Back & Complete Form
                </button>
            </div>
        </body>
        </html>
        <?php
        exit();
    }
    
    try {
        // Generate enrollment ID
        $enrollmentId = 'ENR' . date('Ymd') . rand(1000, 9999);
        
        // Get user_id if user is logged in
        $user_id = null;
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }
        
        // Insert into database
        $stmt = $pdo->prepare("
            INSERT INTO enrollments (
                enrollment_id, user_id, first_name, last_name, email, phone, country, 
                experience_level, schedule_preference, career_goals, 
                payment_method, additional_services, newsletter_subscription,
                enrollment_date, status
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'pending'
            )
        ");
        
        $result = $stmt->execute([
            $enrollmentId, $user_id, $firstName, $lastName, $email, $phone, $country,
            $experience, $schedule, $goals, $paymentMethod, '[]', $newsletter
        ]);
        
        if ($result) {
            // Create admin_notifications table if it doesn't exist
            try {
                $pdo->query("SELECT 1 FROM admin_notifications LIMIT 1");
            } catch (PDOException $e) {
                // Create admin_notifications table
                $createAdminNotificationSQL = "
                    CREATE TABLE admin_notifications (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        notification_type VARCHAR(50) NOT NULL,
                        title VARCHAR(200) NOT NULL,
                        message TEXT NOT NULL,
                        enrollment_id VARCHAR(50),
                        priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
                        is_read TINYINT(1) DEFAULT 0,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        INDEX idx_enrollment_id (enrollment_id),
                        INDEX idx_is_read (is_read)
                    )
                ";
                $pdo->exec($createAdminNotificationSQL);
            }
            
            // Send notification to admin about new enrollment
            try {
                $adminNotificationMessage = "New enrollment received from {$firstName} {$lastName} ({$email}). Enrollment ID: {$enrollmentId}. Experience Level: {$experience}. Please review and take action.";
                
                $adminNotificationStmt = $pdo->prepare("
                    INSERT INTO admin_notifications (notification_type, title, message, enrollment_id, priority, created_at) 
                    VALUES (?, ?, ?, ?, ?, NOW())
                ");
                $adminNotificationStmt->execute([
                    'new_enrollment',
                    'New Enrollment Received',
                    $adminNotificationMessage,
                    $enrollmentId,
                    'high'
                ]);
            } catch (Exception $e) {
                error_log("Failed to create admin notification: " . $e->getMessage());
            }
            
            // Create user notification for enrollment submission
            if ($user_id) {
                try {
                    $userNotificationStmt = $pdo->prepare("
                        INSERT INTO user_notifications (user_id, notification_type, title, message, enrollment_id, priority, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW())
                    ");
                    $userNotificationStmt->execute([
                        $user_id,
                        'enrollment_submitted',
                        'Enrollment Submitted Successfully',
                        "Your enrollment has been submitted successfully! Enrollment ID: {$enrollmentId}. Our team will review your application and contact you within 24 hours.",
                        $enrollmentId,
                        'high'
                    ]);
                } catch (Exception $e) {
                    error_log("Failed to create user enrollment notification: " . $e->getMessage());
                }
            }
            
            // Success - show professional alert page
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Enrollment Successful - BeThePro's</title>
                <link rel="stylesheet" href="css/style.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
                <style>
                    body {
                        margin: 0;
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    }
                    .success-container {
                        min-height: 100vh;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        padding: 2rem;
                    }
                    .success-card {
                        background: white;
                        border-radius: 20px;
                        padding: 3rem;
                        max-width: 500px;
                        width: 100%;
                        text-align: center;
                        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
                        animation: slideUp 0.6s ease-out;
                    }
                    @keyframes slideUp {
                        from { opacity: 0; transform: translateY(30px); }
                        to { opacity: 1; transform: translateY(0); }
                    }
                    .success-icon {
                        width: 80px;
                        height: 80px;
                        background: linear-gradient(135deg, #10B981, #059669);
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin: 0 auto 2rem;
                        animation: checkmark 0.8s ease-in-out 0.3s both;
                    }
                    @keyframes checkmark {
                        0% { transform: scale(0); }
                        50% { transform: scale(1.2); }
                        100% { transform: scale(1); }
                    }
                    .success-icon i {
                        font-size: 2.5rem;
                        color: white;
                    }
                    .success-title {
                        font-size: 2rem;
                        font-weight: 700;
                        color: #1F2937;
                        margin-bottom: 1rem;
                    }
                    .success-message {
                        font-size: 1.1rem;
                        color: #6B7280;
                        line-height: 1.6;
                        margin-bottom: 2rem;
                    }
                    .enrollment-id {
                        background: #F3F4F6;
                        padding: 1rem;
                        border-radius: 10px;
                        margin: 1.5rem 0;
                        border-left: 4px solid #10B981;
                    }
                    .enrollment-id strong {
                        color: #1F2937;
                        font-size: 1.1rem;
                    }
                    .success-buttons {
                        display: flex;
                        gap: 1rem;
                        justify-content: center;
                        margin-top: 2rem;
                        flex-wrap: wrap;
                    }
                    .btn {
                        padding: 12px 24px;
                        border-radius: 10px;
                        text-decoration: none;
                        font-weight: 600;
                        transition: all 0.3s ease;
                        border: none;
                        cursor: pointer;
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                    }
                    .btn-primary {
                        background: linear-gradient(135deg, #667eea, #764ba2);
                        color: white;
                    }
                    .btn-primary:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
                    }
                    .btn-secondary {
                        background: #F3F4F6;
                        color: #6B7280;
                        border: 1px solid #E5E7EB;
                    }
                    .btn-secondary:hover {
                        background: #E5E7EB;
                        transform: translateY(-2px);
                    }
                    .progress-bar {
                        width: 100%;
                        height: 4px;
                        background: #E5E7EB;
                        border-radius: 2px;
                        margin-top: 2rem;
                        overflow: hidden;
                    }
                    .progress-fill {
                        height: 100%;
                        background: linear-gradient(90deg, #10B981, #059669);
                        border-radius: 2px;
                        animation: progress 3s ease-out;
                    }
                    @keyframes progress {
                        from { width: 0%; }
                        to { width: 100%; }
                    }
                    .next-steps {
                        background: #EFF6FF;
                        border: 1px solid #DBEAFE;
                        border-radius: 10px;
                        padding: 1.5rem;
                        margin: 1.5rem 0;
                        text-align: left;
                    }
                    .next-steps h4 {
                        color: #1E40AF;
                        margin: 0 0 1rem 0;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                    }
                    .next-steps ul {
                        margin: 0;
                        padding-left: 1.5rem;
                        color: #374151;
                    }
                    .next-steps li {
                        margin-bottom: 0.5rem;
                    }
                    @media (max-width: 768px) {
                        .success-card {
                            padding: 2rem;
                            margin: 1rem;
                        }
                        .success-buttons {
                            flex-direction: column;
                        }
                        .btn {
                            width: 100%;
                            justify-content: center;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="success-container">
                    <div class="success-card">
                        <div class="success-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        
                        <h1 class="success-title">🎉 Enrollment Successful!</h1>
                        
                        <p class="success-message">
                            Thank you for choosing BeThePro's! Your enrollment has been submitted successfully and our team will contact you within 24 hours.
                        </p>
                        
                        <div class="enrollment-id">
                            <strong>📝 Enrollment ID: <?php echo htmlspecialchars($enrollmentId); ?></strong>
                        </div>
                        
                        <div class="next-steps">
                            <h4><i class="fas fa-list-check"></i> What Happens Next?</h4>
                            <ul>
                                <li>📧 You'll receive a confirmation email shortly</li>
                                <li>📞 Our team will call you within 24 hours</li>
                                <li><i class="fas fa-book"></i> Course materials will be shared after consultation</li>
                                <li>💳 Payment details will be discussed during the call</li>
                                <li><i class="fas fa-bullseye"></i> We'll help you create a personalized learning path</li>
                            </ul>
                        </div>
                        
                        <div class="success-buttons">
                            <a href="index.php" class="btn btn-primary">
                                <i class="fas fa-home"></i> Go to Homepage
                            </a>
                            <a href="courses.php" class="btn btn-secondary">
                                <i class="fas fa-book"></i> View Courses
                            </a>
                            <a href="enroll.php" class="btn btn-secondary">
                                <i class="fas fa-plus"></i> New Enrollment
                            </a>
                        </div>
                        
                        <div class="progress-bar">
                            <div class="progress-fill"></div>
                        </div>
                        
                        <p style="font-size: 0.9rem; color: #9CA3AF; margin-top: 1rem;">
                            <i class="fas fa-clock"></i> You will be redirected automatically in <span id="countdown">15</span> seconds
                        </p>
                    </div>
                </div>
                
                <script>
                    // Countdown timer
                    let timeLeft = 15;
                    const countdownElement = document.getElementById('countdown');
                    
                    const countdown = setInterval(function() {
                        timeLeft--;
                        countdownElement.textContent = timeLeft;
                        
                        if (timeLeft <= 0) {
                            clearInterval(countdown);
                            window.location.href = 'index.php';
                        }
                    }, 1000);
                    
                    // Add click event to stop countdown when user interacts
                    document.addEventListener('click', function() {
                        clearInterval(countdown);
                        countdownElement.parentElement.style.display = 'none';
                    });
                </script>
            </body>
            </html>
            <?php
            exit();
        } else {
            throw new Exception("Failed to save enrollment");
        }
        
    } catch (Exception $e) {
        // Error - show professional error page
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Enrollment Error - BeThePro's</title>
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <style>
                body {
                    margin: 0;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                }
                .error-container {
                    min-height: 100vh;
                    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 2rem;
                }
                .error-card {
                    background: white;
                    border-radius: 20px;
                    padding: 3rem;
                    max-width: 500px;
                    width: 100%;
                    text-align: center;
                    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
                    animation: slideUp 0.6s ease-out;
                }
                @keyframes slideUp {
                    from { opacity: 0; transform: translateY(30px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .error-icon {
                    width: 80px;
                    height: 80px;
                    background: linear-gradient(135deg, #ef4444, #dc2626);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 2rem;
                    animation: shake 0.8s ease-in-out;
                }
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    25% { transform: translateX(-5px); }
                    75% { transform: translateX(5px); }
                }
                .error-icon i {
                    font-size: 2.5rem;
                    color: white;
                }
                .error-title {
                    font-size: 2rem;
                    font-weight: 700;
                    color: #1F2937;
                    margin-bottom: 1rem;
                }
                .error-message {
                    font-size: 1.1rem;
                    color: #6B7280;
                    line-height: 1.6;
                    margin-bottom: 2rem;
                }
                .btn {
                    padding: 12px 24px;
                    border-radius: 10px;
                    text-decoration: none;
                    font-weight: 600;
                    transition: all 0.3s ease;
                    border: none;
                    cursor: pointer;
                    background: linear-gradient(135deg, #667eea, #764ba2);
                    color: white;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    margin: 0 0.5rem;
                }
                .btn:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
                }
                .support-info {
                    background: #FEF2F2;
                    border: 1px solid #FECACA;
                    border-radius: 10px;
                    padding: 1.5rem;
                    margin: 1.5rem 0;
                    color: #DC2626;
                }
                @media (max-width: 768px) {
                    .error-card {
                        padding: 2rem;
                        margin: 1rem;
                    }
                }
            </style>
        </head>
        <body>
            <div class="error-container">
                <div class="error-card">
                    <div class="error-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    
                    <h1 class="error-title"><i class="fas fa-times-circle"></i> Enrollment Failed</h1>
                    
                    <p class="error-message">
                        We're sorry, but there was an error processing your enrollment. Please try again or contact our support team for assistance.
                    </p>
                    
                    <div class="support-info">
                        <h4><i class="fas fa-headset"></i> Need Help?</h4>
                        <p><strong>📞 Call:</strong> +1 (555) 123-4567</p>
                        <p><strong>📧 Email:</strong> support@bethepros.com</p>
                        <p><strong>💬 WhatsApp:</strong> +1 (555) 987-6543</p>
                    </div>
                    
                    <div style="margin-top: 2rem;">
                        <a href="enroll.php" class="btn">
                            <i class="fas fa-redo"></i> Try Again
                        </a>
                        <a href="contact.php" class="btn">
                            <i class="fas fa-envelope"></i> Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit();
    }
    
} else {
    header("Location: enroll.php");
    exit();
}
?>