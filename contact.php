<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - BeThePro's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/hero.css">
    <link rel="stylesheet" href="css/animations.css">
</head>
<body class="loading">
    <?php
include 'assets/loader.php';


include 'assets/header.php';

?>

    
    <!-- Contact Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="hero-content">
                <h1>Get In Touch With Us</h1>
                <p>Have questions about our courses or services? Our dedicated team is here to help you achieve your career goals through personalized interview preparation guidance.</p>
                <div class="hero-highlights">
                    <div class="highlight-item">
                        <span class="highlight-icon">⚡</span>
                        <span class="highlight-text">24/7 Support</span>
                    </div>
                    <div class="highlight-item">
                        <span class="highlight-icon">🎯</span>
                        <span class="highlight-text">Expert Guidance</span>
                    </div>
                    <div class="highlight-item">
                        <span class="highlight-icon">⏱️</span>
                        <span class="highlight-text">Quick Response</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-shape"></div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info">
                    <h2>Contact Information</h2>
                    <p>Fill out the form or reach out to us directly through the information below.</p>
                    
                    <div class="contact-method">
                        <div class="contact-icon">📧</div>
                        <div>
                            <h3>Email Us</h3>
                            <p>support@bethepros.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="contact-icon">📞</div>
                        <div>
                            <h3>Call Us</h3>
                            <p>+1 (555) 123-4567</p>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="contact-icon">📍</div>
                        <div>
                            <h3>Visit Us</h3>
                            <p>123 Success Ave, Suite 500<br>San Francisco, CA 94107</p>
                        </div>
                    </div>
                </div>
                
                <div class="form-container">
                    <h2>Send Us a Message</h2>
                    
                    <?php if (isset($_SESSION['contact_success'])): ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['contact_success']; unset($_SESSION['contact_success']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['contact_error'])): ?>
                        <div class="alert alert-error">
                            <?php echo $_SESSION['contact_error']; unset($_SESSION['contact_error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form id="contactForm" method="POST" action="process_contact.php">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Your WhatsApp No</label>
                            <input type="text" id="phone" name="phone" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Your Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="primary-btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How do I choose the right course for my level?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>We offer course recommendations based on your experience level during the signup process. You can also take our quick assessment test to determine which course would be most beneficial for you.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can I access the courses on mobile devices?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes! Our platform is fully responsive and works on all devices including smartphones and tablets. You can even download lessons for offline viewing in our mobile app.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What if I'm not satisfied with the courses?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>We offer a 30-day money-back guarantee. If you're not completely satisfied with our courses within the first 30 days, we'll refund your payment in full.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How often is the content updated?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>We update our content quarterly to reflect the latest interview trends and techniques. Major updates are announced to all active subscribers.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you offer corporate training programs?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we provide customized corporate training solutions for organizations looking to improve their teams' interview skills. Contact our sales team for more information.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can I get personalized feedback on my interview skills?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Our premium plans include one-on-one coaching sessions with our experts who will provide personalized feedback and improvement strategies.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (same as index.html) -->
    <?php include 'assets/footer.php'; ?>

    <script src="script.js"></script>

    Main Imp For contact.php
    <script>
        // Loader functionality (same as index.html)
        // window.addEventListener('load', function() {
        //     const loader = document.getElementById('loader');
        //     const body = document.body;
            
        //     setTimeout(() => {
        //         loader.classList.add('fade-out');
        //         body.classList.remove('loading');
                
        //         setTimeout(() => {
        //             loader.style.display = 'none';
        //         }, 500);
        //     }, 2000);
        // });

        // FAQ Accordion
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const item = question.parentElement;
                const answer = item.querySelector('.faq-answer');
                const icon = question.querySelector('.toggle-icon');
                
                item.classList.toggle('active');
                
                if (item.classList.contains('active')) {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    icon.textContent = '-';
                } else {
                    answer.style.maxHeight = '0';
                    icon.textContent = '+';
                }
                
                // Close other open items
                document.querySelectorAll('.faq-item').forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                        otherItem.querySelector('.faq-answer').style.maxHeight = '0';
                        otherItem.querySelector('.toggle-icon').textContent = '+';
                    }
                });
            });
        });

        // Form submission
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                // Check if user is logged in
                <?php if (!isset($_SESSION['user_id'])) { ?>
                    e.preventDefault();
                    // Show custom alert
                    const alertMessage = document.createElement('div');
                    alertMessage.className = 'custom-alert';
                    alertMessage.innerHTML = `
                        <div class="alert-content">
                            <h3>🔐 Login Required</h3>
                            <p>You need to be logged in to send messages. Please log in or create an account to continue.</p>
                            <div class="alert-buttons">
                                <a href="login.php" class="primary-btn">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                                <a href="signup.php" class="secondary-btn">
                                    <i class="fas fa-user-plus"></i> Sign Up
                                </a>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(alertMessage);
                    
                    // Add fade in effect
                    setTimeout(() => alertMessage.classList.add('show'), 10);
                    
                    // Remove alert when clicking outside
                    alertMessage.addEventListener('click', function(event) {
                        if (event.target === this) {
                            this.classList.remove('show');
                            setTimeout(() => this.remove(), 300);
                        }
                    });
                    
                    // Add close button functionality with Escape key
                    document.addEventListener('keydown', function(event) {
                        if (event.key === 'Escape' && document.querySelector('.custom-alert.show')) {
                            const alert = document.querySelector('.custom-alert.show');
                            alert.classList.remove('show');
                            setTimeout(() => alert.remove(), 300);
                        }
                    });
                    
                    return;
                <?php } else { ?>
                    // Simple validation for logged-in users
                    const inputs = this.querySelectorAll('input[required], textarea[required]');
                    let isValid = true;
                    
                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            isValid = false;
                            input.classList.add('error');
                        } else {
                            input.classList.remove('error');
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                        alert('Please fill in all required fields.');
                        return;
                    }
                    
                    // If validation passes, let the form submit normally to process_contact.php
                <?php } ?>
            });
        }
    </script>
</body>
</html>