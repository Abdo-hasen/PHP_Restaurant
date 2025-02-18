<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "restaurant_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 
function uploadImage($file) {
    $targetDir = "uploads/";
    $fileName = basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;

    
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

   
    if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        return $targetFilePath;
    }
    return false;
}


if (isset($_POST["add_item"])) {
    $category_id = $_POST["category_id"];
    $item_name = $_POST["item_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $is_available = isset($_POST["is_available"]) ? 1 : 0;

    
    $image_url = uploadImage($_FILES["image"]);
    if (!$image_url) {
        echo "<script>alert('Image upload failed!');</script>";
    }

    $sql = "INSERT INTO menu_items (category_id, item_name, description, price, image_url, is_available) 
            VALUES ('$category_id', '$item_name', '$description', '$price', '$image_url', '$is_available')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New menu item added successfully!'); window.location.href='manage_menu.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}


if (isset($_POST["update_item"])) {
    $item_id = $_POST["item_id"];
    $category_id = $_POST["category_id"];
    $item_name = $_POST["item_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $is_available = isset($_POST["is_available"]) ? 1 : 0;

   
    if ($_FILES["image"]["name"] != "") {
        $image_url = uploadImage($_FILES["image"]);
    } else {
        $image_url = $_POST["current_image"];
    }

    $sql = "UPDATE menu_items SET 
            category_id='$category_id', item_name='$item_name', description='$description', 
            price='$price', image_url='$image_url', is_available='$is_available' 
            WHERE item_id='$item_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Menu item updated successfully!'); window.location.href='manage_menu.php';</script>";
    } else {
        echo "<script>alert('Error updating: " . $conn->error . "');</script>";
    }
}


if (isset($_GET["delete"])) {
    $item_id = $_GET["delete"];
    $conn->query("DELETE FROM menu_items WHERE item_id = $item_id");
    echo "<script>alert('Menu item deleted!'); window.location.href='manage_menu.php';</script>";
}


$menu_items = $conn->query("SELECT menu_items.*, categories.category_name 
                            FROM menu_items 
                            JOIN categories ON menu_items.category_id = categories.category_id");


$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="container mt-4">

    <h2 class="text-center mb-4">Menu Items</h2>

    
    <div class="row">
        <?php while ($row = $menu_items->fetch_assoc()): ?>
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
        <?php endwhile; ?>
    </div>

  
    <div class="card p-4">
        <h3 id="form-title">Add New Item</h3>
        <form id="menu-form" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="item_id" id="item_id">
            <input type="hidden" name="current_image" id="current_image">

            <label>Category:</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                <?php while ($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['category_id']; ?>"><?= $cat['category_name']; ?></option>
                <?php endwhile; ?>
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
        });

        $("#cancel-edit").click(function () {
            location.reload();
        });
    </script>

</body>
</html>

<?php $conn->close(); ?>
