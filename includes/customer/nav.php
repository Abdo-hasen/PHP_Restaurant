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
                    <?php if (isAdmin()): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= URL ?>admin/dashboard.php">Admin Dashboard</a></li>
                    <?php endif; ?>
                </ul>
            </div>
                        <!-- Profile Dropdown -->
            <div class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <span>Profile</span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <a class="dropdown-item" href="profile.php">My Profile</a>
                            <a class="dropdown-item" href="order_history.php">Order History</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="handlers/common/logout.php">Logout</a>
                        </li>
                    </div>
                </ul>
            </div>

            <a href="#reservation" class="btn btn-book">Book a Table</a>
            <div class="dropdown">
                <button class="btn btn-light position-relative rounded-circle p-2" id="notificationBell" data-bs-toggle="dropdown">
                    <i class="fas fa-bell fa-lg"></i>
                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill" id="notificationCount"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm p-2" id="notificationDropdown" style="width: 300px; max-height: 300px; overflow-y: auto;">
                    <li class="text-center text-muted small">No notifications</li>
                </ul>
            </div>
        </div>
    </nav>        </div>
    </nav>