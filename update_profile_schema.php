<?php
// Database schema update script for profile enhancements
// Adds columns for tracking admin views on enrollments

require_once __DIR__ . '/config/database.php';

try {
    echo "<h2>🔧 Updating Database Schema for Profile Enhancements...</h2>";
    
    // Check if admin_viewed column exists in enrollments table
    $stmt = $pdo->query("SHOW COLUMNS FROM enrollments LIKE 'admin_viewed'");
    if (!$stmt->fetch()) {
        echo "<p>Adding admin_viewed column to enrollments table...</p>";
        $pdo->exec("ALTER TABLE enrollments ADD COLUMN admin_viewed BOOLEAN DEFAULT FALSE AFTER status");
        echo "<p>✅ Added admin_viewed column</p>";
    } else {
        echo "<p>✅ admin_viewed column already exists in enrollments table</p>";
    }
    
    // Check if profile_picture column exists in users table
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'profile_picture'");
    if (!$stmt->fetch()) {
        echo "<p>Adding profile_picture column to users table...</p>";
        $pdo->exec("ALTER TABLE users ADD COLUMN profile_picture VARCHAR(255) NULL AFTER password");
        echo "<p>✅ Added profile_picture column</p>";
    } else {
        echo "<p>✅ profile_picture column already exists in users table</p>";
    }
    
    // Check if user_id column exists in contact_messages table for linking messages to users
    $stmt = $pdo->query("SHOW COLUMNS FROM contact_messages LIKE 'user_id'");
    if (!$stmt->fetch()) {
        echo "<p>Adding user_id column to contact_messages table...</p>";
        $pdo->exec("ALTER TABLE contact_messages ADD COLUMN user_id INT NULL AFTER id");
        $pdo->exec("ALTER TABLE contact_messages ADD FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL");
        echo "<p>✅ Added user_id column to contact_messages</p>";
    } else {
        echo "<p>✅ user_id column already exists in contact_messages table</p>";
    }
    
    // Add missing indexes for better performance
    try {
        $pdo->exec("CREATE INDEX idx_enrollments_user_email ON enrollments(user_id, email)");
        echo "<p>✅ Added performance index on enrollments</p>";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false) {
            echo "<p>⚠️ Could not add index: " . $e->getMessage() . "</p>";
        } else {
            echo "<p>✅ Performance index already exists on enrollments</p>";
        }
    }
    
    try {
        $pdo->exec("CREATE INDEX idx_contact_messages_user_email ON contact_messages(user_id, email)");
        echo "<p>✅ Added performance index on contact_messages</p>";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false) {
            echo "<p>⚠️ Could not add index: " . $e->getMessage() . "</p>";
        } else {
            echo "<p>✅ Performance index already exists on contact_messages</p>";
        }
    }
    
    echo "<br><h3>🎉 Database schema updated successfully!</h3>";
    echo "<p>The profile page now supports:</p>";
    echo "<ul>";
    echo "<li>✅ Profile editing (name, email, password)</li>";
    echo "<li>✅ Admin view tracking for enrollments</li>";
    echo "<li>✅ Contact message history display</li>";
    echo "<li>✅ Enhanced user experience with status indicators</li>";
    echo "</ul>";
    
    echo "<br><a href='profile.php' style='padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;'>View Enhanced Profile Page</a>";
    
} catch (PDOException $e) {
    echo "<h3>❌ Error updating database schema:</h3>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
?>