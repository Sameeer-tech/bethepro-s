<?php
// Database setup script for contact form functionality

$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect to MySQL server first
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create the database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS bethepros");
    $pdo->exec("USE bethepros");
    
    // Create the contact_messages table
    $sql = "CREATE TABLE IF NOT EXISTS contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL,
        phone VARCHAR(20),
        subject VARCHAR(200) NOT NULL,
        message TEXT NOT NULL,
        status ENUM('unread', 'read') DEFAULT 'unread',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    
    echo "<h2>Database Setup Complete!</h2>";
    echo "<p>✅ Database 'bethepros' created successfully</p>";
    echo "<p>✅ Table 'contact_messages' created successfully</p>";
    echo "<p><a href='contact.php'>Test Contact Form</a> | <a href='admin.pannel/admin.php'>View Admin Panel</a></p>";
    
} catch (PDOException $e) {
    echo "<h2>Database Setup Error:</h2>";
    echo "<p>❌ " . $e->getMessage() . "</p>";
    echo "<p>Please make sure XAMPP MySQL is running and check your database configuration.</p>";
}
?>
