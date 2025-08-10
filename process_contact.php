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
        $_SESSION['contact_error'] = 'Please fill in all required fields.';
        header('Location: contact.php');
        exit();
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['contact_error'] = 'Please enter a valid email address.';
        header('Location: contact.php');
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
        $_SESSION['contact_success'] = 'Thank you for your message! We will get back to you soon.';
    } else {
        $_SESSION['contact_error'] = 'Sorry, there was an error sending your message. Please try again.';
    }
    
} catch (PDOException $e) {
    $_SESSION['contact_error'] = 'Database error: Unable to save your message. Please try again later.';
    error_log("Contact form error: " . $e->getMessage());
}

// Redirect back to contact page
header('Location: contact.php');
exit();
?>
