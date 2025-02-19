<?php
// var_dump("test");
// die;
require_once "../../init.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $orderId = $data['order_id'];
    $newStatus = $data['status'];
    
    try {
        $db->table('orders')->update(
            ['status' => $newStatus],
            ['order_id' => $orderId]
        );
        
        //  notification (logic here)
        if (in_array($newStatus, ['Ready', 'Delivered'])) {
            $message = "Your order #$orderId status has been updated to $newStatus";
            //  send notification
            // file_put_contents('notifications.log', $message . PHP_EOL, FILE_APPEND);
        }
        
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}