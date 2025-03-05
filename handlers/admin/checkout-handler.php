<?php
require_once __DIR__ . "/../../init.php";

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['error'] = "Your cart is empty";
    redirect(URL . "cart.php");
}

try {
    $db->mysqli->begin_transaction();

    $total = 0;
    foreach ($_SESSION['cart'] as $item_id => $itemData) {
        $item = $db->table('menu_items')->find($item_id, "item_id");
        $total += $item['price'] * $itemData['quantity'];
    }

    $orderData = [
        'user_id' => $_SESSION['user_id'] ?? null,
        'total_amount' => $total,
        'status' => 'Pending'
    ];

    if ($orderData['user_id'] === null) {
        redirect(URL. "login.php");
    }
    
    //Add Order
    $db->table('orders')->insert($orderData);
    $order_id = $db->mysqli->insert_id;

    //add Order Items
    foreach ($_SESSION['cart'] as $item_id => $itemData) {
        $quantity = $itemData['quantity'];
        $notes = $itemData['notes'];
        
        $orderItemData = [
            'order_id' => $order_id,
            'item_id' => $item_id,
            'quantity' => $quantity,
            'notes' => $notes
        ];
        
        $db->table('order_items')->insert($orderItemData);
    }

    // Add payment
    $paymentData = [
        'order_id' => $order_id,
<<<<<<< HEAD
        'payment_method' => 'Credit/Debit Card',
=======
        'payment_method' => 'Credit/Debit Card', // Use a valid ENUM value
>>>>>>> e52a31900e16cb09d2e2b9c7e1b9b64474617ea0
        'amount' => $total,
        'status' => 'Completed'
    ];
    $db->table('payments')->insert($paymentData);

    $db->mysqli->commit();

    unset($_SESSION['cart']);

    $_SESSION['success'] = "Payment processed successfully!";

    // notifications
    $db->table("notifications")->insert([
        "user_id" => $_SESSION['user_id'], // Use the session variable
        "message" => "Order from user: {$_SESSION['user_id']}!", // Use the session variable
        "user_role" => "customer",
        "type" => "Order"
    ]);

    redirect(URL . "cart.php");
} catch (Exception $e) {
    $db->mysqli->rollback();
    $_SESSION['error'] = "Payment processing failed. Please try again.";
    redirect(URL . "cart.php");
}
