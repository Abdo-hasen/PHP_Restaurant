<?php
require_once "init.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Resto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Resto<span class="text-danger">.</span></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="<?= URL ?>index.php#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= URL ?>index.php#aboutUs">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= URL ?>index.php#menu">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= URL ?>index.php#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= URL ?>index.php#contact">Contact</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL ?>cart.php">
                            <i class="fas fa-shopping-cart"></i> Cart
                            <?php if (!empty($_SESSION['cart'])): ?>
                                <span class="badge bg-danger"><?= array_sum($_SESSION['cart']) ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
            </div>

            <a href="<?= URL ?>index.php#reservation" class="btn btn-book">Book a Table</a>
        </div>
    </nav>

    
    <div class="container-fluid py-5 mt-2" id="cart" >
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success text-center"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <div class="text-center">
            <p class="text-muted mt-3">YOUR CART</p>
            <h2 class="menu-title">Review Your <span>Order</span></h2>
        </div>
        
        <div class="container mt-5">
            <?php if (!empty($_SESSION['cart'])): ?>
                <form action="<?= URL ?>admin/handelers/cart-handler.php" method="POST">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            foreach ($_SESSION['cart'] as $item_id => $quantity): 
                                $item = $db->table('menu_items')->find($item_id, "item_id");
                                $itemTotal = $item['price'] * $quantity;
                                $total += $itemTotal;
                            ?>
                                <tr>
                                    <td><?= $item['item_name'] ?></td>
                                    <td><?= $item['price'] ?> EGP</td>
                                    <td>
                                        <input type="number" name="quantities[<?= $item_id ?>]" 
                                               value="<?= $quantity ?>" min="1" class="form-control">
                                    </td>
                                    <td><?= $itemTotal ?> EGP</td>
                                    <td>
                                        <a href="<?= URL ?>admin/handelers/cart-handler.php?remove_from_cart=<?= $item_id ?>" 
                                           class="btn btn-danger btn-sm">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total</th>
                                <th colspan="2"><?= $total ?> EGP</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-center mt-4">
                        <div class="d-grid gap-2 d-md-block">
                            <button type="submit" name="update_cart" class="btn btn-warning me-2 mb-2">
                                <i class="fas fa-sync-alt"></i> Update Cart
                            </button>
                            <a href="<?= URL ?>admin/handelers/checkout-handler.php" class="btn btn-success mb-2">
                                <i class="fas fa-credit-card"></i> Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-info">Your cart is empty</div>
            <?php endif; ?>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
