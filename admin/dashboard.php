<?php
require_once "../init.php";
restrictToAdmin(); // Restrict access to admin pages
include '../includes/admin/header.php';
include '../includes/admin/sidebar.php';
include '../functions/stats.php';
include '../includes/admin/footer.php';

// Fetch analytics data
$totalOrders = getTotalOrders($db);
$totalRevenue = getTotalRevenue($db);
$mostPopularItem = getMostPopularItem($db);
$activeOrders = getActiveOrders($db);
$totalReservations = getTotalReservations($db);

// Fetch revenue data for the charts
$weeklyRevenue = getWeeklyRevenue($db);
$monthlyRevenue = getMonthlyRevenue($db);
$yearlyRevenue = getYearlyRevenue($db);
?>

<!-- Navbar is included from navbar.php -->
<div class="container">
    <div class="page-inner">
        <div class="page-category">
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
                            <h5 class="card-title">Active Orders</h5>
                            <p class="card-text"><?php echo $activeOrders; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Reservations</h5>
                            <p class="card-text"><?php echo $totalReservations; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs for Weekly, Monthly, and Yearly Revenue -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Revenue Over Time</h5>

                            <!-- Bootstrap 5 Tabs -->
                            <ul class="nav nav-tabs" id="revenueTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="weekly-tab" data-bs-toggle="tab" data-bs-target="#weekly" type="button" role="tab" aria-controls="weekly" aria-selected="true">Weekly Revenue</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly" type="button" role="tab" aria-controls="monthly" aria-selected="false">Monthly Revenue</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="yearly-tab" data-bs-toggle="tab" data-bs-target="#yearly" type="button" role="tab" aria-controls="yearly" aria-selected="false">Yearly Revenue</button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content" id="revenueTabsContent">
                                <!-- Weekly Revenue Tab -->
                                <div class="tab-pane fade show active" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
                                    <canvas id="weeklyChart" width="400" height="200"></canvas>
                                </div>

                                <!-- Monthly Revenue Tab -->
                                <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                    <canvas id="monthlyChart" width="400" height="200"></canvas>
                                </div>

                                <!-- Yearly Revenue Tab -->
                                <div class="tab-pane fade" id="yearly" role="tabpanel" aria-labelledby="yearly-tab">
                                    <canvas id="yearlyChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Weekly Revenue Chart (Days of the Week)
    const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
    const weeklyChart = new Chart(weeklyCtx, {
        type: 'line',
        data: {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            datasets: [{
                label: 'Weekly Revenue',
                data: <?php echo json_encode($weeklyRevenue); ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Monthly Revenue Chart (Weeks of the Month)
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Monthly Revenue',
                data: <?php echo json_encode($monthlyRevenue); ?>,
                borderColor: 'rgba(153, 102, 255, 1)',
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Yearly Revenue Chart (Months of the Year)
    const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
    const yearlyChart = new Chart(yearlyCtx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Yearly Revenue',
                data: <?php echo json_encode($yearlyRevenue); ?>,
                borderColor: 'rgba(255, 159, 64, 1)',
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>