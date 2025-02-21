<?php
require_once "./../../init.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = sanitizeInput($_POST['item_id']);
    $discount_percent = sanitizeInput($_POST['discount_percent']);
    $start_date = sanitizeInput($_POST['start_date']);
    $expiry_date = sanitizeInput($_POST['expiry_date']);

    $errors = [];


    if (empty($item_id)) {
        $errors[] = "Menu item is required";
    }


    if (empty($discount_percent)) {
        $errors[] = "Discount percentage is required.";
    } elseif (!is_numeric($discount_percent) || $discount_percent < 0 || $discount_percent > 100) {
        $errors[] = "Discount percentage must be a number between 0 and 100";
    }


    if (empty($start_date)) {
        $errors[] = "Start date is required";
    }


    if (empty($expiry_date)) {
        $errors[] = "Expiry date is required";
    } elseif ($expiry_date < $start_date) {
        $errors[] = "Expiry date cannot be earlier than start date";
    }

    if (empty($errors)) {

        $result = $db->table("special_offers")->insert([
            "item_id" => $item_id,
            "discount_percent" => $discount_percent,
            "start_date" => $start_date,
            "expiry_date" => $expiry_date
        ]);
        if ($result) {
            $_SESSION['success'] = "Special offer added successfully!";
            redirect(URL . "admin/view-special-offer.php");
        } else {
            $_SESSION['error'] = "Failed to add special offer.";
            redirect(URL . "admin/layout/special-offer.php");
        }
    } else {
        $_SESSION['errors'] = $errors;
            redirect("./../layout/special-offer.php");
    }
}
