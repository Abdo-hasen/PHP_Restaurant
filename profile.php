<?php
require_once __DIR__ . "/init.php";
include './includes/admin/sidebar.php';
include './includes/admin/header.php';

if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

$db->table('users');
$user_id = $_SESSION['user_id'];
$current_user = $db->find($user_id, 'user_id');

// Handle form submission
if (checkRequestMethod('POST') && checkInput($_POST, 'update_profile')) {
    $errors = [];

    // Sanitize inputs
    $data = [
        'full_name' => sanitizeInput($_POST['full_name']),
        'email' => sanitizeInput($_POST['email']),
        'phone' => sanitizeInput($_POST['phone'] ?? null),
        'address' => sanitizeInput($_POST['address'] ?? null)
    ];

    // Validation
    if (requiredVal($data['full_name'])) {
        $errors[] = "Full name is required";
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Handle password change
    if (!empty($_POST['new_password'])) {
        if (empty($_POST['current_password'])) {
            $errors[] = "Current password is required to change password";
        } elseif (!password_verify($_POST['current_password'], $current_user['password'])) {
            $errors[] = "Current password is incorrect";
        } elseif ($_POST['new_password'] !== $_POST['confirm_password']) {
            $errors[] = "New passwords do not match";
        } else {
            $data['password'] = $db->encPassword($_POST['new_password']);
        }
    }

    // Handle file upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_picture'];
        $max_size = 2 * 1024 * 1024; // 2MB
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

        if ($file['size'] > $max_size) {
            $errors[] = "File size exceeds 2MB limit";
        } elseif (!in_array($file['type'], $allowed_types)) {
            $errors[] = "Only JPG, PNG, and GIF files are allowed";
        } else {
            $upload_dir = './assets/profile-image/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = "user_{$user_id}_" . time() . ".{$file_ext}";
            $target_path = $upload_dir . $filename;

            if (move_uploaded_file($file['tmp_name'], $target_path)) {
                // Delete old image if exists
                if ($current_user['profile_picture'] && file_exists($current_user['profile_picture'])) {
                    unlink($current_user['profile_picture']);
                }
                $data['profile_picture'] = $target_path;
            } else {
                $errors[] = "Failed to upload profile picture";
            }
        }
    }

    if (empty($errors)) {
        if ($db->update($data, ['user_id' => $user_id])) {
            setToastMessage('success', 'Profile updated successfully');
            redirect('profile.php');
        } else {
            setToastMessage('danger', 'Failed to update profile');
        }
    } else {
        $_SESSION['errors'] = $errors;
    }
}

// Refresh user data after potential update
$current_user = $db->find($user_id, 'user_id');
?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">My Profile</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Pages</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Starter Page</a>
                </li>
            </ul>
        </div>
        <div class="page-category">
            <div class="container mt-5">
                <h3 class="card-title mb-0 mt-5">
                    My Profile
                </h3>

                <div class="container mt-5">
                    <?php showToast(); ?>

                    <div class="row">
                        <!-- Profile Picture Section -->
                        <div class="col-md-4 text-center mb-4">
                            <div class="position-relative">
                                <img src="<?= $current_user['profile_picture'] ?? 'assets/default-profile.png' ?>"
                                    class="img-thumbnail rounded-circle mb-3"
                                    style="width: 200px; height: 200px; object-fit: cover"
                                    alt="Profile Picture">

                                <form method="POST" enctype="multipart/form-data">
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="profile_picture"
                                            id="profilePicture" accept="image/*" hidden>
                                        <label for="profilePicture" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-camera"></i> Change Photo
                                        </label>
                                    </div>
                            </div>
                        </div>

                        <!-- Profile Form -->
                        <div class="col-md-8">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" name="full_name" required
                                            value="<?= htmlspecialchars($current_user['full_name']) ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="email" required
                                            value="<?= htmlspecialchars($current_user['email']) ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" name="phone"
                                            value="<?= htmlspecialchars($current_user['phone'] ?? '') ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" name="address"
                                            value="<?= htmlspecialchars($current_user['address'] ?? '') ?>">
                                    </div>

                                    <!-- Password Change Section -->
                                    <div class="col-12 mt-4">
                                        <div class="card border-warning">
                                            <div class="card-header bg-warning text-dark">
                                                <i class="fas fa-lock me-2"></i>Change Password
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-2">
                                                    <div class="col-md-4">
                                                        <input type="password" class="form-control"
                                                            name="current_password"
                                                            placeholder="Current Password">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="password" class="form-control"
                                                            name="new_password"
                                                            placeholder="New Password">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="password" class="form-control"
                                                            name="confirm_password"
                                                            placeholder="Confirm Password">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" name="update_profile"
                                            class="btn btn-primary px-4">
                                            <i class="fas fa-save me-2"></i>Save Changes
                                        </button>
                                        <a href="dashboard.php" class="btn btn-outline-secondary">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include './includes/admin/footer.php'; ?>