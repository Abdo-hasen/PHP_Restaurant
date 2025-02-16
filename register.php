<?php
require_once __DIR__ . "/handlers/register_handler.php";

if (checkRequestMethod('POST')) {
    $data = [
        'full_name' => sanitizeInput($_POST['full_name']),
        'email' => sanitizeInput($_POST['email']),
        'password' => sanitizeInput($_POST['password']),
        'confirm_password' => sanitizeInput($_POST['confirm_password']),
    ];

    handleRegister($data, $_FILES);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Restaurant App</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Create Account</h2>
                            <p class="text-muted">Fill in your details to get started</p>
                        </div>
<<<<<<< HEAD

                        <form action="admin/register.php" method="POST" enctype="multipart/form-data">
                            <div class="text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    <img src="/api/placeholder/100/100" alt="Profile Preview" id="profilePreview"
                                        class="rounded-circle border" style="width: 100px; height: 100px; object-fit: cover;">
                                    <label for="profilePic" class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow-sm"
                                        style="cursor: pointer;">

                                    </label>
                                    <input type="file" id="profilePic" name="profilePic" class="d-none" accept="image/*">
                                </div>
                            </div>
                            <!-- check errors -->
            

=======
                        <?php if (isset($_SESSION['errors'])): ?>
                            <?php foreach ($_SESSION['errors'] as $error): ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
                            <?php endforeach; ?>
                            <?php unset($_SESSION['errors']); ?>
                        <?php endif; ?>
                        <form method="POST" enctype="multipart/form-data">
>>>>>>> 7fd9e2d8e989f847ffdd5e87aab60faeacd1721e
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="profilePic" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="profilePic" name="profilePic" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Create Account</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php" class="text-decoration-none">Already have an account? Sign In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>