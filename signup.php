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
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #357abd;
            --gold: #ffd700;
            --gold-hover: #ffe44d;
            --dark: #333;
            --gray: #666;
            --light-gray: #f8f9fa;
            --white: #fff;
            --shadow: 0 2px 10px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 20px;
        }

        .container {
            background: var(--white);
            padding: 40px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 7px;
            background: linear-gradient(90deg, var(--gold) 0%, var(--gold-hover) 100%);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-text {
            font-size: 2rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
        }

        h2 {
            text-align: center;
            color: var(--dark);
            font-size: 1.5rem;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--gray);
            font-size: 0.95rem;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #eee;
            border-radius: 10px;
            font-size: 1rem;
            transition: var(--transition);
            color: var(--dark);
            font-family: 'Poppins', sans-serif;
        }

        input:focus {
            border-color: var(--gold);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
        }

        button {
            width: 100%;
            padding: 14px;
            background: var(--gold);
            color: var(--dark);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: var(--transition);
            margin-top: 20px;
            font-family: 'Poppins', sans-serif;
        }

        button:hover {
            background: var(--gold-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255, 215, 0, 0.2);
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            color: var(--gray);
            font-size: 0.95rem;
        }

        .footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-left: 5px;
        }

        .footer a:hover {
            color: var(--secondary-color);
        }

        .alert {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 10px;
            text-align: center;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>
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
