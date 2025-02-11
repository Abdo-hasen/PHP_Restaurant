<?php

$menuData = file_get_contents("assets/customer/menu.json");
$menu = json_decode($menuData, true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resto</title>
    <link rel="icon" type="image/x-icon" href="assets/customer/images/favicon.png">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/assets/customer/css/indexstyle.css">
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
                    <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#aboutUs">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </div>

            <a href="#reservation" class="btn btn-book">Book a Table</a>
        </div>
    </nav>


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

                    From the sizzling grilled kebabs to the comforting koshari, every bite at Resto Restaurant is a journey through Egypt’s culinary heritage. Our chefs bring passion and tradition to every dish, ensuring an experience that feels both nostalgic and unforgettable.

                    Whether you're craving a classic Molokhia, a hearty Fattah, or a sweet Basbousa, we've got something special for everyone. At Resto Restaurant, we don’t just serve food – we share culture, tradition, and a true taste of Egypt.

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
    <div class="container-fluid py-5" id="menu">

        <div class="text-center">
            <p class="text-muted">OUR MENU</p>
            <h2 class="menu-title">Check Our <span>Menu</span></h2>
        </div>



        <div class="container mt-5">
            <ul class="nav nav-tabs justify-content-center mt-4 text-light" id="menuTabs">
                <?php $firstTab = true; ?>
                <?php foreach ($menu as $category => $items): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $firstTab ? 'active' : ''; ?>" data-bs-toggle="tab" href="#<?php echo strtolower($category); ?>">
                            <?php echo $category; ?>
                        </a>
                    </li>
                    <?php $firstTab = false; ?>
                <?php endforeach; ?>
            </ul>

            <div class="tab-content mt-4">
                <?php $firstContent = true; ?>
                <?php foreach ($menu as $category => $items): ?>
                    <div class="tab-pane fade <?php echo $firstContent ? 'show active' : ''; ?>" id="<?php echo strtolower($category); ?>">
                        <div class="row">
                            <?php foreach ($items as $item): ?>
                                <div class="card mx-2 mb-5 " style="width: 18rem;">
                                    <img src="<?php echo $item['image']; ?>" class="card-img-top rounded-circle img-fluid mt-2 mx-auto" alt="<?php echo $item['name']; ?>">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?php echo $item['name']; ?></h5>
                                        <p class="card-text"><?php echo $item['description']; ?></p>
                                        <p class="card-price"><?php echo $item['price']; ?> EGP</p>

                                        <a href="#" class="card-btn mx-auto">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php $firstContent = false; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


    <!-- book a table -->
    <div class="container-fluid my-5" id="reservation">
        <div class="text-center">
            <p class="text-muted">Reservvation</p>
            <h2 class="menu-title">Book A <span>Table</span></h2>
        </div>
        <div class=" container-fluid my-5 reservation-container">
            <div class="reservation-image">
                <img class="img-fluid rounded" src="assets/customer/images/about1.jpg" alt="Table Reservation">
            </div>
            <div class="reservation-form">
                <form action="#">
                    <div class="input-row">
                        <input type="text" placeholder="Your Name" required>
                        <input type="email" placeholder="Your Email" required>
                        <input type="tel" placeholder="Your Phone" required>
                    </div>
                    <div class="input-row">
                        <input type="date" required>
                        <input type="time" required>
                        <input type="number" placeholder="# of people" required>
                    </div>
                    <textarea placeholder="Message" rows="4"></textarea>
                    <button type="submit" class="btn-reserve">Book a Table</button>
                </form>
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












    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="script.js" defer></script>
</body>

</html>