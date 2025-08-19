<?php
// Loader
include '../assets/loader.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BeThePros Quiz Categories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #667eea;
      --secondary-color: #764ba2;
      --white: #fff;
      --card-radius: 14px;
      --transition: all 0.3s ease;
      --footer-bg: #22234b;
      --footer-text: #fff;
      --gray-medium: #bfc2d1;
    }
    body { background: #f8f9fa; }
    
    /* Banner Styles */
    .quiz-banner {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      color: white;
      padding: 80px 0;
      margin-top: 80px;
      position: relative;
      overflow: hidden;
    }
    .quiz-banner::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><path d="M0,0v46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1099.07,31.83,1200,52.32V0z"/></svg>') repeat-x;
      background-size: 1000px 100px;
    }
    .quiz-banner h1 {
      font-size: 3.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .quiz-banner p {
      font-size: 1.2rem;
      opacity: 0.9;
      margin-bottom: 2rem;
    }
    .quiz-stats {
      display: flex;
      justify-content: center;
      gap: 40px;
      margin-top: 40px;
    }
    .quiz-stat {
      text-align: center;
    }
    .quiz-stat-number {
      font-size: 2.5rem;
      font-weight: 700;
      display: block;
    }
    .quiz-stat-label {
      font-size: 0.9rem;
      opacity: 0.8;
    }
    
    /* Card Styles */
    .quiz-card { 
      box-shadow: 0 4px 12px rgba(0,0,0,0.08); 
      border-radius: var(--card-radius); 
      transition: var(--transition); 
      background: #fff; 
      border: none;
      overflow: hidden;
      height: 100%;
    }
    .quiz-card:hover { 
      transform: translateY(-8px); 
      box-shadow: 0 8px 25px rgba(0,0,0,0.15); 
    }
    .quiz-card-header {
      height: 100px;
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 2.5rem;
      margin-bottom: 0;
    }
    .quiz-card-body {
      padding: 24px;
      display: flex;
      flex-direction: column;
      height: calc(100% - 100px);
    }
    .quiz-card-title {
      font-size: 1.4rem;
      font-weight: 600;
      margin-bottom: 12px;
      color: #333;
    }
    .quiz-card-desc {
      color: #666;
      font-size: 0.95rem;
      line-height: 1.5;
      flex-grow: 1;
      margin-bottom: 20px;
    }
    .quiz-card-btn {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      border: none;
      color: white;
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: 500;
      transition: var(--transition);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-size: 0.9rem;
    }
    .quiz-card-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
      color: white;
    }
    
    .quiz-modal { background: rgba(0,0,0,0.5); position: fixed; top:0; left:0; width:100vw; height:100vh; display:flex; align-items:center; justify-content:center; z-index:9999; }
    .quiz-modal-content { background: #fff; border-radius: 16px; padding: 32px; max-width: 500px; width: 100%; box-shadow: 0 8px 32px rgba(0,0,0,0.18); position: relative; }
    .progress { height: 8px; border-radius: 4px; }
    .option-btn { margin-bottom: 8px; }
    .result { font-size: 1.2rem; font-weight: 600; margin-top: 16px; }
    .close-btn { 
      position: absolute; 
      top: 15px; 
      right: 20px; 
      font-size: 2rem; 
      background: none; 
      border: none; 
      color: #666; 
      cursor: pointer; 
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }
    .close-btn:hover { 
      background: #f5f5f5; 
      color: #333; 
    }
    .level-select { margin-bottom: 24px; }
    footer { background: var(--footer-bg) !important; color: var(--footer-text) !important; margin-top: 40px; }
    .footer-section ul li a { color: var(--gray-medium) !important; }
    .footer-section ul li a:hover { color: var(--white) !important; }
    
    /* Wrong Answers Review Section Styles */
    .wrong-answers-review {
      position: relative;
      margin-top: 25px;
      border: 2px solid #e9ecef;
      border-radius: 16px;
      background: #f8f9fa;
      overflow: hidden;
    }
    .wrong-answers-header {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      padding: 16px 20px;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .wrong-answers-title {
      margin: 0;
      font-size: 1.1rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .wrong-answers-close {
      background: rgba(255,255,255,0.2);
      border: 1px solid rgba(255,255,255,0.3);
      color: white;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 18px;
      font-weight: bold;
      transition: all 0.3s ease;
    }
    .wrong-answers-close:hover {
      background: rgba(255,255,255,0.3);
      border-color: rgba(255,255,255,0.5);
      transform: scale(1.1);
    }
    .wrong-answers-content {
      max-height: 400px;
      overflow-y: auto;
      padding: 20px;
    }
    .wrong-answers-content::-webkit-scrollbar {
      width: 6px;
    }
    .wrong-answers-content::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 3px;
    }
    .wrong-answers-content::-webkit-scrollbar-thumb {
      background: #c1c1c1;
      border-radius: 3px;
    }
    .wrong-answers-content::-webkit-scrollbar-thumb:hover {
      background: #a8a8a8;
    }
    .wrong-answer-card {
      background: white;
      border: 1px solid #dee2e6;
      border-radius: 12px;
      padding: 18px;
      margin-bottom: 16px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      transition: all 0.3s ease;
    }
    .wrong-answer-card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transform: translateY(-2px);
    }
    .wrong-answer-card:last-child {
      margin-bottom: 0;
    }
    .question-number {
      color: var(--primary-color);
      font-weight: 700;
      font-size: 0.9rem;
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .question-text {
      color: #333;
      font-weight: 600;
      margin-bottom: 14px;
      font-size: 0.95rem;
      line-height: 1.4;
    }
    .answer-comparison {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .user-answer, .correct-answer {
      padding: 12px 14px;
      border-radius: 8px;
      font-size: 0.9rem;
    }
    .user-answer {
      background: #f8d7da;
      border-left: 4px solid #dc3545;
    }
    .correct-answer {
      background: #d4edda;
      border-left: 4px solid #28a745;
    }
    .answer-text.incorrect {
      color: #721c24;
      font-weight: 500;
    }
    .answer-text.correct {
      color: #155724;
      font-weight: 500;
    }
    
    @media (max-width: 768px) {
      .quiz-banner h1 { font-size: 2.5rem; }
      .quiz-banner p { font-size: 1rem; }
      .quiz-stats { flex-direction: column; gap: 20px; }
      .quiz-stat-number { font-size: 2rem; }
    }
    @media (max-width: 576px) { 
      .quiz-modal-content { padding: 12px; } 
      .quiz-banner { padding: 60px 0; }
      .quiz-banner h1 { font-size: 2rem; }
      .wrong-answers-header {
        padding: 12px 16px;
        flex-direction: column;
        gap: 10px;
        text-align: center;
      }
      .wrong-answers-title {
        font-size: 1rem;
      }
      .wrong-answers-content {
        max-height: 300px;
        padding: 15px;
      }
      .wrong-answer-card {
        padding: 14px;
        margin-bottom: 12px;
      }
      .question-number {
        font-size: 0.8rem;
      }
      .question-text {
        font-size: 0.9rem;
        margin-bottom: 12px;
      }
      .answer-comparison {
        gap: 8px;
      }
      .user-answer, .correct-answer {
        padding: 10px 12px;
        font-size: 0.85rem;
      }
    }
  </style>
</head>
<body class="loading">
<?php include '../assets/header.php'; ?>

  <!-- Quiz Banner -->
  <section class="quiz-banner">
    <div class="container text-center">
      <h1>Test Your Skills</h1>
      <p>Challenge yourself with our comprehensive interview preparation quizzes</p>
      <div class="quiz-stats">
        <div class="quiz-stat">
          <span class="quiz-stat-number">6</span>
          <span class="quiz-stat-label">Categories</span>
        </div>
        <div class="quiz-stat">
          <span class="quiz-stat-number">180+</span>
          <span class="quiz-stat-label">Questions</span>
        </div>
        <div class="quiz-stat">
          <span class="quiz-stat-number">3</span>
          <span class="quiz-stat-label">Difficulty Levels</span>
        </div>
      </div>
    </div>
  </section>

  <div class="container py-5">
    <h2 class="text-center mb-5" style="color:var(--primary-color);font-weight:700;">Choose Your Quiz Category</h2>
    <div class="row" id="categoryCards"></div>
  </div>
  <!-- Quiz Modal -->
  <div id="quizModal" class="quiz-modal d-none">
    <div class="quiz-modal-content">
      <button class="close-btn" onclick="closeQuizModal()">&times;</button>
      <div class="level-select mb-3">
        <label for="levelSelect" class="form-label">Select Level:</label>
        <select id="levelSelect" class="form-select">
          <option value="junior">Junior</option>
          <option value="mid">Mid-level</option>
          <option value="senior">Senior</option>
        </select>
      </div>
      <div id="quizProgress" class="mb-3"></div>
      <h4 id="quizTitle"></h4>
      <div id="quizQuestions"></div>
      <button id="nextBtn" class="btn btn-primary w-100 mt-3 d-none" onclick="nextQuestion()">Next</button>
      <button id="submitBtn" class="btn btn-success w-100 mt-3 d-none" onclick="submitQuiz()">Submit Quiz</button>
      <div id="quizResult" class="result"></div>
    </div>
  </div>
<?php include '../assets/footer.php'; ?>
<script>
const quizCategories = [
  {
    key: 'data_analyst',
    title: 'Data Analyst',
    desc: 'Test your skills for Data Analyst interviews.',
    color: '#667eea',
    quiz: {
      junior: {
        title: 'Junior Data Analyst Quiz',
        questions: [
          { q: "Which tool is most commonly used by data analysts?", options: ["Excel", "Photoshop", "Illustrator", "Word"], answer: 0 },
          { q: "What does SQL stand for?", options: ["Simple Query Logic", "Structured Query Language", "System Query List", "Standard Query Language"], answer: 1 },
          { q: "Which chart best shows trends over time?", options: ["Line Chart", "Pie Chart", "Bar Chart", "Scatter Plot"], answer: 0 },
          { q: "Which database is open-source?", options: ["Oracle", "MySQL", "MS Access", "DB2"], answer: 1 },
          { q: "What is the file extension for Excel?", options: [".docx", ".xlsx", ".pptx", ".xlsm"], answer: 1 },
          { q: "Which of these is a data cleaning step?", options: ["Remove duplicates", "Add animations", "Resize images", "Add transitions"], answer: 0 },
          { q: "What does CSV stand for?", options: ["Comma Separated Values", "Central Storage View", "Calculated Sheet Version", "Columnar Storage Value"], answer: 0 },
          { q: "Which language is often used with databases?", options: ["Python", "C++", "SQL", "Java"], answer: 2 },
          { q: "Which Excel function counts numbers?", options: ["COUNT()", "SUM()", "LEN()", "AVERAGE()"], answer: 0 },
          { q: "Why should we hire you?", options: ["I am a quick learner and eager to grow", "I just need a job urgently", "I don’t know, maybe luck", "I am not sure"], answer: 0 }
        ]
      },
      mid: {
        title: 'Mid-level Data Analyst Quiz',
        questions: [
          { q: "Which function merges two tables in SQL?", options: ["JOIN", "MERGE", "UNION", "GROUP"], answer: 0 },
          { q: "Which visualization is best for distribution?", options: ["Histogram", "Pie Chart", "Line Chart", "Bar Chart"], answer: 0 },
          { q: "What is ETL?", options: ["Extract, Transform, Load", "Edit, Test, Launch", "Evaluate, Transfer, List", "Export, Tabulate, Link"], answer: 0 },
          { q: "Which is a Python library for data analysis?", options: ["NumPy", "React", "Laravel", "Spring"], answer: 0 },
          { q: "Which SQL clause filters results?", options: ["WHERE", "ORDER BY", "GROUP BY", "HAVING"], answer: 0 },
          { q: "What is a pivot table used for?", options: ["Summarizing data", "Drawing charts", "Writing code", "Sending emails"], answer: 0 },
          { q: "Which is a supervised ML algorithm?", options: ["Linear Regression", "K-Means", "Apriori", "PCA"], answer: 0 },
          { q: "Which file format is NOT for data?", options: [".csv", ".json", ".mp3", ".xlsx"], answer: 2 },
          { q: "What does API stand for?", options: ["Application Programming Interface", "Advanced Program Integration", "Applied Protocol Interface", "Automated Process Integration"], answer: 0 },
          { q: "What is data normalization?", options: ["Scaling data", "Encrypting data", "Deleting data", "Backing up data"], answer: 0 }
        ]
      },
      senior: {
        title: 'Senior Data Analyst Quiz',
        questions: [
          { q: "Which SQL command removes duplicates?", options: ["SELECT DISTINCT", "DELETE", "GROUP BY", "ORDER BY"], answer: 0 },
          { q: "Which is a time-series analysis technique?", options: ["ARIMA", "KNN", "SVM", "Naive Bayes"], answer: 0 },
          { q: "What is a data warehouse?", options: ["Central repository", "Spreadsheet", "Web server", "Mobile app"], answer: 0 },
          { q: "Which is a big data platform?", options: ["Hadoop", "WordPress", "Magento", "Joomla"], answer: 0 },
          { q: "Which is a cloud data service?", options: ["AWS Redshift", "Google Docs", "Dropbox", "Slack"], answer: 0 },
          { q: "What is data governance?", options: ["Managing data policies", "Writing code", "Designing UI", "Testing apps"], answer: 0 },
          { q: "Which is a NoSQL database?", options: ["MongoDB", "MySQL", "Oracle", "DB2"], answer: 0 },
          { q: "What is OLAP?", options: ["Online Analytical Processing", "Offline Application", "Open License API", "Object Linking"], answer: 0 },
          { q: "Which is a data visualization tool?", options: ["Tableau", "Word", "Excel", "PowerPoint"], answer: 0 },
          { q: "What is the main benefit of automation in analytics?", options: ["Efficiency", "Cost", "Design", "Marketing"], answer: 0 }
        ]
      }
    }
  },
  {
    key: 'web_developer',
    title: 'Web Developer',
    desc: 'Test your frontend and backend development skills for web developer positions.',
    icon: '💻',
    color: '#e67e22',
    quiz: {
      junior: {
        title: 'Junior Web Developer Quiz',
        questions: [
          { q: "Which language runs in a web browser?", options: ["Java", "C", "JavaScript", "Python"], answer: 2 },
          { q: "What does CSS stand for?", options: ["Cascading Style Sheets", "Computer Style Syntax", "Creative Style System", "Code Style Sheet"], answer: 0 },
          { q: "Which HTML tag is used for links?", options: ["<a>", "<link>", "<href>", "<url>"], answer: 0 },
          { q: "Which is a JavaScript framework?", options: ["Laravel", "React", "Django", "Flask"], answer: 1 },
          { q: "What does API stand for?", options: ["Application Programming Interface", "Advanced Program Integration", "Applied Protocol Interface", "Automated Process Integration"], answer: 0 },
          { q: "Which method is used to add elements to an array in JavaScript?", options: ["push()", "add()", "insert()", "append()"], answer: 0 },
          { q: "What is the correct way to declare a variable in JavaScript?", options: ["var name;", "variable name;", "v name;", "declare name;"], answer: 0 },
          { q: "Which CSS property is used to change text color?", options: ["color", "text-color", "font-color", "text-style"], answer: 0 },
          { q: "What does HTML stand for?", options: ["HyperText Markup Language", "High Tech Modern Language", "Home Tool Markup Language", "HyperText Modern Language"], answer: 0 },
          { q: "Which HTTP method is used to retrieve data?", options: ["GET", "POST", "PUT", "DELETE"], answer: 0 }
        ]
      },
      mid: {
        title: 'Mid-level Web Developer Quiz',
        questions: [
          { q: "What is the purpose of a CDN?", options: ["Content Delivery Network", "Code Development Network", "Central Data Network", "Custom Design Network"], answer: 0 },
          { q: "Which is a Node.js framework?", options: ["Express", "React", "Angular", "Vue"], answer: 0 },
          { q: "What is REST?", options: ["Representational State Transfer", "Real Estate Transfer", "Remote System Transfer", "Relational State Transfer"], answer: 0 },
          { q: "Which database is NoSQL?", options: ["MySQL", "MongoDB", "PostgreSQL", "SQLite"], answer: 1 },
          { q: "What is AJAX?", options: ["Asynchronous JavaScript and XML", "Advanced Java and XML", "Automated JavaScript and XML", "Applied Java and XML"], answer: 0 },
          { q: "Which is a CSS preprocessor?", options: ["SASS", "React", "Angular", "Vue"], answer: 0 },
          { q: "What is the purpose of webpack?", options: ["Module bundler", "Database", "Web server", "CSS framework"], answer: 0 },
          { q: "Which is a version control system?", options: ["Git", "NPM", "Docker", "Apache"], answer: 0 },
          { q: "What is MVC?", options: ["Model View Controller", "Multiple View Container", "Modern View Component", "Master View Control"], answer: 0 },
          { q: "Which is a testing framework for JavaScript?", options: ["Jest", "Laravel", "Django", "Spring"], answer: 0 }
        ]
      },
      senior: {
        title: 'Senior Web Developer Quiz',
        questions: [
          { q: "What is microservices architecture?", options: ["Small, independent services", "Large monolithic application", "Database design pattern", "Frontend framework"], answer: 0 },
          { q: "Which is a containerization tool?", options: ["Docker", "Git", "NPM", "Webpack"], answer: 0 },
          { q: "What is GraphQL?", options: ["Query language for APIs", "Database", "Frontend framework", "CSS preprocessor"], answer: 0 },
          { q: "Which pattern is used for scalable applications?", options: ["Load balancing", "Singleton", "Observer", "Factory"], answer: 0 },
          { q: "What is CI/CD?", options: ["Continuous Integration/Deployment", "Code Integration/Development", "Central Integration/Deployment", "Custom Integration/Development"], answer: 0 },
          { q: "Which is a cloud platform?", options: ["AWS", "Git", "NPM", "Docker"], answer: 0 },
          { q: "What is serverless computing?", options: ["Cloud-based execution", "No server needed", "Local hosting", "Database hosting"], answer: 0 },
          { q: "Which is a message queue system?", options: ["Redis", "MySQL", "MongoDB", "PostgreSQL"], answer: 0 },
          { q: "What is OAuth?", options: ["Authorization framework", "Database", "Frontend library", "CSS framework"], answer: 0 },
          { q: "Which is a performance monitoring tool?", options: ["New Relic", "Git", "NPM", "Docker"], answer: 0 }
        ]
      }
    }
  },
  {
    key: 'sales_marketing',
    title: 'Sales & Marketing',
    desc: 'Practice sales techniques, marketing strategies, and customer relationship skills.',
    icon: '📈',
    color: '#27ae60',
    quiz: {
      junior: {
        title: 'Junior Sales & Marketing Quiz',
        questions: [
          { q: "What is the first step in the sales process?", options: ["Closing", "Prospecting", "Negotiation", "Follow-up"], answer: 1 },
          { q: "Which is a sales technique?", options: ["SPIN Selling", "SEO", "Branding", "Analytics"], answer: 0 },
          { q: "What does CRM stand for?", options: ["Customer Relationship Management", "Creative Resource Marketing", "Client Review Meeting", "Central Resource Management"], answer: 0 },
          { q: "Which is a soft skill for sales?", options: ["Empathy", "Coding", "Design", "Mathematics"], answer: 0 },
          { q: "What is upselling?", options: ["Selling more expensive items", "Selling to new customers", "Selling online", "Selling in bulk"], answer: 0 },
          { q: "What does ROI stand for?", options: ["Return on Investment", "Rate of Interest", "Revenue of Income", "Result of Investment"], answer: 0 },
          { q: "Which is a marketing channel?", options: ["Social Media", "Database", "Server", "Code"], answer: 0 },
          { q: "What is a lead?", options: ["Potential customer", "Sales manager", "Product feature", "Marketing budget"], answer: 0 },
          { q: "Which is important in customer service?", options: ["Active listening", "Technical skills", "Programming", "Design"], answer: 0 },
          { q: "What is a sales funnel?", options: ["Customer journey stages", "Sales tool", "Marketing budget", "Product catalog"], answer: 0 }
        ]
      },
      mid: {
        title: 'Mid-level Sales & Marketing Quiz',
        questions: [
          { q: "What is A/B testing?", options: ["Comparing two versions", "Employee assessment", "Product testing", "Budget analysis"], answer: 0 },
          { q: "Which metric measures customer loyalty?", options: ["NPS", "ROI", "CTR", "CPM"], answer: 0 },
          { q: "What is content marketing?", options: ["Creating valuable content", "Direct selling", "Cold calling", "Price negotiation"], answer: 0 },
          { q: "Which is a digital marketing channel?", options: ["Email marketing", "Cold calling", "Door-to-door", "Print ads"], answer: 0 },
          { q: "What is SEO?", options: ["Search Engine Optimization", "Sales Execution Officer", "Social Engagement Optimization", "System Enhancement Operation"], answer: 0 },
          { q: "Which is a key sales metric?", options: ["Conversion rate", "Server uptime", "Code quality", "Design aesthetics"], answer: 0 },
          { q: "What is market segmentation?", options: ["Dividing target market", "Product pricing", "Sales training", "Customer service"], answer: 0 },
          { q: "Which tool is used for email marketing?", options: ["Mailchimp", "Photoshop", "Excel", "PowerPoint"], answer: 0 },
          { q: "What is customer lifetime value?", options: ["Total customer worth", "Daily sales", "Monthly revenue", "Annual profit"], answer: 0 },
          { q: "Which is a social media platform for B2B?", options: ["LinkedIn", "TikTok", "Instagram", "Snapchat"], answer: 0 }
        ]
      },
      senior: {
        title: 'Senior Sales & Marketing Quiz',
        questions: [
          { q: "What is marketing automation?", options: ["Automated marketing processes", "Manual campaigns", "Personal selling", "Direct mail"], answer: 0 },
          { q: "Which is a growth hacking technique?", options: ["Viral marketing", "Traditional advertising", "Cold calling", "Print media"], answer: 0 },
          { q: "What is omnichannel marketing?", options: ["Integrated customer experience", "Single channel focus", "Product-based approach", "Price-based strategy"], answer: 0 },
          { q: "Which metric measures marketing effectiveness?", options: ["ROAS", "CPU", "RAM", "Storage"], answer: 0 },
          { q: "What is predictive analytics in marketing?", options: ["Forecasting customer behavior", "Historical reporting", "Basic statistics", "Simple calculations"], answer: 0 },
          { q: "Which is a customer retention strategy?", options: ["Loyalty programs", "Price increases", "Product reduction", "Service limitation"], answer: 0 },
          { q: "What is account-based marketing?", options: ["Targeting specific accounts", "Mass marketing", "General advertising", "Broad campaigns"], answer: 0 },
          { q: "Which tool is used for marketing analytics?", options: ["Google Analytics", "Word", "PowerPoint", "Notepad"], answer: 0 },
          { q: "What is influencer marketing?", options: ["Partnering with influencers", "Direct sales", "Cold calling", "Email blasts"], answer: 0 },
          { q: "Which is a B2B sales strategy?", options: ["Solution selling", "Impulse buying", "Window shopping", "Bargain hunting"], answer: 0 }
        ]
      }
    }
  },
  {
    key: 'hr_recruitment',
    title: 'HR & Recruitment',
    desc: 'Test your knowledge of human resources, recruitment, and people management.',
    icon: '👥',
    color: '#9b59b6',
    quiz: {
      junior: {
        title: 'Junior HR & Recruitment Quiz',
        questions: [
          { q: "What does HR stand for?", options: ["Human Resources", "High Revenue", "Human Relations", "Hiring Representatives"], answer: 0 },
          { q: "Which is a recruitment method?", options: ["Job posting", "Product development", "Market research", "Financial analysis"], answer: 0 },
          { q: "What is onboarding?", options: ["New employee orientation", "Performance review", "Salary negotiation", "Exit interview"], answer: 0 },
          { q: "Which law protects against workplace discrimination?", options: ["Equal Employment Opportunity", "Labor Relations Act", "Safety Standards Act", "Minimum Wage Law"], answer: 0 },
          { q: "What is a job description?", options: ["Role requirements and duties", "Salary information", "Company history", "Office location"], answer: 0 },
          { q: "Which is an employee benefit?", options: ["Health insurance", "Job interview", "Performance review", "Training session"], answer: 0 },
          { q: "What is performance appraisal?", options: ["Employee evaluation", "Salary calculation", "Job posting", "Interview process"], answer: 0 },
          { q: "Which is important in recruitment?", options: ["Cultural fit", "Office decoration", "Parking space", "Coffee preferences"], answer: 0 },
          { q: "What is employee engagement?", options: ["Emotional commitment to work", "Salary satisfaction", "Office location", "Working hours"], answer: 0 },
          { q: "Which is a soft skill?", options: ["Communication", "Programming", "Accounting", "Engineering"], answer: 0 }
        ]
      },
      mid: {
        title: 'Mid-level HR & Recruitment Quiz',
        questions: [
          { q: "What is talent acquisition?", options: ["Strategic recruiting", "Basic hiring", "Job posting", "Resume screening"], answer: 0 },
          { q: "Which is a behavioral interview technique?", options: ["STAR method", "Technical testing", "Salary discussion", "Reference check"], answer: 0 },
          { q: "What is employer branding?", options: ["Company reputation as employer", "Product marketing", "Financial performance", "Office design"], answer: 0 },
          { q: "Which metric measures recruitment success?", options: ["Time to hire", "Office size", "Number of computers", "Coffee consumption"], answer: 0 },
          { q: "What is diversity and inclusion?", options: ["Equal opportunities for all", "Hiring only locals", "Age-based hiring", "Gender-specific roles"], answer: 0 },
          { q: "Which is a retention strategy?", options: ["Career development", "Salary cuts", "Longer hours", "Less benefits"], answer: 0 },
          { q: "What is competency-based interviewing?", options: ["Skills-focused assessment", "Personality test", "Background check", "Salary negotiation"], answer: 0 },
          { q: "Which tool is used for applicant tracking?", options: ["ATS software", "Excel", "Word", "PowerPoint"], answer: 0 },
          { q: "What is succession planning?", options: ["Preparing future leaders", "Laying off employees", "Cutting costs", "Reducing benefits"], answer: 0 },
          { q: "Which is important for employee satisfaction?", options: ["Work-life balance", "Longer commute", "More meetings", "Less flexibility"], answer: 0 }
        ]
      },
      senior: {
        title: 'Senior HR & Recruitment Quiz',
        questions: [
          { q: "What is strategic workforce planning?", options: ["Aligning talent with business goals", "Random hiring", "Cost cutting", "Downsizing"], answer: 0 },
          { q: "Which is a global HR challenge?", options: ["Cultural differences", "Local regulations only", "Single time zone", "Same language"], answer: 0 },
          { q: "What is change management?", options: ["Managing organizational transitions", "Keeping everything same", "Avoiding change", "Resisting updates"], answer: 0 },
          { q: "Which analytics help in HR decisions?", options: ["People analytics", "Financial only", "Technical only", "Sales only"], answer: 0 },
          { q: "What is total rewards strategy?", options: ["Comprehensive compensation package", "Salary only", "Benefits only", "Recognition only"], answer: 0 },
          { q: "Which is important for leadership development?", options: ["Mentoring programs", "Isolation", "Competition", "Secrecy"], answer: 0 },
          { q: "What is organizational development?", options: ["Improving organizational effectiveness", "Maintaining status quo", "Reducing efficiency", "Creating confusion"], answer: 0 },
          { q: "Which technology transforms HR?", options: ["AI and automation", "Fax machines", "Typewriters", "Paper files"], answer: 0 },
          { q: "What is employee experience design?", options: ["Creating positive journey", "Making work difficult", "Adding complexity", "Reducing support"], answer: 0 },
          { q: "Which is a future HR trend?", options: ["Remote work policies", "Office-only work", "No technology", "Manual processes"], answer: 0 }
        ]
      }
    }
  },
  {
    key: 'finance_accounting',
    title: 'Finance & Accounting',
    desc: 'Master financial concepts, accounting principles, and business analysis.',
    icon: '💰',
    color: '#34495e',
    quiz: {
      junior: {
        title: 'Junior Finance & Accounting Quiz',
        questions: [
          { q: "What is the accounting equation?", options: ["Assets = Liabilities + Equity", "Revenue = Expenses + Profit", "Cash = Sales - Costs", "Income = Assets - Debt"], answer: 0 },
          { q: "Which is a current asset?", options: ["Cash", "Building", "Equipment", "Land"], answer: 0 },
          { q: "What does ROI stand for?", options: ["Return on Investment", "Rate of Interest", "Revenue of Income", "Result of Investment"], answer: 0 },
          { q: "Which is a financial statement?", options: ["Balance Sheet", "Marketing Plan", "HR Policy", "IT Strategy"], answer: 0 },
          { q: "What is depreciation?", options: ["Asset value decrease", "Asset value increase", "Revenue increase", "Expense decrease"], answer: 0 },
          { q: "Which is a liability?", options: ["Accounts payable", "Cash", "Inventory", "Equipment"], answer: 0 },
          { q: "What is gross profit?", options: ["Revenue minus cost of goods sold", "Total revenue", "Net income", "Operating expenses"], answer: 0 },
          { q: "Which ratio measures liquidity?", options: ["Current ratio", "Debt ratio", "ROE", "P/E ratio"], answer: 0 },
          { q: "What is working capital?", options: ["Current assets minus current liabilities", "Total assets", "Total revenue", "Net income"], answer: 0 },
          { q: "Which is an operating expense?", options: ["Rent", "Equipment purchase", "Loan payment", "Dividend payment"], answer: 0 }
        ]
      },
      mid: {
        title: 'Mid-level Finance & Accounting Quiz',
        questions: [
          { q: "What is NPV?", options: ["Net Present Value", "Net Profit Value", "New Product Value", "Net Portfolio Value"], answer: 0 },
          { q: "Which is a valuation method?", options: ["DCF", "ABC", "XYZ", "DEF"], answer: 0 },
          { q: "What is EBITDA?", options: ["Earnings before interest, taxes, depreciation, amortization", "Economic business income total daily average", "Estimated business income tax deduction amount", "Expected business investment total debt analysis"], answer: 0 },
          { q: "Which is a capital budgeting technique?", options: ["IRR", "ROI", "ROE", "EPS"], answer: 0 },
          { q: "What is cost of capital?", options: ["Cost of financing", "Product cost", "Operating cost", "Marketing cost"], answer: 0 },
          { q: "Which is a credit analysis ratio?", options: ["Debt-to-equity", "Current ratio", "Gross margin", "Inventory turnover"], answer: 0 },
          { q: "What is variance analysis?", options: ["Comparing actual vs budget", "Market research", "Product development", "Customer analysis"], answer: 0 },
          { q: "Which is a cash flow statement section?", options: ["Operating activities", "Marketing activities", "HR activities", "IT activities"], answer: 0 },
          { q: "What is financial leverage?", options: ["Using debt to increase returns", "Reducing costs", "Increasing sales", "Improving quality"], answer: 0 },
          { q: "Which is important for budgeting?", options: ["Forecasting", "Guessing", "Hoping", "Assuming"], answer: 0 }
        ]
      },
      senior: {
        title: 'Senior Finance & Accounting Quiz',
        questions: [
          { q: "What is economic value added (EVA)?", options: ["Profit minus cost of capital", "Total revenue", "Gross profit", "Operating income"], answer: 0 },
          { q: "Which is a derivatives instrument?", options: ["Options", "Stocks", "Bonds", "Cash"], answer: 0 },
          { q: "What is transfer pricing?", options: ["Internal transaction pricing", "External sales pricing", "Market pricing", "Cost pricing"], answer: 0 },
          { q: "Which is a risk management technique?", options: ["Hedging", "Speculation", "Gambling", "Guessing"], answer: 0 },
          { q: "What is WACC?", options: ["Weighted Average Cost of Capital", "Working Assets Current Capital", "Weighted Annual Cash Cost", "Working Average Credit Capital"], answer: 0 },
          { q: "Which standard governs financial reporting?", options: ["IFRS", "ISO", "IEEE", "ANSI"], answer: 0 },
          { q: "What is financial modeling?", options: ["Mathematical representation of financial situation", "Art creation", "Music composition", "Story writing"], answer: 0 },
          { q: "Which is a merger valuation method?", options: ["Comparable company analysis", "Product comparison", "Service analysis", "Marketing research"], answer: 0 },
          { q: "What is regulatory capital?", options: ["Required capital for compliance", "Optional capital", "Marketing capital", "IT capital"], answer: 0 },
          { q: "Which is important for international finance?", options: ["Currency risk", "Local risk only", "No risk", "Single currency"], answer: 0 }
        ]
      }
    }
  },
  {
    key: 'project_management',
    title: 'Project Management',
    desc: 'Test your project planning, execution, and leadership skills.',
    icon: '📋',
    color: '#f39c12',
    quiz: {
      junior: {
        title: 'Junior Project Management Quiz',
        questions: [
          { q: "What is a project?", options: ["Temporary endeavor with specific goal", "Ongoing operation", "Daily routine", "Permanent activity"], answer: 0 },
          { q: "Which is a project constraint?", options: ["Time", "Weather", "Luck", "Mood"], answer: 0 },
          { q: "What is a milestone?", options: ["Significant project point", "Daily task", "Coffee break", "Meeting room"], answer: 0 },
          { q: "Which is a project phase?", options: ["Initiation", "Celebration", "Vacation", "Shopping"], answer: 0 },
          { q: "What is scope?", options: ["Work to be done", "Office size", "Team size", "Budget size"], answer: 0 },
          { q: "Which is a stakeholder?", options: ["Project sponsor", "Janitor", "Security guard", "Delivery person"], answer: 0 },
          { q: "What is a deliverable?", options: ["Project output", "Input data", "Meeting notes", "Coffee order"], answer: 0 },
          { q: "Which tool helps track progress?", options: ["Gantt chart", "Calendar", "Clock", "Thermometer"], answer: 0 },
          { q: "What is a work breakdown structure?", options: ["Task decomposition", "Building structure", "Organization chart", "Floor plan"], answer: 0 },
          { q: "Which is a communication method?", options: ["Status report", "Gossip", "Rumors", "Assumptions"], answer: 0 }
        ]
      },
      mid: {
        title: 'Mid-level Project Management Quiz',
        questions: [
          { q: "What is critical path?", options: ["Longest sequence of activities", "Shortest route", "Most expensive path", "Easiest way"], answer: 0 },
          { q: "Which is a risk response strategy?", options: ["Mitigation", "Ignorance", "Denial", "Avoidance"], answer: 0 },
          { q: "What is earned value management?", options: ["Progress measurement technique", "Salary calculation", "Performance review", "Budget allocation"], answer: 0 },
          { q: "Which is an agile methodology?", options: ["Scrum", "Waterfall", "Traditional", "Sequential"], answer: 0 },
          { q: "What is a change control process?", options: ["Managing project changes", "Changing office", "Changing team", "Changing mind"], answer: 0 },
          { q: "Which is a quality management tool?", options: ["Quality assurance", "Guessing", "Hoping", "Assuming"], answer: 0 },
          { q: "What is resource leveling?", options: ["Balancing resource allocation", "Making everyone equal", "Removing resources", "Adding resources"], answer: 0 },
          { q: "Which is a procurement process?", options: ["Vendor selection", "Team building", "Office decoration", "Coffee ordering"], answer: 0 },
          { q: "What is a project charter?", options: ["Project authorization document", "Team photo", "Office rules", "Lunch menu"], answer: 0 },
          { q: "Which helps manage stakeholders?", options: ["Stakeholder analysis", "Guessing interests", "Avoiding contact", "Random communication"], answer: 0 }
        ]
      },
      senior: {
        title: 'Senior Project Management Quiz',
        questions: [
          { q: "What is portfolio management?", options: ["Managing multiple projects", "Single project focus", "Personal investment", "File organization"], answer: 0 },
          { q: "Which is a strategic alignment tool?", options: ["Balanced scorecard", "Random selection", "Gut feeling", "Coin toss"], answer: 0 },
          { q: "What is organizational change management?", options: ["Managing transformation", "Keeping status quo", "Avoiding change", "Random changes"], answer: 0 },
          { q: "Which framework supports scaling agile?", options: ["SAFe", "Waterfall", "Traditional", "Sequential"], answer: 0 },
          { q: "What is value management?", options: ["Optimizing project value", "Cutting costs only", "Increasing time", "Reducing quality"], answer: 0 },
          { q: "Which is important for global projects?", options: ["Cultural awareness", "Single culture", "Ignorance", "Assumptions"], answer: 0 },
          { q: "What is program management?", options: ["Managing related projects", "Single project", "Random projects", "No projects"], answer: 0 },
          { q: "Which helps with complex stakeholders?", options: ["Stakeholder engagement strategy", "Avoiding stakeholders", "Random communication", "No communication"], answer: 0 },
          { q: "What is benefits realization?", options: ["Achieving expected benefits", "Hoping for best", "Ignoring outcomes", "Random results"], answer: 0 },
          { q: "Which is crucial for project success?", options: ["Leadership", "Luck", "Chance", "Magic"], answer: 0 }
        ]
      }
    }
  },
  // Add more categories here if needed
];
const categoryCards = document.getElementById('categoryCards');
quizCategories.forEach(cat => {
  const col = document.createElement('div');
  col.className = 'col-lg-4 col-md-6 mb-4';
  col.innerHTML = `
    <div class="quiz-card">
      <div class="quiz-card-header" style="background: linear-gradient(135deg, ${cat.color}, ${cat.color}dd);">
        ${cat.icon}
      </div>
      <div class="quiz-card-body">
        <h5 class="quiz-card-title">${cat.title}</h5>
        <p class="quiz-card-desc">${cat.desc}</p>
        <button class="quiz-card-btn w-100" onclick="startQuiz('${cat.key}')">Start Quiz</button>
      </div>
    </div>
  `;
  categoryCards.appendChild(col);
});
let currentQuiz = null;
let currentQ = 0;
let userAnswers = [];
let wrongAnswers = [];
let currentLevel = 'junior';
function startQuiz(key) {
  const cat = quizCategories.find(c => c.key === key);
  if (!cat) return;
  currentLevel = document.getElementById('levelSelect') ? document.getElementById('levelSelect').value : 'junior';
  currentQuiz = cat.quiz[currentLevel];
  currentQ = 0;
  userAnswers = [];
  wrongAnswers = [];
  document.getElementById('quizTitle').textContent = currentQuiz.title;
  document.getElementById('quizResult').textContent = '';
  document.getElementById('quizQuestions').innerHTML = '';
  document.getElementById('quizModal').classList.remove('d-none');
  document.getElementById('levelSelect').value = currentLevel;
  showQuestion();
}
document.getElementById('levelSelect').addEventListener('change', function() {
  if (currentQuiz) {
    currentLevel = this.value;
    const cat = quizCategories.find(c => c.quiz[currentLevel]);
    if (cat) {
      currentQuiz = cat.quiz[currentLevel];
      currentQ = 0;
      userAnswers = [];
      wrongAnswers = [];
      document.getElementById('quizTitle').textContent = currentQuiz.title;
      document.getElementById('quizResult').textContent = '';
      showQuestion();
    }
  }
});
function showQuestion() {
  const q = currentQuiz.questions[currentQ];
  if (!q) return;
  document.getElementById('quizProgress').innerHTML = `<div class='progress'><div class='progress-bar' role='progressbar' style='width:${((currentQ+1)/currentQuiz.questions.length)*100}%;background:${getCategoryColor()}'></div></div>`;
  document.getElementById('quizQuestions').innerHTML = `
    <div class='mb-3'><strong>Q${currentQ+1}:</strong> ${q.q}</div>
    <div id='options'></div>
  `;
  const optionsDiv = document.getElementById('options');
  q.options.forEach((opt, idx) => {
    const btn = document.createElement('button');
    btn.className = 'btn btn-outline-primary option-btn w-100';
    btn.textContent = opt;
    btn.onclick = () => selectOption(idx);
    optionsDiv.appendChild(btn);
  });
  document.getElementById('nextBtn').classList.add('d-none');
  document.getElementById('submitBtn').classList.add('d-none');
}
function selectOption(idx) {
  userAnswers[currentQ] = idx;
  Array.from(document.getElementsByClassName('option-btn')).forEach((btn, i) => {
    btn.classList.toggle('active', i === idx);
    btn.classList.toggle('btn-primary', i === idx);
    btn.classList.toggle('btn-outline-primary', i !== idx);
  });
  if (currentQ < currentQuiz.questions.length - 1) {
    document.getElementById('nextBtn').classList.remove('d-none');
  } else {
    document.getElementById('submitBtn').classList.remove('d-none');
  }
}
function nextQuestion() {
  currentQ++;
  showQuestion();
}
function submitQuiz() {
  let score = 0;
  wrongAnswers = []; // Reset wrong answers array
  
  currentQuiz.questions.forEach((q, i) => {
    if (userAnswers[i] === q.answer) {
      score++;
    } else {
      // Track wrong answers
      wrongAnswers.push({
        questionNumber: i + 1,
        question: q.q,
        userAnswer: q.options[userAnswers[i]] || 'No answer selected',
        correctAnswer: q.options[q.answer]
      });
    }
  });
  
  const totalQuestions = currentQuiz.questions.length;
  const percentage = Math.round((score / totalQuestions) * 100);
  
  let resultMessage = '';
  let resultClass = '';
  
  if (percentage >= 80) {
    resultMessage = 'Excellent! You have strong knowledge in this area.';
    resultClass = 'success';
  } else if (percentage >= 60) {
    resultMessage = 'Good job! You have decent knowledge, but there\'s room for improvement.';
    resultClass = 'warning';
  } else {
    resultMessage = 'Keep studying! You need to improve your knowledge in this area.';
    resultClass = 'danger';
  }

  // Create wrong answers review section
  let wrongAnswersHtml = '';
  if (wrongAnswers.length > 0) {
    wrongAnswersHtml = `
      <div class="wrong-answers-review" id="wrongAnswersReview">
        <div class="wrong-answers-header">
          <h5 class="wrong-answers-title">
            <i class="fas fa-lightbulb"></i>
            Review Your Mistakes (${wrongAnswers.length} incorrect)
          </h5>
          <button class="wrong-answers-close" onclick="hideWrongAnswers()" title="Close Review">×</button>
        </div>
        <div class="wrong-answers-content">
    `;
    
    wrongAnswers.forEach((item, index) => {
      wrongAnswersHtml += `
        <div class="wrong-answer-card">
          <div class="question-number">Question ${item.questionNumber}</div>
          <div class="question-text">${item.question}</div>
          <div class="answer-comparison">
            <div class="user-answer">
              <strong>Your Answer:</strong> 
              <span class="answer-text incorrect">${item.userAnswer}  </span>
            </div>
            <div class="correct-answer">
              <strong>Correct Answer:</strong> 
              <span class="answer-text correct">${item.correctAnswer}</span>
            </div>
          </div>
        </div>
      `;
    });
    
    wrongAnswersHtml += `
        </div>
      </div>
    `;
  }

  // Display results
  document.getElementById('quizQuestions').innerHTML = `
    <div style="text-align: center;">
      <h3 style="margin-bottom: 20px;">Quiz Completed!</h3>
      <div style="margin-bottom: 20px;">
        <h2 style="color: ${resultClass === 'success' ? '#28a745' : resultClass === 'warning' ? '#ffc107' : '#dc3545'};">
          ${score}/${totalQuestions} (${percentage}%)
        </h2>
      </div>
      <p style="color: ${resultClass === 'success' ? '#28a745' : resultClass === 'warning' ? '#856404' : '#721c24'}; font-size: 1.1rem; margin-bottom: 20px;">
        ${resultMessage}
      </p>
      
      ${wrongAnswersHtml}
      
      <div style="margin-top: 30px; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
        <button style="background: var(--primary-color); color: white; border: none; padding: 12px 24px; border-radius: 5px; cursor: pointer; font-size: 1rem;" onclick="restartQuiz()">Take Another Quiz</button>
        ${wrongAnswers.length > 0 ? '<button id="showReviewBtn" style="background: #17a2b8; color: white; border: none; padding: 12px 24px; border-radius: 5px; cursor: pointer; font-size: 1rem; display: none;" onclick="showWrongAnswers()">Show Review</button>' : ''}
        <button style="background: #6c757d; color: white; border: none; padding: 12px 24px; border-radius: 5px; cursor: pointer; font-size: 1rem;" onclick="closeQuizModal()">Back to Categories</button>
      </div>
    </div>
  `;
  
  document.getElementById('nextBtn').classList.add('d-none');
  document.getElementById('submitBtn').classList.add('d-none');
  document.getElementById('quizResult').textContent = '';
}
function closeQuizModal() {
  document.getElementById('quizModal').classList.add('d-none');
}

function restartQuiz() {
  currentQ = 0;
  userAnswers = [];
  wrongAnswers = [];
  document.getElementById('quizResult').textContent = '';
  showQuestion();
}

function hideWrongAnswers() {
  const reviewSection = document.getElementById('wrongAnswersReview');
  const showBtn = document.getElementById('showReviewBtn');
  
  if (reviewSection) {
    reviewSection.style.display = 'none';
  }
  if (showBtn) {
    showBtn.style.display = 'inline-block';
  }
}

function showWrongAnswers() {
  const reviewSection = document.getElementById('wrongAnswersReview');
  const showBtn = document.getElementById('showReviewBtn');
  
  if (reviewSection) {
    reviewSection.style.display = 'block';
  }
  if (showBtn) {
    showBtn.style.display = 'none';
  }
}

function getCategoryColor() {
  const cat = quizCategories.find(c => c.quiz[currentLevel]);
  return cat ? cat.color : '#667eea';
}
</script>
</body>
</html>

