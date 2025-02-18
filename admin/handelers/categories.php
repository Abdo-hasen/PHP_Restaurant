<?php
require_once '../../init.php';


$db = new Database();


$db->table("categories");
// Handle Add Category
if (checkRequestMethod("POST") && checkInput($_POST, 'add_category')) {
    $category_name = $_POST['category_name'];
    $existing = $db->read("*");
    $exists = false;

    foreach ($existing as $category) {
        if ($category['category_name'] === $category_name) {
            $exists = true;
            break;
        }
    }

    if ($exists) {
        echo "<script>alert('already exist!');</script>";
    } else {
         $db->insert(["category_name" => $category_name]);
    }
}

if ( checkInput($_POST, 'edit_category')) {
    $category_id = $_POST['category_id'];
    $category_name =trim( $_POST['category_name']);
    if (!empty($category_name)) {
        $db->update(['category_name' => $category_name], ['category_id' => $category_id]);
    }
}

if (checkRequestMethod("POST") && checkInput($_POST, 'delete_category')) {
    $id = $_POST['category_id'];
    $db->delete($id, 'category_id');
}
$categories = $db->read();
?>