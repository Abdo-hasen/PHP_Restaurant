<?php
require_once __DIR__ . "/../../init.php";

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['error'] = "Your cart is empty";
    redirect(URL . "cart.php");
}

$total = 0;
foreach ($_SESSION['cart'] as $item_id => $quantity) {
    $item = $db->table('menu_items')->find($item_id, "item_id");
    $total += $item['price'] * $quantity;
}

try {
    $db->mysqli->begin_transaction();

    $orderData = [
        'user_id' => $_SESSION['user_id'] ?? 1, //handel login and remove 1 
        'total_amount' => $total,
        'status' => 'Pending'
    ];
    $db->table('orders')->insert($orderData);
    $order_id = $db->mysqli->insert_id;


    foreach ($_SESSION['cart'] as $item_id => $quantity) {
        $orderItemData = [
            'order_id' => $order_id,
            'item_id' => $item_id,
            'quantity' => $quantity
        ];
        $db->table('order_items')->insert($orderItemData);
    }

    $paymentData = [
        'order_id' => $order_id,
        'payment_method' => 'Credit Card', 
        'amount' => $total,
        'status' => 'Completed'
    ];
    $db->table('payments')->insert($paymentData);

    $db->mysqli->commit();


    unset($_SESSION['cart']);
    
    $_SESSION['success'] = "Payment processed successfully!";
    redirect(URL . "cart.php");

} catch (Exception $e) {
    $db->mysqli->rollback();
    $_SESSION['error'] = "Payment processing failed. Please try again.";
    redirect(URL . "cart.php");
}
