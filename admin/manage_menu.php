<?php
session_start();

// Redirect to login if not logged in or not an admin
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once "./../init.php"; // Include the initialization file
include './../includes/admin/sidebar.php';
include './../includes/admin/header.php';

// Create a new instance of the Database class
$db = new Database();

// Fetch all menu items
$menu_items = $db->table('menu_items')->read();

// Fetch all categories
$categories = $db->table('categories')->read();

// Function to upload image
function uploadImage($file) {
    $targetDir = "../../assets/admin/uploads/";
    $fileName = basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;

    // Create the directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        return $targetFilePath;
    }
    return false;
}

// Handle adding a new menu item
if (isset($_POST["add_item"])) {
    $category_id = $_POST["category_id"];
    $item_name = $_POST["item_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $is_available = isset($_POST["is_available"]) ? 1 : 0;

    // Upload the image
    $image_url = uploadImage($_FILES["image"]);
    if (!$image_url) {
        echo "<script>alert('Image upload failed!');</script>";
    }

    // Insert the new menu item into the database
    $data = [
        'category_id' => $category_id,
        'item_name' => $item_name,
        'description' => $description,
        'price' => $price,
        'image_url' => $image_url,
        'is_available' => $is_available
    ];

    if ($db->table('menu_items')->insert($data)) {
        echo "<script>alert('New menu item added successfully!'); window.location.href='manage_menu.php';</script>";
    } else {
        echo "<script>alert('Error adding menu item!');</script>";
    }
}

// Handle updating a menu item
if (isset($_POST["update_item"])) {
    $item_id = $_POST["item_id"];
    $category_id = $_POST["category_id"];
    $item_name = $_POST["item_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $is_available = isset($_POST["is_available"]) ? 1 : 0;

    // If a new image is uploaded, update the image URL
    if ($_FILES["image"]["name"] != "") {
        $image_url = uploadImage($_FILES["image"]);
    } else {
        $image_url = $_POST["current_image"];
    }

    // Update the menu item in the database
    $data = [
        'category_id' => $category_id,
        'item_name' => $item_name,
        'description' => $description,
        'price' => $price,
        'image_url' => $image_url,
        'is_available' => $is_available
    ];

    $condition = ['item_id' => $item_id];

    if ($db->table('menu_items')->update($data, $condition)) {
        echo "<script>alert('Menu item updated successfully!'); window.location.href='manage_menu.php';</script>";
    } else {
        echo "<script>alert('Error updating menu item!');</script>";
    }
}

// Handle deleting a menu item
if (isset($_GET["delete"])) {
    $item_id = $_GET["delete"];
    if ($db->table('menu_items')->delete($item_id, 'item_id')) {
        echo "<script>alert('Menu item deleted!'); window.location.href='manage_menu.php';</script>";
    } else {
        echo "<script>alert('Error deleting menu item!');</script>";
    }
}

// Fetch all menu items with their categories
$menu_items = $db->table('menu_items')
    ->join('categories', 'menu_items.category_id = categories.category_id')
    ->select('menu_items.*, categories.category_name')
    ->get();

// Fetch all categories
$categories = $db->table('categories')->select('*')->get();
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
        <div class="container mt-4">

<h2 class="text-center mb-4">Menu Items</h2>

<div class="row">
    <?php foreach ($menu_items as $row): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?= $row['image_url']; ?>" class="card-img-top" alt="<?= $row['item_name']; ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['item_name']; ?></h5>
                    <p class="text-muted"><?= $row['category_name']; ?></p>
                    <p class="card-text"><?= $row['description']; ?></p>
                    <p class="fw-bold">$<?= $row['price']; ?></p>
                    <p><?= $row['is_available'] ? "<span class='badge bg-success'>Available</span>" : "<span class='badge bg-danger'>Not Available</span>"; ?></p>
                    <button class="btn btn-sm btn-warning edit-btn" 
                            data-id="<?= $row['item_id']; ?>"
                            data-category="<?= $row['category_id']; ?>"
                            data-name="<?= $row['item_name']; ?>"
                            data-description="<?= $row['description']; ?>"
                            data-price="<?= $row['price']; ?>"
                            data-image="<?= $row['image_url']; ?>"
                            data-available="<?= $row['is_available']; ?>">
                        Edit
                    </button>
                    <a href="manage_menu.php?delete=<?= $row['item_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
                <option value="<?= $cat['category_id']; ?>"><?= $cat['category_name']; ?></option>
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

<script>
    $(".edit-btn").click(function () {
        $("#form-title").text("Edit Menu Item");
        $("#submit-btn").addClass("d-none");
        $("#update-btn, #cancel-edit").removeClass("d-none");

        $("#item_id").val($(this).data("id"));
        $("#category_id").val($(this).data("category"));
        $("#item_name").val($(this).data("name"));
        $("#description").val($(this).data("description"));
        $("#price").val($(this).data("price"));
        $("#current_image").val($(this).data("image"));
        $("#is_available").prop("checked", $(this).data("available") == 1);
    });

    $("#cancel-edit").click(function () {
        location.reload();
    });
</script>

<?php $db->close(); ?>