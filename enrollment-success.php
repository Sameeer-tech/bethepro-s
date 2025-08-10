<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Successful - BeThePro's</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/enroll.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .success-hero {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.95), rgba(5, 150, 105, 0.9)),
                        url("https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80");
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .success-icon {
            font-size: 4rem;
            color: #10B981;
            margin-bottom: 2rem;
            animation: successPulse 2s infinite;
        }
        
        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .success-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 3rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            color: var(--text-color);
        }
        
        .enrollment-details {
            background: #f8fafc;
            padding: 2rem;
            border-radius: 15px;
            margin: 2rem 0;
            border-left: 4px solid #10B981;
        }
        
        .next-steps {
            text-align: left;
            margin: 2rem 0;
        }
        
        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 10px;
        }
        
        .step-number {
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            min-width: 30px;
        }
        
        .contact-info {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.02));
            padding: 2rem;
            border-radius: 15px;
            margin: 2rem 0;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }
        
        .contact-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .contact-method {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
        }
        
        .contact-method i {
            color: var(--primary-color);
            width: 20px;
        }
    </style>
</head>
<body class="loading">
    <?php
    include 'assets/loader.php';
    include 'assets/header.php';
    
    // Get enrollment ID from URL
    $enrollmentId = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'ENR' . date('Ymd') . rand(1000, 9999);
    ?>

    <!-- Success Hero Section -->
    <section class="success-hero">
        <div class="container">
            <div class="success-content">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1>Enrollment Successful!</h1>
                <p>Congratulations! You've successfully enrolled in BeThePro's. Your journey to interview mastery starts now.</p>
                
                <div class="enrollment-details">
                    <h3><i class="fas fa-id-card"></i> Enrollment Details</h3>
                    <p><strong>Enrollment ID:</strong> <?php echo $enrollmentId; ?></p>
                    <p><strong>Date:</strong> <?php echo date('F j, Y'); ?></p>
                    <p><strong>Status:</strong> <span style="color: #10B981; font-weight: 600;">Confirmed</span></p>
                </div>
                
                <div class="next-steps">
                    <h3>What Happens Next?</h3>
                    
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div>
                            <strong>Confirmation Email (Within 5 minutes)</strong>
                            <p>You'll receive a detailed confirmation email with your enrollment details and next steps.</p>
                        </div>
                    </div>
                    
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div>
                            <strong>Course Access (Within 24 hours)</strong>
                            <p>Your course materials and student dashboard access will be activated and sent to your email.</p>
                        </div>
                    </div>
                    
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div>
                            <strong>Welcome Call (Within 48 hours)</strong>
                            <p>Our team will contact you to schedule your first session and answer any questions.</p>
                        </div>
                    </div>
                    
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div>
                            <strong>Start Learning</strong>
                            <p>Begin your personalized interview preparation journey with expert guidance.</p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-info">
                    <h3><i class="fas fa-headset"></i> Need Immediate Help?</h3>
                    <p>Our support team is here for you 24/7:</p>
                    
                    <div class="contact-methods">
                        <div class="contact-method">
                            <i class="fas fa-envelope"></i>
                            <span>support@bethepros.com</span>
                        </div>
                        <div class="contact-method">
                            <i class="fas fa-phone"></i>
                            <span>+1-800-BETHEPRO</span>
                        </div>
                        <div class="contact-method">
                            <i class="fas fa-comments"></i>
                            <span>Live Chat Available</span>
                        </div>
                        <div class="contact-method">
                            <i class="fas fa-clock"></i>
                            <span>24/7 Support</span>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 2rem;">
                    <a href="courses.php" class="btn-primary" style="margin-right: 1rem;">
                        <i class="fas fa-arrow-left"></i> Back to Courses
                    </a>
                    <a href="index.php" class="btn-secondary">
                        <i class="fas fa-home"></i> Go to Homepage
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stats -->
    <section class="trust-section">
        <div class="container">
            <h3>You're Joining a Community of Success</h3>
            <div class="trust-stats">
                <div class="trust-stat">
                    <strong>10,000+</strong>
                    <span>Students Like You</span>
                </div>
                <div class="trust-stat">
                    <strong>95%</strong>
                    <span>Interview Success Rate</span>
                </div>
                <div class="trust-stat">
                    <strong>4.9/5</strong>
                    <span>Student Satisfaction</span>
                </div>
                <div class="trust-stat">
                    <strong>500+</strong>
                    <span>Partner Companies</span>
                </div>
            </div>
        </div>
    </section>

    <?php include 'assets/footer.php'; ?>

    <script>
        // Auto-scroll to success content
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.success-content').scrollIntoView({ 
                behavior: 'smooth',
                block: 'center'
            });
            
            // Show success animation
            setTimeout(() => {
                document.querySelector('.success-icon').style.animation = 'successPulse 2s infinite';
            }, 500);
        });
    </script>
</body>
</html>
