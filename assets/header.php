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
        /* CSS Variables */
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --white: #ffffff;
            --transition: all 0.3s ease;
        }
        
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
    margin: 0;
    padding: 0;
}

.nav-links li {
    margin-left: 30px;
    list-style: none;
}

.nav-links a {
    color: #ffffff;
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
    background-color: #ffffff;
    transition: var(--transition);
}

.nav-links a:hover::after {
    width: 100%;
}

/* Mobile Menu Button */
.mobile-menu-btn {
    display: none;
    flex-direction: column;
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
    z-index: 1001;
}

.mobile-menu-btn span {
    width: 25px;
    height: 3px;
    background-color: #ffffff;
    margin: 3px 0;
    transition: 0.3s;
    border-radius: 2px;
}

.mobile-menu-btn.active span:nth-child(1) {
    transform: rotate(-45deg) translate(-5px, 6px);
}

.mobile-menu-btn.active span:nth-child(2) {
    opacity: 0;
}

.mobile-menu-btn.active span:nth-child(3) {
    transform: rotate(45deg) translate(-5px, -6px);
}

/* Desktop Navigation - ensure it's visible on large screens */
@media (min-width: 769px) {
    .mobile-menu-btn {
        display: none !important;
    }
    
    .nav-links {
        position: static !important;
        display: flex !important;
        flex-direction: row !important;
        height: auto !important;
        width: auto !important;
        background: none !important;
        justify-content: flex-end !important;
        align-items: center !important;
    }
    
    .nav-links li {
        opacity: 1 !important;
        transform: none !important;
        margin: 0 0 0 30px !important;
    }
    
    .nav-links a {
        font-size: 1rem !important;
        padding: 0 !important;
        border-radius: 0 !important;
    }
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
    header {
        padding: 12px 0;
    }
    
    nav {
        padding: 0 20px;
        position: relative;
    }
    
    .logo {
        font-size: 1.5rem;
    }
    
    .mobile-menu-btn {
        display: flex;
    }
    
    .nav-links {
        position: fixed;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transition: left 0.3s ease;
        z-index: 1000;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .nav-links.active {
        left: 0;
    }
    
    .nav-links li {
        margin: 20px 0;
        margin-left: 0;
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s ease;
        list-style: none;
    }
    
    .nav-links.active li {
        opacity: 1;
        transform: translateY(0);
    }
    
    .nav-links.active li:nth-child(1) { transition-delay: 0.1s; }
    .nav-links.active li:nth-child(2) { transition-delay: 0.2s; }
    .nav-links.active li:nth-child(3) { transition-delay: 0.3s; }
    .nav-links.active li:nth-child(4) { transition-delay: 0.4s; }
    .nav-links.active li:nth-child(5) { transition-delay: 0.5s; }
    .nav-links.active li:nth-child(6) { transition-delay: 0.6s; }
    
    .nav-links a {
        font-size: 1.5rem;
        padding: 15px 30px;
        border-radius: 8px;
        transition: all 0.3s ease;
        color: #ffffff;
        text-decoration: none;
        display: block;
        text-align: center;
    }
    
    .nav-links a:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: scale(1.05);
    }
    
    .nav-links a::after {
        display: none;
    }
    
    .auth-buttons {
        gap: 8px;
        position: relative;
        z-index: 1001;
    }
    
    .cta-btn {
        padding: 6px 12px;
        font-size: 0.8rem;
    }
    
    .user-menu {
        position: relative;
        z-index: 1001;
        gap: 8px;
    }
    
    .username {
        font-size: 0.8rem;
    }
    
    .logout-btn {
        padding: 4px 8px;
        font-size: 0.7rem;
    }
}

@media (max-width: 480px) {
    .logo {
        font-size: 1.3rem;
    }
    
    .mobile-menu-btn span {
        width: 22px;
        height: 2px;
    }
    
    .nav-links a {
        font-size: 1.3rem;
        padding: 12px 25px;
    }
    
    .cta-btn {
        padding: 5px 10px;
        font-size: 0.75rem;
    }
    
    .username {
        font-size: 0.75rem;
    }
    
    .logout-btn {
        padding: 3px 6px;
        font-size: 0.65rem;
    }
}
</style>



 <header>
      <nav class="container">
        <div class="logo">BeThePro's</div>
        
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
        <ul class="nav-links" id="navLinks">
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

<script>
// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navLinks = document.getElementById('navLinks');
    
    if (mobileMenuBtn && navLinks) {
        mobileMenuBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            navLinks.classList.toggle('active');
            
            // Prevent body scrolling when menu is open
            if (navLinks.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
        
        // Close menu when clicking on a nav link
        const navLinksItems = navLinks.querySelectorAll('a');
        navLinksItems.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.classList.remove('active');
                mobileMenuBtn.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenuBtn.contains(event.target) && !navLinks.contains(event.target)) {
                navLinks.classList.remove('active');
                mobileMenuBtn.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                navLinks.classList.remove('active');
                mobileMenuBtn.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }
});
</script>

</body>
</html>