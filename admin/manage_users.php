<?php
// Include necessary files
require_once '../init.php';
restrictToAdmin(); // Restrict access to admin pages
include '../includes/admin/header.php';
include '../includes/admin/sidebar.php';

// Handle Delete User
if (isset($_GET['delete_id'])) {
    $id = filter_input(INPUT_GET, 'delete_id', FILTER_VALIDATE_INT);
    if ($id) {
        if ($db->table('users')->delete($id, 'user_id')) {
            $_SESSION['success'] = "User deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete user.";
        }
    } else {
        $_SESSION['error'] = "Invalid user ID.";
    }
    header("Location: manage_users.php"); // Redirect without query string
    exit();
}

// Handle Edit User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $fields = [
        'full_name' => filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING),
        'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
        'role' => filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING)
    ];

    if ($id && !empty($fields['full_name']) && !empty($fields['email']) && !empty($fields['role'])) {
        $condition = ['user_id' => $id];
        if ($db->table('users')->update($fields, $condition)) {
            $_SESSION['success'] = "User updated successfully!";
            header("Location: manage_users.php"); // Redirect without query string
            exit();
        } else {
            $_SESSION['error'] = "Failed to update user.";
            header("Location: manage_users.php"); // Redirect without query string
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid input data.";
    }
    header("Location: manage_users.php"); // Redirect without query string
    exit();
}


$users = $db->table('users')->read();

// Display success/error messages
if (isset($_SESSION['success'])) {
    echo "<p class='alert alert-success'>" . htmlspecialchars($_SESSION['success']) . "</p>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<p class='alert alert-danger'>" . htmlspecialchars($_SESSION['error']) . "</p>";
    unset($_SESSION['error']);
}
?>
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h2 class="page-title">Manage Users</h2>
        </div>
            <div class="page-category">
            <div class="container mt-4">
                <a href="../functions/add_user.php" class="btn btn-primary mb-3">Add User</a>

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
                                        <!-- Edit Button (Link to Edit Page) -->
                                        <a href="../functions/edit_user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                                        <!-- Delete Button (Form for POST Request) -->
                                        <form action="manage_users.php" method="GET" style="display: inline;">
                                            <input type="hidden" name="delete_id" value="<?php echo $user['user_id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                        </form>
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
            </div>
          </div>
        </div>

<?php include '../includes/admin/footer.php'; ?>