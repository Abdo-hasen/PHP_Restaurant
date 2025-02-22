<?php
require_once __DIR__ . "../../../init.php";

/**
 * Handles user registration.
 * @param array $data The user's registration data.
 * @param array $files The uploaded files (e.g., profile picture).
 */
function handleRegister($data, $files) {
    global $db;

    $errors = [];

    // Validate inputs
    if (empty($data['full_name'])) {
        $errors[] = "Full name is required.";
    }
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($data['password']) || strlen($data['password']) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if ($data['password'] !== $data['confirm_password']) {
        $errors[] = "Passwords do not match.";
    }

    // Check if email already exists
    $existingUser = $db->table('users')->find($data['email'], 'email');
    if ($existingUser) {
        $errors[] = "Email already registered.";
    }

    // Handle profile picture upload
    $image_path = null;
    if (isset($files['profilePic']) && $files['profilePic']['error'] === 0) {
        $file = $files['profilePic'];
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
            $upload_dir = __DIR__ . '/../assets/profile-image/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_name = uniqid() . '_' . $fileName;
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($fileTmpName, $target_path)) {
                $image_path = $target_path;
            } else {
                $errors[] = "Failed to upload the profile picture.";
            }
        }
    }

    // If there are errors, redirect back to the registration page
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: register.php");
        exit();
    }

    // Hash password
    $data['password'] = $db->encPassword($data['password']);

    // Insert user into the database
    $success = $db->table('users')->insert([
        'full_name' => $data['full_name'],
        'email' => $data['email'],
        'password' => $data['password'],
        'profile_picture' => $image_path,
        'role' => 'customer', // Default role for registration
    ]);

    if ($success) {
        $_SESSION['success'] = "Registration successful! Please log in.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['errors'] = ["Failed to register user. Please try again."];
        header("Location: register.php");
        exit();
    }
}
?>