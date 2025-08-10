<?php
// process_enrollment.php - Handle enrollment form submission

session_start();

// Include database configuration
include 'config/database.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Sanitize and validate input data
    $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
    $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
    $experience = filter_var($_POST['experience'], FILTER_SANITIZE_STRING);
    $schedule = filter_var($_POST['schedule'], FILTER_SANITIZE_STRING);
    $goals = filter_var($_POST['goals'], FILTER_SANITIZE_STRING);
    $paymentMethod = filter_var($_POST['paymentMethod'], FILTER_SANITIZE_STRING);
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    
    // Handle additional services
    $additionalServices = isset($_POST['services']) ? $_POST['services'] : [];
    $servicesJson = json_encode($additionalServices);
    
    // Validate required fields
    $errors = [];
    
    if (empty($firstName)) $errors[] = "First name is required";
    if (empty($lastName)) $errors[] = "Last name is required";
    if (!$email) $errors[] = "Valid email is required";
    if (empty($phone)) $errors[] = "Phone number is required";
    if (empty($country)) $errors[] = "Country is required";
    
    // Payment validation (relaxed for class project)
    if ($paymentMethod === 'card') {
        $cardName = filter_var($_POST['cardName'], FILTER_SANITIZE_STRING);
        $cardNumber = filter_var($_POST['cardNumber'], FILTER_SANITIZE_STRING);
        $expiryDate = filter_var($_POST['expiryDate'], FILTER_SANITIZE_STRING);
        $cvv = filter_var($_POST['cvv'], FILTER_SANITIZE_STRING);
        
        // For class project - no strict validation required
        // Students can use demo data
    }
    
    // If no errors, process the enrollment
    if (empty($errors)) {
        try {
            // Generate enrollment ID
            $enrollmentId = 'ENR' . date('Ymd') . rand(1000, 9999);
            
            // Insert enrollment record (you'll need to create this table)
            $stmt = $pdo->prepare("
                INSERT INTO enrollments (
                    enrollment_id, first_name, last_name, email, phone, country, 
                    experience_level, schedule_preference, career_goals, 
                    payment_method, additional_services, newsletter_subscription,
                    enrollment_date, status
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'pending'
                )
            ");
            
            $stmt->execute([
                $enrollmentId, $firstName, $lastName, $email, $phone, $country,
                $experience, $schedule, $goals, $paymentMethod, $servicesJson, $newsletter
            ]);
            
            // Send confirmation email (implement email function)
            sendConfirmationEmail($email, $firstName, $enrollmentId);
            
            // Redirect to success page
            header("Location: enrollment-success.php?id=" . $enrollmentId);
            exit();
            
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
    
    // If there are errors, redirect back with error messages
    if (!empty($errors)) {
        $_SESSION['enrollment_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: enroll.php?error=1");
        exit();
    }
    
} else {
    // If not a POST request, redirect to enrollment page
    header("Location: enroll.php");
    exit();
}

function sendConfirmationEmail($email, $firstName, $enrollmentId) {
    // Email configuration
    $to = $email;
    $subject = "Enrollment Confirmation - BeThePro's";
    $from = "noreply@bethepros.com";
    
    // Email content
    $message = "
    <html>
    <head>
        <title>Enrollment Confirmation</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
            .highlight { background: #667eea; color: white; padding: 10px; border-radius: 5px; display: inline-block; margin: 10px 0; }
            .footer { text-align: center; margin-top: 20px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Welcome to BeThePro's!</h1>
                <p>Your journey to interview success starts here</p>
            </div>
            <div class='content'>
                <h2>Hello {$firstName},</h2>
                <p>Thank you for enrolling with BeThePro's! We're excited to help you achieve your career goals.</p>
                
                <div class='highlight'>
                    <strong>Enrollment ID: {$enrollmentId}</strong>
                </div>
                
                <h3>What's Next?</h3>
                <ul>
                    <li>You'll receive your course access details within 24 hours</li>
                    <li>Our team will contact you to schedule your first session</li>
                    <li>You can access your student dashboard at any time</li>
                </ul>
                
                <h3>Need Help?</h3>
                <p>Our support team is available 24/7 to assist you:</p>
                <ul>
                    <li>Email: support@bethepros.com</li>
                    <li>Phone: +1-800-BETHEPRO</li>
                    <li>Live Chat: Available on our website</li>
                </ul>
                
                <p>We look forward to working with you!</p>
                <p><strong>The BeThePro's Team</strong></p>
            </div>
            <div class='footer'>
                <p>&copy; 2024 BeThePro's. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: {$from}" . "\r\n";
    $headers .= "Reply-To: {$from}" . "\r\n";
    
    // Send email
    return mail($to, $subject, $message, $headers);
}
?>
