<?php
$host = 'sql104.infinityfree.com';
$dbname = 'if0_39772363_bethepros';   // <-- use your actual database name
$username = 'if0_39772363';
$password = 'cpstar123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
