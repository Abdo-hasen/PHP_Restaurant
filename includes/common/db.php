<?php
// Database configuration
define('DB_HOST', 'localhost'); // Database host (usually 'localhost')
define('DB_USER', 'restaurant_user'); // Database username
define('DB_PASS', 'password'); // Database password
define('DB_NAME', 'restaurant_db'); // Database name

// Include the Database class
require_once 'database.php';

// Create a new Database instance
$db = new Database();
?>