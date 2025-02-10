<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// base url and root 
//customize for every one
define('URL', "http://127.0.0.1/PHP_Restaurant/"); // for links and urls - project folder

// include function files
require_once __DIR__ . "/includes/common/Database.php";
require_once __DIR__ . "/includes/common/Functions.php";
require_once __DIR__ . "/includes/common/validations.php";

$db = new Database();





