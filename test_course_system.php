<?php
// Simple test to check if the course system is working
include 'config/database.php';

echo "<h2>🧪 Course System Test</h2>";

try {
    // Check if courses table exists and has data
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM courses");
    $result = $stmt->fetch();
    echo "<p>✅ Courses table found with " . $result['count'] . " courses</p>";

    // Show all courses
    $stmt = $pdo->query("SELECT * FROM courses ORDER BY created_at DESC");
    $courses = $stmt->fetchAll();
    
    echo "<h3>Current Courses:</h3>";
    echo "<ul>";
    foreach ($courses as $course) {
        echo "<li><strong>" . htmlspecialchars($course['title']) . "</strong> - $" . $course['price'] . " (" . $course['level'] . " - " . $course['status'] . ")</li>";
    }
    echo "</ul>";
    
    echo "<hr>";
    echo "<p>✅ Database connection successful</p>";
    echo "<p>✅ Course management system ready</p>";
    echo "<p><a href='courses.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔗 View Main Courses Page</a></p>";
    echo "<p><a href='admin.pannel/admin.php' style='background: #4a90e2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔗 View Admin Panel</a></p>";
    
} catch (PDOException $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
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
