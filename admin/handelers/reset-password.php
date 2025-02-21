<?php
require_once __DIR__ .'./../../init.php';


$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = htmlspecialchars($_POST['token'] ?? '', ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8');
    $confirm_password = htmlspecialchars($_POST['confirm_password'] ?? '', ENT_QUOTES, 'UTF-8');

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Verify token using read() method
        $users = $db->table('users')->read();
        $user = null;
        foreach ($users as $u) {
            if ($u['password_reset_token'] === $token && strtotime($u['updated_at']) > time() - 3600) {
                $user = $u;
                break;
            }
        }

        if ($user) {
            // Update password using update() method
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $db->table('users')->update(
                [
                    'password' => $hashedPassword,
                    'password_reset_token' => null, // Clear the token
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                ['email' => $user['email']]
            );

            $success = "Password has been reset successfully. You can now login.";
        } else {
            $error = "Invalid or expired token.";
        }
    }
} else {
    $token = htmlspecialchars($_GET['token'] ?? '', ENT_QUOTES, 'UTF-8');
    if (empty($token)) {
        header('Location: forgot-password.php');
        exit();
    }
}
?>