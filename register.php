<?php
require_once "./init.php";
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
    <!--  check error -->

    <?php if (isset($_SESSION["errors"])) : ?>
        <?php foreach ($_SESSION["errors"] as $error) : ?>
            <div class="alert alert-danger text-center mx-auto w-50">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION["errors"]); ?>
    <?php endif; ?>



    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Create Account</h2>
                            <p class="text-muted">Fill in your details to get started</p>
                        </div>

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

                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" name="fullName" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-4">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                            </div>

                            <div class="mb-3">
                                <label for="profilePic" class="form-label">Upload Profile Picture</label>
                                <input type="file" class="form-control" id="profilePic" name="profilePic" accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                Create Account
                            </button>
                        </form>

                        <div class="text-center">
                            <p class="mb-0">Already have an account? <a href="login.php" class="text-decoration-none">Sign In</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>