<?php
require_once "./init.php";
include './includes/admin/sidebar.php';
include './includes/admin/header.php';

// // Check if the user ID is provided
// if (!isset($_GET['id'])) {
//     header("Location: profile.php");
//     exit();
// }

// $id = $_GET['id'];

// // Fetch the user's data from the database
// $user = $db->table('users')->find($id, 'user_id');

// if (!$user) {
//     echo "<p class='alert alert-danger'>User not found.</p>";
//     exit();
// }

// // Handle form submission
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
//     $fields = [
//         'full_name' => $_POST['full_name'],
//         'email' => $_POST['email'],
//         'role' => $_POST['role']
//     ];

//     if ($db->table('users')->update($fields, ['user_id' => $id])) {
//         echo "<p class='alert alert-success'>User updated successfully!</p>";
//     } else {
//         echo "<p class='alert alert-danger'>Failed to update user.</p>";
//     }
// }
?>

<div class="container mt-4">
    <h2>My Profile</h2>
    <form class="row g-3" method="POST" action="edit_user.php?id=<?php echo $id; ?>">
        <div class="col-12 mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
        </div>
        <div class="col-12 mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="col-12 mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="phone" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>
        <div class="col-12 mb-3">
            <label for="inputAddress" class="form-label">Address</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
        </div>
        <div class="col-md-6">
            <label for="inputCity" class="form-label">City</label>
            <input type="text" class="form-control" id="inputCity">
        </div>
        <div class="col-md-4">
            <label for="inputState" class="form-label">State</label>
            <select id="inputState" class="form-select">
            <option selected>Choose...</option>
            <option>...</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="inputZip" class="form-label">Zip</label>
            <input type="text" class="form-control" id="inputZip">
        </div>
        <div>
            <label class="form-label" for="customFile">Upload Profile Picture</label>
            <input type="file" class="form-control" id="customFile" />
        </div class="col-12 mb-3">
        <button type="submit" class="btn btn-primary" name="edit_user">Save Changes</button>
        <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include '../includes/admin/footer.php'; ?>