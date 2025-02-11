<?php
require_once "./../init.php";

$errors = [];

if (checkRequestMethod('POST')) {
    // Sanitize inputs
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = sanitizeInput($_POST['password'] ?? '');

    if (requiredVal($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    //validation error
    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        redirect(URL . "./login.php");
    }


 
    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $db->mysqli->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();


        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];


            if ($user['role'] === 'customer') {
                // redirect(URL . "admin/dashboard.php");
                var_dump("customer");
            } else {
                // redirect(URL . "customer/profile.php");
                var_dump("staff");
            }
            exit();
        } else {
            $errors[] = "Invalid email or password.";
        }
    } else {
        $errors[] = "User not found.";
    }

    //authntication error
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect(URL . "./login.php");
    }
}
