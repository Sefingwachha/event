<?php
// db.php
// Establishes a connection to the MySQL database.

// Database configuration
$dbHost = 'localhost';      // Your database host (e.g., 'localhost' or an IP)
$dbUser = 'root';           // Your database username
$dbPass = '';               // Your database password
$dbName = 'event_management'; // The name of the database created in the SQL script

// Create a new MySQLi connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check for connection errors
if ($conn->connect_error) {
    // If a connection error occurs, terminate the script and display the error message.
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to utf8mb4 for full Unicode support
$conn->set_charset("utf8mb4");

// The $conn variable is now ready to be used in other PHP files to interact with the database.
?>
