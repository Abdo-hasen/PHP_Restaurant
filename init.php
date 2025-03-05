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

// create database instance
$db = new Database();

// Function to check if the user is an admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'staff';
}

// Function to check if the user is a customer
function isCustomer() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'customer';
}

// Function to restrict access to admin pages
function restrictToAdmin() {
    if (!isAdmin()) {
        $_SESSION['error'] = "You do not have permission to access this page.";
        header("Location: ../index.php");
        exit();
    }
}
?>