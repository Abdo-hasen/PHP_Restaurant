<?php
require_once "init.php";
require_once "./includes/customer/header.php";
require_once "./includes/customer/nav.php";
include 'includes/customer/footer.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$orders = $db->mysqli->query("
    SELECT o.*, 
           GROUP_CONCAT(mi.item_name SEPARATOR ', ') AS items
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu_items mi ON oi.item_id = mi.item_id
    WHERE o.user_id = $userId
    GROUP BY o.order_id
    ORDER BY o.created_at DESC
")->fetch_all(MYSQLI_ASSOC);
?>

    <!-- show order history -->
    <div class="container-fluid py-5 mt-2">
        <div class="text-center">
            <p class="text-muted mt-3">ORDER HISTORY</p>
            <h2 class="menu-title">My Past <span>Orders</span></h2>
        </div>

        <div class="container mt-5">
            <?php if (!empty($orders)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?= $order['order_id'] ?></td>
                                    <td><?= $order['items'] ?></td>
                                    <td><?= $order['total_amount'] ?> EGP</td>
                                    <td><?= $order['status'] ?></td>
                                    <td><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></td>
                                    <td>
                                        <a href="order_details.php?order_id=<?= $order['order_id'] ?>"
                                            class="btn btn-sm btn-info">
                                            View Details
                                        </a>
                                        <form action="handlers/admin/reorder_handler.php" method="POST" class="d-inline">
                                            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                Reorder
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">You haven't placed any orders yet.</div>
            <?php endif; ?>
        </div>
    </div>