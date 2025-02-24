<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../init.php';
include '../includes/admin/sidebar.php';
include '../includes/admin/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_inventory"])) {
        $fields = [
            'item_id' => filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT),
            'quantity' => filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT),
            'unit' => filter_input(INPUT_POST, 'unit', FILTER_SANITIZE_STRING),
            'reorder_level' => filter_input(INPUT_POST, 'reorder_level', FILTER_VALIDATE_INT),
            'last_restocked' => date("Y-m-d")
        ];

        $existing = $db->table('inventory')->find($fields['item_id'], 'item_id');
        if ($existing) {
            $fields['quantity'] += $existing['quantity'];
            $condition = ['item_id' => $fields['item_id']];
            $success = $db->table('inventory')->update($fields, $condition);
        } else {
            $success = $db->table('inventory')->insert($fields);
        }
        $_SESSION[$success ? 'success' : 'error'] = $success ? "Inventory updated successfully!" : "Error updating inventory.";
    }
    header("Location: manage_inventory.php");
    exit();
}

$inventory = $db->table('inventory')->read("inventory.*, menu_items.item_name", "JOIN menu_items ON inventory.item_id = menu_items.item_id");
$low_stock_items = $db->table('inventory')->read("inventory.*, menu_items.item_name", "JOIN menu_items ON inventory.item_id = menu_items.item_id WHERE inventory.quantity < inventory.reorder_level");
$menu_items = $db->table('menu_items')->read();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Inventory Management</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"> <?php echo $_SESSION['success'];
            unset($_SESSION['success']); ?> </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"> <?php echo $_SESSION['error'];
            unset($_SESSION['error']); ?> </div>
        <?php endif; ?>

        <?php if (!empty($low_stock_items)): ?>
            <div class="alert alert-danger">
                <strong>Warning!</strong> The following items are low on stock:
                <ul>
                    <?php foreach ($low_stock_items as $row): ?>
                        <li><?php echo htmlspecialchars($row['item_name']); ?> -
                            <?php echo htmlspecialchars($row['quantity']); ?> left</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Reorder Level</th>
                        <th>Last Restocked</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventory as $row): ?>
                        <tr class="<?php echo ($row['quantity'] < $row['reorder_level']) ? 'table-danger' : ''; ?>">
                            <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['unit']); ?></td>
                            <td><?php echo htmlspecialchars($row['reorder_level']); ?></td>
                            <td><?php echo htmlspecialchars($row['last_restocked']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card p-4 mt-4">
        <h3>Add Inventory Item</h3>
        <form action="" method="POST">
            <label>Item:</label>
            <select name="item_id" class="form-control" required>
                <option value="">Select Item</option>
                <?php foreach ($menu_items as $item): ?>
                    <option value="<?php echo $item['item_id']; ?>"> <?php echo htmlspecialchars($item['item_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label>Quantity:</label>
            <input type="number" name="quantity" class="form-control" required><br>

            <label>Unit:</label>
            <input type="text" name="unit" class="form-control" required><br>

            <label>Reorder Level:</label>
            <input type="number" name="reorder_level" class="form-control" required><br>

            <button type="submit" name="add_inventory" class="btn btn-primary">Add Item</button>
        </form>
    </div>
</body>

</html>