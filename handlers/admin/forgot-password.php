<?php
// var_dump(__DIR__ .'./../../init.php');
// die;
require_once "./../../init.php";

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
    
    if (!empty($email)) {
        // Check if email exists using find() method
        $user = $db->table('users')->find($email, 'email');
        
        if ($user) {
            // Generate a unique token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Store token in database using insert() method
            $db->table('users')->update(
                ['password_reset_token' => $token, 'updated_at' => date('Y-m-d H:i:s')],
                ['email' => $email]
            );
            
            // Send email with reset link
            $resetLink = URL . "reset-password.php?token=" . urlencode($token);
            $subject = "Password Reset Request";
            $message = "Click this link to reset your password: $resetLink";
            $headers = "From: no-reply@restaurant.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            
            if (mail($email, $subject, $message, $headers)) {
                $success = "Password reset link has been sent to your email.";
            } else {
                $error = "Failed to send the reset email. Please try again.";
            }
        } else {
            $error = "Email not found in our system.";
        }
    } else {
        $error = "Please enter a valid email address.";
    }
}
?>