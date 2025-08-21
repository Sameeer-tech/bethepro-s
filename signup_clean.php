<?php
session_start();
include 'config/database.php';
include 'assets/loader.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        // First check if email already exists
        $check = $pdo->prepare("SELECT email FROM users WHERE email = ?");
        $check->execute([$email]);
        
        if ($check->rowCount() > 0) {
            $error = "This email is already registered. Please try logging in.";
        } else {
            // If email doesn't exist, create new user
            $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password, role, status, created_at, updated_at) VALUES (?, ?, ?, 'Student', 'Active', NOW(), NOW())");
            $stmt->execute([$fullname, $email, $password]);
            
            // Set success message in session
            $_SESSION['success'] = "Registration successful! Please login.";
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - BeThePro's</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="css/signup.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="brand-header">
            <div class="brand-logo">BeThePro's</div>
            <div class="brand-tagline">Master Your Interview Skills</div>
        </div>
        <h2>Create Your Account</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <div class="footer">
            Already have an account? <a href="login.php">Log in</a>
        </div>
    </div>
</body>
</html>
