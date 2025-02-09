<?php
// manage_menu.php
require_once '../includes/common/db.php';

// Fetch all menu items
$query = "SELECT * FROM menu_items";
$result = $conn->query($query);
?>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['item_id']; ?></td>
            <td><?php echo $row['item_name']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['category_id']; ?></td>
            <td>
                <a href="edit_menu.php?id=<?php echo $row['item_id']; ?>" class="btn btn-warning">Edit</a>
                <a href="delete_menu.php?id=<?php echo $row['item_id']; ?>" class="btn btn-danger">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>