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
<body class="loading">
<style>
/* Ensure consistent fonts across all pages */
* {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana,    // Highlight active page
    const currentPage = window.location.pathname.split('/').pop() || 'index.php';
    const menuLinks = document.querySelectorAll('.menu-links a');
    
    menuLinks.forEach(link => {
        const linkPage = link.getAttribute('href').split('/').pop().split('#')[0];
        if (linkPage === currentPage || (currentPage === '' && linkPage === 'index.php')) {
            link.classList.add('active');
            link.style.background = 'rgba(255, 215, 0, 0.2)';
            link.style.color = '#ffd700';
            link.style.borderColor = 'rgba(255, 215, 0, 0.3)';
        }
    });;
}

/* Professional hamburger sidebar from left */
.mobile-dropdown {
    position: fixed;
    top: 0;
    left: -400px;
    width: 400px;
    height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    z-index: 1100;
    transition: left 0.3s cubic-bezier(.4,0,.2,1);
    backdrop-filter: blur(10px);
    box-shadow: 2px 0 20px rgba(0, 0, 0, 0.3);
}

.mobile-dropdown.active {
    left: 0;
}

/* Overlay for background when sidebar is open */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1050;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.sidebar-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Close button */
.close-menu-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    padding: 12px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.2rem;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 1200;
}

.close-menu-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #ffd700;
    transform: rotate(90deg) scale(1.1);
}

/* Scrollable menu content */
.menu-content {
    height: 100vh;
    overflow-y: auto;
    padding: 80px 20px 40px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}

.menu-links {
    list-style: none;
    margin: 0;
    padding: 0;
    width: 100%;
}

.menu-links li {
    margin: 8px 0;
    opacity: 0;
    transform: translateX(-30px);
    transition: all 0.4s ease;
}

.mobile-dropdown.active .menu-links li {
    opacity: 1;
    transform: translateX(0);
}

.mobile-dropdown.active .menu-links li:nth-child(1) { transition-delay: 0.1s; }
.mobile-dropdown.active .menu-links li:nth-child(2) { transition-delay: 0.15s; }
.mobile-dropdown.active .menu-links li:nth-child(3) { transition-delay: 0.2s; }
.mobile-dropdown.active .menu-links li:nth-child(4) { transition-delay: 0.25s; }
.mobile-dropdown.active .menu-links li:nth-child(5) { transition-delay: 0.3s; }
.mobile-dropdown.active .menu-links li:nth-child(6) { transition-delay: 0.35s; }
.mobile-dropdown.active .menu-links li:nth-child(7) { transition-delay: 0.4s; }
.mobile-dropdown.active .menu-links li:nth-child(8) { transition-delay: 0.45s; }
.mobile-dropdown.active .menu-links li:nth-child(9) { transition-delay: 0.5s; }
.mobile-dropdown.active .menu-links li:nth-child(10) { transition-delay: 0.55s; }
.mobile-dropdown.active .menu-links li:nth-child(11) { transition-delay: 0.6s; }

.menu-links a {
    color: #ffffff;
    font-size: 1.1rem;
    text-decoration: none;
    padding: 15px 20px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 15px;
    transition: all 0.3s ease;
    font-weight: 500;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 4px;
}

.menu-links a:hover {
    background: rgba(255, 255, 255, 0.15);
    color: #ffd700;
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.menu-links i {
    font-size: 1rem;
    width: 20px;
    text-align: center;
}

/* Menu divider */
.menu-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    margin: 15px 0 !important;
    opacity: 1 !important;
    transform: none !important;
}

.menu-divider:hover {
    background: none;
    transform: none;
}

/* Mobile responsive sidebar */
@media (max-width: 480px) {
    .mobile-dropdown {
        width: 300px;
        left: -300px;
    }
    
    .menu-content {
        padding: 70px 15px 30px;
    }
    
    .menu-links a {
        font-size: 1rem;
        padding: 12px 15px;
    }
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

/* Left side navigation */
.nav-left {
    display: flex;
    align-items: center;
    gap: 20px;
}

/* Right side navigation */
.nav-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

/* User actions on left side */
.user-actions-left {
    display: flex;
    align-items: center;
    gap: 12px;
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
    margin-left: 40px;
    list-style: none;
}

.nav-links a {
    color: #ffffff;
    text-decoration: none;
    font-weight: 500;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    transition: var(--transition);
    position: relative;
    padding: 8px 12px;
    border-radius: 5px;
}

.nav-links a:hover {
    opacity: 0.9;
    background: rgba(255, 255, 255, 0.1);
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

/* Mobile Menu Button - show on all screen sizes for professional hamburger design */
.mobile-menu-btn {
    display: flex;
    flex-direction: column;
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
    z-index: 1001;
}

.mobile-menu-btn span {
    width: 28px;
    height: 3px;
    background-color: #ffffff;
    margin: 4px 0;
    transition: all 0.3s ease;
    border-radius: 3px;
    display: block;
}

.mobile-menu-btn.active span:nth-child(1) {
    transform: rotate(-45deg) translate(-7px, 7px);
    background-color: #ffd700;
}

.mobile-menu-btn.active span:nth-child(2) {
    opacity: 0;
}

.mobile-menu-btn.active span:nth-child(3) {
    transform: rotate(45deg) translate(-7px, -7px);
    background-color: #ffd700;
}

/* Hide desktop navigation - using hamburger menu only for professional look */
.nav-links {
    display: none !important;
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
    
    .nav-container {
        padding: 0 20px;
    }
    
    .logo {
        font-size: 1.5rem;
    }
    
    .nav-left {
        gap: 15px;
    }
    
    .nav-right {
        gap: 10px;
    }
    
    .user-actions-left {
        gap: 8px;
    }
    
    .username-text {
        display: none;
    }
    
    .username {
        padding: 8px;
        margin-right: 5px;
    }
    
    .auth-buttons {
        gap: 8px;
    }
    
    .cta-btn {
        padding: 6px 12px;
        font-size: 0.8rem;
    }
    
    .logout-btn {
        padding: 6px 12px;
        font-size: 0.8rem;
    }
    
    .menu-content {
        padding: 60px 15px 30px;
    }
    
    .menu-links {
        max-width: 350px;
    }
    
    .menu-links a {
        font-size: 1.2rem;
        padding: 12px 20px;
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
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 30px;
}

@media (max-width: 1200px) {
    .container {
        padding: 0 20px;
    }
}
</style>


 <header>
      <nav class="container">
        <!-- Left side: Logo + Profile Elements -->
        <div class="nav-left">
            <div class="logo">BeThePro's</div>
            
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
                
                <div class="user-actions-left">
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
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Right side: Auth buttons + Hamburger -->
        <div class="nav-right">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="<?php echo $basePath; ?>logout.php" class="logout-btn">Logout</a>
            <?php else: ?>
                <div class="auth-buttons">
                    <a href="<?php echo $basePath; ?>login.php" class="cta-btn login">Login</a>
                    <a href="<?php echo $basePath; ?>signup.php" class="cta-btn signup">Sign Up</a>
                </div>
            <?php endif; ?>
            
            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        
        <!-- Mobile Dropdown with close button and scroll -->
        <div class="mobile-dropdown" id="mobileDropdown">
            <!-- Close button -->
            <button class="close-menu-btn" id="closeMenuBtn">
                <i class="fas fa-times"></i>
            </button>
            
            <!-- Scrollable menu content -->
            <div class="menu-content">
                <ul class="menu-links">
                    <li><a href="<?php echo $basePath; ?>index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="<?php echo $basePath; ?>preparation.php"><i class="fas fa-book-open"></i> Preparation</a></li>
                    <li><a href="<?php echo $basePath; ?>courses.php"><i class="fas fa-graduation-cap"></i> Courses</a></li>
                    <li><a href="<?php echo $basePath; ?>skill-assessment.php"><i class="fas fa-star"></i> Skills Rating</a></li>
                    <li><a href="<?php echo $basePath; ?>quiz/main.php"><i class="fas fa-question-circle"></i> Quiz</a></li>
                    <li><a href="<?php echo $basePath; ?>contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
                    <li><a href="<?php echo $basePath; ?>About.php"><i class="fas fa-info-circle"></i> About Us</a></li>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="menu-divider"></li>
                        <li><a href="<?php echo $basePath; ?>notifications.php">
                            <i class="fas fa-bell"></i> Notifications 
                            <?php if (isset($unread_count) && $unread_count > 0): ?>
                                <span class="mobile-notification-badge"><?php echo $unread_count > 99 ? '99+' : $unread_count; ?></span>
                            <?php endif; ?>
                        </a></li>
                        <li><a href="<?php echo $basePath; ?>recommendations.php">
                            <i class="fas fa-lightbulb"></i> Recommendations
                        </a></li>
                        <li><a href="<?php echo $basePath; ?>profile.php"><i class="fas fa-user"></i> My Profile</a></li>
                        <li><a href="<?php echo $basePath; ?>logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    <?php else: ?>
                        <li class="menu-divider"></li>
                        <li><a href="<?php echo $basePath; ?>login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li><a href="<?php echo $basePath; ?>signup.php"><i class="fas fa-user-plus"></i> Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        
        <!-- Sidebar overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
      </nav>
    </header>

<script>
// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileDropdown = document.getElementById('mobileDropdown');
    const closeMenuBtn = document.getElementById('closeMenuBtn');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    // Highlight active page in sidebar menu
    const currentPage = window.location.pathname.split('/').pop() || 'index.php';
    const menuLinks = document.querySelectorAll('.menu-links a');
    
    menuLinks.forEach(link => {
        const linkPage = link.getAttribute('href').split('/').pop().split('#')[0];
        if (linkPage === currentPage || (currentPage === '' && linkPage === 'index.php')) {
            link.classList.add('active');
            link.style.background = 'rgba(255, 215, 0, 0.2)';
            link.style.color = '#ffd700';
            link.style.borderColor = 'rgba(255, 215, 0, 0.3)';
        }
    });

    // Sidebar control functions
    function openSidebar() {
        console.log('Opening sidebar...');
        if (mobileMenuBtn) mobileMenuBtn.classList.add('active');
        if (mobileDropdown) mobileDropdown.classList.add('active');
        if (sidebarOverlay) sidebarOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeSidebar() {
        console.log('Closing sidebar...');
        if (mobileMenuBtn) mobileMenuBtn.classList.remove('active');
        if (mobileDropdown) mobileDropdown.classList.remove('active');
        if (sidebarOverlay) sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Debug: Check if elements exist
    console.log('Mobile menu button:', mobileMenuBtn);
    console.log('Mobile dropdown:', mobileDropdown);
    console.log('Sidebar overlay:', sidebarOverlay);
    
    // Open sidebar when hamburger is clicked
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function(e) {
            console.log('Hamburger clicked!');
            e.preventDefault();
            e.stopPropagation();
            
            if (mobileDropdown && mobileDropdown.classList.contains('active')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    // Close sidebar when close button is clicked
    if (closeMenuBtn) {
        closeMenuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeSidebar();
        });
    }
    
    // Close sidebar when overlay is clicked
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            closeSidebar();
        });
    }
    
    // Close sidebar when clicking a menu link
    if (mobileDropdown) {
        mobileDropdown.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                closeSidebar();
            });
        });
        
        // Prevent sidebar from closing when clicking inside it
        mobileDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // Handle escape key to close sidebar
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileDropdown && mobileDropdown.classList.contains('active')) {
            closeSidebar();
        }
    });
});
</script>

</body>
</html>