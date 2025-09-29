<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Courses - BeThePro's</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/courses.css">
    <link rel="stylesheet" href="css/course-images.css">
    <link rel="stylesheet" href="css/animations.css">\
</head>

<style>

.my_cover
{
    width: 100%;
    
    object-fit: cover;
}

.container1
{
    width: 100%;
    padding-top: 60px;
    position: relative;
}
   


</style>





    <?php
include 'assets/loader.php';


include 'assets/header.php';

?>

     <!-- Professional Courses Hero Section -->
     <div class="courses-hero-bg">
         <div class="courses-hero-content">
             <h1>Master Your Professional Skills</h1>
             <p>Transform your career with our comprehensive training programs designed by industry experts</p>
         </div>
     </div>
     
<body>
    <!-- Course Categories -->
    <section class="course-categories">
        <div class="container" style="display:flex; justify-content: center; text-align:center; margin-top: 25px;">
            <div class="courses-heading">
                <h2 class="section-title">Our Professional Courses</h2>
                <p class="section-subtitle">Discover comprehensive training programs designed to advance your career</p>
            </div>
        </div>
    </section>

    <!-- Courses Grid -->
    <section class="courses-grid-section">
        <div class="container">
            <div class="courses-grid">
                <?php
                // Load courses from database
                include 'config/database.php';
                
                $coursesDisplayed = false;
                
                try {
                    $stmt = $pdo->query("SELECT * FROM courses WHERE status = 'Active' ORDER BY created_at DESC");
                    $courses = $stmt->fetchAll();
                    
                    if (!empty($courses)) {
                        foreach ($courses as $course) {
                            // Convert features string to array
                            $features = explode(',', $course['features']);
                            
                            // Get category from level
                            $category = strtolower($course['level']);
                            
                            // Assign professional CSS image class based on title content
                            $imageClass = 'course-image';
                            if (stripos($course['title'], 'interview') !== false) {
                                $imageClass .= ' interview-prep';
                            } elseif (stripos($course['title'], 'technical') !== false || stripos($course['title'], 'coding') !== false) {
                                $imageClass .= ' technical';
                            } elseif (stripos($course['title'], 'communication') !== false || stripos($course['title'], 'soft skills') !== false) {
                                $imageClass .= ' communication';
                            } elseif (stripos($course['title'], 'leadership') !== false || stripos($course['title'], 'management') !== false) {
                                $imageClass .= ' leadership';
                            } else {
                                // Fallback based on level
                                $imageClass .= ' ' . $category;
                            }
                            
                            echo '<div class="course-card animate-fade-in" data-category="' . $category . '">';
                            echo '<div class="course-badge" data-type="' . $category . '">' . htmlspecialchars($course['level']) . '</div>';
                            echo '<div class="' . $imageClass . '"></div>';
                            echo '<div class="course-content">';
                            echo '<h3>' . htmlspecialchars($course['title']) . '</h3>';
                            echo '<p class="course-description">' . htmlspecialchars($course['description']) . '</p>';
                            echo '<div class="course-meta">';
                            echo '<span class="duration">⏱️ ' . htmlspecialchars($course['duration']) . '</span>';
                            echo '<span class="lessons"><i class="fas fa-book"></i> 24 Lessons</span>';
                            echo '<span class="level"><i class="fas fa-chart-bar"></i> ' . htmlspecialchars($course['level']) . '</span>';
                            echo '</div>';
                            echo '<div class="course-price">';
                            echo '<span class="price">$' . number_format($course['price'], 0) . '</span>';
                            echo '<button class="enroll-btn" onclick="checkLoginAndEnroll(\'' . htmlspecialchars($course['title']) . '\', ' . $course['price'] . ', \'' . htmlspecialchars($course['duration']) . '\', \'24 Lessons\')">Enroll Now</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        $coursesDisplayed = true;
                    }
                } catch (PDOException $e) {
                    // Continue to show sample courses if database fails
                    error_log("Database error in courses.php: " . $e->getMessage());
                }
                
                // Show sample courses if no database courses found
                if (!$coursesDisplayed) {
                    $sampleCourses = [
                        [
                            'title' => 'Interview Mastery for Freshers',
                            'description' => 'Complete interview preparation course designed specifically for fresh graduates and entry-level professionals.',
                            'level' => 'Beginner',
                            'duration' => '4 weeks',
                            'price' => 99
                        ],
                        [
                            'title' => 'Advanced Interview Techniques',
                            'description' => 'Advanced strategies for experienced professionals targeting senior positions and leadership roles.',
                            'level' => 'Advanced',
                            'duration' => '6 weeks',
                            'price' => 199
                        ],
                        [
                            'title' => 'Technical Interview Prep',
                            'description' => 'Specialized course for technical interviews including coding challenges and system design.',
                            'level' => 'Intermediate',
                            'duration' => '5 weeks',
                            'price' => 149
                        ],
                        [
                            'title' => 'Communication & Soft Skills',
                            'description' => 'Master the art of communication, body language, and interpersonal skills for interviews.',
                            'level' => 'Beginner',
                            'duration' => '3 weeks',
                            'price' => 79
                        ],
                        [
                            'title' => 'Executive Interview Coaching',
                            'description' => 'Premium coaching for C-level and executive positions with personalized guidance.',
                            'level' => 'Expert',
                            'duration' => '8 weeks',
                            'price' => 299
                        ],
                        [
                            'title' => 'Industry-Specific Preparation',
                            'description' => 'Tailored preparation for specific industries including finance, tech, healthcare, and more.',
                            'level' => 'Intermediate',
                            'duration' => '4 weeks',
                            'price' => 129
                        ]
                    ];
                    
                    foreach ($sampleCourses as $course) {
                        $category = strtolower($course['level']);
                        
                        // Assign professional CSS image class based on title content
                        $imageClass = 'course-image';
                        if (stripos($course['title'], 'interview') !== false) {
                            $imageClass .= ' interview-prep';
                        } elseif (stripos($course['title'], 'technical') !== false || stripos($course['title'], 'coding') !== false) {
                            $imageClass .= ' technical';
                        } elseif (stripos($course['title'], 'communication') !== false || stripos($course['title'], 'soft skills') !== false) {
                            $imageClass .= ' communication';
                        } elseif (stripos($course['title'], 'leadership') !== false || stripos($course['title'], 'management') !== false || stripos($course['title'], 'executive') !== false) {
                            $imageClass .= ' leadership';
                        } else {
                            // Fallback based on level
                            $imageClass .= ' ' . $category;
                        }
                        
                        echo '<div class="course-card animate-fade-in" data-category="' . $category . '">';
                        echo '<div class="course-badge" data-type="' . $category . '">' . htmlspecialchars($course['level']) . '</div>';
                        echo '<div class="' . $imageClass . '"></div>';
                        echo '<div class="course-content">';
                        echo '<h3>' . htmlspecialchars($course['title']) . '</h3>';
                        echo '<p class="course-description">' . htmlspecialchars($course['description']) . '</p>';
                        echo '<div class="course-meta">';
                        echo '<span class="duration">⏱️ ' . htmlspecialchars($course['duration']) . '</span>';
                        echo '<span class="lessons"><i class="fas fa-book"></i> 24 Lessons</span>';
                        echo '<span class="level">📊 ' . htmlspecialchars($course['level']) . '</span>';
                        echo '</div>';
                        echo '<div class="course-price">';
                        echo '<span class="price">$' . number_format($course['price'], 0) . '</span>';
                        echo '<button class="enroll-btn" onclick="checkLoginAndEnroll(\'' . htmlspecialchars($course['title']) . '\', ' . $course['price'] . ', \'' . htmlspecialchars($course['duration']) . '\', \'24 Lessons\')">Enroll Now</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Course Benefits -->
    <section class="course-benefits">
        <div class="container">
            <h2 class="section-title">Why Our Courses Work</h2>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-bullseye"></i></div>
                    <h3>Structured Learning Path</h3>
                    <p>Step-by-step modules that build your skills progressively.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">🤝</div>
                    <h3>Real-world Scenarios</h3>
                    <p>Practice with actual interview questions from top companies.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">📈</div>
                    <h3>Performance Tracking</h3>
                    <p>Monitor your progress with detailed analytics.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">👨‍🏫</div>
                    <h3>Expert Feedback</h3>
                    <p>Get personalized feedback on mock interviews.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready to Transform Your Interview Skills?</h2>
            <p>Join thousands of professionals who have successfully landed their dream jobs with our expert guidance.</p>
            <a href="#signup" class="primary-btn">Start Your Journey Today</a>
        </div>
    </section>

<?php include 'assets/footer.php'; ?>

<style>
/* Custom Alert Styles */
.custom-alert {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.custom-alert.show {
    opacity: 1;
}

.alert-content {
    background: white;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    transform: translateY(-20px);
    transition: transform 0.3s ease;
}

.custom-alert.show .alert-content {
    transform: translateY(0);
}

.alert-content h3 {
    color: var(--primary-color);
    margin-bottom: 15px;
    font-size: 1.5rem;
    font-weight: 600;
}

.alert-content p {
    margin-bottom: 25px;
    color: var(--gray-dark);
    line-height: 1.6;
}

.alert-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.alert-buttons .primary-btn,
.alert-buttons .secondary-btn {
    padding: 12px 24px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.alert-buttons .primary-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.alert-buttons .primary-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.alert-buttons .secondary-btn {
    background: var(--gray-light);
    color: var(--gray-dark);
    border: 2px solid var(--gray-light);
}

.alert-buttons .secondary-btn:hover {
    background: white;
    border-color: var(--primary-color);
    color: var(--primary-color);
}
</style>

<script>
function checkLoginAndEnroll(courseName, price, duration, lessons) {
    <?php if (!isset($_SESSION['user_id'])) { ?>
        // Show custom alert for login requirement
        const alertMessage = document.createElement('div');
        alertMessage.className = 'custom-alert';
        alertMessage.innerHTML = `
            <div class="alert-content">
                <h3>🔐 Login Required</h3>
                <p>You need to be logged in to enroll in courses. Please log in or create an account to continue with your enrollment.</p>
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
        
    <?php } else { ?>
        // User is logged in, proceed to enrollment
        const enrollmentUrl = `enroll.php?course=${encodeURIComponent(courseName)}&price=${price}&duration=${encodeURIComponent(duration)}&lessons=${encodeURIComponent(lessons)}`;
        window.location.href = enrollmentUrl;
    <?php } ?>
}
</script>

<script src="js/script.js"></script>
<script src="js/courses.js"></script>
<script src="js/scroll-animations.js"></script>
</body>
</html>