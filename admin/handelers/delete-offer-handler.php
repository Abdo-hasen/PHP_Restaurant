<?php
require_once "./../../init.php";

if (isset($_GET['id'])) {
    $offer_id = sanitizeInput($_GET['id']);
    
    $condition = ['offer_id' => $offer_id];
    $result = $db->table('special_offers')->delete($condition);
    
    if ($result) {
        $_SESSION['success'] = "Offer deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete offer";
    }
    
    redirect(URL . "/admin/layout/view-special-offer.php");
} else {
    $_SESSION['error'] = "Invalid offer ID";
    redirect(URL . "/admin/layout/view-special-offer.php");
}
