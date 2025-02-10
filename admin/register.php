<?php
session_start();

require_once "./../init.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullName = sanitizeInput($_POST['fullName']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $confirmPassword = sanitizeInput($_POST['confirmPassword']);
  




    $errors = [];
    if (requiredVal($fullName)) {
        $errors[] = "Full name is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (minVal($password, 8)) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    $image_path = null;
    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === 0) {
        $file = $_FILES['profilePic'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileType = $file['type'];


        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Only JPEG, PNG, and GIF images are allowed.";
        } elseif ($fileSize > $maxFileSize) {
            $errors[] = "File size must be less than 2MB.";
        } else {
            $upload_dir = './../assets/profile-image/'; 
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir);
            }

            $file_name = uniqid() . '_' . $fileName . date("Y-M-D");
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($fileTmpName, $target_path)) {
                $image_path = $target_path;
            } else {
                $errors[] = "Failed to upload the profile picture.";
            }
        }
    }


    if (checkError($errors)) {
        $_SESSION["errors"] = $errors;
        redirect(URL . "register.php");
    } else {
        
        $success = $db->table("users")->insert(
            [
                "full_name" => $fullName,
                "email" => $email,
                "password" => $db->encPassword($password),
                "profile_picture" => $image_path,
            ]
        );

        redirect(URL . "./login.php");
    }
}
