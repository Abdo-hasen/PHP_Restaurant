<?php
require_once "./../../init.php";
$pageTitle = "Special Offer";
require_once ROOT . "./includes/admin/header.php";
$menuItems = $db->table("menu_items")->read();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- Display Success Message -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <!-- Display Error Messages -->
            <?php if (isset($_SESSION['errors'])): ?>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <div class="alert alert-danger">
                        <?= $error; ?>
                    </div>
                <?php endforeach; ?>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title text-center">Add Special Offer</h3>
                </div>
                <div class="card-body">
                    <form action="<?= URL . "admin/handelers/special-offer.php" ?>"  method="POST">
                        <div class="mb-3">
                            <label for="item_id" class="form-label">Select Menu Item</label>
                            <select class="form-select" id="item_id" name="item_id" required>
                                <option value="">Choose a menu item...</option>
                                <?php foreach ($menuItems as $item): ?>
                                    <option value="<?= $item['item_id']; ?>"><?= $item['item_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="discount_percent" class="form-label">Discount Percentage</label>
                            <input type="number" class="form-control" id="discount_percent" name="discount_percent" step="0.01" min="0" max="100" required>
                        </div>


                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Add Offer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once ROOT . "./includes/admin/footer.php";
?>