<?php
if(!isset($_SESSION)) {
    session_start();
}

// Detect if we're in a subdirectory
$isSubdir = (basename(dirname($_SERVER['SCRIPT_NAME'])) !== 'bethepro-s');
$basePath = $isSubdir ? '../' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/animations.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<style>
/* Ensure consistent fonts across all pages */
* {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Hide mobile dropdown on desktop by default */
.mobile-dropdown {
    display: none !important;
}

@media (max-width: 768px) {
    .nav-links {
        display: none !important;
    }
        .mobile-dropdown {
            display: flex !important;
            flex-direction: column;
            position: fixed;
            top: 60px;
            left: 0;
            width: 100vw;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 1100;
            padding: 30px 0 0 0;
            margin: 0;
            list-style: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            opacity: 0;
            pointer-events: none;
            transform: translateY(-20px);
            transition: opacity 0.3s cubic-bezier(.4,0,.2,1), transform 0.3s cubic-bezier(.4,0,.2,1);
        }
        .mobile-dropdown.active {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }
        .mobile-dropdown li {
            margin: 12px 0;
            text-align: center;
            transition: background 0.2s;
        }
        .mobile-dropdown a {
            color: #fff;
            font-size: 1.15rem;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            display: block;
            transition: background 0.2s, color 0.2s;
            font-weight: 500;
            letter-spacing: 0.02em;
        }
        .mobile-dropdown a:hover {
            background: rgba(255,255,255,0.12);
            color: #ffd700;
        }
    .mobile-menu-btn {
        z-index: 1200;
    }
}
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
        .username {
            color: #ffffff;
            text-decoration: none;
            margin-right: 15px;
            font-weight: 500;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 8px 16px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .username:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
            color: #ffffff;
            text-decoration: none;
        }
        
        .nav-profile-pic {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .nav-profile-initial {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(45deg, #ffd700, #fff);
            color: #667eea;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .username:hover .nav-profile-pic,
        .username:hover .nav-profile-initial {
            border-color: rgba(255, 255, 255, 0.8);
            transform: scale(1.05);
        }
        
        /* Notification Bell Styles */
        .notification-bell,
        .recommendations-icon {
            position: relative;
            color: #ffffff;
            text-decoration: none;
            padding: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }
        
        .notification-bell:hover,
        .recommendations-icon:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px) scale(1.05);
            color: #ffffff;
            text-decoration: none;
        }
        
        .notification-bell i,
        .recommendations-icon i {
            font-size: 1.1rem;
        }
        
        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: linear-gradient(135deg, #ff6b6b, #ffa500);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Mobile notification badge */
        .mobile-notification-badge {
            background: linear-gradient(135deg, #ff6b6b, #ffa500);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 8px;
            min-width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .username-text {
            white-space: nowrap;
        }
        
        @media (max-width: 768px) {
            .username-text {
                display: none;
            }
            
            .username {
                padding: 8px;
                margin-right: 10px;
            }
        }
        
        .logout-btn {
            background: transparent;
            border: 1px solid #ffd700;
            color: #ffd700;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 500;
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

.nav-links a.active {
    color: #ffd700;
}

.nav-links a.active::after {
    width: 100%;
    background-color: #ffd700;
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
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
    
    .container {
        padding: 0;
    }
    
    .logo {
        font-size: 1.5rem;
    }
    
    .mobile-menu-btn {
        display: flex !important;
        position: relative;
        z-index: 1200;
        cursor: pointer;
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

/* Container styling */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

@media (max-width: 1200px) {
    .container {
        padding: 0 20px;
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
                    <li><a href="<?php echo $basePath; ?>index.php">Home</a></li>
                    <li><a href="<?php echo $basePath; ?>preparation.php">Preparation</a></li>
                    <li><a href="<?php echo $basePath; ?>courses.php">Courses</a></li>
                    <li><a href="<?php echo $basePath; ?>skill-assessment.php">Skills Rating</a></li>
                    <li><a href="<?php echo $basePath; ?>quiz/main.php">Quiz</a></li>
                    <li><a href="<?php echo $basePath; ?>contact.php">Contact</a></li>
                    <li><a href="<?php echo $basePath; ?>About.php">About Us</a></li>
                </ul>
                <!-- Mobile Dropdown -->
                <ul class="mobile-dropdown" id="mobileDropdown">
                    <li><a href="<?php echo $basePath; ?>index.php">Home</a></li>
                    <li><a href="<?php echo $basePath; ?>preparation.php">Preparation</a></li>
                    <li><a href="<?php echo $basePath; ?>courses.php">Courses</a></li>
                    <li><a href="<?php echo $basePath; ?>skill-assessment.php">Skills Rating</a></li>
                    <li><a href="<?php echo $basePath; ?>quiz/main.php">Quiz</a></li>
                    <li><a href="<?php echo $basePath; ?>contact.php">Contact</a></li>
                    <li><a href="<?php echo $basePath; ?>About.php">About Us</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li><a href="<?php echo $basePath; ?>notifications.php">
                            <i class="fas fa-bell"></i> Notifications 
                            <?php if (isset($unread_count) && $unread_count > 0): ?>
                                <span class="mobile-notification-badge"><?php echo $unread_count > 99 ? '99+' : $unread_count; ?></span>
                            <?php endif; ?>
                        </a></li>
                        <li><a href="<?php echo $basePath; ?>recommendations.php">
                            <i class="fas fa-lightbulb"></i> Recommendations
                        </a></li>
                        <li><a href="<?php echo $basePath; ?>profile.php">My Profile</a></li>
                        <li><a href="<?php echo $basePath; ?>logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo $basePath; ?>login.php">Login</a></li>
                        <li><a href="<?php echo $basePath; ?>signup.php">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
        <?php if(isset($_SESSION['user_id'])): ?>
            <?php
            // Get unread notification count for header badge
            $unread_count = 0;
            try {
                if (file_exists($basePath . 'config/database.php')) {
                    require_once $basePath . 'config/database.php';
                    if (isset($pdo)) {
                        require_once $basePath . 'includes/NotificationSystem.php';
                        $notificationSystem = new NotificationSystem($pdo);
                        $unread_count = $notificationSystem->getUnreadCount($_SESSION['user_id']);
                    }
                }
            } catch (Exception $e) {
                $unread_count = 0;
                error_log("Header notification count error: " . $e->getMessage());
            }
            ?>
            <div class="user-menu">
                <!-- Notifications Bell -->
                <a href="<?php echo $basePath; ?>notifications.php" class="notification-bell" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <?php if ($unread_count > 0): ?>
                        <span class="notification-badge"><?php echo $unread_count > 99 ? '99+' : $unread_count; ?></span>
                    <?php endif; ?>
                </a>
                
                <!-- Recommendations Link -->
                <a href="<?php echo $basePath; ?>recommendations.php" class="recommendations-icon" title="Your Recommendations">
                    <i class="fas fa-lightbulb"></i>
                </a>
                
                <a href="<?php echo $basePath; ?>profile.php" class="username">
                    <?php if(isset($_SESSION['user_profile_picture']) && $_SESSION['user_profile_picture']): ?>
                        <img src="<?php echo $basePath . htmlspecialchars($_SESSION['user_profile_picture']); ?>" alt="Profile" class="nav-profile-pic">
                    <?php else: ?>
                        <div class="nav-profile-initial">
                            <?php echo strtoupper(substr($_SESSION['user_fullname'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                    <span class="username-text">Welcome, <?php echo htmlspecialchars($_SESSION['user_fullname']); ?></span>
                </a>
                <a href="<?php echo $basePath; ?>logout.php" class="logout-btn">Logout</a>
            </div>
        <?php else: ?>
            <div class="auth-buttons">
                <a href="<?php echo $basePath; ?>login.php" class="cta-btn login">Login</a>
                <a href="<?php echo $basePath; ?>signup.php" class="cta-btn signup">Sign Up</a>
            </div>
        <?php endif; ?>
      </nav>
    </header>

<script>
// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileDropdown = document.getElementById('mobileDropdown');
    const navLinks = document.getElementById('navLinks');
    // Highlight current page for desktop nav
    const currentPage = window.location.pathname.split('/').pop();
    const navLinksItems = navLinks.querySelectorAll('a');
    navLinksItems.forEach(link => {
        const linkPage = link.getAttribute('href').split('/').pop().split('#')[0];
        if (linkPage === currentPage || 
            (currentPage === '' && linkPage === 'index.php') ||
            (currentPage === 'index.php' && linkPage === 'index.php')) {
            link.classList.add('active');
        }
    });

    // Mobile dropdown logic
    if (mobileMenuBtn && mobileDropdown) {
        console.log('Mobile menu elements found'); // Debug log
        mobileMenuBtn.addEventListener('click', function(e) {
            console.log('Hamburger clicked'); // Debug log
            e.stopPropagation();
            mobileDropdown.classList.toggle('active');
            if (mobileDropdown.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
        // Close dropdown when clicking a link
        mobileDropdown.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                mobileDropdown.classList.remove('active');
                mobileMenuBtn.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (
                mobileDropdown.classList.contains('active') &&
                !mobileMenuBtn.contains(event.target) &&
                !mobileDropdown.contains(event.target)
            ) {
                mobileDropdown.classList.remove('active');
                mobileMenuBtn.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                mobileDropdown.classList.remove('active');
                mobileMenuBtn.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }
});
</script>

</body>
</html>