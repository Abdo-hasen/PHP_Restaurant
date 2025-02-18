<?php
session_start();

// Redirect to login if not logged in or not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../login.php");
    exit();
}

require_once "./../init.php";
include '../includes/admin/sidebar.php';
include '../includes/admin/header.php';
include '../functions/stats.php';

// // Retrieve the logged-in user's name from the session
// $logged_in_user = $_SESSION['user'];

// Fetch analytics data
$totalOrders = getTotalOrders($db);
$totalRevenue = getTotalRevenue($db);
$mostPopularItem = getMostPopularItem($db);
$activeOrders = getActiveOrders($db);
$totalReservations = getTotalReservations($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar is included from navbar.php -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Orders</h5>
                        <p class="card-text"><?php echo $totalOrders; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Revenue</h5>
                        <p class="card-text">$<?php echo number_format($totalRevenue, 2); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Most Popular Item</h5>
                        <p class="card-text"><?php echo $mostPopularItem; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Active Orders</h5>
                        <p class="card-text"><?php echo $activeOrders; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Reservations</h5>
                        <p class="card-text"><?php echo $totalReservations; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>