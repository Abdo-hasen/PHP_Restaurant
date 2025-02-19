<?php
require_once "./../../init.php";
$pageTitle = "Edit Special Offer";
require_once "./../../includes/admin/header.php";

// Get offer ID from URL
$offer_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch the offer data
// $offer = $db->table("special_offers")
//     ->join("menu_items", "special_offers.item_id = menu_items.item_id")
//     ->where("offer_id", $offer_id)
//     ->first();

$query = "SELECT special_offers.*, menu_items.item_name AS item_name 
    FROM special_offers 
    JOIN menu_items ON special_offers.item_id = menu_items.item_id
    WHERE special_offers.offer_id = $offer_id";
$result = $db->mysqli->query($query);
$offer = $result->fetch_assoc();

if (!$offer) {
    $_SESSION['error'] = "Offer not found";
    redirect(URL . "admin/layout/view-special-offer.php");
}

// Fetch menu items for dropdown
$menuItems = $db->table("menu_items")->read();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title text-center">Edit Special Offer</h3>
                </div>
                <div class="card-body">
                    <form action="<?= URL . "admin/handelers/edit-offer-handler.php" ?>" method="POST">
                        <input type="hidden" name="offer_id" value="<?= $offer['offer_id'] ?>">

                        <div class="mb-3">
                            <label for="item_id" class="form-label">Menu Item</label>
                            <select class="form-select" id="item_id" name="item_id" required>
                                <?php foreach ($menuItems as $item): ?>
                                    <option value="<?= $item['item_id'] ?>"
                                        <?= $item['item_id'] == $offer['item_id'] ? 'selected' : '' ?>>
                                        <?= $item['item_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="discount_percent" class="form-label">Discount Percentage</label>
                            <input type="number" class="form-control" id="discount_percent"
                                name="discount_percent" value="<?= $offer['discount_percent'] ?>"
                                step="0.01" min="0" max="100" required>
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date"
                                name="start_date" value="<?= $offer['start_date'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="expiry_date"
                                name="expiry_date" value="<?= $offer['expiry_date'] ?>" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Offer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once "./../../includes/admin/footer.php";
?>