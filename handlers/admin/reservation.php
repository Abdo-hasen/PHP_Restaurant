<?php
require_once __DIR__ . "/../../init.php";
// require_once "../../init.php";
$db = new Database();
$db->table("tables");

// Handle Add Table
if (checkRequestMethod("POST") && checkInput($_POST, 'add_table')) {
    $table_number = $_POST['table_number'];
    $capacity = $_POST['capacity'];
    $existing = $db->read("*");
    $exists = false;

    foreach ($existing as $table) {
        if ($table['table_number'] == $table_number) {
            $exists = true;
            break;
        }
    }

    if ($exists) {
        setToastMessage('danger', 'This table is already exist.');
    } else {
        $db->insert([
            "table_number" => $table_number,
            "capacity" => $capacity,
            "status" => 'Available'
        ]);
        setToastMessage('success', 'Table added successfully.');
    }
}

// Handle Edit Table
if (checkRequestMethod("POST") && checkInput($_POST, 'edit_table')) {
    $table_id = $_POST['table_id'];
    $table_number = trim($_POST['table_number']);
    $capacity = trim($_POST['capacity']);
    $status = $_POST['status'];

    if (!empty($table_number) && !empty($capacity)) {
        $db->update([
            'table_number' => $table_number,
            'capacity' => $capacity,
            'status' => $status
        ], ['table_id' => $table_id]);
        setToastMessage('success', 'Table details updated successfully.');
    }
}

// Handle Delete Table
if (checkRequestMethod("POST") && checkInput($_POST, 'delete_table')) {
    $table_id = $_POST['table_id'];
    $db->delete($table_id, 'table_id');
    setToastMessage('success', 'Table deleted successfully.');
}
$tables = $db->read();
$db->table("reservations");
if (checkRequestMethod("POST") && checkInput($_POST, 'add_reservation')) {
    $user_id = $_POST['user_id'];
    $table_id = $_POST['table_id'];
    $reservation_date = $_POST['reservation_date'];
    $time_slot = $_POST['time_slot'];
    $guests = $_POST['guests'];
    $message = $_POST['message'] ?? '';

    $db->table("tables");
    $tableExists = $db->read("*");
    $tableExists = array_filter($tableExists, fn($row) => $row['table_id'] == $table_id);

    $db->table("users");
    $userExists = $db->read("*");
    $userExists = array_filter($userExists, fn($row) => $row['user_id'] == $user_id);

    $db->table("reservations");
    $existingReservation = $db->read("*");
    $existingReservation = array_filter(
        $existingReservation,
        fn($row) =>
        $row['table_id'] == $table_id &&
            $row['reservation_date'] == $reservation_date &&
            $row['time_slot'] == $time_slot
    );


    if (!$tableExists) {
        setToastMessage('danger', 'Selected table does not exist.');
    } elseif (!$userExists) {
        setToastMessage('danger', 'User does not exist.');
    } elseif ($existingReservation) {
        setToastMessage('danger', 'Table is already reserved at this time.');
    } else {
        $db->insert([
            "user_id" => $user_id,
            "table_id" => $table_id,
            "reservation_date" => $reservation_date,
            "time_slot" => $time_slot,
            "guests" => $guests,
            "message" => $message,
            "status" => 'Confirmed'
        ]);
        setToastMessage('success', 'Reservation is added successfully.');
    }
}
if (checkRequestMethod("POST") && checkInput($_POST, 'update_reservation_status')) {
    $reservation_id = $_POST['reservation_id'];
    $new_status = $_POST['new_status'];

    // Update reservation status
    $db->update(['status' => $new_status], ['reservation_id' => $reservation_id]);
    setToastMessage('success', 'Reservation details updated successfully.');
}
if (checkRequestMethod("POST") && checkInput($_POST, 'delete_reservation')) {
    $reservation_id = $_POST['reservation_id'];
    $db->delete($reservation_id, 'reservation_id');
    setToastMessage('success', 'Reservation is deleted successfully.');
}

$reservations = $db->read();

?>
