<?php
include 'config/database.php';

try {
    // Create courses table
    $sql = "CREATE TABLE IF NOT EXISTS courses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(200) NOT NULL,
        description TEXT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        duration VARCHAR(50) NOT NULL,
        level ENUM('Beginner', 'Intermediate', 'Advanced') DEFAULT 'Beginner',
        features TEXT,
        image_url VARCHAR(255),
        status ENUM('Active', 'Inactive') DEFAULT 'Active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    
    // Check if courses already exist
    $checkStmt = $pdo->query("SELECT COUNT(*) FROM courses");
    $courseCount = $checkStmt->fetchColumn();
    
    if ($courseCount == 0) {
        // Insert sample courses
        $courses = [
            [
                'title' => 'Fresher Interview Mastery',
                'description' => 'Master the art of acing interviews as a fresh graduate. Learn essential skills, common questions, and confidence-building techniques.',
                'price' => 99.00,
                'duration' => '4 weeks',
                'level' => 'Beginner',
                'features' => 'Resume Building,Mock Interviews,Industry Insights,Confidence Building',
                'image_url' => 'img/course1.jpg',
                'status' => 'Active'
            ],
            [
                'title' => 'Mid-Career Advancement',
                'description' => 'Strategic approaches for professionals looking to advance their careers and land leadership positions.',
                'price' => 149.00,
                'duration' => '6 weeks',
                'level' => 'Intermediate',
                'features' => 'Leadership Skills,Strategic Thinking,Negotiation,Career Planning',
                'image_url' => 'img/course2.jpg',
                'status' => 'Active'
            ],
            [
                'title' => 'Executive Interview Prep',
                'description' => 'Master executive-level interviews and presentations with advanced strategies and insider knowledge.',
                'price' => 199.00,
                'duration' => '8 weeks',
                'level' => 'Advanced',
                'features' => 'Executive Presence,Board Presentations,Strategic Vision,C-Suite Communication',
                'image_url' => 'img/course3.jpg',
                'status' => 'Active'
            ],
            [
                'title' => 'Tech Interview Fundamentals',
                'description' => 'Comprehensive preparation for technical interviews in software development and IT roles.',
                'price' => 129.00,
                'duration' => '5 weeks',
                'level' => 'Intermediate',
                'features' => 'Coding Challenges,System Design,Technical Communication,Problem Solving',
                'image_url' => 'img/course4.jpg',
                'status' => 'Active'
            ],
            [
                'title' => 'Sales Interview Excellence',
                'description' => 'Master sales interviews with proven techniques, objection handling, and relationship building skills.',
                'price' => 119.00,
                'duration' => '4 weeks',
                'level' => 'Beginner',
                'features' => 'Sales Techniques,Objection Handling,Client Relations,Performance Metrics',
                'image_url' => 'img/course5.jpg',
                'status' => 'Active'
            ],
            [
                'title' => 'Remote Work Interview Skills',
                'description' => 'Navigate remote work interviews and showcase your ability to excel in distributed teams.',
                'price' => 89.00,
                'duration' => '3 weeks',
                'level' => 'Beginner',
                'features' => 'Remote Communication,Virtual Presence,Time Management,Digital Tools',
                'image_url' => 'img/course6.jpg',
                'status' => 'Active'
            ]
        ];
        
        $stmt = $pdo->prepare("INSERT INTO courses (title, description, price, duration, level, features, image_url, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        foreach ($courses as $course) {
            $stmt->execute([
                $course['title'],
                $course['description'],
                $course['price'],
                $course['duration'],
                $course['level'],
                $course['features'],
                $course['image_url'],
                $course['status']
            ]);
        }
        
        echo "<h2>✅ Courses Database Setup Complete!</h2>";
        echo "<p>✅ Courses table created successfully</p>";
        echo "<p>✅ " . count($courses) . " sample courses added</p>";
        
    } else {
        echo "<h2>✅ Courses Database Already Exists!</h2>";
        echo "<p>Found $courseCount courses in database</p>";
    }
    
    // Show current courses
    $stmt = $pdo->query("SELECT * FROM courses ORDER BY created_at DESC");
    $allCourses = $stmt->fetchAll();
    
    echo "<h3>Current Courses:</h3>";
    echo "<ul>";
    foreach ($allCourses as $course) {
        echo "<li><strong>" . htmlspecialchars($course['title']) . "</strong> - $" . $course['price'] . " (" . $course['status'] . ")</li>";
    }
    echo "</ul>";
    
    echo "<hr>";
    echo "<p><a href='courses.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔗 View Courses Page</a></p>";
    echo "<p><a href='admin.pannel/admin.php' style='background: #4a90e2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔗 View Admin Panel</a></p>";
    
} catch (PDOException $e) {
    echo "<h2>❌ Database Error:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>

<style>
body { 
    font-family: Arial, sans-serif; 
    max-width: 800px; 
    margin: 50px auto; 
    padding: 20px; 
    line-height: 1.6;
    background: #f8f9fa;
}
h2, h3 { color: #333; }
p { margin: 10px 0; }
a { margin: 5px; display: inline-block; }
ul { background: white; padding: 20px; border-radius: 5px; }
</style>
