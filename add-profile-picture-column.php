<?php
// Script to add profile_picture column to users table
include 'config/database.php';

echo "<h2>Adding Profile Picture Column to Users Table</h2>";

try {
    // Check if the column already exists
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'profile_picture'");
    if ($stmt->rowCount() > 0) {
        echo "✅ profile_picture column already exists<br>";
    } else {
        // Add the profile_picture column
        $pdo->exec("ALTER TABLE users ADD COLUMN profile_picture VARCHAR(255) NULL AFTER email");
        echo "✅ profile_picture column added successfully<br>";
    }
    
    // Verify the column was added
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll();
    
    echo "<h3>Current Users Table Structure:</h3>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Default'] ?? 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<br><a href='signup.php'>← Back to Signup</a> | <a href='profile.php'>View Profile →</a>";
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; line-height: 1.6; }
h2, h3 { color: #333; }
table { width: 100%; }
th, td { padding: 8px 12px; text-align: left; }
th { background: #f4f4f4; }
a { color: #667eea; text-decoration: none; margin: 0 10px; }
a:hover { text-decoration: underline; }
</style>