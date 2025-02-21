<?php
require_once "./../init.php";
include '../includes/admin/sidebar.php';
include '../includes/admin/header.php';
$pageTitle = "View Special Offers";

$offers = $db->mysqli->query("
    SELECT so.*, mi.item_name 
    FROM special_offers so
    JOIN menu_items mi ON so.item_id = mi.item_id
    ORDER BY so.start_date DESC
")->fetch_all(MYSQLI_ASSOC);
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
                <div class="row">
                    <div class="col-12 d-flex justify-content-between align-items-center mb-4">
                        <h1>Special Offers</h1>
                        <a href="<?= URL ?>admin/layout/special-offer.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Offer
                        </a>
                    </div>
                    <div class="col-12">
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success">
                                <?= $_SESSION['success']; ?>
                            </div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['errors'])): ?>
                            <?php foreach ($_SESSION['errors'] as $error): ?>
                                <div class="alert alert-danger">
                                    <?= $error; ?>
                                </div>
                            <?php endforeach; ?>
                            <?php unset($_SESSION['errors']); ?>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Menu Item</th>
                                        <th>Discount (%)</th>
                                        <th>Start Date</th>
                                        <th>Expiry Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($offers) > 0): ?>
                                        <?php foreach ($offers as $offer): ?>
                                            <tr>
                                                <td><?= $offer['item_name'] ?></td>
                                                <td><?= $offer['discount_percent'] ?>%</td>
                                                <td><?= date('M d, Y', strtotime($offer['start_date'])) ?></td>
                                                <td><?= date('M d, Y', strtotime($offer['expiry_date'])) ?></td>
                                                <td>
                                                    <a href="<?= URL ?>admin/layout/edit-offer.php?id=<?= $offer['offer_id'] ?>"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a href="<?= URL ?>handlers/admin/delete-offer-handler.php?id=<?= $offer['offer_id'] ?>"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this offer?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No special offers found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
require_once "./../includes/admin/footer.php";
?>