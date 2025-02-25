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