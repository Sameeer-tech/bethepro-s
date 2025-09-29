// Quiz Categories Configuration
const quizCategories = [
  {
    key: 'data_analyst',
    title: 'Data Analyst',
    desc: 'Test your skills for Data Analyst interviews.',
    icon: '📊',
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
          { q: "Why should we hire you?", options: ["I am a quick learner and eager to grow", "I just need a job urgently", "I don't know, maybe luck", "I am not sure"], answer: 0 }
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
  }
];

// Global Variables
let currentQuiz = null;
let currentQ = 0;
let userAnswers = [];
let wrongAnswers = [];
let currentLevel = 'junior';

// Initialize Quiz Categories
function initializeQuizCategories() {
  const categoryCards = document.getElementById('categoryCards');
  quizCategories.forEach((cat, index) => {
    const col = document.createElement('div');
    col.className = 'col-lg-4 col-md-6 mb-4';
    col.innerHTML = `
      <div class="quiz-card animate-scale-in">
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
}

// Start Quiz Function
function startQuiz(key) {
  const cat = quizCategories.find(c => c.key === key);
  if (!cat) {
    console.error('Quiz category not found:', key);
    return;
  }
  
  // Get current level from select dropdown
  const levelSelect = document.getElementById('levelSelect');
  currentLevel = levelSelect ? levelSelect.value : 'junior';
  
  console.log('Starting quiz:', key, 'Level:', currentLevel);
  
  currentQuiz = cat.quiz[currentLevel];
  if (!currentQuiz) {
    console.error('Quiz data not found for level:', currentLevel);
    return;
  }
  
  currentQ = 0;
  userAnswers = [];
  wrongAnswers = [];
  
  // Show modal first
  const modal = document.getElementById('quizModal');
  modal.classList.remove('d-none');
  
  // Set title and clear previous content
  document.getElementById('quizTitle').textContent = currentQuiz.title;
  document.getElementById('quizResult').innerHTML = '';
  document.getElementById('quizQuestions').innerHTML = '';
  
  // Update level select to current level
  if (levelSelect) {
    levelSelect.value = currentLevel;
  }
  
  console.log('Quiz initialized, showing first question');
  showQuestion();
}

// Level Select Event Listener
function initializeLevelSelect() {
  const levelSelect = document.getElementById('levelSelect');
  if (!levelSelect) {
    console.error('Level select element not found');
    return;
  }
  
  levelSelect.addEventListener('change', function() {
    console.log('Level changed to:', this.value);
    
    if (currentQuiz) {
      const oldLevel = currentLevel;
      currentLevel = this.value;
      
      // Find the current category
      const currentCat = quizCategories.find(c => Object.keys(c.quiz).includes(oldLevel));
      if (currentCat && currentCat.quiz[currentLevel]) {
        currentQuiz = currentCat.quiz[currentLevel];
        currentQ = 0;
        userAnswers = [];
        wrongAnswers = [];
        
        document.getElementById('quizTitle').textContent = currentQuiz.title;
        document.getElementById('quizResult').innerHTML = '';
        
        console.log('Restarting quiz with new level');
        showQuestion();
      }
    }
  });
  
  console.log('Level select initialized');
}

// Show Question Function
function showQuestion() {
  console.log('showQuestion called, currentQ:', currentQ);
  console.log('currentQuiz:', currentQuiz);
  
  if (!currentQuiz || !currentQuiz.questions) {
    console.error('No quiz data available');
    return;
  }
  
  const q = currentQuiz.questions[currentQ];
  if (!q) {
    console.error('Question not found at index:', currentQ);
    return;
  }
  
  console.log('Showing question:', currentQ + 1, q.q);
  console.log('Question options:', q.options);
  
  // Update progress bar
  const progressElement = document.getElementById('quizProgress');
  if (progressElement) {
    const progressPercentage = ((currentQ + 1) / currentQuiz.questions.length) * 100;
    progressElement.innerHTML = `
      <div class='progress' style='height: 10px; background-color: #e9ecef; border-radius: 5px; overflow: hidden;'>
        <div class='progress-bar' role='progressbar' 
             style='width: ${progressPercentage}%; background: ${getCategoryColor()}; transition: width 0.3s ease;'>
        </div>
      </div>
    `;
  }
  
  // Update question content
  const questionsElement = document.getElementById('quizQuestions');
  if (questionsElement) {
    questionsElement.innerHTML = `
      <div class='mb-4'>
        <h5 class='mb-3'><strong>Question ${currentQ + 1} of ${currentQuiz.questions.length}</strong></h5>
        <p class='fs-6 mb-4'>${q.q}</p>
        <div id='options'></div>
      </div>
    `;
    
    // Add options with a small delay to ensure DOM is ready
    setTimeout(() => {
      const optionsDiv = document.getElementById('options');
      if (optionsDiv && q.options) {
        console.log('Adding options to DOM');
        optionsDiv.innerHTML = ''; // Clear existing options
        
        q.options.forEach((opt, idx) => {
          const btn = document.createElement('button');
          btn.className = 'btn btn-outline-primary option-btn w-100 mb-2';
          btn.style.padding = '12px 16px';
          btn.style.textAlign = 'left';
          btn.style.border = '2px solid #e9ecef';
          btn.style.borderRadius = '8px';
          btn.style.transition = 'all 0.3s ease';
          btn.textContent = opt;
          btn.onclick = () => selectOption(idx);
          
          // Add hover effect
          btn.onmouseover = function() {
            if (!this.classList.contains('active')) {
              this.style.borderColor = '#007bff';
              this.style.backgroundColor = '#f8f9fa';
            }
          };
          
          btn.onmouseout = function() {
            if (!this.classList.contains('active')) {
              this.style.borderColor = '#e9ecef';
              this.style.backgroundColor = '#fff';
            }
          };
          
          optionsDiv.appendChild(btn);
          console.log('Added option:', opt);
        });
      } else {
        console.error('Options div not found or no options available');
      }
    }, 50);
  }
  
  // Hide next/submit buttons initially
  const nextBtn = document.getElementById('nextBtn');
  const submitBtn = document.getElementById('submitBtn');
  if (nextBtn) nextBtn.classList.add('d-none');
  if (submitBtn) submitBtn.classList.add('d-none');
  
  console.log('Question display setup complete');
}

// Select Option Function
function selectOption(idx) {
  console.log('Option selected:', idx);
  userAnswers[currentQ] = idx;
  
  // Update button styles
  const optionButtons = document.getElementsByClassName('option-btn');
  Array.from(optionButtons).forEach((btn, i) => {
    if (i === idx) {
      // Selected button
      btn.classList.add('active');
      btn.style.backgroundColor = '#007bff';
      btn.style.borderColor = '#007bff';
      btn.style.color = '#fff';
    } else {
      // Unselected buttons
      btn.classList.remove('active');
      btn.style.backgroundColor = '#fff';
      btn.style.borderColor = '#e9ecef';
      btn.style.color = '#495057';
    }
  });
  
  // Show appropriate next/submit button
  const nextBtn = document.getElementById('nextBtn');
  const submitBtn = document.getElementById('submitBtn');
  
  if (currentQ < currentQuiz.questions.length - 1) {
    if (nextBtn) nextBtn.classList.remove('d-none');
    if (submitBtn) submitBtn.classList.add('d-none');
  } else {
    if (nextBtn) nextBtn.classList.add('d-none');
    if (submitBtn) submitBtn.classList.remove('d-none');
  }
  
  console.log('Option selection complete, answer recorded:', idx);
}

// Next Question Function
function nextQuestion() {
  currentQ++;
  showQuestion();
}

// Submit Quiz Function
function submitQuiz() {
  console.log('Submit quiz called');
  console.log('User answers:', userAnswers);
  console.log('Quiz questions:', currentQuiz.questions);
  
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
  
  console.log('Quiz completed - Score:', score, 'Total:', totalQuestions, 'Percentage:', percentage);
  
  let resultMessage = '';
  let resultColor = '';
  
  if (percentage >= 80) {
    resultMessage = 'Excellent! You have strong knowledge in this area.';
    resultColor = '#28a745';
  } else if (percentage >= 60) {
    resultMessage = 'Good job! You have decent knowledge, but there\'s room for improvement.';
    resultColor = '#ffc107';
  } else {
    resultMessage = 'Keep studying! You need to improve your knowledge in this area.';
    resultColor = '#dc3545';
  }

  // Create a simpler, more reliable result display
  let resultHtml = `
    <div style="background: white; padding: 30px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center;">
      <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px; color: ${resultColor};">
        ${score}/${totalQuestions}
      </div>
      <div style="font-size: 1.5rem; margin-bottom: 15px; color: ${resultColor};">
        ${percentage}%
      </div>
      <div style="font-size: 1.1rem; margin-bottom: 20px; color: #333;">
        ${resultMessage}
      </div>
      
      <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
        <button onclick="restartQuiz()" 
                style="background: #007bff; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-size: 1rem;">
          🔄 Retake Quiz
        </button>
        <button onclick="closeQuizModal()" 
                style="background: #6c757d; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-size: 1rem;">
          <i class="fas fa-book"></i> Choose Another Quiz
        </button>
      </div>
    </div>
  `;

  // Add wrong answers review section if there are mistakes
  if (wrongAnswers.length > 0) {
    resultHtml += `
      <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
        <h5 style="color: #dc3545; margin-bottom: 20px; font-size: 1.2rem;">
          <i class="fas fa-book"></i> Review Your Mistakes (${wrongAnswers.length})
        </h5>
        <div style="max-height: 400px; overflow-y: auto;">
          ${wrongAnswers.map(item => `
            <div style="border: 1px solid #e9ecef; border-radius: 8px; padding: 15px; margin-bottom: 15px; background: #f8f9fa;">
              <div style="font-weight: 600; color: #dc3545; margin-bottom: 10px;">
                <i class="fas fa-times-circle"></i> Question ${item.questionNumber}
              </div>
              <div style="margin-bottom: 15px; font-size: 1rem; color: #333;">
                ${item.question}
              </div>
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div style="padding: 10px; border-radius: 6px; background: #f8d7da; border-left: 4px solid #dc3545;">
                  <div style="font-weight: 600; color: #721c24; margin-bottom: 5px;">Your Answer:</div>
                  <div style="color: #721c24;">${item.userAnswer}</div>
                </div>
                <div style="padding: 10px; border-radius: 6px; background: #d4edda; border-left: 4px solid #28a745;">
                  <div style="font-weight: 600; color: #155724; margin-bottom: 5px;">Correct Answer:</div>
                  <div style="color: #155724;">${item.correctAnswer}</div>
                </div>
              </div>
            </div>
          `).join('')}
        </div>
      </div>
    `;
  } else {
    resultHtml += `
      <div style="background: linear-gradient(135deg, #28a745, #20c997); color: white; text-align: center; border-radius: 12px; padding: 30px; margin-bottom: 20px;">
        <h4 style="margin-bottom: 15px; color: white;">🎉 Perfect Score!</h4>
        <p style="margin: 0; font-size: 1.1rem;">You answered all questions correctly! Excellent work!</p>
      </div>
    `;
  }

  console.log('Displaying results...');
  
  // Clear question content and show results
  const questionsElement = document.getElementById('quizQuestions');
  const progressElement = document.getElementById('quizProgress');
  const nextBtn = document.getElementById('nextBtn');
  const submitBtn = document.getElementById('submitBtn');
  const resultContainer = document.getElementById('quizResult');
  
  if (questionsElement) questionsElement.innerHTML = '';
  if (progressElement) progressElement.innerHTML = '';
  if (nextBtn) nextBtn.classList.add('d-none');
  if (submitBtn) submitBtn.classList.add('d-none');
  
  if (resultContainer) {
    resultContainer.innerHTML = resultHtml;
    console.log('Results displayed successfully');
  } else {
    console.error('Result container not found');
  }
}

// Close Quiz Modal
function closeQuizModal() {
  console.log('Closing quiz modal...');
  const modal = document.getElementById('quizModal');
  if (modal) {
    modal.classList.add('d-none');
  }
  
  // Reset quiz state
  currentQ = 0;
  userAnswers = [];
  wrongAnswers = [];
  currentQuiz = null;
  
  // Clear all content
  const elements = ['quizQuestions', 'quizProgress', 'quizResult', 'quizTitle'];
  elements.forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.innerHTML = '';
    }
  });
  
  // Hide buttons
  const buttons = ['nextBtn', 'submitBtn'];
  buttons.forEach(id => {
    const btn = document.getElementById(id);
    if (btn) {
      btn.classList.add('d-none');
    }
  });
}

// Hide Wrong Answers
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

// Show Wrong Answers
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

// Restart Quiz
function restartQuiz() {
  console.log('Restarting quiz...');
  currentQ = 0;
  userAnswers = [];
  wrongAnswers = [];
  
  // Clear results
  const resultContainer = document.getElementById('quizResult');
  if (resultContainer) {
    resultContainer.innerHTML = '';
  }
  
  // Show first question
  showQuestion();
}

// Toggle Mistake (for expandable mistake items)
function toggleMistake(index) {
  const content = document.getElementById(`mistake-content-${index}`);
  const arrow = document.getElementById(`arrow-${index}`);
  
  if (content && arrow) {
    if (content.style.display === 'none' || content.style.display === '') {
      content.style.display = 'block';
      arrow.style.transform = 'rotate(180deg)';
    } else {
      content.style.display = 'none';
      arrow.style.transform = 'rotate(0deg)';
    }
  }
}

// Get Category Color
function getCategoryColor() {
  // Find the category that has the current level in its quiz object
  let categoryColor = '#667eea'; // default color
  
  for (const cat of quizCategories) {
    if (cat.quiz && cat.quiz[currentLevel]) {
      categoryColor = cat.color;
      break;
    }
  }
  
  return categoryColor;
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM loaded, initializing quiz...');
  
  // Check if required elements exist
  const categoryCards = document.getElementById('categoryCards');
  const levelSelect = document.getElementById('levelSelect');
  const quizModal = document.getElementById('quizModal');
  
  if (!categoryCards) {
    console.error('categoryCards element not found');
    return;
  }
  
  if (!levelSelect) {
    console.error('levelSelect element not found');
    return;
  }
  
  if (!quizModal) {
    console.error('quizModal element not found');
    return;
  }
  
  console.log('All required elements found, initializing...');
  
  // Initialize quiz categories
  initializeQuizCategories();
  
  // Initialize level select
  initializeLevelSelect();
  
  console.log('Quiz initialization complete');
});
