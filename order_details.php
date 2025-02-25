<?php
require_once "init.php";

if (!isset($_GET['order_id'])) {
    header("Location: order_history.php");
    exit();
}

$orderId = $_GET['order_id'];
$userId = $_SESSION['user_id'];

//  order details
$order = $db->mysqli->query("
    SELECT o.*, 
           GROUP_CONCAT(mi.item_name SEPARATOR ', ') AS items
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu_items mi ON oi.item_id = mi.item_id
    WHERE o.order_id = $orderId AND o.user_id = $userId
    GROUP BY o.order_id
")->fetch_assoc();

if (!$order) {
    $_SESSION['error'] = "Order not found";
    header("Location: order_history.php");
    exit();
}

//  order items
$items = $db->mysqli->query("
    SELECT oi.*, mi.item_name, mi.price
    FROM order_items oi
    JOIN menu_items mi ON oi.item_id = mi.item_id
    WHERE oi.order_id = $orderId
")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Resto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php
    require_once "./includes/customer/nav.php";
    ?>
    
    <div class="container-fluid py-5 mt-2">
        <div class="container">
            <h2 class="mb-4">Order #<?= $order['order_id'] ?></h2>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Status:</strong> <?= $order['status'] ?></p>
                    <p><strong>Order Date:</strong> <?= date('M d, Y H:i', strtotime($order['created_at'])) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Total Amount:</strong> <?= $order['total_amount'] ?> EGP</p>
                </div>
            </div>

            <h4>Order Items</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= $item['item_name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= $item['price'] ?> EGP</td>
                            <td><?= $item['notes'] ?: 'No special requests' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a href="order_history.php" class="btn btn-secondary">Back to Order History</a>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html> 