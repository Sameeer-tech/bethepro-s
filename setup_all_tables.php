
<?php
// Simple setup script for BeThePro's database and tables

// Use the same connection info as config/database.php
require_once __DIR__ . '/config/database.php';

// Get connection info from config/database.php
$host = isset($host) ? $host : 'localhost';
$user = isset($username) ? $username : 'root';
$pass = isset($password) ? $password : '';
$dbname = isset($dbname) ? $dbname : 'bethepros';

try {
    // Connect to MySQL (no database selected yet)
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbname`");

    // Now create all tables if they don't exist

    // Users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('User','Admin') DEFAULT 'User',
        status ENUM('Active','Inactive') DEFAULT 'Active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;");

    // Courses table
    $pdo->exec("CREATE TABLE IF NOT EXISTS courses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        duration VARCHAR(50) NOT NULL,
        level VARCHAR(50) NOT NULL,
        features TEXT NOT NULL,
        status ENUM('Active','Inactive') DEFAULT 'Active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;");

    // Enrollments table
    $pdo->exec("CREATE TABLE IF NOT EXISTS enrollments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        enrollment_id VARCHAR(20) UNIQUE NOT NULL,
        user_id INT NULL,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        country VARCHAR(100) NOT NULL,
        course_name VARCHAR(255) NULL,
        course_price DECIMAL(10,2) NULL,
        experience_level VARCHAR(50) NULL,
        schedule_preference VARCHAR(100) NULL,
        career_goals TEXT NULL,
        payment_method VARCHAR(50) NOT NULL,
        additional_services JSON NULL,
        newsletter_subscription BOOLEAN DEFAULT FALSE,
        enrollment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        status ENUM('pending', 'confirmed', 'rejected', 'active', 'completed', 'cancelled') DEFAULT 'pending',
        payment_status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    ) ENGINE=InnoDB;");

    // Contact messages table
    $pdo->exec("CREATE TABLE IF NOT EXISTS contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        status ENUM('unread','read') DEFAULT 'unread',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;");

    echo "<h2>✅ All tables created successfully!</h2>";
    echo "<a href='admin.pannel/admin.php'>Go to Admin Panel</a>";

} catch (PDOException $e) {
    echo "<h2>❌ Error: " . $e->getMessage() . "</h2>";
}
?>
