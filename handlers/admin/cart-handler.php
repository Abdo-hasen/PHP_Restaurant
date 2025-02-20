<?php
require_once __DIR__ . "/../../init.php";

if (isset($_POST['add_to_cart'])) {
    $item_id = sanitizeInput($_POST['item_id']);
    $quantity = sanitizeInput($_POST['quantity'] ?? 1);
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id] += $quantity;
    } else {
        $_SESSION['cart'][$item_id] = $quantity;
    }

    $item = $db->table('menu_items')->find($item_id, 'item_id');
    $_SESSION['success'] = "{$item['item_name']} added to cart!";
    redirect(URL . "index.php#menu");
}


if (isset($_GET['remove_from_cart'])) {
    $item_id = sanitizeInput($_GET['remove_from_cart']);
    
    if (isset($_SESSION['cart'][$item_id])) {
        unset($_SESSION['cart'][$item_id]);
        $_SESSION['success'] = "Item removed from cart!";
    }
    
    redirect(URL . "cart.php");
}

if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $item_id => $quantity) {
        $item_id = sanitizeInput($item_id);
        $quantity = sanitizeInput($quantity);
        
        if ($quantity > 0) {
            $_SESSION['cart'][$item_id] = $quantity;
        } else {
            unset($_SESSION['cart'][$item_id]);
        }
    }
    
    $_SESSION['success'] = "Cart updated!";
    redirect(URL . "cart.php");
}