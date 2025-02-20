<?php
require_once "../../init.php";

if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    
    // phone
    $order = $db->mysqli->query("
        SELECT o.*, u.full_name, u.email,
               GROUP_CONCAT(mi.item_name SEPARATOR ', ') AS items
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN menu_items mi ON oi.item_id = mi.item_id
        WHERE o.order_id = $orderId
        GROUP BY o.order_id
    ")->fetch_assoc();
    
    if ($order) {
?>
    <!-- phone -->
        <div class="order-details">
            <h5>Order #<?php echo $order['order_id']; ?></h5>
            <p><strong>Customer:</strong> <?php echo $order['full_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
            <p><strong>Items:</strong> <?php echo $order['items']; ?></p>
            <p><strong>Total Amount:</strong> <?php echo $order['total_amount']; ?> EGP</p>
            <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
            <p><strong>Order Date:</strong> <?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></p>
        </div>
        
        <?php
        // Get order items with details
        $items = $db->mysqli->query("
            SELECT oi.*, mi.item_name, mi.price
            FROM order_items oi
            JOIN menu_items mi ON oi.item_id = mi.item_id
            WHERE oi.order_id = $orderId
        ")->fetch_all(MYSQLI_ASSOC);
        ?>
        
        <h6 class="mt-4">Order Items</h6>
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
                <?php foreach ($items as $item) { ?>
                    <tr>
                        <td><?php echo $item['item_name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo $item['price']; ?> EGP</td>
                        <td><?php echo ($item['notes'] ?: 'N/A'); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
<?php
    } else {
?>
        <div class="alert alert-danger">Order not found</div>
<?php
    }
}
?>