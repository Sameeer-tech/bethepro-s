<?php  ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Preparation - BeThePros</title>
    <link rel="stylesheet" href="css/style.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="css/preparation.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="loading">
<?php
include "assets/loader.php";

include 'assets/header.php';
?>

<!-- Hero Banner Section -->
<section class="preparation-banner">
    <div class="banner-container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="banner-badge">
                    <i class="fas fa-star"></i>
                    <span>Professional Interview Preparation</span>
                </div>
                <h1 class="banner-title">
                    Master Your <span class="highlight">Interview Skills</span>
                    <br>Land Your Dream Job
                </h1>
                <p class="banner-description">
                    Comprehensive preparation resources, practice questions, and expert guidance 
                    to help you succeed in technical interviews across multiple domains.
                </p>
                <div class="banner-stats">
                    <div class="stat-item">
                        <div class="stat-number">1000+</div>
                        <div class="stat-label">Practice Questions</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">6</div>
                        <div class="stat-label">Career Domains</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">95%</div>
                        <div class="stat-label">Success Rate</div>
                    </div>
                </div>
                <div class="banner-cta">
                    <button class="btn-primary" onclick="document.querySelector('.preparation-sidebar').scrollIntoView({behavior: 'smooth'})">
                        <i class="fas fa-rocket"></i>
                        Start Preparing Now
                    </button>
                    <button class="btn-secondary" onclick="window.location.href='courses.php'">
                        <i class="fas fa-play-circle"></i>
                        View Courses
                    </button>
                </div>
            </div>
            <div class="banner-visual">
                <div class="visual-container">
                    <div class="floating-cards">
                        <div class="card card-1">
                            <i class="fas fa-chart-bar"></i>
                            <span>Data Analytics</span>
                        </div>
                        <div class="card card-2">
                            <i class="fas fa-code"></i>
                            <span>Web Development</span>
                        </div>
                        <div class="card card-3">
                            <i class="fas fa-chart-line"></i>
                            <span>Sales & Marketing</span>
                        </div>
                        <div class="card card-4">
                            <i class="fas fa-user-friends"></i>
                            <span>HR & Recruitment</span>
                        </div>
                        <div class="card card-5">
                            <i class="fas fa-calculator"></i>
                            <span>Finance</span>
                        </div>
                        <div class="card card-6">
                            <i class="fas fa-tasks"></i>
                            <span>Project Management</span>
                        </div>
                    </div>
                    <div class="central-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-background">
        <div class="bg-shape shape-1"></div>
        <div class="bg-shape shape-2"></div>
        <div class="bg-shape shape-3"></div>
    </div>
</section>

<!-- Main Preparation Content -->
<main class="preparation-main">
    <div class="container">
        <div class="preparation-container">
            <!-- Sidebar Container -->
            <div class="sidebar-container">
                <!-- Sidebar Navigation -->
                <aside class="preparation-sidebar">
                <div class="sidebar-header">
                    <h2><i class="fas fa-graduation-cap"></i> Interview Prep Hub</h2>
                    <p>Master your skills for career success</p>
                </div>
                
                <nav class="sidebar-nav">
                    <!-- Data Analyst Section -->
                    <div class="nav-category active" data-category="data-analyst">
                        <div class="category-header">
                            <i class="fas fa-chart-bar"></i>
                            <span>Data Analyst</span>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                        <div class="category-items">
                            <a href="#data-analyst-mcq" class="nav-item active" data-section="data-analyst-mcq">
                                <i class="fas fa-question-circle"></i>
                                <span>MCQ Preparation</span>
                            </a>
                            <a href="#data-analyst-sql" class="nav-item" data-section="data-analyst-sql">
                                <i class="fas fa-database"></i>
                                <span>SQL & Databases</span>
                            </a>
                            <a href="#data-analyst-tools" class="nav-item" data-section="data-analyst-tools">
                                <i class="fas fa-tools"></i>
                                <span>Analytics Tools</span>
                            </a>
                            <a href="#data-analyst-interview" class="nav-item" data-section="data-analyst-interview">
                                <i class="fas fa-user-tie"></i>
                                <span>Interview Guide</span>
                            </a>
                            <a href="#data-analyst-presentation" class="nav-item" data-section="data-analyst-presentation">
                                <i class="fas fa-presentation"></i>
                                <span>Presentation Skills</span>
                            </a>
                        </div>
                    </div>

                    <!-- Web Developer Section -->
                    <div class="nav-category" data-category="web-developer">
                        <div class="category-header">
                            <i class="fas fa-code"></i>
                            <span>Web Developer</span>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                        <div class="category-items">
                            <a href="#web-developer-mcq" class="nav-item" data-section="web-developer-mcq">
                                <i class="fas fa-question-circle"></i>
                                <span>MCQ Preparation</span>
                            </a>
                            <a href="#web-developer-frontend" class="nav-item" data-section="web-developer-frontend">
                                <i class="fab fa-html5"></i>
                                <span>Frontend Technologies</span>
                            </a>
                            <a href="#web-developer-backend" class="nav-item" data-section="web-developer-backend">
                                <i class="fas fa-server"></i>
                                <span>Backend Development</span>
                            </a>
                            <a href="#web-developer-frameworks" class="nav-item" data-section="web-developer-frameworks">
                                <i class="fab fa-react"></i>
                                <span>Frameworks & Libraries</span>
                            </a>
                            <a href="#web-developer-interview" class="nav-item" data-section="web-developer-interview">
                                <i class="fas fa-user-tie"></i>
                                <span>Technical Interviews</span>
                            </a>
                            <a href="#web-developer-presentation" class="nav-item" data-section="web-developer-presentation">
                                <i class="fas fa-presentation"></i>
                                <span>Portfolio Presentation</span>
                            </a>
                        </div>
                    </div>

                    <!-- Sales & Marketing Section -->
                    <div class="nav-category" data-category="sales-marketing">
                        <div class="category-header">
                            <i class="fas fa-chart-line"></i>
                            <span>Sales & Marketing</span>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                        <div class="category-items">
                            <a href="#sales-marketing-mcq" class="nav-item" data-section="sales-marketing-mcq">
                                <i class="fas fa-question-circle"></i>
                                <span>MCQ Preparation</span>
                            </a>
                            <a href="#sales-marketing-techniques" class="nav-item" data-section="sales-marketing-techniques">
                                <i class="fas fa-handshake"></i>
                                <span>Sales Techniques</span>
                            </a>
                            <a href="#sales-marketing-digital" class="nav-item" data-section="sales-marketing-digital">
                                <i class="fas fa-globe"></i>
                                <span>Digital Marketing</span>
                            </a>
                            <a href="#sales-marketing-crm" class="nav-item" data-section="sales-marketing-crm">
                                <i class="fas fa-users"></i>
                                <span>CRM & Analytics</span>
                            </a>
                            <a href="#sales-marketing-interview" class="nav-item" data-section="sales-marketing-interview">
                                <i class="fas fa-user-tie"></i>
                                <span>Sales Interviews</span>
                            </a>
                            <a href="#sales-marketing-presentation" class="nav-item" data-section="sales-marketing-presentation">
                                <i class="fas fa-presentation"></i>
                                <span>Sales Presentations</span>
                            </a>
                        </div>
                    </div>

                    <!-- HR & Recruitment Section -->
                    <div class="nav-category" data-category="hr-recruitment">
                        <div class="category-header">
                            <i class="fas fa-user-friends"></i>
                            <span>HR & Recruitment</span>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                        <div class="category-items">
                            <a href="#hr-recruitment-mcq" class="nav-item" data-section="hr-recruitment-mcq">
                                <i class="fas fa-question-circle"></i>
                                <span>MCQ Preparation</span>
                            </a>
                            <a href="#hr-recruitment-process" class="nav-item" data-section="hr-recruitment-process">
                                <i class="fas fa-clipboard-list"></i>
                                <span>Recruitment Process</span>
                            </a>
                            <a href="#hr-recruitment-behavioral" class="nav-item" data-section="hr-recruitment-behavioral">
                                <i class="fas fa-brain"></i>
                                <span>Behavioral Assessment</span>
                            </a>
                            <a href="#hr-recruitment-legal" class="nav-item" data-section="hr-recruitment-legal">
                                <i class="fas fa-gavel"></i>
                                <span>HR Laws & Compliance</span>
                            </a>
                            <a href="#hr-recruitment-interview" class="nav-item" data-section="hr-recruitment-interview">
                                <i class="fas fa-user-tie"></i>
                                <span>HR Interviews</span>
                            </a>
                            <a href="#hr-recruitment-presentation" class="nav-item" data-section="hr-recruitment-presentation">
                                <i class="fas fa-presentation"></i>
                                <span>HR Presentations</span>
                            </a>
                        </div>
                    </div>

                    <!-- Finance & Accounting Section -->
                    <div class="nav-category" data-category="finance-accounting">
                        <div class="category-header">
                            <i class="fas fa-calculator"></i>
                            <span>Finance & Accounting</span>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                        <div class="category-items">
                            <a href="#finance-accounting-mcq" class="nav-item" data-section="finance-accounting-mcq">
                                <i class="fas fa-question-circle"></i>
                                <span>MCQ Preparation</span>
                            </a>
                            <a href="#finance-accounting-principles" class="nav-item" data-section="finance-accounting-principles">
                                <i class="fas fa-book"></i>
                                <span>Accounting Principles</span>
                            </a>
                            <a href="#finance-accounting-analysis" class="nav-item" data-section="finance-accounting-analysis">
                                <i class="fas fa-chart-pie"></i>
                                <span>Financial Analysis</span>
                            </a>
                            <a href="#finance-accounting-software" class="nav-item" data-section="finance-accounting-software">
                                <i class="fas fa-laptop"></i>
                                <span>Accounting Software</span>
                            </a>
                            <a href="#finance-accounting-interview" class="nav-item" data-section="finance-accounting-interview">
                                <i class="fas fa-user-tie"></i>
                                <span>Finance Interviews</span>
                            </a>
                            <a href="#finance-accounting-presentation" class="nav-item" data-section="finance-accounting-presentation">
                                <i class="fas fa-presentation"></i>
                                <span>Financial Presentations</span>
                            </a>
                        </div>
                    </div>

                    <!-- Project Management Section -->
                    <div class="nav-category" data-category="project-management">
                        <div class="category-header">
                            <i class="fas fa-tasks"></i>
                            <span>Project Management</span>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                        <div class="category-items">
                            <a href="#project-management-mcq" class="nav-item" data-section="project-management-mcq">
                                <i class="fas fa-question-circle"></i>
                                <span>MCQ Preparation</span>
                            </a>
                            <a href="#project-management-methodologies" class="nav-item" data-section="project-management-methodologies">
                                <i class="fas fa-sitemap"></i>
                                <span>PM Methodologies</span>
                            </a>
                            <a href="#project-management-tools" class="nav-item" data-section="project-management-tools">
                                <i class="fas fa-tools"></i>
                                <span>PM Tools & Software</span>
                            </a>
                            <a href="#project-management-leadership" class="nav-item" data-section="project-management-leadership">
                                <i class="fas fa-users"></i>
                                <span>Leadership & Teams</span>
                            </a>
                            <a href="#project-management-interview" class="nav-item" data-section="project-management-interview">
                                <i class="fas fa-user-tie"></i>
                                <span>PM Interviews</span>
                            </a>
                            <a href="#project-management-presentation" class="nav-item" data-section="project-management-presentation">
                                <i class="fas fa-presentation"></i>
                                <span>Project Presentations</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </aside>

            <!-- Course Promotion Sidebar -->
            <aside class="course-promotion-sidebar">
                <div class="sidebar-header">
                    <h3><i class="fas fa-graduation-cap"></i> Take Your Preparation Further</h3>
                </div>
                <div class="sidebar-content">
                    <p>We also offer courses. If you want to prepare with live experience, you can purchase our courses to practice with real-time mock interviews and improve your preparation even further.</p>
                    <a href="courses.php" class="btn-courses">
                        <i class="fas fa-arrow-right"></i>
                        Explore Our Courses
                    </a>
                </div>
            </aside>

            <!-- Quiz Section Sidebar -->
            <aside class="quiz-section-sidebar">
                <div class="sidebar-header">
                    <h3><i class="fas fa-brain"></i> Test Your Knowledge</h3>
                </div>
                <div class="sidebar-content">
                    <p>Ready to put your preparation to the test? Take our comprehensive quizzes designed to simulate real interview scenarios. Get instant feedback, track your progress, and identify areas for improvement.</p>
                    <div class="quiz-features">
                        <div class="feature-item">
                            <i class="fas fa-clock"></i>
                            <span>Timed Practice Tests</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-chart-line"></i>
                            <span>Performance Analytics</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-trophy"></i>
                            <span>Skill Assessment</span>
                        </div>
                    </div>
                    <a href="quiz/main.php" class="btn-quiz">
                        <i class="fas fa-play"></i>
                        Start Quiz Now
                    </a>
                </div>
            </aside>
            </div>

            <!-- Main Content Area -->
            <section class="preparation-content">
                <!-- Data Analyst MCQ Preparation -->
                <div id="data-analyst-mcq" class="content-section active">
                    <div class="section-header">
                        <h1><i class="fas fa-chart-bar"></i> Data Analyst MCQ Preparation</h1>
                        <p>Master the fundamentals with comprehensive question preparation guides</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📝</div>
                                <h3>Junior Level Topics</h3>
                            </div>
                            <div class="card-content">
                                <h4>Key Areas to Study:</h4>
                                <ul>
                                    <li>Basic SQL queries and database concepts</li>
                                    <li>Excel functions and data manipulation</li>
                                    <li>Data visualization fundamentals</li>
                                    <li>Statistical measures (mean, median, mode)</li>
                                    <li>Data cleaning and preprocessing</li>
                                    <li>Chart types and their applications</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Tip:</strong> Practice basic SQL SELECT statements and Excel pivot tables daily.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">⚡</div>
                                <h3>Mid Level Topics</h3>
                            </div>
                            <div class="card-content">
                                <h4>Advanced Concepts:</h4>
                                <ul>
                                    <li>Complex SQL joins and subqueries</li>
                                    <li>Python/R for data analysis</li>
                                    <li>Statistical hypothesis testing</li>
                                    <li>Data warehouse concepts</li>
                                    <li>ETL processes and tools</li>
                                    <li>Business intelligence platforms</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Tip:</strong> Focus on understanding JOIN operations and data modeling concepts.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🚀</div>
                                <h3>Senior Level Topics</h3>
                            </div>
                            <div class="card-content">
                                <h4>Expert Level Skills:</h4>
                                <ul>
                                    <li>Advanced machine learning concepts</li>
                                    <li>Big data technologies (Hadoop, Spark)</li>
                                    <li>Data governance and quality</li>
                                    <li>Advanced statistical analysis</li>
                                    <li>Cloud data platforms</li>
                                    <li>Performance optimization</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Tip:</strong> Study real-world case studies and practice with large datasets.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Analyst Interview Preparation -->
                <div id="data-analyst-interview" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-user-tie"></i> Data Analyst Interview Guide</h1>
                        <p>Comprehensive preparation strategies for data analyst interviews</p>
                    </div>

                    <div class="interview-sections">
                        <div class="interview-card">
                            <h3><i class="fas fa-search"></i> Before the Interview</h3>
                            <div class="interview-content">
                                <h4>Research Phase:</h4>
                                <ul>
                                    <li>Study the company's data infrastructure and tools</li>
                                    <li>Understand their business model and key metrics</li>
                                    <li>Review recent company news and data initiatives</li>
                                    <li>Research the team structure and reporting hierarchy</li>
                                </ul>
                                
                                <h4>Technical Preparation:</h4>
                                <ul>
                                    <li>Practice SQL queries on sample datasets</li>
                                    <li>Refresh statistical concepts and formulas</li>
                                    <li>Prepare examples of your past data projects</li>
                                    <li>Practice explaining technical concepts simply</li>
                                </ul>
                            </div>
                        </div>

                        <div class="interview-card">
                            <h3><i class="fas fa-comments"></i> Common Interview Questions</h3>
                            <div class="interview-content">
                                <h4>Technical Questions:</h4>
                                <ul>
                                    <li>"How do you handle missing or inconsistent data?"</li>
                                    <li>"Explain the difference between correlation and causation"</li>
                                    <li>"What's your process for data validation?"</li>
                                    <li>"How do you determine which visualization to use?"</li>
                                </ul>
                                
                                <h4>Behavioral Questions:</h4>
                                <ul>
                                    <li>"Tell me about a challenging data project you worked on"</li>
                                    <li>"How do you communicate complex findings to non-technical stakeholders?"</li>
                                    <li>"Describe a time when your analysis led to a business decision"</li>
                                    <li>"How do you stay updated with data analysis trends?"</li>
                                </ul>
                            </div>
                        </div>

                        <div class="interview-card">
                            <h3><i class="fas fa-tools"></i> Technical Skills Assessment</h3>
                            <div class="interview-content">
                                <h4>SQL Proficiency:</h4>
                                <ul>
                                    <li>Writing complex queries with multiple joins</li>
                                    <li>Aggregate functions and window functions</li>
                                    <li>Data manipulation and transformation</li>
                                    <li>Query optimization techniques</li>
                                </ul>
                                
                                <h4>Analytical Tools:</h4>
                                <ul>
                                    <li>Excel/Google Sheets advanced functions</li>
                                    <li>Python (Pandas, NumPy) or R programming</li>
                                    <li>Visualization tools (Tableau, Power BI)</li>
                                    <li>Statistical analysis software</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Analyst Presentation Skills -->
                <div id="data-analyst-presentation" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-presentation"></i> Data Presentation Skills</h1>
                        <p>Learn to present data insights effectively to stakeholders</p>
                    </div>

                    <div class="presentation-guide">
                        <div class="presentation-card">
                            <h3><i class="fas fa-chart-line"></i> Data Storytelling</h3>
                            <div class="presentation-content">
                                <h4>Structure Your Story:</h4>
                                <ol>
                                    <li><strong>Context:</strong> Start with the business problem or question</li>
                                    <li><strong>Methodology:</strong> Explain your approach and data sources</li>
                                    <li><strong>Findings:</strong> Present key insights with supporting evidence</li>
                                    <li><strong>Recommendations:</strong> Provide actionable next steps</li>
                                    <li><strong>Impact:</strong> Show potential business value</li>
                                </ol>
                                
                                <h4>Best Practices:</h4>
                                <ul>
                                    <li>Use clear, jargon-free language</li>
                                    <li>Focus on insights, not just data</li>
                                    <li>Support conclusions with evidence</li>
                                    <li>Address potential limitations</li>
                                </ul>
                            </div>
                        </div>

                        <div class="presentation-card">
                            <h3><i class="fas fa-eye"></i> Visualization Guidelines</h3>
                            <div class="presentation-content">
                                <h4>Chart Selection:</h4>
                                <ul>
                                    <li><strong>Line Charts:</strong> Trends over time</li>
                                    <li><strong>Bar Charts:</strong> Comparisons between categories</li>
                                    <li><strong>Scatter Plots:</strong> Relationships between variables</li>
                                    <li><strong>Pie Charts:</strong> Parts of a whole (use sparingly)</li>
                                </ul>
                                
                                <h4>Design Principles:</h4>
                                <ul>
                                    <li>Keep it simple and focused</li>
                                    <li>Use consistent colors and fonts</li>
                                    <li>Label everything clearly</li>
                                    <li>Remove unnecessary elements</li>
                                    <li>Make data accessible to colorblind viewers</li>
                                </ul>
                            </div>
                        </div>

                        <div class="presentation-card">
                            <h3><i class="fas fa-users"></i> Audience Engagement</h3>
                            <div class="presentation-content">
                                <h4>Know Your Audience:</h4>
                                <ul>
                                    <li>Technical level and background</li>
                                    <li>Decision-making authority</li>
                                    <li>Time constraints and priorities</li>
                                    <li>Preferred communication style</li>
                                </ul>
                                
                                <h4>Engagement Techniques:</h4>
                                <ul>
                                    <li>Start with a compelling hook</li>
                                    <li>Use relatable examples and analogies</li>
                                    <li>Encourage questions and discussion</li>
                                    <li>Provide interactive elements when possible</li>
                                    <li>End with clear next steps</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Web Developer MCQ Preparation -->
                <div id="web-developer-mcq" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-code"></i> Web Developer MCQ Preparation</h1>
                        <p>Master web development concepts with structured study guides</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📝</div>
                                <h3>Junior Level Topics</h3>
                            </div>
                            <div class="card-content">
                                <h4>Frontend Fundamentals:</h4>
                                <ul>
                                    <li>HTML5 semantic elements and structure</li>
                                    <li>CSS3 properties, selectors, and layouts</li>
                                    <li>JavaScript basics and DOM manipulation</li>
                                    <li>Responsive design principles</li>
                                    <li>Browser developer tools usage</li>
                                    <li>Basic Git version control</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Tip:</strong> Practice building small projects using only HTML, CSS, and vanilla JavaScript.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">⚡</div>
                                <h3>Mid Level Topics</h3>
                            </div>
                            <div class="card-content">
                                <h4>Framework & Tools:</h4>
                                <ul>
                                    <li>React, Vue.js, or Angular fundamentals</li>
                                    <li>Node.js and npm package management</li>
                                    <li>RESTful API integration</li>
                                    <li>Database basics (SQL/NoSQL)</li>
                                    <li>Build tools (Webpack, Vite)</li>
                                    <li>Testing frameworks and methodologies</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Tip:</strong> Focus on one framework deeply rather than learning multiple superficially.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🚀</div>
                                <h3>Senior Level Topics</h3>
                            </div>
                            <div class="card-content">
                                <h4>Advanced Concepts:</h4>
                                <ul>
                                    <li>System design and architecture</li>
                                    <li>Performance optimization</li>
                                    <li>Security best practices</li>
                                    <li>CI/CD pipelines and DevOps</li>
                                    <li>Microservices architecture</li>
                                    <li>Cloud platforms and deployment</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Tip:</strong> Study large-scale application architecture and scalability patterns.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Web Developer Interview Preparation -->
                <div id="web-developer-interview" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-user-tie"></i> Web Developer Interview Guide</h1>
                        <p>Comprehensive preparation for web development interviews</p>
                    </div>

                    <div class="interview-sections">
                        <div class="interview-card">
                            <h3><i class="fas fa-laptop-code"></i> Technical Preparation</h3>
                            <div class="interview-content">
                                <h4>Code Practice:</h4>
                                <ul>
                                    <li>Algorithm and data structure problems</li>
                                    <li>Live coding exercises and challenges</li>
                                    <li>Code review and refactoring scenarios</li>
                                    <li>System design questions</li>
                                </ul>
                                
                                <h4>Portfolio Preparation:</h4>
                                <ul>
                                    <li>Showcase your best projects with clean code</li>
                                    <li>Demonstrate different technologies and frameworks</li>
                                    <li>Include live demos and GitHub repositories</li>
                                    <li>Prepare to explain your design decisions</li>
                                </ul>
                            </div>
                        </div>

                        <div class="interview-card">
                            <h3><i class="fas fa-question"></i> Common Questions</h3>
                            <div class="interview-content">
                                <h4>Technical Questions:</h4>
                                <ul>
                                    <li>"Explain the difference between var, let, and const"</li>
                                    <li>"How do you optimize website performance?"</li>
                                    <li>"What is the Virtual DOM and how does it work?"</li>
                                    <li>"Describe your approach to responsive design"</li>
                                </ul>
                                
                                <h4>Problem-Solving:</h4>
                                <ul>
                                    <li>"How would you implement a search feature?"</li>
                                    <li>"Debug this piece of code"</li>
                                    <li>"Design a simple todo application"</li>
                                    <li>"Explain how you would handle user authentication"</li>
                                </ul>
                            </div>
                        </div>

                        <div class="interview-card">
                            <h3><i class="fas fa-cogs"></i> Technical Skills</h3>
                            <div class="interview-content">
                                <h4>Frontend Skills:</h4>
                                <ul>
                                    <li>Modern JavaScript (ES6+)</li>
                                    <li>CSS preprocessors and frameworks</li>
                                    <li>Component-based architecture</li>
                                    <li>State management (Redux, Vuex)</li>
                                </ul>
                                
                                <h4>Backend & Tools:</h4>
                                <ul>
                                    <li>Server-side programming (Node.js, PHP, Python)</li>
                                    <li>Database design and optimization</li>
                                    <li>API development and integration</li>
                                    <li>Version control and deployment</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Web Developer Presentation Skills -->
                <div id="web-developer-presentation" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-presentation"></i> Developer Presentation Skills</h1>
                        <p>Learn to present technical projects and solutions effectively</p>
                    </div>

                    <div class="presentation-guide">
                        <div class="presentation-card">
                            <h3><i class="fas fa-project-diagram"></i> Project Presentations</h3>
                            <div class="presentation-content">
                                <h4>Structure Your Presentation:</h4>
                                <ol>
                                    <li><strong>Problem:</strong> What challenge were you solving?</li>
                                    <li><strong>Solution:</strong> How did you approach it?</li>
                                    <li><strong>Technology:</strong> What tools and frameworks did you use?</li>
                                    <li><strong>Demo:</strong> Show the working application</li>
                                    <li><strong>Results:</strong> What was the impact or outcome?</li>
                                </ol>
                                
                                <h4>Demo Best Practices:</h4>
                                <ul>
                                    <li>Test your demo beforehand</li>
                                    <li>Have screenshots/videos as backup</li>
                                    <li>Focus on key features and functionality</li>
                                    <li>Explain your code architecture briefly</li>
                                </ul>
                            </div>
                        </div>

                        <div class="presentation-card">
                            <h3><i class="fas fa-code"></i> Code Reviews</h3>
                            <div class="presentation-content">
                                <h4>Presenting Your Code:</h4>
                                <ul>
                                    <li>Explain your thought process and approach</li>
                                    <li>Highlight key design patterns used</li>
                                    <li>Discuss performance considerations</li>
                                    <li>Address potential improvements</li>
                                </ul>
                                
                                <h4>Code Explanation Tips:</h4>
                                <ul>
                                    <li>Start with the high-level architecture</li>
                                    <li>Walk through the main flow step by step</li>
                                    <li>Explain complex algorithms or logic</li>
                                    <li>Be open to questions and suggestions</li>
                                </ul>
                            </div>
                        </div>

                        <div class="presentation-card">
                            <h3><i class="fas fa-chalkboard-teacher"></i> Technical Communication</h3>
                            <div class="presentation-content">
                                <h4>Audience Adaptation:</h4>
                                <ul>
                                    <li><strong>To Developers:</strong> Focus on technical details and architecture</li>
                                    <li><strong>To Managers:</strong> Emphasize business value and timelines</li>
                                    <li><strong>To Clients:</strong> Highlight features and user benefits</li>
                                    <li><strong>To Stakeholders:</strong> Show ROI and project success</li>
                                </ul>
                                
                                <h4>Communication Skills:</h4>
                                <ul>
                                    <li>Use clear, concise language</li>
                                    <li>Avoid excessive technical jargon</li>
                                    <li>Use visual aids and diagrams</li>
                                    <li>Encourage questions and feedback</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Analyst SQL & Databases -->
                <div id="data-analyst-sql" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-database"></i> SQL & Database Preparation</h1>
                        <p>Master database concepts and SQL queries for data analyst interviews</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">💾</div>
                                <h3>SQL Fundamentals</h3>
                            </div>
                            <div class="card-content">
                                <h4>Core SQL Concepts:</h4>
                                <ul>
                                    <li>SELECT, WHERE, ORDER BY clauses</li>
                                    <li>JOIN operations (INNER, LEFT, RIGHT, FULL)</li>
                                    <li>GROUP BY and aggregate functions</li>
                                    <li>Subqueries and CTEs</li>
                                    <li>Window functions and ranking</li>
                                    <li>Data types and constraints</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Practice Tip:</strong> Use platforms like HackerRank, LeetCode, or SQLBolt for hands-on practice.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🏗️</div>
                                <h3>Database Design</h3>
                            </div>
                            <div class="card-content">
                                <h4>Database Concepts:</h4>
                                <ul>
                                    <li>Normalization and denormalization</li>
                                    <li>Primary and foreign keys</li>
                                    <li>Indexing strategies</li>
                                    <li>ACID properties</li>
                                    <li>Database performance tuning</li>
                                    <li>Data warehousing concepts</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Study Focus:</strong> Understand when to use different database types (SQL vs NoSQL).
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Analyst Tools -->
                <div id="data-analyst-tools" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-tools"></i> Analytics Tools Mastery</h1>
                        <p>Essential tools every data analyst should know</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🐍</div>
                                <h3>Python for Data Analysis</h3>
                            </div>
                            <div class="card-content">
                                <h4>Key Libraries:</h4>
                                <ul>
                                    <li>Pandas for data manipulation</li>
                                    <li>NumPy for numerical computing</li>
                                    <li>Matplotlib & Seaborn for visualization</li>
                                    <li>Scikit-learn for machine learning</li>
                                    <li>Jupyter notebooks for analysis</li>
                                    <li>Beautiful Soup for web scraping</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Hands-on:</strong> Complete a portfolio project showing end-to-end data analysis.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📊</div>
                                <h3>Visualization Tools</h3>
                            </div>
                            <div class="card-content">
                                <h4>Popular Platforms:</h4>
                                <ul>
                                    <li>Tableau for interactive dashboards</li>
                                    <li>Power BI for business intelligence</li>
                                    <li>Excel for quick analysis and charts</li>
                                    <li>R and ggplot2 for statistical visualization</li>
                                    <li>Google Data Studio for reporting</li>
                                    <li>D3.js for custom web visualizations</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Portfolio Tip:</strong> Create dashboards that tell a story with your data.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Web Developer Frontend -->
                <div id="web-developer-frontend" class="content-section">
                    <div class="section-header">
                        <h1><i class="fab fa-html5"></i> Frontend Technologies</h1>
                        <p>Master the client-side technologies for modern web development</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🎨</div>
                                <h3>Core Technologies</h3>
                            </div>
                            <div class="card-content">
                                <h4>Fundamentals:</h4>
                                <ul>
                                    <li>HTML5 semantic elements and accessibility</li>
                                    <li>CSS3 Grid, Flexbox, and animations</li>
                                    <li>Responsive design and mobile-first approach</li>
                                    <li>JavaScript ES6+ features and DOM manipulation</li>
                                    <li>Browser APIs and Web standards</li>
                                    <li>Performance optimization techniques</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Practice:</strong> Build responsive layouts without frameworks first.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">⚡</div>
                                <h3>Modern Frontend</h3>
                            </div>
                            <div class="card-content">
                                <h4>Advanced Concepts:</h4>
                                <ul>
                                    <li>Progressive Web Apps (PWAs)</li>
                                    <li>Service Workers and offline functionality</li>
                                    <li>Module bundlers (Webpack, Vite)</li>
                                    <li>CSS preprocessors (Sass, Less)</li>
                                    <li>Browser development tools</li>
                                    <li>Cross-browser compatibility</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Study:</strong> Understand the browser rendering process and optimization.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Web Developer Backend -->
                <div id="web-developer-backend" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-server"></i> Backend Development</h1>
                        <p>Server-side technologies and architecture patterns</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🔧</div>
                                <h3>Server Technologies</h3>
                            </div>
                            <div class="card-content">
                                <h4>Backend Stack:</h4>
                                <ul>
                                    <li>Node.js and Express.js</li>
                                    <li>Python with Django or Flask</li>
                                    <li>PHP with Laravel or Symfony</li>
                                    <li>RESTful API design and implementation</li>
                                    <li>GraphQL query language</li>
                                    <li>Authentication and authorization</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Focus:</strong> Master one backend language deeply before exploring others.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">💾</div>
                                <h3>Database & Infrastructure</h3>
                            </div>
                            <div class="card-content">
                                <h4>Backend Systems:</h4>
                                <ul>
                                    <li>Relational databases (MySQL, PostgreSQL)</li>
                                    <li>NoSQL databases (MongoDB, Redis)</li>
                                    <li>ORM/ODM frameworks</li>
                                    <li>Caching strategies</li>
                                    <li>Message queues and background jobs</li>
                                    <li>Microservices architecture</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Practice:</strong> Build APIs with proper error handling and validation.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Web Developer Frameworks -->
                <div id="web-developer-frameworks" class="content-section">
                    <div class="section-header">
                        <h1><i class="fab fa-react"></i> Frameworks & Libraries</h1>
                        <p>Popular frameworks and their ecosystems</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">⚛️</div>
                                <h3>Frontend Frameworks</h3>
                            </div>
                            <div class="card-content">
                                <h4>Popular Choices:</h4>
                                <ul>
                                    <li>React with hooks and context</li>
                                    <li>Vue.js 3 with composition API</li>
                                    <li>Angular with TypeScript</li>
                                    <li>State management (Redux, Vuex, NgRx)</li>
                                    <li>Router libraries for SPA navigation</li>
                                    <li>Component libraries and design systems</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Choose Wisely:</strong> Pick one framework and become proficient before learning others.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🛠️</div>
                                <h3>Development Tools</h3>
                            </div>
                            <div class="card-content">
                                <h4>Essential Tools:</h4>
                                <ul>
                                    <li>Package managers (npm, yarn, pnpm)</li>
                                    <li>Build tools and bundlers</li>
                                    <li>Testing frameworks (Jest, Cypress)</li>
                                    <li>Linting and formatting (ESLint, Prettier)</li>
                                    <li>Version control with Git</li>
                                    <li>CI/CD pipelines</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Workflow:</strong> Set up a complete development environment with all tools.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales & Marketing MCQ -->
                <div id="sales-marketing-mcq" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-chart-line"></i> Sales & Marketing MCQ Preparation</h1>
                        <p>Master sales techniques and marketing strategies for interview success</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📈</div>
                                <h3>Junior Level Topics</h3>
                            </div>
                            <div class="card-content">
                                <h4>Core Sales Concepts:</h4>
                                <ul>
                                    <li>Sales process fundamentals (Prospecting to Closing)</li>
                                    <li>Customer Relationship Management (CRM) basics</li>
                                    <li>Basic sales techniques (SPIN Selling, consultative selling)</li>
                                    <li>Understanding ROI and key sales metrics</li>
                                    <li>Upselling and cross-selling strategies</li>
                                    <li>Lead generation and qualification</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Study Focus:</strong> Practice role-playing common sales scenarios and objection handling.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon"><i class="fas fa-bullseye"></i></div>
                                <h3>Marketing Fundamentals</h3>
                            </div>
                            <div class="card-content">
                                <h4>Essential Marketing:</h4>
                                <ul>
                                    <li>Marketing mix (4Ps: Product, Price, Place, Promotion)</li>
                                    <li>Digital marketing channels (Social Media, Email, SEO)</li>
                                    <li>Customer segmentation and targeting</li>
                                    <li>Marketing funnels and customer journey</li>
                                    <li>Content marketing strategies</li>
                                    <li>Basic analytics and performance measurement</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Practice:</strong> Create sample marketing campaigns for different target audiences.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales & Marketing Techniques -->
                <div id="sales-marketing-techniques" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-handshake"></i> Advanced Sales Techniques</h1>
                        <p>Professional selling strategies and relationship building</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🎤</div>
                                <h3>Consultative Selling</h3>
                            </div>
                            <div class="card-content">
                                <h4>Advanced Techniques:</h4>
                                <ul>
                                    <li>SPIN Selling methodology (Situation, Problem, Implication, Need-payoff)</li>
                                    <li>Solution selling approach</li>
                                    <li>Value-based selling strategies</li>
                                    <li>Account-based selling for B2B</li>
                                    <li>Social selling and LinkedIn strategies</li>
                                    <li>Challenger Sale methodology</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Key Skill:</strong> Master asking the right questions to uncover customer pain points.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🤝</div>
                                <h3>Relationship Building</h3>
                            </div>
                            <div class="card-content">
                                <h4>Customer Relationships:</h4>
                                <ul>
                                    <li>Building trust and rapport with prospects</li>
                                    <li>Active listening and empathy techniques</li>
                                    <li>Handling objections and negotiations</li>
                                    <li>Follow-up strategies and customer retention</li>
                                    <li>Referral programs and word-of-mouth marketing</li>
                                    <li>Customer success and account management</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Remember:</strong> Focus on solving customer problems rather than just selling products.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales & Marketing Digital -->
                <div id="sales-marketing-digital" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-globe"></i> Digital Marketing Mastery</h1>
                        <p>Modern digital marketing strategies and tools</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📱</div>
                                <h3>Digital Channels</h3>
                            </div>
                            <div class="card-content">
                                <h4>Key Platforms:</h4>
                                <ul>
                                    <li>Search Engine Optimization (SEO) and SEM</li>
                                    <li>Social Media Marketing (Facebook, Instagram, LinkedIn, TikTok)</li>
                                    <li>Email marketing automation and nurturing</li>
                                    <li>Content marketing and blogging strategies</li>
                                    <li>Pay-per-click (PPC) advertising</li>
                                    <li>Influencer marketing and partnerships</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Stay Updated:</strong> Digital marketing trends change rapidly - follow industry blogs and news.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📊</div>
                                <h3>Analytics & Measurement</h3>
                            </div>
                            <div class="card-content">
                                <h4>Performance Tracking:</h4>
                                <ul>
                                    <li>Google Analytics and tracking setup</li>
                                    <li>Key Performance Indicators (KPIs) for digital marketing</li>
                                    <li>A/B testing and conversion optimization</li>
                                    <li>Marketing attribution models</li>
                                    <li>ROI and ROAS measurement</li>
                                    <li>Customer acquisition cost (CAC) and lifetime value (LTV)</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Data-Driven:</strong> Always measure and optimize your marketing campaigns based on data.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales & Marketing CRM -->
                <div id="sales-marketing-crm" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-users"></i> CRM & Sales Analytics</h1>
                        <p>Customer relationship management and sales performance tracking</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">💼</div>
                                <h3>CRM Platforms</h3>
                            </div>
                            <div class="card-content">
                                <h4>Popular CRM Tools:</h4>
                                <ul>
                                    <li>Salesforce CRM features and customization</li>
                                    <li>HubSpot for inbound marketing and sales</li>
                                    <li>Pipedrive for sales pipeline management</li>
                                    <li>Zoho CRM for small to medium businesses</li>
                                    <li>Microsoft Dynamics 365 integration</li>
                                    <li>CRM data management and hygiene</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Hands-on:</strong> Get certified in at least one major CRM platform to boost your credentials.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📈</div>
                                <h3>Sales Analytics</h3>
                            </div>
                            <div class="card-content">
                                <h4>Key Metrics:</h4>
                                <ul>
                                    <li>Sales conversion rates and pipeline velocity</li>
                                    <li>Customer acquisition cost and lifetime value</li>
                                    <li>Sales forecasting and quota management</li>
                                    <li>Lead scoring and qualification metrics</li>
                                    <li>Sales team performance analytics</li>
                                    <li>Revenue attribution and source analysis</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Business Impact:</strong> Connect your sales activities to business outcomes and revenue.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales & Marketing Interview -->
                <div id="sales-marketing-interview" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-user-tie"></i> Sales & Marketing Interview Guide</h1>
                        <p>Ace your sales and marketing interviews with confidence</p>
                    </div>

                    <div class="interview-sections">
                        <div class="interview-card">
                            <h3><i class="fas fa-comments"></i> Common Sales Interview Questions</h3>
                            <div class="interview-content">
                                <h4>Behavioral Questions:</h4>
                                <ul>
                                    <li><strong>Tell me about a time you exceeded your sales target.</strong> - Use STAR method with specific numbers</li>
                                    <li><strong>How do you handle rejection?</strong> - Show resilience and learning mindset</li>
                                    <li><strong>Describe your sales process.</strong> - Walk through your methodology step by step</li>
                                    <li><strong>How do you qualify leads?</strong> - Demonstrate understanding of BANT or similar frameworks</li>
                                </ul>
                                
                                <h4>Scenario-Based Questions:</h4>
                                <ul>
                                    <li>How would you sell our product to a skeptical customer?</li>
                                    <li>What would you do if a client suddenly went silent?</li>
                                    <li>How would you handle a price objection?</li>
                                    <li>Describe how you'd research a new prospect</li>
                                </ul>
                            </div>
                        </div>

                        <div class="interview-card">
                            <h3><i class="fas fa-chart-bar"></i> Marketing Interview Preparation</h3>
                            <div class="interview-content">
                                <h4>Technical Marketing Questions:</h4>
                                <ul>
                                    <li><strong>How do you measure marketing ROI?</strong> - Discuss attribution models and KPIs</li>
                                    <li><strong>What's your experience with A/B testing?</strong> - Share specific examples</li>
                                    <li><strong>How do you develop buyer personas?</strong> - Explain research methods</li>
                                    <li><strong>Describe a successful campaign you've run.</strong> - Focus on results and learnings</li>
                                </ul>

                                <h4>Strategy Questions:</h4>
                                <ul>
                                    <li>How would you market our product to a new audience?</li>
                                    <li>What digital channels would you prioritize and why?</li>
                                    <li>How do you stay updated with marketing trends?</li>
                                    <li>What metrics would you track for this role?</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales & Marketing Presentation -->
                <div id="sales-marketing-presentation" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-presentation"></i> Sales Presentation Excellence</h1>
                        <p>Master the art of persuasive presentations and pitches</p>
                    </div>

                    <div class="presentation-guide">
                        <div class="presentation-card">
                            <h3><i class="fas fa-rocket"></i> Sales Pitch Structure</h3>
                            <div class="presentation-content">
                                <h4>The Perfect Sales Presentation:</h4>
                                <ol>
                                    <li><strong>Opening Hook</strong> - Grab attention with a relevant story or statistic</li>
                                    <li><strong>Problem Identification</strong> - Clearly define the customer's pain points</li>
                                    <li><strong>Solution Presentation</strong> - Show how your product solves their problems</li>
                                    <li><strong>Proof & Social Evidence</strong> - Share case studies and testimonials</li>
                                    <li><strong>Objection Handling</strong> - Address common concerns proactively</li>
                                    <li><strong>Clear Call to Action</strong> - Guide them to the next step</li>
                                </ol>

                                <h4>Presentation Best Practices:</h4>
                                <ul>
                                    <li>Keep slides visual and minimal text</li>
                                    <li>Use the 10-20-30 rule (10 slides, 20 minutes, 30pt font)</li>
                                    <li>Practice your transitions and timing</li>
                                    <li>Prepare for questions and interruptions</li>
                                    <li>Have backup slides for deep-dive topics</li>
                                </ul>
                            </div>
                        </div>

                        <div class="presentation-card">
                            <h3><i class="fas fa-users"></i> Audience Engagement</h3>
                            <div class="presentation-content">
                                <h4>Interactive Elements:</h4>
                                <ul>
                                    <li>Ask engaging questions throughout</li>
                                    <li>Use polls or quick surveys</li>
                                    <li>Include live demonstrations</li>
                                    <li>Share relevant anecdotes</li>
                                    <li>Encourage participation and feedback</li>
                                </ul>

                                <h4>Virtual Presentation Tips:</h4>
                                <ul>
                                    <li>Test technology beforehand</li>
                                    <li>Use breakout rooms for smaller discussions</li>
                                    <li>Share screen effectively</li>
                                    <li>Maintain eye contact with camera</li>
                                    <li>Use annotation tools for emphasis</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HR & Recruitment MCQ -->
                <div id="hr-recruitment-mcq" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-user-friends"></i> HR & Recruitment MCQ Preparation</h1>
                        <p>Key HR concepts and recruitment strategies for interview success</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">👥</div>
                                <h3>HR Fundamentals</h3>
                            </div>
                            <div class="card-content">
                                <h4>Core HR Topics:</h4>
                                <ul>
                                    <li>Human Resources principles and functions</li>
                                    <li>Recruitment methods and job posting strategies</li>
                                    <li>Employee onboarding and orientation processes</li>
                                    <li>Performance appraisal and evaluation techniques</li>
                                    <li>Employee benefits and compensation management</li>
                                    <li>Workplace diversity and inclusion initiatives</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Study Focus:</strong> Practice STAR method for behavioral interview questions and prepare HR case studies.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📋</div>
                                <h3>Recruitment & Talent Acquisition</h3>
                            </div>
                            <div class="card-content">
                                <h4>Key Recruitment Concepts:</h4>
                                <ul>
                                    <li>Talent acquisition vs traditional recruiting</li>
                                    <li>Behavioral and competency-based interviewing</li>
                                    <li>STAR method for structured interviews</li>
                                    <li>Employer branding and candidate experience</li>
                                    <li>ATS (Applicant Tracking Systems) usage</li>
                                    <li>Diversity recruiting and retention strategies</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Hands-on:</strong> Prepare examples of successful recruitment campaigns and cultural fit assessments.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HR & Recruitment Process -->
                <div id="hr-recruitment-process" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-clipboard-list"></i> Recruitment Process Mastery</h1>
                        <p>End-to-end recruitment and hiring best practices</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon"><i class="fas fa-bullseye"></i></div>
                                <h3>Recruitment Lifecycle</h3>
                            </div>
                            <div class="card-content">
                                <h4>Process Steps:</h4>
                                <ul>
                                    <li>Job analysis and requirements gathering</li>
                                    <li>Sourcing strategies (job boards, social media, networking)</li>
                                    <li>Screening and pre-qualification techniques</li>
                                    <li>Interview scheduling and coordination</li>
                                    <li>Reference checks and background verification</li>
                                    <li>Offer negotiation and onboarding preparation</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Metrics Focus:</strong> Track time-to-hire, cost-per-hire, and quality of hire metrics.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">⚖️</div>
                                <h3>Interview Techniques</h3>
                            </div>
                            <div class="card-content">
                                <h4>Assessment Methods:</h4>
                                <ul>
                                    <li>Structured vs unstructured interviews</li>
                                    <li>Panel interviews and group assessments</li>
                                    <li>Technical skills evaluation</li>
                                    <li>Cultural fit assessment tools</li>
                                    <li>Bias reduction in hiring decisions</li>
                                    <li>Candidate experience optimization</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Best Practice:</strong> Use standardized evaluation criteria for fair and consistent assessments.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HR & Recruitment Behavioral -->
                <div id="hr-recruitment-behavioral" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-brain"></i> Behavioral Assessment Techniques</h1>
                        <p>Advanced behavioral interviewing and assessment methods</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🎭</div>
                                <h3>Behavioral Interview Methods</h3>
                            </div>
                            <div class="card-content">
                                <h4>Assessment Techniques:</h4>
                                <ul>
                                    <li>STAR method implementation (Situation, Task, Action, Result)</li>
                                    <li>Competency-based questioning frameworks</li>
                                    <li>Situational judgment tests and scenarios</li>
                                    <li>Personality assessments and psychometric testing</li>
                                    <li>Team dynamics and collaboration evaluation</li>
                                    <li>Leadership potential identification</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Practice:</strong> Develop a bank of behavioral questions for different competencies and roles.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📊</div>
                                <h3>Assessment Tools</h3>
                            </div>
                            <div class="card-content">
                                <h4>Evaluation Methods:</h4>
                                <ul>
                                    <li>Behavioral rating scales and scorecards</li>
                                    <li>360-degree feedback processes</li>
                                    <li>Work sample tests and simulations</li>
                                    <li>Cognitive ability and aptitude tests</li>
                                    <li>Emotional intelligence assessments</li>
                                    <li>Values and culture fit evaluation</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Data-Driven:</strong> Use validated assessment tools and track their predictive accuracy.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HR & Recruitment Legal -->
                <div id="hr-recruitment-legal" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-gavel"></i> HR Laws & Compliance</h1>
                        <p>Essential employment law and compliance knowledge</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon"><i class="fas fa-book"></i></div>
                                <h3>Employment Laws</h3>
                            </div>
                            <div class="card-content">
                                <h4>Key Regulations:</h4>
                                <ul>
                                    <li>Equal Employment Opportunity (EEO) regulations</li>
                                    <li>Title VII and anti-discrimination laws</li>
                                    <li>ADA (Americans with Disabilities Act) compliance</li>
                                    <li>FMLA (Family and Medical Leave Act) policies</li>
                                    <li>Wage and hour laws (FLSA compliance)</li>
                                    <li>Workplace safety and OSHA requirements</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Stay Current:</strong> Employment laws change frequently - follow SHRM and legal updates.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🛡️</div>
                                <h3>Compliance & Risk Management</h3>
                            </div>
                            <div class="card-content">
                                <h4>Risk Areas:</h4>
                                <ul>
                                    <li>Harassment and discrimination prevention</li>
                                    <li>Proper documentation and record keeping</li>
                                    <li>Background check and reference verification</li>
                                    <li>Immigration and work authorization (I-9)</li>
                                    <li>Privacy and data protection (GDPR compliance)</li>
                                    <li>Termination and layoff procedures</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Documentation:</strong> Always maintain detailed records for compliance and legal protection.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HR & Recruitment Interview -->
                <div id="hr-recruitment-interview" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-user-tie"></i> HR Interview Guide</h1>
                        <p>Prepare for common HR and recruitment interview questions</p>
                    </div>
                    <div class="interview-sections">
                        <div class="interview-card">
                            <h3><i class="fas fa-comments"></i> Common HR Interview Questions</h3>
                            <div class="interview-content">
                                <ul>
                                    <li>Describe your experience with talent acquisition.</li>
                                    <li>How do you handle workplace conflict?</li>
                                    <li>What strategies do you use for employee retention?</li>
                                    <li>How do you ensure diversity and inclusion?</li>
                                    <li>Explain a successful onboarding process you managed.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="interview-card">
                            <h3><i class="fas fa-gavel"></i> HR Laws & Compliance</h3>
                            <div class="interview-content">
                                <ul>
                                    <li>Equal Employment Opportunity regulations</li>
                                    <li>Workplace safety and labor laws</li>
                                    <li>Handling discrimination and harassment cases</li>
                                    <li>Employee rights and benefits</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HR & Recruitment Presentation -->
                <div id="hr-recruitment-presentation" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-presentation"></i> HR Presentation Skills</h1>
                        <p>Tips for presenting HR strategies and recruitment plans</p>
                    </div>
                    <div class="presentation-guide">
                        <div class="presentation-card">
                            <h3><i class="fas fa-users"></i> Presenting HR Initiatives</h3>
                            <div class="presentation-content">
                                <ul>
                                    <li>Use data and metrics to support your proposals</li>
                                    <li>Share case studies and success stories</li>
                                    <li>Engage your audience with interactive elements</li>
                                    <li>Highlight the impact on employee satisfaction and retention</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Finance & Accounting MCQ -->
                <div id="finance-accounting-mcq" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-calculator"></i> Finance & Accounting MCQ Preparation</h1>
                        <p>Essential finance and accounting concepts for interviews</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">💰</div>
                                <h3>Finance Fundamentals</h3>
                            </div>
                            <div class="card-content">
                                <h4>Core Finance Topics:</h4>
                                <ul>
                                    <li>Financial statements (Balance Sheet, Income Statement, Cash Flow)</li>
                                    <li>Accounting principles (GAAP, IFRS)</li>
                                    <li>Budgeting, forecasting, and variance analysis</li>
                                    <li>Financial ratios and performance analysis</li>
                                    <li>Cost accounting and management accounting</li>
                                    <li>Investment analysis and capital budgeting</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Practice:</strong> Work through financial statement analysis and ratio calculations regularly.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📊</div>
                                <h3>Accounting Software & Tools</h3>
                            </div>
                            <div class="card-content">
                                <h4>Essential Tools:</h4>
                                <ul>
                                    <li>QuickBooks, Xero, SAP, Oracle Financials</li>
                                    <li>Advanced Excel skills (pivot tables, VLOOKUP, formulas)</li>
                                    <li>ERP systems and financial modules</li>
                                    <li>Financial modeling and analysis tools</li>
                                    <li>Tax preparation software</li>
                                    <li>Business intelligence and reporting tools</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Certification:</strong> Get certified in major accounting software to boost your credentials.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Finance & Accounting Principles -->
                <div id="finance-accounting-principles" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-book"></i> Accounting Principles & Standards</h1>
                        <p>Master fundamental accounting principles and reporting standards</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📋</div>
                                <h3>GAAP & IFRS</h3>
                            </div>
                            <div class="card-content">
                                <h4>Accounting Standards:</h4>
                                <ul>
                                    <li>Generally Accepted Accounting Principles (GAAP)</li>
                                    <li>International Financial Reporting Standards (IFRS)</li>
                                    <li>Revenue recognition principles</li>
                                    <li>Matching principle and accrual accounting</li>
                                    <li>Conservatism and materiality concepts</li>
                                    <li>Consistency and comparability requirements</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Understanding:</strong> Focus on practical applications of these principles in real business scenarios.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🔍</div>
                                <h3>Financial Statement Preparation</h3>
                            </div>
                            <div class="card-content">
                                <h4>Key Components:</h4>
                                <ul>
                                    <li>Balance sheet preparation and analysis</li>
                                    <li>Income statement and profit analysis</li>
                                    <li>Cash flow statement (operating, investing, financing)</li>
                                    <li>Statement of equity changes</li>
                                    <li>Notes to financial statements</li>
                                    <li>Monthly/quarterly closing procedures</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Practice:</strong> Work through complete financial statement preparation exercises.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Finance & Accounting Analysis -->
                <div id="finance-accounting-analysis" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-chart-pie"></i> Financial Analysis & Ratios</h1>
                        <p>Advanced financial analysis techniques and performance measurement</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📈</div>
                                <h3>Ratio Analysis</h3>
                            </div>
                            <div class="card-content">
                                <h4>Key Financial Ratios:</h4>
                                <ul>
                                    <li>Liquidity ratios (current, quick, cash ratio)</li>
                                    <li>Profitability ratios (ROE, ROA, gross margin, net margin)</li>
                                    <li>Efficiency ratios (inventory turnover, receivables turnover)</li>
                                    <li>Leverage ratios (debt-to-equity, interest coverage)</li>
                                    <li>Market value ratios (P/E, price-to-book)</li>
                                    <li>DuPont analysis and ROE decomposition</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Application:</strong> Practice calculating ratios and interpreting what they mean for business performance.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">💡</div>
                                <h3>Variance Analysis</h3>
                            </div>
                            <div class="card-content">
                                <h4>Performance Analysis:</h4>
                                <ul>
                                    <li>Budget vs actual variance analysis</li>
                                    <li>Price and volume variance calculations</li>
                                    <li>Labor efficiency and rate variances</li>
                                    <li>Material usage and price variances</li>
                                    <li>Overhead variance analysis</li>
                                    <li>Trend analysis and forecasting</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Business Impact:</strong> Connect variance analysis to actionable business insights and recommendations.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Finance & Accounting Software -->
                <div id="finance-accounting-software" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-laptop"></i> Accounting Software Mastery</h1>
                        <p>Essential software skills for modern finance professionals</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">💻</div>
                                <h3>Popular Accounting Platforms</h3>
                            </div>
                            <div class="card-content">
                                <h4>Enterprise Systems:</h4>
                                <ul>
                                    <li>SAP Financial Accounting and Controlling</li>
                                    <li>Oracle Financials and ERP Cloud</li>
                                    <li>Microsoft Dynamics 365 Finance</li>
                                    <li>NetSuite financial management</li>
                                    <li>Sage Intacct and Sage 50</li>
                                    <li>Workday Financial Management</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Hands-on:</strong> Get practical experience with at least one major ERP system.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📱</div>
                                <h3>Small Business Tools</h3>
                            </div>
                            <div class="card-content">
                                <h4>SMB Solutions:</h4>
                                <ul>
                                    <li>QuickBooks Online and Desktop</li>
                                    <li>Xero cloud accounting</li>
                                    <li>FreshBooks invoicing and time tracking</li>
                                    <li>Wave accounting for small businesses</li>
                                    <li>Zoho Books and financial suite</li>
                                    <li>Excel/Google Sheets financial modeling</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Versatility:</strong> Be comfortable with both cloud-based and desktop accounting solutions.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Finance & Accounting Interview -->
                <div id="finance-accounting-interview" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-handshake"></i> Finance & Accounting Interview Preparation</h1>
                        <p>Excel in finance and accounting job interviews</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🎯</div>
                                <h3>Technical Interview Questions</h3>
                            </div>
                            <div class="card-content">
                                <h4>Common Finance Questions:</h4>
                                <ul>
                                    <li>"Explain the three financial statements and their relationships"</li>
                                    <li>"Walk me through a DCF model"</li>
                                    <li>"How do you calculate working capital?"</li>
                                    <li>"What's the difference between cash and accrual accounting?"</li>
                                    <li>"Explain EBITDA and its limitations"</li>
                                    <li>"How would you value a company?"</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Strategy:</strong> Practice explaining complex financial concepts in simple terms.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🧮</div>
                                <h3>Accounting Case Studies</h3>
                            </div>
                            <div class="card-content">
                                <h4>Practical Scenarios:</h4>
                                <ul>
                                    <li>Journal entry creation for complex transactions</li>
                                    <li>Month-end closing procedures and timeline</li>
                                    <li>Resolving account reconciliation discrepancies</li>
                                    <li>Fixed asset depreciation calculations</li>
                                    <li>Revenue recognition for different business models</li>
                                    <li>Tax compliance and reporting requirements</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Preparation:</strong> Be ready to work through real accounting problems step-by-step.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon"><i class="fas fa-book"></i></div>
                                <h3>Behavioral Questions</h3>
                            </div>
                            <div class="card-content">
                                <h4>Finance-Specific Behavioral:</h4>
                                <ul>
                                    <li>"Describe a time you found a significant error in financial reports"</li>
                                    <li>"How do you handle tight month-end deadlines?"</li>
                                    <li>"Tell me about a time you improved a financial process"</li>
                                    <li>"How do you stay current with accounting standards?"</li>
                                    <li>"Describe your experience with financial audits"</li>
                                    <li>"How do you ensure accuracy in your work?"</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>STAR Method:</strong> Structure answers with specific situations, tasks, actions, and results.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🔍</div>
                                <h3>Industry Knowledge</h3>
                            </div>
                            <div class="card-content">
                                <h4>Current Trends:</h4>
                                <ul>
                                    <li>Digital transformation in finance and automation</li>
                                    <li>ESG reporting and sustainability accounting</li>
                                    <li>Data analytics and business intelligence</li>
                                    <li>Regulatory changes and compliance updates</li>
                                    <li>Cloud-based accounting solutions</li>
                                    <li>AI and machine learning in financial processes</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Stay Updated:</strong> Follow financial news and industry publications regularly.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Finance & Accounting Presentation -->
                <div id="finance-accounting-presentation" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-presentation"></i> Finance Presentation Mastery</h1>
                        <p>Professional presentation skills for financial data and business insights</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📊</div>
                                <h3>Financial Data Visualization</h3>
                            </div>
                            <div class="card-content">
                                <h4>Effective Chart Types:</h4>
                                <ul>
                                    <li>Line charts for trend analysis and time series data</li>
                                    <li>Bar charts for comparing categories and periods</li>
                                    <li>Pie charts for showing proportions (use sparingly)</li>
                                    <li>Waterfall charts for showing changes over time</li>
                                    <li>Heat maps for large datasets and correlations</li>
                                    <li>Dashboard design principles and KPI displays</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Best Practice:</strong> Choose chart types that best tell your data story and avoid clutter.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🎯</div>
                                <h3>Executive Reporting</h3>
                            </div>
                            <div class="card-content">
                                <h4>C-Suite Presentations:</h4>
                                <ul>
                                    <li>Lead with key insights and recommendations</li>
                                    <li>Use the "So what?" test for every slide</li>
                                    <li>Focus on business impact and strategic implications</li>
                                    <li>Present variance analysis with actionable insights</li>
                                    <li>Include forward-looking statements and projections</li>
                                    <li>Prepare for challenging questions and drill-downs</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Executive Tip:</strong> Start with conclusions, then provide supporting details when asked.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">💡</div>
                                <h3>Financial Storytelling</h3>
                            </div>
                            <div class="card-content">
                                <h4>Narrative Techniques:</h4>
                                <ul>
                                    <li>Build a logical flow from context to conclusion</li>
                                    <li>Use the "situation-complication-resolution" structure</li>
                                    <li>Connect financial metrics to business outcomes</li>
                                    <li>Highlight risks, opportunities, and recommendations</li>
                                    <li>Use analogies to explain complex financial concepts</li>
                                    <li>Include benchmarking and industry comparisons</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Storytelling:</strong> Make numbers meaningful by connecting them to business strategy.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🛠️</div>
                                <h3>Presentation Tools & Design</h3>
                            </div>
                            <div class="card-content">
                                <h4>Professional Tools:</h4>
                                <ul>
                                    <li>PowerPoint advanced features and templates</li>
                                    <li>Excel integration and live data connections</li>
                                    <li>Tableau and Power BI for interactive dashboards</li>
                                    <li>Financial modeling templates and best practices</li>
                                    <li>Professional color schemes and typography</li>
                                    <li>Animation and transition best practices</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Design Principle:</strong> Keep slides clean, professional, and focused on key messages.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Management MCQ -->
                <div id="project-management-mcq" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-tasks"></i> Project Management MCQ Preparation</h1>
                        <p>Essential project management concepts and methodologies for interviews</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📅</div>
                                <h3>PM Fundamentals</h3>
                            </div>
                            <div class="card-content">
                                <h4>Core Project Management:</h4>
                                <ul>
                                    <li>Project lifecycle (initiation, planning, execution, monitoring, closing)</li>
                                    <li>Scope, time, cost, quality management</li>
                                    <li>Project charter and stakeholder management</li>
                                    <li>Work breakdown structure (WBS) and scheduling</li>
                                    <li>Critical path method (CPM) and PERT</li>
                                    <li>Risk identification, assessment, and mitigation</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Practice:</strong> Work through project planning scenarios and timeline calculations.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🔄</div>
                                <h3>Agile & Scrum Methodologies</h3>
                            </div>
                            <div class="card-content">
                                <h4>Agile Frameworks:</h4>
                                <ul>
                                    <li>Scrum events (sprints, daily standups, retrospectives)</li>
                                    <li>Scrum roles (Product Owner, Scrum Master, Dev Team)</li>
                                    <li>User stories, epics, and acceptance criteria</li>
                                    <li>Sprint planning and estimation techniques</li>
                                    <li>Kanban boards and continuous improvement</li>
                                    <li>Scaled Agile Framework (SAFe) basics</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Certification:</strong> Consider PSM, CSM, or PMI-ACP certifications to validate your knowledge.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Management Methodologies -->
                <div id="project-management-methodologies" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-sitemap"></i> PM Methodologies & Frameworks</h1>
                        <p>Comprehensive overview of project management approaches</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🏗️</div>
                                <h3>Traditional Methodologies</h3>
                            </div>
                            <div class="card-content">
                                <h4>Waterfall & Hybrid:</h4>
                                <ul>
                                    <li>Waterfall project phases and gate reviews</li>
                                    <li>PRINCE2 methodology and processes</li>
                                    <li>PMI/PMBOK Guide knowledge areas</li>
                                    <li>Critical Chain Project Management (CCPM)</li>
                                    <li>Hybrid approaches combining traditional and agile</li>
                                    <li>Phase-gate and stage-gate processes</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Selection:</strong> Choose methodology based on project complexity, requirements stability, and team structure.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">⚡</div>
                                <h3>Lean & DevOps</h3>
                            </div>
                            <div class="card-content">
                                <h4>Modern Approaches:</h4>
                                <ul>
                                    <li>Lean startup and minimum viable product (MVP)</li>
                                    <li>DevOps culture and CI/CD pipelines</li>
                                    <li>Design thinking and human-centered design</li>
                                    <li>OKRs (Objectives and Key Results) framework</li>
                                    <li>Value stream mapping and flow optimization</li>
                                    <li>Continuous improvement and kaizen principles</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Integration:</strong> Learn how to integrate multiple methodologies for complex projects.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Management Tools -->
                <div id="project-management-tools" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-tools"></i> PM Tools & Software</h1>
                        <p>Master essential project management tools and platforms</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">💻</div>
                                <h3>Popular PM Software</h3>
                            </div>
                            <div class="card-content">
                                <h4>Enterprise Solutions:</h4>
                                <ul>
                                    <li>Microsoft Project and Project Online</li>
                                    <li>Jira and Atlassian suite (Confluence, Bitbucket)</li>
                                    <li>Asana, Monday.com, and Notion for team collaboration</li>
                                    <li>Smartsheet for enterprise project portfolios</li>
                                    <li>Slack, Teams, and communication platforms</li>
                                    <li>Gantt chart tools (GanttPRO, TeamGantt)</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Versatility:</strong> Be proficient in at least 2-3 major PM tools and adaptable to new platforms.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📊</div>
                                <h3>Analytics & Reporting</h3>
                            </div>
                            <div class="card-content">
                                <h4>Data-Driven PM:</h4>
                                <ul>
                                    <li>Project dashboards and KPI tracking</li>
                                    <li>Burndown charts and velocity metrics</li>
                                    <li>Resource utilization and capacity planning</li>
                                    <li>Earned value management (EVM) calculations</li>
                                    <li>Risk registers and mitigation tracking</li>
                                    <li>Stakeholder communication reports</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Insights:</strong> Focus on actionable metrics that drive project decisions and improvements.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Management Leadership -->
                <div id="project-management-leadership" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-users"></i> PM Leadership & Teams</h1>
                        <p>Leadership skills for successful project management</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🤝</div>
                                <h3>Team Leadership</h3>
                            </div>
                            <div class="card-content">
                                <h4>Leading Project Teams:</h4>
                                <ul>
                                    <li>Building high-performing teams and psychological safety</li>
                                    <li>Conflict resolution and negotiation skills</li>
                                    <li>Motivating team members and managing performance</li>
                                    <li>Cross-functional collaboration and matrix management</li>
                                    <li>Remote team management and virtual leadership</li>
                                    <li>Change management and stakeholder buy-in</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Soft Skills:</strong> Develop emotional intelligence and adaptive leadership styles.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🎯</div>
                                <h3>Stakeholder Management</h3>
                            </div>
                            <div class="card-content">
                                <h4>Managing Expectations:</h4>
                                <ul>
                                    <li>Stakeholder identification and analysis</li>
                                    <li>Communication planning and frequency</li>
                                    <li>Managing competing priorities and requirements</li>
                                    <li>Executive reporting and governance</li>
                                    <li>Customer relationship management</li>
                                    <li>Change control and scope management</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Communication:</strong> Tailor your communication style to different stakeholder groups.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        <div class="prep-card">
                            <div class="card-header"><div class="card-icon">🛠️</div><h3>PM Tools & Software</h3></div>
                            <div class="card-content">
                                <h4>Popular Tools:</h4>
                                <ul>
                                    <li>JIRA, Trello, Asana, MS Project</li>
                                    <li>Gantt charts and Kanban boards</li>
                                    <li>Resource allocation and scheduling</li>
                                </ul>
                                <div class="prep-tip"><strong>Tip:</strong> Get familiar with at least one major PM tool and its features.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Management Interview -->
                <div id="project-management-interview" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-handshake"></i> Project Management Interview Preparation</h1>
                        <p>Excel in project management job interviews with comprehensive preparation</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🎯</div>
                                <h3>Technical PM Questions</h3>
                            </div>
                            <div class="card-content">
                                <h4>Core PM Concepts:</h4>
                                <ul>
                                    <li>"Explain the difference between Agile and Waterfall methodologies"</li>
                                    <li>"How do you calculate earned value management metrics?"</li>
                                    <li>"Walk me through your project planning process"</li>
                                    <li>"How do you identify and manage project risks?"</li>
                                    <li>"Describe your approach to scope management"</li>
                                    <li>"How do you handle changing requirements?"</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Framework:</strong> Use structured approaches like PMBOK or Agile principles in your answers.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🤝</div>
                                <h3>Leadership & Team Management</h3>
                            </div>
                            <div class="card-content">
                                <h4>Behavioral Questions:</h4>
                                <ul>
                                    <li>"Describe a time you had to manage a difficult team member"</li>
                                    <li>"How do you motivate a team during challenging times?"</li>
                                    <li>"Tell me about a project that failed and what you learned"</li>
                                    <li>"How do you handle conflicts between team members?"</li>
                                    <li>"Describe your experience with remote team management"</li>
                                    <li>"How do you ensure team accountability and performance?"</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>STAR Method:</strong> Structure behavioral answers with Situation, Task, Action, and Result.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📊</div>
                                <h3>Stakeholder & Communication</h3>
                            </div>
                            <div class="card-content">
                                <h4>Stakeholder Management:</h4>
                                <ul>
                                    <li>"How do you manage competing stakeholder priorities?"</li>
                                    <li>"Describe your approach to executive reporting"</li>
                                    <li>"How do you handle scope creep from stakeholders?"</li>
                                    <li>"Tell me about a time you had to deliver bad news to stakeholders"</li>
                                    <li>"How do you ensure effective project communication?"</li>
                                    <li>"Describe your experience with change management"</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Communication:</strong> Emphasize your ability to adapt communication style to different audiences.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🔧</div>
                                <h3>Tools & Methodologies</h3>
                            </div>
                            <div class="card-content">
                                <h4>Technical Proficiency:</h4>
                                <ul>
                                    <li>"What project management tools do you prefer and why?"</li>
                                    <li>"How do you choose between different PM methodologies?"</li>
                                    <li>"Describe your experience with Jira, Microsoft Project, or Asana"</li>
                                    <li>"How do you track project progress and performance?"</li>
                                    <li>"What metrics do you use to measure project success?"</li>
                                    <li>"How do you handle resource allocation and capacity planning?"</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Practical Experience:</strong> Be prepared to discuss specific tools and provide concrete examples.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Management Presentation -->
                <div id="project-management-presentation" class="content-section">
                    <div class="section-header">
                        <h1><i class="fas fa-presentation"></i> Project Management Presentation Mastery</h1>
                        <p>Professional presentation skills for project managers</p>
                    </div>

                    <div class="prep-cards">
                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📋</div>
                                <h3>Project Planning Presentations</h3>
                            </div>
                            <div class="card-content">
                                <h4>Essential Elements:</h4>
                                <ul>
                                    <li>Clear project scope, objectives, and success criteria</li>
                                    <li>Visual timeline with milestones and dependencies</li>
                                    <li>Resource allocation and team structure</li>
                                    <li>Risk assessment and mitigation strategies</li>
                                    <li>Budget breakdown and financial projections</li>
                                    <li>Communication plan and stakeholder matrix</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Planning Tip:</strong> Use Gantt charts and visual roadmaps to make complex plans accessible.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">📊</div>
                                <h3>Status & Progress Reports</h3>
                            </div>
                            <div class="card-content">
                                <h4>Regular Reporting:</h4>
                                <ul>
                                    <li>Executive dashboards with key metrics and KPIs</li>
                                    <li>RAG (Red-Amber-Green) status indicators</li>
                                    <li>Burndown charts and velocity tracking</li>
                                    <li>Budget vs. actual spending analysis</li>
                                    <li>Risk register updates and issue tracking</li>
                                    <li>Next steps and upcoming milestones</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Executive Focus:</strong> Lead with insights and exceptions, not just data dumps.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🎯</div>
                                <h3>Stakeholder Communications</h3>
                            </div>
                            <div class="card-content">
                                <h4>Audience-Specific Presentations:</h4>
                                <ul>
                                    <li>Executive summaries focusing on business impact</li>
                                    <li>Technical deep-dives for development teams</li>
                                    <li>Client presentations with value propositions</li>
                                    <li>Team updates with actionable items</li>
                                    <li>Sponsor briefings with strategic alignment</li>
                                    <li>Post-project reviews and lessons learned</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Customization:</strong> Tailor content depth and technical detail to your audience.
                                </div>
                            </div>
                        </div>

                        <div class="prep-card">
                            <div class="card-header">
                                <div class="card-icon">🛠️</div>
                                <h3>PM Presentation Tools</h3>
                            </div>
                            <div class="card-content">
                                <h4>Professional Tools:</h4>
                                <ul>
                                    <li>Microsoft Project timeline exports and reports</li>
                                    <li>Jira dashboard screenshots and metrics</li>
                                    <li>PowerBI or Tableau for interactive dashboards</li>
                                    <li>Miro/Mural for collaborative workshops</li>
                                    <li>Lucidchart for process flows and org charts</li>
                                    <li>Teams/Zoom screen sharing and collaboration</li>
                                </ul>
                                <div class="prep-tip">
                                    <strong>Integration:</strong> Connect live data from PM tools to create dynamic presentations.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- End of new content sections -->
            </section>
        </div>
    </div>
</main>

<?php
include 'assets/stats.php';
include 'assets/footer.php';
?>

<script src="js/preparation.js"></script>
<script>
// Additional debugging
console.log('Preparation page loaded');
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - checking elements');
    console.log('Category headers found:', document.querySelectorAll('.category-header').length);
    console.log('Nav items found:', document.querySelectorAll('.nav-item').length);
    console.log('Categories found:', document.querySelectorAll('.nav-category').length);
});
</script>
</body>
</html>
