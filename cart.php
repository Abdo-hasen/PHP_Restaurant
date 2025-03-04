<?php
require_once "init.php";
require_once "./includes/customer/header.php";
require_once "./includes/customer/nav.php";
include 'includes/customer/footer.php';


// Temporary fix to clear invalid cart data
if (isset($_SESSION['cart']) && !is_array($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}
?>
    
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
                <form action="handlers/admin/cart-handler.php" method="POST">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Special Requests</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            foreach ($_SESSION['cart'] as $item_id => $itemData): 
                               
                                $quantity = $itemData['quantity'];
                                $notes = $itemData['notes'];
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
                                    <td><?= $notes ?: 'No special requests' ?></td>
                                    <td>
                                        <a href="<?= URL ?>handlers/admin/cart-handler.php?remove_from_cart=<?= $item_id ?>" 
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
                            <a href="handlers/admin/checkout-handler.php" class="btn btn-success mb-2">
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
