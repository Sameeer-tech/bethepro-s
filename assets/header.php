<?php
if(!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<style>
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .username {
            color: #ffd700;
            font-weight: 500;
        }
        .logout-btn {
            background: transparent;
            border: 1px solid #ffd700;
            color: #ffd700;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .logout-btn:hover {
            background: #ffd700;
            color: #333;
        }
        header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: var(--white);
    z-index: 1000;
    transition: all 0.3s ease;
    padding: 15px 0;
   }

nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
            font-size: 1.8rem;
            font-weight: bold;
            background: linear-gradient(45deg, #ffd700, #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

.nav-links {
    display: flex;
    list-style: none;
}

.nav-links li {
    margin-left: 30px;
}

.nav-links a {
    color: var(--white);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
    position: relative;
}

.nav-links a:hover {
    opacity: 0.9;
}

.nav-links a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background-color: var(--white);
    transition: var(--transition);
}

.nav-links a:hover::after {
    width: 100%;
}

.auth-buttons {
    display: flex;
    gap: 15px;
    align-items: center;
}

.cta-btn {
    padding: 10px 24px;
    border-radius: 50px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    letter-spacing: 0.5px;
}

.cta-btn.signup {
    background-color: #ffd700;
    color: #333;
    border: 2px solid #ffd700;
    box-shadow: 0 4px 6px rgba(255, 215, 0, 0.2);
}

.cta-btn.signup:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 8px rgba(255, 215, 0, 0.3);
    background-color: #ffe44d;
    border-color: #ffe44d;
}

.cta-btn.login {
    background-color: transparent;
    color: #ffd700;
    border: 2px solid #ffd700;
}

.cta-btn.login:hover {
    background-color: rgba(255, 215, 0, 0.1);
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .auth-buttons {
        gap: 10px;
    }
    .cta-btn {
        padding: 8px 16px;
        font-size: 0.9rem;
    }
}
</style>



 <header>
      <nav class="container">
        <div class="logo">BeThePro's</div>
        <ul class="nav-links">
          <li><a href="index.php">Home</a></li>
          <li><a href="#features">Features</a></li>
          <li><a href="courses.php">Courses</a></li>
          <li><a href="#testimonials">Success Stories</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="about.php">About Us</a></li>
        </ul>
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="user-menu">
                <span class="username">Welcome, <?php echo htmlspecialchars($_SESSION['user_fullname']); ?></span>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        <?php else: ?>
            <div class="auth-buttons">
                <a href="login.php" class="cta-btn login">Login</a>
                <a href="signup.php" class="cta-btn signup">Sign Up</a>
            </div>
        <?php endif; ?>
      </nav>
    </header>

</body>
</html>