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
                <li class="nav-item">
                    <a href="../../admin/manage_menu.php">
                        <i class="fas fa-layer-group"></i>
                        <p>Menu Management</p>
                    </a>
                </li>

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
                        <p>Reservations</p>
                    </a>
                </li>

                <!-- User Management -->
                <li class="nav-item">
                    <a href="../../admin/manage_users.php">
                        <i class="fas fa-table"></i>
                        <p>User Management</p>
                    </a>
                </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Snippets</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#email-nav">
                  <i class="far fa-envelope"></i>
                  <p>Email</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="email-nav">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="email-inbox.html">
                        <span class="sub-item">Inbox</span>
                      </a>
                    </li>
                    <li>
                      <a href="email-compose.html">
                        <span class="sub-item">Email Compose</span>
                      </a>
                    </li>
                    <li>
                      <a href="email-detail.html">
                        <span class="sub-item">Email Detail</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#messages-app-nav">
                  <i class="far fa-paper-plane"></i>
                  <p>Messages App</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="messages-app-nav">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="messages.html">
                        <span class="sub-item">Messages</span>
                      </a>
                    </li>
                    <li>
                      <a href="conversations.html">
                        <span class="sub-item">Conversations</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a href="invoice.html">
                  <i class="fas fa-file-invoice-dollar"></i>
                  <p>Invoices</p>
                  <span class="badge badge-count">6</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="pricing.html">
                  <i class="fas fa-tag"></i>
                  <p>Pricing</p>
                  <span class="badge badge-count">6</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="faqs.html">
                  <i class="far fa-question-circle"></i>
                  <p>Faqs</p>
                  <span class="badge badge-count">6</span>
                </a>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#custompages">
                  <i class="fas fa-paint-roller"></i>
                  <p>Custom Pages</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="custompages">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="login.html">
                        <span class="sub-item">Login & Register 1</span>
                      </a>
                    </li>
                    <li>
                      <a href="login2.html">
                        <span class="sub-item">Login & Register 2</span>
                      </a>
                    </li>
                    <li>
                      <a href="login3.html">
                        <span class="sub-item">Login & Register 3</span>
                      </a>
                    </li>
                    <li>
                      <a href="userprofile.html">
                        <span class="sub-item">User Profile</span>
                      </a>
                    </li>
                    <li>
                      <a href="404.html">
                        <span class="sub-item">404</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#submenu">
                  <i class="fas fa-bars"></i>
                  <p>Menu Levels</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="submenu">
                  <ul class="nav nav-collapse">
                    <li>
                      <a data-bs-toggle="collapse" href="#subnav1">
                        <span class="sub-item">Level 1</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnav1">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a data-bs-toggle="collapse" href="#subnav2">
                        <span class="sub-item">Level 1</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnav2">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Level 1</span>
                      </a>
                    </li>
                  </ul>
                </div>
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
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >
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
                    aria-haspopup="true"
                  >
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
                    id="messageDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fa fa-envelope"></i>
                  </a>
                  <ul
                    class="dropdown-menu messages-notif-box animated fadeIn"
                    aria-labelledby="messageDropdown"
                  >
                    <li>
                      <div class="dropdown-title d-flex justify-content-between align-items-center">
                        Messages
                        <a href="#" class="small">Mark all as read</a>
                      </div>
                    </li>
                    <li>
                      <div class="message-notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          <a href="#">
                            <div class="notif-img">
                              <img src="../assets/admin/img/jm_denis.jpg" alt="Img Profile" />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Jimmy Denis</span>
                              <span class="block"> How are you ? </span>
                              <span class="time">5 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img src="../assets/admin/img/chadengle.jpg" alt="Img Profile" />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Chad</span>
                              <span class="block"> Ok, Thanks ! </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img src="../assets/admin/img/mlane.jpg" alt="Img Profile" />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Jhon Doe</span>
                              <span class="block"> Ready for the meeting today... </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img src="../assets/admin/img/talha.jpg" alt="Img Profile" />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Talha</span>
                              <span class="block"> Hi, Apa Kabar ? </span>
                              <span class="time">17 minutes ago</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </li>
                    <li>
                      <a class="see-all" href="javascript:void(0);"
                        >See all messages<i class="fa fa-angle-right"></i>
                      </a>
                    </li>
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
                    aria-expanded="false"
                  >
                    <i class="fa fa-bell"></i>
                    <span class="notification">4</span>
                  </a>
                  <ul
                    class="dropdown-menu notif-box animated fadeIn"
                    aria-labelledby="notifDropdown"
                  >
                    <li>
                      <div class="dropdown-title">You have 4 new notification</div>
                    </li>
                    <li>
                      <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          <a href="#">
                            <div class="notif-icon notif-primary">
                              <i class="fa fa-user-plus"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block"> New user registered </span>
                              <span class="time">5 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-icon notif-success">
                              <i class="fa fa-comment"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block"> Rahmad commented on Admin </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img src="../assets/admin/img/profile2.jpg" alt="Img Profile" />
                            </div>
                            <div class="notif-content">
                              <span class="block"> Reza send messages to you </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-icon notif-danger"><i class="fa fa-heart"></i></div>
                            <div class="notif-content">
                              <span class="block"> Farrah liked Admin </span>
                              <span class="time">17 minutes ago</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </li>
                    <li>
                      <a class="see-all" href="javascript:void(0);"
                        >See all notifications<i class="fa fa-angle-right"></i>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fas fa-layer-group"></i>
                  </a>
                  <div class="dropdown-menu quick-actions animated fadeIn">
                    <div class="quick-actions-header">
                      <span class="title mb-1">Quick Actions</span>
                      <span class="subtitle op-7">Shortcuts</span>
                    </div>
                    <div class="quick-actions-scroll scrollbar-outer">
                      <div class="quick-actions-items">
                        <div class="row m-0">
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-danger rounded-circle">
                                <i class="far fa-calendar-alt"></i>
                              </div>
                              <span class="text">Calendar</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-warning rounded-circle">
                                <i class="fas fa-map"></i>
                              </div>
                              <span class="text">Maps</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-info rounded-circle">
                                <i class="fas fa-file-excel"></i>
                              </div>
                              <span class="text">Reports</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-success rounded-circle">
                                <i class="fas fa-envelope"></i>
                              </div>
                              <span class="text">Emails</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-primary rounded-circle">
                                <i class="fas fa-file-invoice-dollar"></i>
                              </div>
                              <span class="text">Invoice</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-secondary rounded-circle">
                                <i class="fas fa-credit-card"></i>
                              </div>
                              <span class="text">Payments</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
    <a
        class="dropdown-toggle profile-pic"
        data-bs-toggle="dropdown"
        href="#"
        aria-expanded="false"
    >
        <div class="avatar-sm">
            <img
                src="<?php echo !empty($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '../../assets/profile-image/avatar.png'; ?>"
                alt="Profile Picture"
                class="avatar-img rounded-circle"
            />
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
                            src="<?php echo !empty($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '../../assets/profile-image/avatar.png';?>"
                            alt="Profile Picture"
                            class="avatar-img rounded"
                        />
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
                <a class="dropdown-item" href="../../handlers/logout.php">Logout</a>
            </li>
        </div>
    </ul>
</li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>
