<?php
// // Include necessary files
// require_once '../includes/common/auth.php';
// requireStaff(); // Ensure only staff can access this page
require_once '../includes/common/Database.php';

include '../includes/admin/sidebar.php';
include '../includes/admin/header.php';

// Handle Delete User
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    if ($db->delete('users', $id)) {
        echo "<p class='alert alert-success'>User deleted successfully!</p>";
    } else {
        echo "<p class='alert alert-danger'>Failed to delete user.</p>";
    }
}

// Handle Edit User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $fields = [
        'full_name' => $_POST['full_name'],
        'email' => $_POST['email'],
        'role' => $_POST['role']
    ];

    if ($db->update('users', $id, $fields)) {
        echo "<p class='alert alert-success'>User updated successfully!</p>";
    } else {
        echo "<p class='alert alert-danger'>Failed to update user.</p>";
    }
}

// // Fetch all users from the database
// $db->query("SELECT * FROM users");
// $users = $db->resultSet();

// if (empty($users)) {
//     echo "<p class='alert alert-warning'>No users found.</p>";
// }

?>

<div class="container mt-4">
    <h2>Manage Users</h2>
    <a href="add_user.php" class="btn btn-primary mb-3">Add User</a>

    <!-- Display success/error messages -->
    <?php if (isset($_GET['delete_id']) || isset($_POST['edit_user'])): ?>
        <!-- Messages are already displayed above -->
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (is_array($users) && !empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td>
                        <a href="../functions/edit_user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="manage_users.php?delete_id=<?php echo $user['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/admin/footer.php'; ?>
