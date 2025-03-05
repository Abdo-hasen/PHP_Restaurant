<?php
require_once "init.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "./handlers/customer/reservation.php";
require_once "./includes/customer/header.php";
require_once "./includes/customer/nav.php";

$menu = $db->table("menu_items")->read();

//active offer
$specialOffers = $db->mysqli->query("
    SELECT so.* 
    FROM special_offers so
    WHERE so.start_date <= CURDATE() AND so.expiry_date >= CURDATE()
")->fetch_all(MYSQLI_ASSOC);


$discountMap = [];
foreach ($specialOffers as $offer) {
    $discountMap[$offer['item_id']] = $offer;
}
?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<!-- home -->
<section class="hero-section" id="home">
    <div class="hero-overlay">
        <h1 class="hero-title">RESTO <br> Restaurant</h1>
        <p class="hero-text">Experience the rich flavors of tradition and passion in every dish. Indulge in an unforgettable dining experience at Resto Restaurant.</p>
    </div>
</section>



<!-- About Us -->
<div class="container py-5" id="aboutUs">
    <div class="text-center">
        <p class="text-muted">ABOUT US</p>
        <h2 class="about-title">Learn More <span>About Us</span></h2>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <img src="/assets/customer/images/about1.jpg" class="img-fluid rounded" alt="Restaurant Image">
        </div>

        <div class="col-md-6">
            <p class="fst-italic text-muted">
                Welcome to Resto Restaurant, where the rich flavors of authentic Egyptian cuisine come alive! Located in the heart of Port Said, we take pride in serving traditional Egyptian dishes made with fresh, high-quality ingredients and a touch of home-cooked warmth.

                From the sizzling grilled kebabs to the comforting koshari, every bite at Resto Restaurant is a journey through Egypt's culinary heritage. Our chefs bring passion and tradition to every dish, ensuring an experience that feels both nostalgic and unforgettable.

                Whether you're craving a classic Molokhia, a hearty Fattah, or a sweet Basbousa, we've got something special for everyone. At Resto Restaurant, we don't just serve food – we share culture, tradition, and a true taste of Egypt.

                Come visit us and let your taste buds explore the magic of Egyptian flavors!
            </p>
            <div class="about-title text-center">
                <span>"Resto Restaurant – A Taste of Egypt, A Taste of Home!"</span>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 my-auto">
            <div class="book-table">
                <p>Book a Table</p>
                <span>+1 5589 55488 55</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="video-container">
                <img src="assets/customer/images/about2.avif" class="img-fluid rounded" alt="Food Video">
                <i class="fas fa-play-circle"></i>
            </div>
        </div>
    </div>
</div>



<!-- Menu -->
<div class="container py-5" id="menu">
    <div class="text-center">
        <p class="text-muted">OUR MENU</p>
        <h2 class="menu-title">Check Our <span>Delicious Menu</span></h2>
    </div>

    <div class="row mt-4">
        <?php foreach ($menu as $item): ?>
            <?php
            $isDiscounted = isset($discountMap[$item['item_id']]);
            $discountPercent = $isDiscounted ? $discountMap[$item['item_id']]['discount_percent'] : 0;
            $discountedPrice = $item['price'] * (1 - ($discountPercent / 100));
            ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if ($item['image_url']): ?>
                        <img src="<?= $item['image_url'] ?>" class="card-img-top" alt="<?= $item['item_name'] ?>" style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $item['item_name'] ?></h5>
                        <?php if ($isDiscounted): ?>
                            <p class="text-muted">
                                <span class="text-decoration-line-through">$<?= number_format($item['price'], 2) ?></span>
                                <span class="text-danger fw-bold"> $<?= number_format($discountedPrice, 2) ?></span>
                            </p>
                            <p class="text-success fw-bold"><?= $discountPercent ?>% OFF</p>
                        <?php else: ?>
                            <p class="text-muted fw-bold">$<?= number_format($item['price'], 2) ?></p>
                        <?php endif; ?>
                        <p class="card-text"><?= $item['description'] ?></p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#itemModal<?= $item['item_id'] ?>">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal for Special Requests -->
            <div class="modal fade" id="itemModal<?= $item['item_id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= $item['item_name'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= URL ?>handlers/admin/cart-handler.php" method="POST">
                                <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                                <div class="mb-3">
                                    <label for="quantity<?= $item['item_id'] ?>" class="form-label">Quantity</label>
                                    <input type="number" name="quantity" id="quantity<?= $item['item_id'] ?>" class="form-control" value="1" min="1">
                                </div>
                                <div class="mb-3">
                                    <label for="notes<?= $item['item_id'] ?>" class="form-label">Special Requests</label>
                                    <textarea name="notes" id="notes<?= $item['item_id'] ?>" class="form-control" rows="3" placeholder="e.g., no onions, extra cheese"></textarea>
                                </div>
                                <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>



<!-- book a table -->
<div class="container-fluid my-5" id="reservation">
    <div class="text-center">
        <p class="text-muted">Reservvation</p>
        <h2 class="menu-title">Book A <span>Table</span></h2>
    </div>
    <div class="container my-5">
        <div class="row align-items-center reservation-container p-4 rounded shadow">
            <!-- صورة الحجز -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img class="img-fluid rounded w-100" src="assets/customer/images/about1.jpg" alt="Table Reservation">
            </div>

            <!-- نموذج الحجز -->
            <div class="col-lg-6">
                <h2 class="text-center mb-4 " style="color: #923A35;">Book A Table</h2>
                <form method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Select Date</label>
                        <input type="date" class="form-control" name="reservation_date" required value="<?= $_POST['reservation_date'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Select Time</label>
                        <input type="time" class="form-control" name="time_slot" required value="<?= $_POST['time_slot'] ?? '' ?>">
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" name="check_availability" class="btn  w-100" style="background-color: #923A35; border-color: #923A35; color: white;">Check Availability</button>
                    </div>
                </form>

                <?php if (!empty($_POST['reservation_date']) && !empty($_POST['time_slot'])): ?>
                    <form method="POST" class="row g-3 mt-4">
                        <input type="hidden" name="reservation_date" value="<?= $_POST['reservation_date'] ?>">
                        <input type="hidden" name="time_slot" value="<?= $_POST['time_slot'] ?>">

                        <div class="col-12">
                            <label class="form-label">Select Table</label>
                            <select name="table_id" class="form-select" required>
                                <?= $tablesOptions ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Your Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Your Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Your Phone</label>
                            <input type="tel" class="form-control" name="phone" placeholder="Your Phone" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Number of Guests</label>
                            <input type="number" class="form-control" name="guests" placeholder="# of people" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Additional Message</label>
                            <textarea name="message" class="form-control" placeholder="Message" rows="3"></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" name="book_table" class="btn btn-success w-100">Book a Table</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Gallery -->
<div class="container my-5" id="gallery">
    <div class="text-center">
        <p class="text-muted">Gallery</p>
        <h2 class="menu-title">Check our <span>Gallery</span></h2>
    </div>
    <div id="imageSlider" class="carousel slide my-5 rounded" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active rounded">
                <img src="assets/customer/images/gallery/gallery1.jpg" class="d-block w-100 rounded" alt="Image 1">
            </div>
            <div class="carousel-item">
                <img src="assets/customer/images/gallery/gallery2.jpg" class="d-block w-100 rounded" alt="Image 2">
            </div>
            <div class="carousel-item">
                <img src="assets/customer/images/gallery/gallery3.jpg" class="d-block w-100 rounded" alt="Image 3">
            </div>
            <div class="carousel-item">
                <img src="assets/customer/images/gallery/gallery4.jpg" class="d-block w-100 rounded" alt="Image 3">
            </div>
            <div class="carousel-item">
                <img src="assets/customer/images/gallery/gallery5.jpg" class="d-block w-100 rounded" alt="Image 3">
            </div>
            <div class="carousel-item">
                <img src="assets/customer/images/gallery/gallery6.jpg" class="d-block w-100 rounded" alt="Image 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#imageSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#imageSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="carousel-cursor" id="cursor"></div>
</div>

<!-- contact -->
<div class="container-fluid my-5" id="contact">
    <div class="text-center">
        <p class="text-muted">Contacts</p>
        <h2 class="menu-title">Need Help? <span>Contact Us</span></h2>
    </div>
    <div class="container-fluid my-5">
        <div class="row">
            <!-- Contact Info -->
            <div class="col-md-6 mb-4">
                <div class="info-box">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h5><strong>Address</strong></h5>
                        <p>El-Gomhoreya Street, Port Said, Egypt</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="info-box">
                    <i class="fas fa-phone"></i>
                    <div>
                        <h5><strong>Call Us</strong></h5>
                        <p>+1 5589 55488 55</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="info-box">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h5><strong>Email Us</strong></h5>
                        <p>Restorestaurant@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="info-box">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h5><strong>Opening Hours</strong></h5>
                        <p><strong>Sun-Sat:</strong> 10AM - 1AM</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Contact Form -->
        <div class="contact-box">
            <h4 class="text-center mb-4">Send Us a Message</h4>
            <form>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="email" class="form-control" placeholder="Your Email" required>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Subject" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" rows="4" placeholder="Message" required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-custom">Send Message</button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- footer -->
<footer class="footer bg-dark text-white mt-5 w-100">
    <div class="container-fluid text-center py-5">

        <div class="social-links text-center mb-4">
            <h5 class="mb-3">Follow Us on Social Media</h5>
            <a href="#" class="text-white me-3 social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white me-3 social-icon"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white me-3 social-icon"><i class="fab fa-google"></i></a>
            <a href="#" class="text-white me-3 social-icon"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white me-3 social-icon"><i class="fab fa-linkedin"></i></a>
            <a href="#" class="text-white social-icon"><i class="fab fa-github"></i></a>
        </div>

        <div class="row text-start">
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold">About Us</h5>
                <p>Welcome to <strong>Resto Restaurant</strong>, where flavors come alive with fresh ingredients. Join us for an unforgettable dining experience!</p>
            </div>

            <div class="col-md-3 mb-4">
                <h5 class="fw-bold">Our Menu</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="menu-link">🍽️ Appetizers</a></li>
                    <li><a href="#" class="menu-link">🥩 Main Courses</a></li>
                    <li><a href="#" class="menu-link">🍰 Desserts</a></li>
                    <li><a href="#" class="menu-link">☕ Beverages</a></li>
                </ul>
            </div>

            <div class="col-md-3 mb-4">
                <h5 class="fw-bold">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="menu-link"><i class="fas fa-calendar-check me-2"></i> Reservations</a></li>
                    <li><a href="#" class="menu-link"><i class="fas fa-tags me-2"></i> Special Offers</a></li>
                    <li><a href="#" class="menu-link"><i class="fas fa-concierge-bell me-2"></i> Catering Services</a></li>
                    <li><a href="#" class="menu-link"><i class="fas fa-phone-alt me-2"></i> Contact Us</a></li>
                </ul>
            </div>

            <div class="col-md-3 mb-4">
                <h5 class="fw-bold">Contact Us</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt me-2"></i> El-Gomhoreya Street, Port Said, Egypt</li>
                    <li><i class="fas fa-envelope me-2"></i> Restorestaurant@gmail.com</li>
                    <li><i class="fas fa-phone me-2"></i> +1 234 567 890</li>
                    <li><i class="fas fa-phone me-2"></i> +1 234 567 891</li>
                </ul>
            </div>
        </div>

        <div class="text-center pt-4 mt-4 border-top">
            <p class="mb-0">© 2025 <strong>Resto Restaurant</strong>. All rights reserved.</p>
        </div>
    </div>
</footer>
<?php showToast(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById("notificationBell").addEventListener("click", async function() {
        let response = await fetch("../functions/mark_all_notifications_read.php", {
            method: "POST"
        });

        if (response.ok) {
            document.getElementById("notificationCount").textContent = "";
            setTimeout(() => {
                loadUserNotifications();
            }, 40000);
        }
    });
    async function loadUserNotifications() {
        let response = await fetch("../functions/fetch_notifications_user.php");
        let notifications = await response.json();

        let dropdown = document.getElementById("notificationDropdown");
        let count = document.getElementById("notificationCount");

        dropdown.innerHTML = "";
        count.textContent = notifications.length;
        console.log(notifications);

        if (notifications.length === 0) {
            dropdown.innerHTML = '<li class="dropdown-item text-muted">There is no Notifications</li>';
            document.getElementById("notificationCount").textContent = "";
        } else {
            notifications.forEach(notification => {
                let li = document.createElement("li");
                li.className = "dropdown-item " + (notification.is_read == 1 ? "read" : "unread");
                li.textContent = notification.message;

                dropdown.appendChild(li);
            });
        }
    }
    document.getElementById("notificationBell").addEventListener("click", async function() {

        document.getElementById("notificationCount").textContent = "";
    });


    loadUserNotifications();
    setInterval(loadUserNotifications, 5000);
</script>
<?php include 'includes/customer/footer.php'; ?>