<?php
require_once __DIR__ . "/handlers/auth_handler.php";

if (checkRequestMethod('POST')) {
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    handleLogin($email, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Restaurant App</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <!-- put image logo here -->
                            <img src="/api/placeholder/80/80" alt="Logo" class="mb-4 rounded-circle">
                            <h2 class="fw-bold">Welcome Back</h2>
                            <p class="text-muted">Please login to your account</p>
                        </div>
                        <!-- check errors -->
                        <?php if (isset($_SESSION["errors"])) : ?>
                            <?php foreach ($_SESSION["errors"] as $error) : ?>
                                <div class="alert alert-danger text-center mx-auto w-50">
                                    <?= htmlspecialchars($error); ?>
                                </div>
                            <?php endforeach; ?>
                            <?php unset($_SESSION["errors"]); ?>
                        <?php endif; ?>


                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                Sign In
                            </button>
                        </form>

                        <div class="text-center">
                            <a href="forgot-password.php" class="text-decoration-none">Forgot Password?</a>
                            <hr class="my-4">
                            <p class="mb-0">Don't have an account? <a href="register.php" class="text-decoration-none">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>