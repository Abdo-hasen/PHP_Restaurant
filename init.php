<?php
//session check 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// base url and root 
//customize for every one
define('URL', "http://localhost:8080/"); // for redirect or location


// include classes and function 
require_once __DIR__ . "/includes/common/Database.php";
require_once __DIR__ . "/includes/common/Functions.php";
require_once __DIR__ . "/includes/common/validations.php";

//layout


// create database instance
$db = new Database();
