<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once "./../../init.php";
require './../../vendor/autoload.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email'] ?? '');
    
    if (!empty($email)) {
        $user = $db->table('users')->find($email, 'email');
        
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            $db->table('users')->update(
                ['password_reset_token' => $token, 'updated_at' => date('Y-m-d H:i:s')],
                ['email' => $email]
            );
            

            $resetLink = URL . "./handlers/admin/reset-password.php?token=" . urlencode($token);
          
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';  
                $mail->SMTPAuth   = true;
                $mail->Username   = 'abdohasen200@gmail.com';        
                $mail->Password   = 'dbiuzuuanbzcqsno';          
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //  TLS encryption
                $mail->Port       = 587;             

                // Recipients
                $mail->setFrom('abdohasen200@gmail.com', 'Abdo Hasen');
                $mail->addAddress($email);                  

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = '
                    <h2>Password Reset Request</h2>
                    <p>We received a request to reset your password. Click the link below to proceed:</p>
                    <p><a href="'.$resetLink.'">Reset My Password</a></p>
                    <p>If you didn\'t request this, please ignore this email. This link will expire in 1 hour.</p>
                ';
                $mail->AltBody = "To reset your password, please visit this link: $resetLink\n\nIf you didn't request this, please ignore this email. This link will expire in 1 hour.";

                $mail->send();
                $_SESSION['success'] = "Password reset link has been sent to your email.";
                redirect(URL . "login.php");
            } catch (Exception $e) {
                $error = "Failed to send the reset email. Please try again. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $error = "Email not found in our system.";
        }
    } else {
        $error = "Please enter a valid email address.";
    }
}

if (!empty($error)) {
    $_SESSION['error'] = $error;
    redirect(URL . "forgot-password.php");
}
?>