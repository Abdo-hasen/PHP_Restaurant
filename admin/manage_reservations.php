<?php
require_once '../init.php';
include '../includes/admin/sidebar.php';
include '../includes/admin/header.php';
require_once "../handlers/admin/reservation.php";
?>

<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h4 class="page-title">Dashboard</h4>
      <ul class="breadcrumbs">
        <li class="nav-home">
          <a href="#">
            <i class="icon-home"></i>
          </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="#">Pages</a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="#">Starter Page</a>
        </li>
      </ul>
    </div>
    <div class="page-category">
    <div class="container mt-5">
<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary p-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Admin Dashboard</a>
        <div class="dropdown">
            <button class="btn btn-light position-relative rounded-circle p-2" id="notificationBell" data-bs-toggle="dropdown">
                <i class="fas fa-bell fa-lg"></i>
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill" id="adminNotificationCount"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm p-2" id="adminNotificationDropdown" style="width: 300px; max-height: 300px; overflow-y: auto;">
                <li class="text-center text-muted small">No notifications</li>
            </ul>
        </div>
    </div>
</nav> -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Manage Restaurant Tables</h2>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Add New Table</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Table Number</label>
                        <input type="number" name="table_number" class="form-control" required min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Capacity</label>
                        <input type="number" name="capacity" class="form-control" required min="1">
                    </div>
                    <button type="submit" name="add_table" class="btn btn-success">Add Table</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-dark text-white">Existing Tables</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Table Number</th>
                            <th class="text-center">Capacity</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $id = 1 ?>
                        <?php foreach ($tables as $table): ?>
                            <tr>
                                <td class="text-center"><?= $id++ ?></td>
                                <td class="text-center"><?= $table['table_number']; ?></td>
                                <td class="text-center"><?= $table['capacity']; ?></td>
                                <td class="text-center"><?= $table['status']; ?></td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" onclick="setEditModalData(<?= $table['table_id']; ?>, '<?= $table['table_number']; ?>', '<?= $table['capacity']; ?>', '<?= $table['status']; ?>')">Edit</button>
                                    <form method="POST" style="display:inline-block;">
                                        <input type="hidden" name="table_id" value="<?= $table['table_id']; ?>">
                                        <button type="submit" name="delete_table" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Table Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Table</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="table_id" id="edit_table_id">
                        <div class="mb-3">
                            <label class="form-label">Table Number</label>
                            <input type="number" name="table_number" id="edit_table_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Capacity</label>
                            <input type="number" name="capacity" id="edit_capacity" class="form-control" required>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="edit_status" class="form-control">
                                <option value="Available">Available</option>
                                <option value="Reserved">Reserved</option>
                            </select>
                        </div>
                        <button type="submit" name="edit_table" class="btn btn-primary">Update Table</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- resevation -->
    <div class="container mt-5">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">Add New Reservation</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">User ID</label>
                        <input type="number" name="user_id" class="form-control" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reservation Date</label>
                        <input type="date" name="reservation_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Time Slot</label>
                        <input type="time" name="time_slot" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Table ID</label>
                        <input type="number" name="table_id" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guests</label>
                        <input type="number" name="guests" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control"></textarea>
                    </div>
                    <button type="submit" name="add_reservation" class="btn btn-success">Add Reservation</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-dark text-white">Reservations</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">User ID</th>
                            <th class="text-center">Table ID</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Time Slot</th>
                            <th class="text-center">Guests</th>
                            <th>status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <td class="text-center"><?= $reservation['reservation_id']; ?></td>
                                <td class="text-center"><?= $reservation['user_id']; ?></td>
                                <td class="text-center"><?= $reservation['table_id']; ?></td>
                                <td class="text-center"><?= $reservation['reservation_date']; ?></td>
                                <td class="text-center"><?= $reservation['time_slot']; ?></td>
                                <td class="text-center"><?= $reservation['guests']; ?></td>
                                <td class="text-center"><?= $reservation['status']; ?></td>
                                <td rowspan="2" class="text-center align-middle">
                                    <form method="POST">
                                        <input type="hidden" name="reservation_id" value="<?= $reservation['reservation_id']; ?>">
                                        <input type="hidden" name="new_status" value="accepted">
                                        <button type="submit" name="update_reservation_status" id="accept-btn-<?= $reservation['reservation_id']; ?>"
                                            class="btn btn-success btn-sm w-100">
                                            Accept
                                        </button>
                                    </form>

                                    <form method="POST">
                                        <input type="hidden" name="reservation_id" value="<?= $reservation['reservation_id']; ?>">
                                        <input type="hidden" name="new_status" value="rejected">
                                        <button type="submit" name="update_reservation_status" id="reject-btn-<?= $reservation['reservation_id']; ?>"
                                            class="btn btn-primary btn-sm w-100 mt-1">
                                            Reject
                                        </button>
                                    </form>
                                    <form method="POST">
                                        <input type="hidden" name="reservation_id" value="<?= $reservation['reservation_id']; ?>">
                                        <button type="submit" name="delete_reservation" class="btn btn-danger btn-sm w-100 mt-1">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7"><strong>Message:</strong> <?= $reservation['message']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php showToast(); ?>

        <script>
            function setEditModalData(id, number, capacity, status) {
                document.getElementById('edit_table_id').value = id;
                document.getElementById('edit_table_number').value = number;
                document.getElementById('edit_capacity').value = capacity;
                document.getElementById('edit_status').value = status;
            }
            document.getElementById("notificationBell").addEventListener("click", async function() {
    let response = await fetch("../functions/mark_all_notifications_read.php", { method: "POST" });

    if (response.ok) {
        document.getElementById("adminNotificationCount").textContent = ""; 
        setTimeout(() => {
            loadAdminNotifications();
        }, 40000); 
    }
});
            async function loadAdminNotifications() {
            let response = await fetch("../functions/fetch_notifications_admin.php");
            let notifications = await response.json();

            let dropdown = document.getElementById("adminNotificationDropdown");
            let count = document.getElementById("adminNotificationCount");

            dropdown.innerHTML = "";
            count.textContent = notifications.length;
            console.log(notifications);

            if (notifications.length === 0) {
                dropdown.innerHTML = '<li class="dropdown-item text-muted">There is no Notifications</li>';
                document.getElementById("adminNotificationCount").textContent = "";
            } else {
                notifications.forEach(notification => {
                    let li = document.createElement("li");
                    li.className = "dropdown-item";
                    li.textContent = notification.message;
                    dropdown.appendChild(li);
                });
            }
        }
        document.getElementById("notificationBell").addEventListener("click", async function() {

            document.getElementById("adminNotificationCount").textContent = "";
        });


        loadAdminNotifications();
        setInterval(loadAdminNotifications, 5000);
        </script>

</body>

</html>