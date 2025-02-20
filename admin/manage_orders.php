<?php
require_once "../init.php";
$pageTitle = "Manage Orders";
require_once "./../includes/admin/header.php";

$orders = $db->mysqli->query("
    SELECT o.*, u.full_name, u.email, 
           GROUP_CONCAT(mi.item_name SEPARATOR ', ') AS items
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu_items mi ON oi.item_id = mi.item_id
    GROUP BY o.order_id
    ORDER BY o.created_at DESC
")->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-4">
    <h1 class="mb-4">Manage Orders</h1>

    <!-- Filter -->
    <div class="mb-3">
        <label for="statusFilter" class="form-label">Filter by Status:</label>
        <select class="form-select" id="statusFilter" onchange="filterOrders()">
            <option value="all">All Orders</option>
            <option value="Pending">Pending</option>
            <option value="Preparing">Preparing</option>
            <option value="Ready">Ready</option>
            <option value="Delivered">Delivered</option>
            <option value="Cancelled">Cancelled</option>
        </select>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr data-status="<?= $order['status'] ?>">
                        <td><?= $order['order_id'] ?></td>
                        <td><?= $order['full_name'] ?> (<?= $order['email'] ?>)</td>
                        <td><?= $order['items'] ?></td>
                        <td><?= $order['total_amount'] ?> EGP</td>
                        <td>
                            <select class="form-select status-select" 
                                    data-order-id="<?= $order['order_id'] ?>">
                                <?php 
                                $statuses = ['Pending', 'Preparing', 'Ready', 'Delivered', 'Cancelled'];
                                foreach ($statuses as $status): ?>
                                    <option value="<?= $status ?>" 
                                        <?= $status == $order['status'] ? 'selected' : '' ?>>
                                        <?= $status ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></td>
                        <td>
                            <button class="btn btn-sm btn-info view-details" 
                                    data-order-id="<?= $order['order_id'] ?>">
                                View Details
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="orderDetailsContent"></div>
            </div>
        </div>
    </div>
</div>

<script>

function filterOrders() {
    const status = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        if (status === 'all' || row.getAttribute('data-status') === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Update order status
document.querySelectorAll('.status-select').forEach(select => {
    select.addEventListener('change', function() {
        const orderId = this.getAttribute('data-order-id');
        const newStatus = this.value;
        
        fetch('../handlers/admin/update_order_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId,
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI
                const row = select.closest('tr');
                row.setAttribute('data-status', newStatus);
                
                showToast('success', 'Order status updated successfully');
                
                // update inventory - Do It
                if (newStatus === 'Delivered') {
                    updateInventory(orderId);
                }
            } else {
                showToast('error', 'Failed to update order status');
            }
        });
    });
});

//  order details
document.querySelectorAll('.view-details').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-order-id');
        console.log(`Order details for order ${orderId}`);
        fetch(`../handlers/admin/order_details.php?order_id=${orderId}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('orderDetailsContent').innerHTML = html;
                new bootstrap.Modal('#orderDetailsModal').show();
            });
    });
});

// inventory update - Do It
function updateInventory(orderId) {
    // console.log(`Inventory updated for order ${orderId}`);
}

//  toast notifications
function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" 
                    data-bs-dismiss="toast"></button>
        </div>
    `;
    
    const toastContainer = document.getElementById('toastContainer') || 
        document.body.appendChild(document.createElement('div'));
    toastContainer.id = 'toastContainer';
    toastContainer.style.position = 'fixed';
    toastContainer.style.bottom = '20px';
    toastContainer.style.right = '20px';
    toastContainer.appendChild(toast);
    
    new bootstrap.Toast(toast).show();
}
</script>

<?php
require_once "./../includes/admin/footer.php";
?>