<?php
require_once "./../init.php"; 
include './../includes/admin/header.php';
include './../includes/admin/sidebar.php';


$db = new Database();


$menu_items = $db->table('menu_items')->read();
$categories = $db->table('categories')->read();


function uploadImage($file)
{
    $targetDir = "../../assets/admin/uploads/";
    $fileName = basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    return move_uploaded_file($file["tmp_name"], $targetFilePath) ? $targetFilePath : false;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $category_id = $_POST["category_id"];
    $item_name = $_POST["item_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $is_available = isset($_POST["is_available"]) ? 1 : 0;
    $image_url = isset($_FILES["image"]) && $_FILES["image"]["name"] ? uploadImage($_FILES["image"]) : "";

    $data = [
        'category_id' => $category_id,
        'item_name' => $item_name,
        'description' => $description,
        'price' => $price,
        'image_url' => $image_url,
        'is_available' => $is_available
    ];

    if (isset($_POST["add_item"])) {
        if ($db->table('menu_items')->insert($data)) {
            echo "<script>alert('New menu item added successfully!'); window.location.href='manage_menu.php';</script>";
        } else {
            echo "<script>alert('Error adding menu item!');</script>";
        }
    } elseif (isset($_POST["update_item"])) {
        $item_id = $_POST["item_id"];
        if (!$image_url) {
            $image_url = $_POST["current_image"];
        }
        $data['image_url'] = $image_url;

        $condition = ['item_id' => $item_id];
        if ($db->table('menu_items')->update($data, $condition)) {
            echo "<script>alert('Menu item updated successfully!'); window.location.href='manage_menu.php';</script>";
        } else {
            echo "<script>alert('Error updating menu item!');</script>";
        }
    }
}


if (isset($_GET["delete"])) {
    $item_id = $_GET["delete"];
    if ($db->table('menu_items')->delete($item_id, 'item_id')) {
        echo "<script>alert('Menu item deleted!'); window.location.href='manage_menu.php';</script>";
    } else {
        echo "<script>alert('Error deleting menu item!');</script>";
    }
}


$menu_items = $db->table('menu_items')
    ->join('categories', 'menu_items.category_id = categories.category_id')
    ->select('menu_items.*, categories.category_name')
    ->get();
?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h2 class="page-title">Manage Menu Items</h2>
        </div>
        <div class="page-category">

                <div class="row">
                    <?php foreach ($menu_items as $row): ?>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img src="<?= htmlspecialchars($row['image_url']); ?>" class="card-img-top"
                                     alt="<?= htmlspecialchars($row['item_name']); ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($row['item_name']); ?></h5>
                                    <p class="text-muted"><?= htmlspecialchars($row['category_name']); ?></p>
                                    <p class="card-text"><?= htmlspecialchars($row['description']); ?></p>
                                    <p class="fw-bold">$<?= htmlspecialchars($row['price']); ?></p>
                                    <p><?= $row['is_available'] ? "<span class='badge bg-success'>Available</span>" : "<span class='badge bg-danger'>Not Available</span>"; ?></p>
                                    <button class="btn btn-sm btn-warning edit-btn"
                                            data-id="<?= $row['item_id']; ?>"
                                            data-category="<?= $row['category_id']; ?>"
                                            data-name="<?= htmlspecialchars($row['item_name']); ?>"
                                            data-description="<?= htmlspecialchars($row['description']); ?>"
                                            data-price="<?= $row['price']; ?>"
                                            data-image="<?= $row['image_url']; ?>"
                                            data-available="<?= $row['is_available']; ?>">
                                        Edit
                                    </button>
                                    <a href="manage_menu.php?delete=<?= $row['item_id']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="card p-4">
                    <h3 id="form-title">Add New Item</h3>
                    <form id="menu-form" action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="item_id" id="item_id">
                        <input type="hidden" name="current_image" id="current_image">

                        <label>Category:</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['category_id']; ?>"><?= htmlspecialchars($cat['category_name']); ?></option>
                            <?php endforeach; ?>
                        </select><br>

                        <label>Item Name:</label>
                        <input type="text" name="item_name" id="item_name" class="form-control" required><br>

                        <label>Description:</label>
                        <textarea name="description" id="description" class="form-control" required></textarea><br>

                        <label>Price:</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" required><br>

                        <label>Image:</label>
                        <input type="file" name="image" id="image" class="form-control"><br>

                        <label>Available:</label>
                        <input type="checkbox" name="is_available" id="is_available"><br><br>

                        <button type="submit" name="add_item" id="submit-btn" class="btn btn-primary">Add Item</button>
                        <button type="submit" name="update_item" id="update-btn" class="btn btn-success d-none">Update Item</button>
                        <button type="button" id="cancel-edit" class="btn btn-secondary d-none">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            document.getElementById("form-title").innerText = "Edit Menu Item";
            document.getElementById("submit-btn").classList.add("d-none");
            document.getElementById("update-btn").classList.remove("d-none");
            document.getElementById("cancel-edit").classList.remove("d-none");

            document.getElementById("item_id").value = this.dataset.id;
            document.getElementById("category_id").value = this.dataset.category;
            document.getElementById("item_name").value = this.dataset.name;
            document.getElementById("description").value = this.dataset.description;
            document.getElementById("price").value = this.dataset.price;
            document.getElementById("current_image").value = this.dataset.image;
            document.getElementById("is_available").checked = this.dataset.available == 1;
        });
    });

    document.getElementById("cancel-edit").addEventListener("click", function () {
        location.reload();
    });
</script>

<?php 
// $db->close();

//anyone checks this ???!!!
 ?>
