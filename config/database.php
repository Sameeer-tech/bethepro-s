<?php
/**
 * Database Configuration File
 * 
 * This file establishes a secure connection to the MySQL database.
 * It uses PDO (PHP Data Objects) for database operations with 
 * prepared statements to prevent SQL injection attacks.
 * 
 * SETUP INSTRUCTIONS:
 * 1. Ensure XAMPP MySQL is running
 * 2. Create database named 'bethepros'
 * 3. Import the SQL file: Database_Query/bethepros (2).sql
 * 4. Default XAMPP settings should work without changes
 * 
 * @author BeThePro Development Team
 * @version 2.0
 * @since 2025-09-25
 */

// ==============================================
// DATABASE CONNECTION SETTINGS
// ==============================================

$host = 'localhost';        // Database server (usually localhost for XAMPP)
$dbname = 'bethepros';      // Database name (must match your created database)
$username = 'root';         // Database username (default for XAMPP)
$password = '';             // Database password (empty for default XAMPP)

// ==============================================
// ESTABLISH DATABASE CONNECTION
// ==============================================

try {
    // Create PDO connection with UTF-8 character set
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configure PDO settings for security and convenience
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    // Enable exceptions for errors
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Return associative arrays
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);            // Use real prepared statements
    
    // Optional: Enable persistent connections for better performance
    // $pdo->setAttribute(PDO::ATTR_PERSISTENT, true);
    
} catch(PDOException $e) {
    // Log the error securely (don't expose database details to users)
    error_log("Database connection error: " . $e->getMessage());
    
    // Show user-friendly error message
    die("
        <div style='font-family: Arial; padding: 20px; background: #f8d7da; border: 1px solid #dc3545; border-radius: 5px; margin: 20px; color: #721c24;'>
            <h3>🚫 Database Connection Error</h3>
            <p><strong>Unable to connect to the database.</strong></p>
            
            <h4>Troubleshooting Steps:</h4>
            <ol>
                <li><strong>Check XAMPP:</strong> Ensure Apache and MySQL are running</li>
                <li><strong>Verify Database:</strong> Confirm 'bethepros' database exists</li>
                <li><strong>Import SQL:</strong> Run Database_Query/bethepros (2).sql</li>
                <li><strong>Check Settings:</strong> Verify username/password in config/database.php</li>
            </ol>
            
            <p><em>Error details logged for developer review.</em></p>
        </div>
    ");
}

// Connection successful - $pdo object is now available for database operations
?>
