<?php
require_once "./../../init.php";
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = htmlspecialchars($_POST['token'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');
    $confirm_password = htmlspecialchars($_POST['confirm_password'] ?? '');

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
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
                    'password_reset_token' => null, 
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                ['email' => $user['email']]
            );

            $success = "Password has been reset successfully. You can now login.";
            $_SESSION["success"] = $success;
            redirect(URL . "login.php");
        } else {
            $error = "Invalid or expired token.";
        }
    }
} else {
    $token = htmlspecialchars($_GET['token'] ?? '');
    if (empty($token)) {
        $_SESSION['error'] = "Invalid password reset link.";
        redirect(URL . "forgot-password.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Reset Password</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required minlength="8">
                                <div class="form-text">Password must be at least 8 characters long.</div>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>