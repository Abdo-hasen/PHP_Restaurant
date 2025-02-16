<?php
// Include necessary files
// require_once '../includes/common/auth.php';
// requireStaff(); // Ensure only staff can access this page
require_once '../init.php';
include '../includes/admin/sidebar.php';
include '../includes/admin/header.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    // Collect form data
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Validate inputs
    $errors = [];
    if (empty($full_name)) {
        $errors[] = "Full name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if (empty($role)) {
        $errors[] = "Role is required.";
    }

    // If no errors, proceed to insert the user
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare data for insertion
        $data = [
            'full_name' => $full_name,
            'email' => $email,
            'password' => $hashed_password,
            'role' => $role
        ];

        // Check if the email already exists
        $existing_user = $db->table('users')->find($email, 'email'); // Use the `find()` method

        if ($existing_user) {
            echo "<p class='alert alert-danger'>Email already exists. Please use a different email.</p>";
        } else {
            // Insert the user into the database
            try {
                if ($db->table('users')->insert($data)) {
                    $_SESSION['success'] = "User added successfully!";
                    header("Location: ../admin/manage_users.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to add user.";
                    header("Location: ../admin/manage_users.php");
                    exit();
                }
            } catch (mysqli_sql_exception $e) {
                // Handle duplicate email error
                if ($e->getCode() === 1062) { // MySQL error code for duplicate entry
                    echo "<p class='alert alert-danger'>Email already exists. Please use a different email.</p>";
                } else {
                    echo "<p class='alert alert-danger'>An error occurred: " . $e->getMessage() . "</p>";
                }
            }
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo "<p class='alert alert-danger'>$error</p>";
        }
    }
}

?>

<div class="container mt-4">
    <h2>Add User</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role" required>
                <option value="staff">Staff</option>
                <option value="customer">Customer</option>
            </select>
        </div>
        <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
    </form>
</div>

<?php include '../includes/admin/footer.php'; ?>