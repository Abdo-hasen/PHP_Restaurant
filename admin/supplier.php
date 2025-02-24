<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../init.php';
include '../includes/admin/sidebar.php';
include '../includes/admin/header.php';

if (isset($_GET['delete_id'])) {
    $id = filter_input(INPUT_GET, 'delete_id', FILTER_VALIDATE_INT);
    if ($id) {
        if ($db->table('suppliers')->delete($id, 'supplier_id')) {
            $_SESSION['success'] = "Supplier deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete supplier.";
        }
    } else {
        $_SESSION['error'] = "Invalid supplier ID.";
    }
    header("Location: manage_suppliers.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['supplier_id']) ? filter_input(INPUT_POST, 'supplier_id', FILTER_VALIDATE_INT) : null;
    $fields = [
        'supplier_name' => filter_input(INPUT_POST, 'supplier_name', FILTER_SANITIZE_STRING),
        'contact_email' => filter_input(INPUT_POST, 'contact_email', FILTER_SANITIZE_EMAIL),
        'phone' => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING)
    ];

    if (!empty($fields['supplier_name']) && !empty($fields['contact_email']) && !empty($fields['phone'])) {
        if ($id) {
            $condition = ['supplier_id' => $id];
            $success = $db->table('suppliers')->update($fields, $condition);
            $message = $success ? "Supplier updated successfully!" : "Failed to update supplier.";
        } else {
            $success = $db->table('suppliers')->insert($fields);
            $message = $success ? "Supplier added successfully!" : "Failed to add supplier.";
        }
        $_SESSION[$success ? 'success' : 'error'] = $message;
    } else {
        $_SESSION['error'] = "Invalid input data.";
    }
    header("Location: manage_suppliers.php");
    exit();
}

$suppliers = $db->table('suppliers')->read();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Suppliers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Manage Suppliers</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?> </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?> </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Supplier Name</th>
                        <th>Contact Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($suppliers)): ?>
                        <?php foreach ($suppliers as $supplier): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($supplier['supplier_name']); ?></td>
                                <td><?php echo htmlspecialchars($supplier['contact_email']); ?></td>
                                <td><?php echo htmlspecialchars($supplier['phone']); ?></td>
                                <td>
                                    <a href="manage_suppliers.php?edit_id=<?php echo $supplier['supplier_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="manage_suppliers.php?delete_id=<?php echo $supplier['supplier_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No suppliers found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
