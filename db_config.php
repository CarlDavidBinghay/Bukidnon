<?php
// Database credentials
$host = 'localhost';  // Hostname (usually localhost)
$dbname = 'admin_dashboard';  // Database name
$username = 'root';  // Your MySQL username
$password = '';  // Your MySQL password (empty for default XAMPP)

try {
    // Create a PDO connection to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}
?>
