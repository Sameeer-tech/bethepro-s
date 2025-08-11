<?php
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit();
}

// Include database connection
include 'config/database.php';

try {
    // Get form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? ''); // Changed from 'number' to 'phone'
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
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
                    Please fill in all required fields (Name, Email, Subject, and Message) to send your message.
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
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Invalid Email - BeThePro's</title>
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
                    <i class="fas fa-envelope-open"></i>
                </div>
                
                <h1 class="warning-title">📧 Invalid Email</h1>
                
                <p class="warning-message">
                    Please enter a valid email address so we can respond to your message.
                </p>
                
                <button onclick="window.history.back()" class="btn">
                    <i class="fas fa-arrow-left"></i> Go Back & Fix Email
                </button>
            </div>
        </body>
        </html>
        <?php
        exit();
    }
    
    // Insert into database
    $sql = "INSERT INTO contact_messages (name, email, phone, subject, message, status, created_at) 
            VALUES (:name, :email, :phone, :subject, :message, 'unread', NOW())";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':subject' => $subject,
        ':message' => $message
    ]);
    
    if ($result) {
        // Generate message ID for reference
        $messageId = 'MSG' . date('Ymd') . rand(1000, 9999);
        
        // Success - show professional success page
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Message Sent Successfully - BeThePro's</title>
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <style>
                body {
                    margin: 0;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                }
                .success-container {
                    min-height: 100vh;
                    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
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
                .message-id {
                    background: #F3F4F6;
                    padding: 1rem;
                    border-radius: 10px;
                    margin: 1.5rem 0;
                    border-left: 4px solid #10B981;
                }
                .message-id strong {
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
                .response-info {
                    background: #ECFDF5;
                    border: 1px solid #A7F3D0;
                    border-radius: 10px;
                    padding: 1.5rem;
                    margin: 1.5rem 0;
                    text-align: left;
                }
                .response-info h4 {
                    color: #065F46;
                    margin: 0 0 1rem 0;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }
                .response-info ul {
                    margin: 0;
                    padding-left: 1.5rem;
                    color: #374151;
                }
                .response-info li {
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
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    
                    <h1 class="success-title">✅ Message Sent Successfully!</h1>
                    
                    <p class="success-message">
                        Thank you for contacting BeThePro's! Your message has been received and our team will respond to you shortly.
                    </p>
                    
                    <div class="message-id">
                        <strong>📝 Message ID: <?php echo $messageId; ?></strong>
                    </div>
                    
                    <div class="response-info">
                        <h4><i class="fas fa-clock"></i> What Happens Next?</h4>
                        <ul>
                            <li>📧 You'll receive an email confirmation within 5 minutes</li>
                            <li>📞 Our team will respond within 2-4 hours during business hours</li>
                            <li>💬 For urgent matters, contact us via WhatsApp</li>
                            <li>📋 Keep your Message ID for reference: <strong><?php echo $messageId; ?></strong></li>
                        </ul>
                    </div>
                    
                    <div class="success-buttons">
                        <a href="index.php" class="btn btn-primary">
                            <i class="fas fa-home"></i> Go to Homepage
                        </a>
                        <a href="courses.php" class="btn btn-secondary">
                            <i class="fas fa-book"></i> View Courses
                        </a>
                        <a href="contact.php" class="btn btn-secondary">
                            <i class="fas fa-envelope"></i> Send Another Message
                        </a>
                    </div>
                    
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>
                    
                    <p style="font-size: 0.9rem; color: #9CA3AF; margin-top: 1rem;">
                        <i class="fas fa-clock"></i> You will be redirected automatically in <span id="countdown">12</span> seconds
                    </p>
                </div>
            </div>
            
            <script>
                // Countdown timer
                let timeLeft = 12;
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
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Message Error - BeThePro's</title>
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
                    
                    <h1 class="error-title">❌ Message Failed</h1>
                    
                    <p class="error-message">
                        We're sorry, but there was an error sending your message. Please try again or contact us directly.
                    </p>
                    
                    <div class="support-info">
                        <h4><i class="fas fa-headset"></i> Alternative Contact Methods</h4>
                        <p><strong>📞 Phone:</strong> +1 (555) 123-4567</p>
                        <p><strong>📧 Email:</strong> support@bethepros.com</p>
                        <p><strong>💬 WhatsApp:</strong> +1 (555) 987-6543</p>
                    </div>
                    
                    <div style="margin-top: 2rem;">
                        <button onclick="window.history.back()" class="btn">
                            <i class="fas fa-redo"></i> Try Again
                        </button>
                        <a href="index.php" class="btn">
                            <i class="fas fa-home"></i> Go Home
                        </a>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit();
    }

} catch (PDOException $e) {
    // Database error - show professional error page
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Database Error - BeThePro's</title>
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
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-card">
                <div class="error-icon">
                    <i class="fas fa-database"></i>
                </div>
                
                <h1 class="error-title">🔧 Technical Issue</h1>
                
                <p class="error-message">
                    We're experiencing temporary technical difficulties. Please try again in a few moments or contact us directly.
                </p>
                
                <div class="support-info">
                    <h4><i class="fas fa-tools"></i> Technical Support</h4>
                    <p><strong>📞 Emergency Line:</strong> +1 (555) 123-4567</p>
                    <p><strong>📧 Tech Support:</strong> tech@bethepros.com</p>
                    <p><strong>⚡ Status:</strong> We're working to resolve this issue</p>
                </div>
                
                <div style="margin-top: 2rem;">
                    <button onclick="window.history.back()" class="btn">
                        <i class="fas fa-redo"></i> Try Again
                    </button>
                    <a href="index.php" class="btn">
                        <i class="fas fa-home"></i> Go Home
                    </a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    error_log("Contact form error: " . $e->getMessage());
    exit();
}

// If no POST request, redirect to contact page
header('Location: contact.php');
exit();
?>
