<?php
require_once "../init.php";
header('Content-Type: application/json');

try {
    $conn = new mysqli("localhost", "root", "2001", "restaurant_db");

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE  is_read = 0");
    $stmt->execute();

    echo json_encode(["success" => true]);

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
