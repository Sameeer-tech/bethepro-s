<?php
/**
 * Simple setup script for recommendation system
 * Creates the necessary table for tracking user actions
 */

include 'config/database.php';

try {
    // Create table for tracking user recommendation actions
    $sql = "CREATE TABLE IF NOT EXISTS user_recommendation_actions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        action VARCHAR(50) NOT NULL,
        item_id VARCHAR(255) NOT NULL,
        item_type VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_user_id (user_id),
        INDEX idx_action (action),
        INDEX idx_item_type (item_type)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $pdo->exec($sql);
    echo "✓ User recommendation actions table created successfully!\n";
    
    // Check if we need to add some sample data for testing
    $stmt = $pdo->query("SELECT COUNT(*) FROM courses WHERE status = 'Active'");
    $active_courses = $stmt->fetchColumn();
    
    if ($active_courses == 0) {
        echo "⚠ No active courses found. You may want to add some courses for recommendations to work properly.\n";
    } else {
        echo "✓ Found $active_courses active courses for recommendations.\n";
    }
    
    echo "\n🎉 Simple recommendation system is ready to use!\n";
    echo "Access it at: simple-recommendations.php\n";
    
} catch (PDOException $e) {
    echo "❌ Error setting up recommendation system: " . $e->getMessage() . "\n";
}
?>