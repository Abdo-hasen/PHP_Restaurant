<?php
require_once __DIR__ . "/../init.php";

/**
 * Handles user login.
 * @param string $email The user's email.
 * @param string $password The user's password.
 */
function handleLogin($email, $password) {
    global $db;

    $errors = [];

    // Validate inputs
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // If there are validation errors, redirect back to login page
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: login.php");
        exit();
    }

    // Fetch user from the database
    $user = $db->table('users')->find($email, 'email');
    if (!$user) {
        $_SESSION['errors'] = ["User not found."];
        header("Location: login.php");
        exit();
    }

    // Verify password
    if (!password_verify($password, $user['password'])) {
        $_SESSION['errors'] = ["Invalid email or password."];
        header("Location: login.php");
        exit();
    }

    // Set session variables
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['role'] = $user['role'];

    // Redirect based on role
    if ($user['role'] === 'customer') {
        header("Location: ../index.php");
        exit();
    } else {
        header("Location: ../admin/dashboard.php");
        exit();
    }
}

/**
 * Handles user logout.
 */
function handleLogout() {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>