<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "restaurant_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST["add_inventory"])) {
    $item_id = $_POST["item_id"];
    $quantity = $_POST["quantity"];
    $unit = $_POST["unit"];
    $reorder_level = $_POST["reorder_level"];
    $last_restocked = date("Y-m-d");

    $sql = "INSERT INTO inventory (item_id, quantity, unit, reorder_level, last_restocked) 
            VALUES ('$item_id', '$quantity', '$unit', '$reorder_level', '$last_restocked') 
            ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity), last_restocked = VALUES(last_restocked)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Inventory updated successfully!'); window.location.href='inventory.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}


$inventory = $conn->query("SELECT inventory.*, menu_items.item_name FROM inventory JOIN menu_items ON inventory.item_id = menu_items.item_id");


$low_stock_items = $conn->query("SELECT inventory.*, menu_items.item_name FROM inventory JOIN menu_items ON inventory.item_id = menu_items.item_id WHERE inventory.quantity < inventory.reorder_level");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2 class="text-center mb-4">Inventory Management</h2>
    
    <?php if ($low_stock_items->num_rows > 0): ?>
    <div class="alert alert-danger">
        <strong>Warning!</strong> The following items are low on stock:
        <ul>
            <?php while ($row = $low_stock_items->fetch_assoc()): ?>
                <li><?= $row['item_name']; ?> - <?= $row['quantity']; ?> left</li>
            <?php endwhile; ?>
        </ul>
    </div>
    <?php endif; ?>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Reorder Level</th>
                <th>Last Restocked</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $inventory->fetch_assoc()): ?>
                <tr class="<?= ($row['quantity'] < $row['reorder_level']) ? 'table-danger' : ''; ?>">
                    <td><?= $row['item_name']; ?></td>
                    <td><?= $row['quantity']; ?></td>
                    <td><?= $row['unit']; ?></td>
                    <td><?= $row['reorder_level']; ?></td>
                    <td><?= $row['last_restocked']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    
    <div class="card p-4">
        <h3>Add Inventory Item</h3>
        <form action="" method="POST">
            <label>Item:</label>
            <select name="item_id" class="form-control" required>
                <option value="">Select Item</option>
                <?php 
                $menu_items = $conn->query("SELECT * FROM menu_items");
                while ($item = $menu_items->fetch_assoc()): ?>
                    <option value="<?= $item['item_id']; ?>"> <?= $item['item_name']; ?> </option>
                <?php endwhile; ?>
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
<?php $conn->close(); ?>
