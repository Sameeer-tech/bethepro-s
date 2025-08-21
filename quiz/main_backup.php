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
  <link rel="stylesheet" href="quiz.css">
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
<script src="quiz.js"></script>
</body>
</html>

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
  let resultColor = '';
  
  if (percentage >= 80) {
    resultMessage = 'Excellent! You have strong knowledge in this area.';
    resultClass = 'success';
    resultColor = '#28a745';
  } else if (percentage >= 60) {
    resultMessage = 'Good job! You have decent knowledge, but there\'s room for improvement.';
    resultClass = 'warning';
    resultColor = '#ffc107';
  } else {
    resultMessage = 'Keep studying! You need to improve your knowledge in this area.';
    resultClass = 'danger';
    resultColor = '#dc3545';
  }

  // Create the main result display
  let resultHtml = `
    <div class="quiz-result-header">
      <div class="score-display" style="color: ${resultColor};">
        ${score}/${totalQuestions}
      </div>
      <div class="score-percentage" style="color: ${resultColor};">
        ${percentage}%
      </div>
      <div class="score-message" style="color: ${resultColor === '#ffc107' ? '#856404' : resultColor === '#dc3545' ? '#721c24' : resultColor};">
        ${resultMessage}
      </div>
    </div>
  `;

  // Add wrong answers review section if there are mistakes
  if (wrongAnswers.length > 0) {
    resultHtml += `
      <div class="wrong-answers-review" id="wrongAnswersReview">
        <div class="review-header">
          <h5 class="review-title">
            📚 Review Your Mistakes (${wrongAnswers.length})
          </h5>
          <button class="review-close-btn" onclick="hideWrongAnswers()" title="Hide review">
            ×
          </button>
        </div>
        <div class="wrong-answers-container">
          ${wrongAnswers.map(item => `
            <div class="wrong-answer-card">
              <div class="question-number">
                ❌ Question ${item.questionNumber}
              </div>
              <div class="question-text">${item.question}</div>
              <div class="answer-comparison">
                <div class="user-answer">
                  <div class="answer-label">Your Answer:</div>
                  <div class="answer-text">${item.userAnswer}</div>
                </div>
                <div class="correct-answer">
                  <div class="answer-label">Correct Answer:</div>
                  <div class="answer-text">${item.correctAnswer}</div>
                </div>
              </div>
            </div>
          `).join('')}
        </div>
      </div>
    `;
  } else {
    resultHtml += `
      <div class="wrong-answers-review" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; text-align: center;">
        <div style="padding: 30px;">
          <h4 style="margin-bottom: 15px; color: white;">🎉 Perfect Score!</h4>
          <p style="margin: 0; font-size: 1.1rem;">You answered all questions correctly! Excellent work!</p>
        </div>
      </div>
    `;
  }

  // Add action buttons
  resultHtml += `
    <div style="text-align: center; margin-top: 30px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
      <button class="btn btn-primary me-3" onclick="restartQuiz()" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border: none; padding: 12px 24px; border-radius: 8px;">
        🔄 Retake Quiz
      </button>
      <button class="btn btn-outline-secondary" onclick="closeQuizModal()" style="padding: 12px 24px; border-radius: 8px;">
        📚 Choose Another Quiz
      </button>
      ${wrongAnswers.length > 0 ? `
        <button class="btn btn-outline-info" onclick="showWrongAnswers()" id="showReviewBtn" style="padding: 12px 24px; border-radius: 8px; margin-left: 10px; display: none;">
          👀 Show Review
        </button>
      ` : ''}
    </div>
  `;

  // Clear question content and show results
  document.getElementById('quizQuestions').innerHTML = '';
  document.getElementById('quizProgress').innerHTML = '';
  document.getElementById('nextBtn').classList.add('d-none');
  document.getElementById('submitBtn').classList.add('d-none');
  document.getElementById('quizResult').innerHTML = resultHtml;
}
function closeQuizModal() {
  document.getElementById('quizModal').classList.add('d-none');
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

function restartQuiz() {
  currentQ = 0;
  userAnswers = [];
  wrongAnswers = [];
  document.getElementById('quizResult').textContent = '';
  showQuestion();
}

function toggleMistake(index) {
  const content = document.getElementById(`mistake-content-${index}`);
  const arrow = document.getElementById(`arrow-${index}`);
  
  if (content.style.display === 'none' || content.style.display === '') {
    content.style.display = 'block';
    arrow.style.transform = 'rotate(180deg)';
  } else {
    content.style.display = 'none';
    arrow.style.transform = 'rotate(0deg)';
  }
}

function getCategoryColor() {
  const cat = quizCategories.find(c => c.quiz[currentLevel]);
  return cat ? cat.color : '#667eea';
}
</script>
</body>
</html>

