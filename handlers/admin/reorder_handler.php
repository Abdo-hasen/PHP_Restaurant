<?php
require_once "../../init.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    
    // Get order items
    $items = $db->mysqli->query("
        SELECT oi.item_id, oi.quantity, oi.notes
        FROM order_items oi
        WHERE oi.order_id = $orderId
    ")->fetch_all(MYSQLI_ASSOC);
    
    // Clear current cart
    $_SESSION['cart'] = [];
    
    // Add items to cart
    foreach ($items as $item) {
        $_SESSION['cart'][$item['item_id']] = [
            'quantity' => $item['quantity'],
            'notes' => $item['notes']
        ];
    }
    
    $_SESSION['success'] = "Items from order #$orderId have been added to your cart!";
    header("Location: ../../cart.php");
    exit();
} 