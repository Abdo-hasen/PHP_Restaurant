<?php
require_once "./../../init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $offer_id = sanitizeInput($_POST['offer_id']);
    $item_id = sanitizeInput($_POST['item_id']);
    $discount_percent = sanitizeInput($_POST['discount_percent']);
    $start_date = sanitizeInput($_POST['start_date']);
    $expiry_date = sanitizeInput($_POST['expiry_date']);

    $errors = [];

    
    if (empty($item_id)) {
        $errors[] = "Menu item is required";
    }
    if (empty($discount_percent) || !is_numeric($discount_percent) || $discount_percent < 0 || $discount_percent > 100) {
        $errors[] = "Discount percentage must be between 0 and 100";
    }
    if (empty($start_date)) {
        $errors[] = "Start date is required";
    }
    if (empty($expiry_date) || $expiry_date < $start_date) {
        $errors[] = "Expiry date must be after start date";
    }

    if (empty($errors)) {
        $data = [
            "item_id" => $item_id,
            "discount_percent" => $discount_percent,
            "start_date" => $start_date,
            "expiry_date" => $expiry_date
        ];

        $condition = ['offer_id' => $offer_id];
        $result = $db->table('special_offers')->update($data, $condition);


        if ($result) {
            $_SESSION['success'] = "Offer updated successfully!";
            redirect(URL . "admin/view-special-offer.php");
        } else {
            $_SESSION['error'] = "Failed to update offer";
            redirect(URL . "admin/layout/edit-offer.php?id=" . $offer_id);
        }
    } else {
        $_SESSION['errors'] = $errors;
        redirect(URL . "admin/layout/edit-offer.php?id=" . $offer_id);
    }
}
