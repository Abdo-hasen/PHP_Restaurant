<?php

require_once "../init.php"; 
header('Content-Type: application/json');

if (!isset($_SESSION["user_id"])) {  
    echo json_encode([]);
    exit();
}

try {
    
    $conn = new mysqli("localhost", "root", "2001", "restaurant_db");

   
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $user_id = intval($_SESSION["user_id"]); 
    $stmt = $conn->prepare("SELECT * FROM notifications WHERE user_role = 'admin' AND is_read = '0' ORDER BY created_at DESC");
    // $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $notifications = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($notifications as &$notification) {
        $notification["message"] = htmlspecialchars($notification["message"]);
    }

    echo json_encode($notifications);

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
