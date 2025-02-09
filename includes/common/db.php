<?php
// Database configuration
define('DB_HOST', 'localhost'); // Database host (usually 'localhost')
define('DB_USER', 'restaurant_user'); // New database username
define('DB_PASS', 'password'); // New database password
define('DB_NAME', 'restaurant_db'); // Database name

// Create a database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8");
?>