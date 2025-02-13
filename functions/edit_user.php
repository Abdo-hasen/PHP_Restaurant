<?php
require_once "./../init.php";
include '../includes/admin/sidebar.php';
include '../includes/admin/header.php';

// Check if the user ID is provided
if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}

$id = $_GET['id'];

// Fetch the user's data from the database
$user = $db->table('users')->find($id, 'user_id');

if (!$user) {
    echo "<p class='alert alert-danger'>User not found.</p>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
    $fields = [
        'full_name' => $_POST['full_name'],
        'email' => $_POST['email'],
        'role' => $_POST['role']
    ];

    if ($db->table('users')->update($fields, ['user_id' => $id])) {
        echo "<p class='alert alert-success'>User updated successfully!</p>";
    } else {
        echo "<p class='alert alert-danger'>Failed to update user.</p>";
    }
}
?>

<div class="container mt-4">
    <h2>Edit User</h2>
    <form method="POST" action="edit_user.php?id=<?php echo $id; ?>">
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
            <select class="form-select" id="role" name="role" required>
                <option value="staff" <?php echo ($user['role'] === 'staff') ? 'selected' : ''; ?>>Staff</option>
                <option value="customer" <?php echo ($user['role'] === 'customer') ? 'selected' : ''; ?>>Customer</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="edit_user">Save Changes</button>
        <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include '../includes/admin/footer.php'; ?>