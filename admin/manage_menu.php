<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../init.php';
include '../includes/admin/sidebar.php';
include '../includes/admin/header.php';

function uploadImage($file) {
    $targetDir = "../uploads/";
    $fileName = basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        return $targetFilePath;
    }
    return false;
}

if (isset($_GET['delete_id'])) {
    $id = filter_input(INPUT_GET, 'delete_id', FILTER_VALIDATE_INT);
    if ($id) {
        if ($db->table('menu_items')->delete($id, 'item_id')) {
            $_SESSION['success'] = "Menu item deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete menu item.";
        }
    } else {
        $_SESSION['error'] = "Invalid menu item ID.";
    }
    header("Location: manage_menu.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) : null;
    $fields = [
        'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT),
        'item_name' => filter_input(INPUT_POST, 'item_name', FILTER_SANITIZE_STRING),
        'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
        'price' => filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT),
        'is_available' => isset($_POST['is_available']) ? 1 : 0
    ];

    if ($_FILES["image"]["name"] != "") {
        $fields['image_url'] = uploadImage($_FILES["image"]);
    }

    if (!empty($fields['item_name']) && !empty($fields['description']) && $fields['price'] !== false) {
        if ($id) {
            $condition = ['item_id' => $id];
            $success = $db->table('menu_items')->update($fields, $condition);
            $message = $success ? "Menu item updated successfully!" : "Failed to update menu item.";
        } else {
            $success = $db->table('menu_items')->insert($fields);
            $message = $success ? "Menu item added successfully!" : "Failed to add menu item.";
        }
        $_SESSION[$success ? 'success' : 'error'] = $message;
    } else {
        $_SESSION['error'] = "Invalid input data.";
    }
    header("Location: manage_menu.php");
    exit();
}

$menu_items = $db->table('menu_items')->read(
    "menu_items.*, categories.category_name AS category_name",
    "LEFT JOIN categories ON menu_items.category_id = categories.category_id"
);
$categories = $db->table('categories')->read();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Manage Menu</h2>

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
                        <th>ID</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($menu_items)): ?>
                        <?php foreach ($menu_items as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['item_id']); ?></td>
                                <td><?php echo htmlspecialchars($item['category_name']); ?></td>
                                <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                <td><?php echo htmlspecialchars($item['description']); ?></td>
                                <td>$<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></td>
                                <td><?php echo $item['is_available'] ? "<span class='badge bg-success'>Available</span>" : "<span class='badge bg-danger'>Not Available</span>"; ?></td>
                                <td>
                                    <a href="../functions/edit_menu_item.php?id=<?php echo $item['item_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="manage_menu.php?delete_id=<?php echo $item['item_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No menu items found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
