<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll Now - BeThePro's</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/enroll.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="loading">
    <?php
    include 'assets/loader.php';
    include 'assets/header.php';
    
    // Get course information from URL parameters
    $course_name = isset($_GET['course']) ? urldecode($_GET['course']) : 'Course Selection';
    $course_price = isset($_GET['price']) ? $_GET['price'] : '99';
    $course_duration = isset($_GET['duration']) ? $_GET['duration'] : '6 Weeks';
    $course_lessons = isset($_GET['lessons']) ? $_GET['lessons'] : '24 Lessons';
    ?>

    <!-- Enrollment Hero Section -->
    <section class="enroll-hero">
        <div class="container">
            <div class="hero-content">
                <h1>Complete Your Enrollment</h1>
                <p>Take the next step in your career journey with professional interview preparation</p>
                <div class="security-badges">
                    <div class="security-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>SSL Secured</span>
                    </div>
                    <div class="security-item">
                        <i class="fas fa-lock"></i>
                        <span>256-bit Encryption</span>
                    </div>
                    <div class="security-item">
                        <i class="fas fa-credit-card"></i>
                        <span>PCI Compliant</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enrollment Form Section -->
    <section class="enrollment-section">
        <div class="container">
            <div class="enrollment-wrapper">
                <!-- Course Summary -->
                <div class="course-summary">
                    <div class="summary-header">
                        <h3>Course Summary</h3>
                        <div class="course-badge-large">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Premium Course</span>
                        </div>
                    </div>
                    
                    <div class="course-details">
                        <h4 id="selected-course"><?php echo htmlspecialchars($course_name); ?></h4>
                        <div class="course-features">
                            <div class="feature-item">
                                <i class="fas fa-clock"></i>
                                <span id="course-duration"><?php echo htmlspecialchars($course_duration); ?></span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-book"></i>
                                <span id="course-lessons"><?php echo htmlspecialchars($course_lessons); ?></span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-certificate"></i>
                                <span>Certificate Included</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-headset"></i>
                                <span>24/7 Support</span>
                            </div>
                        </div>
                    </div>

                    <div class="pricing-breakdown">
                        <div class="price-item">
                            <span>Course Fee</span>
                            <span id="course-price">$<?php echo htmlspecialchars($course_price); ?></span>
                        </div>
                        <div class="price-item discount">
                            <span>Early Bird Discount (20%)</span>
                            <span id="discount-amount">-$<?php echo round($course_price * 0.2); ?></span>
                        </div>
                        <div class="price-item tax">
                            <span>Tax (8%)</span>
                            <span id="tax-amount">$<?php echo round(($course_price * 0.8) * 0.08); ?></span>
                        </div>
                        <div class="price-total">
                            <span>Total Amount</span>
                            <span id="total-amount">$<?php echo round(($course_price * 0.8) + (($course_price * 0.8) * 0.08)); ?></span>
                        </div>
                    </div>

                    <div class="guarantee-badge">
                        <i class="fas fa-medal"></i>
                        <div class="guarantee-text">
                            <strong>30-Day Money Back Guarantee</strong>
                            <p>Not satisfied? Get a full refund within 30 days</p>
                        </div>
                    </div>
                </div>

                <!-- Enrollment Form -->
                <div class="enrollment-form">
                    <form id="enrollmentForm" method="POST" action="process_enrollment.php">
                        <!-- Hidden course info fields -->
                        <input type="hidden" name="courseName" value="<?php echo htmlspecialchars($course_name); ?>">
                        <input type="hidden" name="coursePrice" value="<?php echo htmlspecialchars($course_price); ?>">
                        <input type="hidden" name="courseDuration" value="<?php echo htmlspecialchars($course_duration); ?>">
                        <!-- Step 1: Personal Information -->
                        <div class="form-step active" data-step="1" style="display: block;">
                            <div class="step-header">
                                <h3><i class="fas fa-user"></i> Personal Information</h3>
                                <div class="step-indicator">Step 1 of 3</div>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="firstName">First Name *</label>
                                    <input type="text" id="firstName" name="firstName" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Last Name *</label>
                                    <input type="text" id="lastName" name="lastName" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required>
                                <small>We'll send your course access details to this email</small>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <input type="tel" id="phone" name="phone" required>
                                </div>
                                <div class="form-group">
                                    <label for="country">Country *</label>
                                    <select id="country" name="country" required>
                                        <option value="">Select Country</option>
                                        <option value="US">United States</option>
                                        <option value="CA">Canada</option>
                                        <option value="PK">Pakistan</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="AU">Australia</option>
                                        <option value="IN">India</option>
                                        <option value="DE">Germany</option>
                                        <option value="FR">France</option>
                                        <option value="OTHER">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="experience">Current Experience Level</label>
                                <select id="experience" name="experience">
                                    <option value="fresh-graduate">Fresh Graduate</option>
                                    <option value="0-2-years">0-2 Years</option>
                                    <option value="3-5-years">3-5 Years</option>
                                    <option value="5-10-years">5-10 Years</option>
                                    <option value="10-plus-years">10+ Years</option>
                                </select>
                            </div>
                        </div>

                        <!-- Step 2: Course Preferences -->
                        <div class="form-step" data-step="2" style="display: block;">
                            <div class="step-header">
                                <h3><i class="fas fa-cogs"></i> Course Preferences</h3>
                                <div class="step-indicator">Step 2 of 3</div>
                            </div>
                            
                            <div class="form-group">
                                <label>Preferred Learning Schedule</label>
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input type="radio" name="schedule" value="weekdays" checked>
                                        <span class="radio-custom"></span>
                                        <div class="radio-content">
                                            <strong>Weekdays (Mon-Fri)</strong>
                                            <small>Intensive weekday sessions</small>
                                        </div>
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="schedule" value="weekends">
                                        <span class="radio-custom"></span>
                                        <div class="radio-content">
                                            <strong>Weekends (Sat-Sun)</strong>
                                            <small>Weekend-focused learning</small>
                                        </div>
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="schedule" value="flexible">
                                        <span class="radio-custom"></span>
                                        <div class="radio-content">
                                            <strong>Flexible Schedule</strong>
                                            <small>Learn at your own pace</small>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="goals">Career Goals (Optional)</label>
                                <textarea id="goals" name="goals" rows="3" placeholder="Tell us about your career goals and what you hope to achieve..."></textarea>
                            </div>
                        </div>

                        <!-- Step 3: Payment Information -->
                        <div class="form-step" data-step="3" style="display: block;">
                            <div class="step-header">
                                <h3><i class="fas fa-credit-card"></i> Payment Information</h3>
                                <div class="step-indicator">Step 3 of 3</div>
                            </div>

                            <div class="payment-methods">
                                <label class="payment-method active">
                                    <input type="radio" name="paymentMethod" value="card" checked>
                                    <div class="method-content">
                                        <i class="fas fa-credit-card"></i>
                                        <span>Credit/Debit Card</span>
                                    </div>
                                </label>
                                <label class="payment-method">
                                    <input type="radio" name="paymentMethod" value="paypal">
                                    <div class="method-content">
                                        <i class="fab fa-paypal"></i>
                                        <span>PayPal</span>
                                    </div>
                                </label>
                                <label class="payment-method">
                                    <input type="radio" name="paymentMethod" value="stripe">
                                    <div class="method-content">
                                        <i class="fas fa-university"></i>
                                        <span>Bank Transfer</span>
                                    </div>
                                </label>
                            </div>

                            <div class="card-form" id="cardForm">
                                <div class="demo-notice" style="background: #f0f9ff; border: 1px solid #0ea5e9; border-radius: 10px; padding: 1rem; margin-bottom: 1.5rem; color: #0c4a6e;">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Demo Mode:</strong> This is a class project. You can use dummy payment information for testing purposes.
                                </div>
                                
                                <div class="form-group">
                                    <label for="cardName">Cardholder Name</label>
                                    <input type="text" id="cardName" name="cardName" placeholder="e.g., John Doe (demo data)">
                                </div>
                                
                                <div class="form-group">
                                    <label for="cardNumber">Card Number</label>
                                    <input type="text" id="cardNumber" name="cardNumber" placeholder="4111 1111 1111 1111 (demo card)">
                                    <div class="card-icons">
                                        <i class="fab fa-cc-visa"></i>
                                        <i class="fab fa-cc-mastercard"></i>
                                        <i class="fab fa-cc-amex"></i>
                                        <i class="fab fa-cc-discover"></i>
                                    </div>
                                </div>
                                
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="expiryDate">Expiry Date</label>
                                        <input type="text" id="expiryDate" name="expiryDate" placeholder="12/25 (demo)">
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">CVV</label>
                                        <input type="text" id="cvv" name="cvv" placeholder="123 (demo)">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="checkbox-option terms">
                                        <input type="checkbox" name="terms" required>
                                        <span class="checkbox-custom"></span>
                                        <span>I agree to the <a href="#" class="terms-link">Terms of Service</a> and <a href="#" class="terms-link">Privacy Policy</a></span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="checkbox-option">
                                        <input type="checkbox" name="newsletter" checked>
                                        <span class="checkbox-custom"></span>
                                        <span>Subscribe to our newsletter for course updates and career tips</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="form-navigation">
                            <button type="button" class="btn-secondary" id="prevBtn" style="display: none;">
                                <i class="fas fa-arrow-left"></i> Previous
                            </button>
                            <button type="button" class="btn-primary" id="nextBtn">
                                Next <i class="fas fa-arrow-right"></i>
                            </button>
                            <button type="submit" class="btn-success" id="submitBtn" style="display: block;">
                                <i class="fas fa-lock"></i> Complete Enrollment
                            </button>
                        </div>

                        <!-- Progress Bar -->
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 33.33%;"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Section -->
    <section class="trust-section">
        <div class="container">
            <h3>Trusted by Professionals Worldwide</h3>
            <div class="trust-stats">
                <div class="trust-stat">
                    <strong>10,000+</strong>
                    <span>Students Enrolled</span>
                </div>
                <div class="trust-stat">
                    <strong>95%</strong>
                    <span>Success Rate</span>
                </div>
                <div class="trust-stat">
                    <strong>4.9/5</strong>
                    <span>Average Rating</span>
                </div>
                <div class="trust-stat">
                    <strong>24/7</strong>
                    <span>Support Available</span>
                </div>
            </div>
        </div>
    </section>

    <?php include 'assets/footer.php'; ?>

    <!-- <script src="js/enroll.js"></script> -->
</body>
</html>
