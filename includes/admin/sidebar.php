<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img src="../assets/admin/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a href="./../admin/dashboard.php">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>

              <!-- Menu Management -->
              <!-- <li class="nav-item">
                    <a href="../../admin/manage_menu.php">
                        <i class="fas fa-layer-group"></i>
                        <p>Menu Management</p>
                    </a>
                </li> -->
              <!-- Menu Management Dropdown -->
              <li class="nav-item">
                <a href="../../admin/dashboard.php" data-bs-toggle="collapse" data-bs-target="#menuManagement"> <i class="fas fa-th-list"></i>
                  <p>Menu Management</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="menuManagement">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="../../admin/manage_menu.php">
                        <span class="sub-item">Menu Items</span>
                      </a>
                    </li>
                    <li>
                      <a href="../../admin/categories.php">
                        <span class="sub-item">Categories</span>
                      </a>
                    </li>
                    <li>
                      <a href="../../admin/view-special-offer.php">
                        <span class="sub-item">Special Offers</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>

              <!-- Special Offers -->
              <!-- <li class="nav-item">
                    <a href="../../admin/layout/view-special-offer.php">
                        <i class="fas fa-layer-group"></i>
                        <p>Special Offer</p>
                    </a>
                </li> -->

              <!-- Order Management -->
              <li class="nav-item">
                <a href="../../admin/manage_orders.php">
                  <i class="fas fa-th-list"></i>
                  <p>Order Management</p>
                </a>
              </li>

              <!-- Reservations -->
              <li class="nav-item">
                <a href="../../admin/manage_reservations.php">
                  <i class="fas fa-pen-square"></i>
                  <p>Reservation Management</p>
                </a>
              </li>

              <!-- Reservations -->
              <li class="nav-item">
                <a href="../../admin/inventory.php">
                  <i class="fas fa-pen-square"></i>
                  <p>Inventory Management</p>
                </a>
              </li>
              <!-- Reservations -->
              <li class="nav-item">
                <a href="../../admin/supplier.php">
                  <i class="fas fa-pen-square"></i>
                  <p>Supplier Management</p>
                </a>
              </li>

              <!-- User Management -->
              <li class="nav-item">
                <a href="../../admin/manage_users.php">
                  <i class="fas fa-table"></i>
                  <p>User Management</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.html" class="logo">
                <img src="../assets/admin/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                      <i class="fa fa-search search-icon"></i>
                    </button>
                  </div>
                  <input type="text" placeholder="Search ..." class="form-control" />
                </div>
              </nav>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true">
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input type="text" placeholder="Search ..." class="form-control" />
                      </div>
                    </form>
                  </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="notifDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="notification">4</span>
                  </a>
                  <ul
                    class="dropdown-menu notif-box animated fadeIn"
                    aria-labelledby="notifDropdown">
                    <li>
                      <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          <a href="#">
                              <div class="dropdown">
                                  <button class="btn btn-light position-relative rounded-circle p-2" id="notificationBell" data-bs-toggle="dropdown">
                                      <i class="fas fa-bell fa-lg"></i>
                                      <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill" id="adminNotificationCount"></span>
                                  </button>
                                  <ul class="dropdown-menu dropdown-menu-end shadow-sm p-2" id="adminNotificationDropdown" style="width: 300px; max-height: 300px; overflow-y: auto;">
                                      <li class="text-center text-muted small">No notifications</li>
                                  </ul>
                            </div>
                          </a>
                        </div>
                      </div>
                    </li>
                  </ul>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false">
                    <div class="avatar-sm">
                      <img
                        src="<?php echo !empty($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '../../assets/profile-image/avatar.png'; ?>"
                        alt="Profile Picture"
                        class="avatar-img rounded-circle" />
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?></span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="<?php echo !empty($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '../../assets/profile-image/avatar.png'; ?>"
                              alt="Profile Picture"
                              class="avatar-img rounded" />
                          </div>
                          <div class="u-text">
                            <h4><?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?></h4>
                            <p class="text-muted"><?php echo htmlspecialchars($_SESSION['email'] ?? 'No email'); ?></p>
                            <a href="../../profile.php" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../../profile.php">My Profile</a>
                        <a class="dropdown-item" href="#">My Balance</a>
                        <a class="dropdown-item" href="#">Inbox</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Account Setting</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../../handlers/common/logout.php">Logout</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>