<?php
function getTotalOrders($db) {
    $result = $db->table('orders')->read();
    return count($result);
}

function getTotalRevenue($db) {
    $orders = $db->table('orders')->read();
    $totalRevenue = 0;
    foreach ($orders as $order) {
        $totalRevenue += $order['total_amount'];
    }
    return $totalRevenue;
}

function getMostPopularItem($db) {
    $orderItems = $db->table('order_items')->read();
    $itemCounts = [];
    foreach ($orderItems as $item) {
        $itemId = $item['item_id'];
        if (isset($itemCounts[$itemId])) {
            $itemCounts[$itemId]++;
        } else {
            $itemCounts[$itemId] = 1;
        }
    }
    if (!empty($itemCounts)) {
        $mostPopularItemId = array_keys($itemCounts, max($itemCounts))[0];
        $mostPopularItem = $db->table('menu_items')->find($mostPopularItemId, 'item_id');
        return $mostPopularItem['item_name'];
    }
    return "No items ordered yet.";
}

function getActiveOrders($db) {
    $orders = $db->table('orders')->read();
    $activeOrders = 0;
    foreach ($orders as $order) {
        if ($order['status'] !== 'Delivered') {
            $activeOrders++;
        }
    }
    return $activeOrders;
}

function getTotalReservations($db) {
    $reservations = $db->table('reservations')->read();
    return count($reservations);
}
?>