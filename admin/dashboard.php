<?php
// dashboard.php
require_once '../includes/common/db.php';
// echo "Connected to database successfully!";

// Fetch total products
$query = "SELECT COUNT(*) AS total_products FROM menu_items";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$total_products = $row['total_products'];

// Fetch total orders
$query = "SELECT COUNT(*) AS total_orders FROM orders";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$total_orders = $row['total_orders'];

// Fetch monthly orders
$query = "SELECT MONTH(created_at) AS month, COUNT(*) AS orders FROM orders GROUP BY MONTH(created_at)";
$result = $conn->query($query);
$monthly_orders = [];
while ($row = $result->fetch_assoc()) {
    $monthly_orders[$row['month']] = $row['orders'];
}
include '../includes/admin/header.php';
?>

    <div class="content animate__animated animate__fadeInUp">

        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4">
                <div class="card p-3 animate__animated animate__zoomIn">
                    <h5>Products</h5>
                    <p><?php echo $total_products; ?></p>
                    <p class="text-success">Increased 21%</p>
                </div>
                </div>
                <div class="col-md-4">
                <div class="card p-3 animate__animated animate__zoomIn" style="animation-delay: 0.2s;">
                    <h5>Orders</h5>
                    <p><?php echo $total_orders; ?></p>
                    <p class="text-success">Increased 12%</p>
                </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 animate__animated animate__zoomIn" style="animation-delay: 0.4s;">
                        <h5>Revenue</h5>
                        <p>$65,950</p>
                        <p class="text-danger">Decreased 7%</p>
                    </div>
                </div>
            </div>

            <div class="card p-3 animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                <h5>Orders & Revenue</h5>
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('barChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [
                {
                    label: "Orders",
                    backgroundColor: "rgba(75,192,192,0.6)",
                    data: [
                        <?php echo $monthly_orders[1] ?? 0; ?>,
                        <?php echo $monthly_orders[2] ?? 0; ?>,
                        <?php echo $monthly_orders[3] ?? 0; ?>,
                        <?php echo $monthly_orders[4] ?? 0; ?>,
                        <?php echo $monthly_orders[5] ?? 0; ?>,
                        <?php echo $monthly_orders[6] ?? 0; ?>,
                        <?php echo $monthly_orders[7] ?? 0; ?>,
                        <?php echo $monthly_orders[8] ?? 0; ?>,
                        <?php echo $monthly_orders[9] ?? 0; ?>,
                        <?php echo $monthly_orders[10] ?? 0; ?>,
                        <?php echo $monthly_orders[11] ?? 0; ?>,
                        <?php echo $monthly_orders[12] ?? 0; ?>
                    ]
                }
            ]
        }
    });
});
</script>
</body>
</html>
