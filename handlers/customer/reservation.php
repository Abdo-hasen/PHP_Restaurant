<?php
require_once __DIR__ . "/../../init.php";
$db = new Database();
$db->table("reservations");

$tablesOptions = "<option value=''>Select Table</option>";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['check_availability'])) {
    $reservation_date = $_POST['reservation_date'];
    $time_slot = $_POST['time_slot'];

    if (empty($reservation_date) || empty($time_slot)) {
        setToastMessage("danger", "Please select a date and time.");
    } else {
        $reservation_end_time = date("H:i:s", strtotime($time_slot . " +1 hour"));

        $reservedTables = $db->read("table_id", "reservation_date = '$reservation_date' AND (
            ('$time_slot' BETWEEN time_slot AND reservation_end_time) OR
            ('$reservation_end_time' BETWEEN time_slot AND reservation_end_time) OR
            (time_slot BETWEEN '$time_slot' AND '$reservation_end_time')
        )");

        $reservedTableIds = array_column($reservedTables, 'table_id');

        $db->table("tables");
        $tables = $db->read("*");

        foreach ($tables as $table) {
            if (!in_array($table['table_id'], $reservedTableIds)) {
                $tablesOptions .= "<option value='{$table['table_id']}'>Table {$table['table_number']} (Capacity: {$table['capacity']})</option>";
            }
        }
    }
    // header("location:__DIR__ . ' ../../index.php#reservation");
    // die;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['book_table'])) {
    if (!isset($_SESSION['user_id'])) {
        setToastMessage("danger", "You must be logged in to book a table.");
    } else {
        $user_id = intval($_SESSION['user_id']);
        $table_id = intval($_POST['table_id']);
        $reservation_date = $_POST['reservation_date'];
        $time_slot = $_POST['time_slot'];
        $guests = intval($_POST['guests']);
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $message = trim($_POST['message']);

        $reservation_end_time = date("H:i:s", strtotime($time_slot . " +1 hour"));

        $existingReservation = $db->read("*", "table_id = $table_id AND reservation_date = '$reservation_date' AND (
            ('$time_slot' BETWEEN time_slot AND reservation_end_time) OR
            ('$reservation_end_time' BETWEEN time_slot AND reservation_end_time) OR
            (time_slot BETWEEN '$time_slot' AND '$reservation_end_time')
        )");

        if (!empty($existingReservation)) {
            setToastMessage("danger", "Sorry, this table is already reserved for that time.");
        } else {
            $insertSuccess = $db->insert([
                "user_id" => $user_id,
                "table_id" => $table_id,
                "reservation_date" => $reservation_date,
                "time_slot" => $time_slot,
                "reservation_end_time" => $reservation_end_time,
                "guests" => $guests,
                "message" => $message
            ]);

            if ($insertSuccess) {
                setToastMessage("success", "Your table reservation is placed!");
                $db->table("notifications")->insert([
                    "user_id" => $user_id,
                    "message" => "Reservation request from user: $user_id!",
                    "user_role" => "customer",
                    "type" => "Reservation"
                ]);

            } else {
                setToastMessage("danger", "Error booking your table. Please try again.");
            }
        }
    }
}
