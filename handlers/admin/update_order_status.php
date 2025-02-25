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
            if ($newStatus== 'Ready'){
                $notif_message = "Your Order Is Ready";
                $user_id= $_SESSION['user_id']; 
                $db->table("notifications")->insert([
                    "user_id" =>  $_SESSION['user_id'],
                    "message" => $notif_message,
                    "user_role" => 'admin'
                ]);
            }
            elseif ($newStatus== 'Delivered') {
                $notif_message = "Your Order Is Delivered";
                $user_id= $_SESSION['user_id']; 
                $db->table("notifications")->insert([
                    "user_id" =>  $_SESSION['user_id'],
                    "message" => $notif_message,
                    "user_role" => 'admin'
                ]);
            }
            elseif ($newStatus== 'Preparing') {
                $notif_message = "Your Order Is Preparing";
                $user_id= $_SESSION['user_id']; 
                $db->table("notifications")->insert([
                    "user_id" =>  $_SESSION['user_id'],
                    "message" => $notif_message,
                    "user_role" => 'admin'
                ]);
            }
        }
        
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}