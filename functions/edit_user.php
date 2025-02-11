<?php
// require_once '../includes/common/auth.php';
// requireStaff(); // Ensure only staff can access this page
require_once '../includes/common/db.php';

// Fetch user details
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $db->query("SELECT * FROM users WHERE user_id = :id");
    $db->bind(':id', $id);
    $user = $db->single();
} else {
    header('Location: manage_users.php');
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fields = [
        'full_name' => $_POST['full_name'],
        'email' => $_POST['email'],
        'role' => $_POST['role']
    ];

    if ($db->update('users', $id, $fields)) {
        header('Location: manage_users.php');
        exit();
    } else {
        echo "<p class='alert alert-danger'>Failed to update user.</p>";
    }
}

include '../includes/admin/header.php';
?>

<div class="container mt-4">
    <h2>Edit User</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role" required>
                <option value="staff" <?php echo $user['role'] == 'staff' ? 'selected' : ''; ?>>Staff</option>
                <option value="customer" <?php echo $user['role'] == 'customer' ? 'selected' : ''; ?>>Customer</option>
            </select>
        </div>
        <input type="hidden" name="id" value="<?php echo $user['user_id']; ?>">
        <button type="submit" name="edit_user" class="btn btn-primary">Update User</button>
    </form>
</div>

<?php include '../includes/admin/footer.php'; ?>