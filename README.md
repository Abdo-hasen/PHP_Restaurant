Here’s the modified `README.md` file based on the directory structure and details you provided:

---

# Restaurant Management System

A PHP-based web application for managing restaurant operations, including menu management, order processing, table reservations, and inventory tracking.

---

## Features

- **User Management**: Staff/customer registration, login, and role-based access.
- **Menu Management**: CRUD operations for categories/items (staff-only).
- **Order System**: Customizable orders with real-time status tracking.
- **Table Reservations**: Online booking with email/SMS confirmation.
- **Payment Integration**: Credit card and cash-on-delivery support.
- **Staff Dashboard**: Sales reports, inventory tracking, and user management.
- **Responsive UI**: Built with Bootstrap for a mobile-friendly experience.

---

## Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Server**: Apache
- **Dependencies**: PHPMailer (for notifications), Stripe/PayPal SDK (for payments)

---

## Directory Structure

```
restaurant-app/
│
├── admin/              # Administrative backend
│   ├── categories.php
│   ├── dashboard.php
│   ├── inventory.php
│   ├── manage_menu.php
│   ├── manage_orders.php
│   ├── manage_reservations.php
│   ├── manage_users.php
│   ├── profile.php
│   ├── supplier.php
│   └── layout/         # Special offer management pages
│       ├── edit-offer.php
│       └── special-offer.php
│
├── assets/             # Static assets (CSS, JS, images)
│   ├── admin/          # Admin panel assets
│   │   ├── css/
│   │   ├── fonts/
│   │   ├── img/
│   │   └── js/
│   └── customer/       # Customer-facing website assets
│       ├── css/
│       ├── images/
│       ├── js/
│       └── menu.json   # Menu data for customer website
│
├── database/           # Database schema and sample data
│   ├── create_user.sql
│   ├── dummy.sql
│   ├── sample_data.sql
│   └── schema.sql
│
├── functions/          # PHP functions
│   ├── add_user.php
│   ├── edit_user.php
│   ├── fetch_notifications_admin.php
│   ├── fetch_notifications_user.php
│   ├── mark_all_notifications_read.php
│   └── stats.php
│
├── handlers/           # Form handling and business logic
│   ├── admin/
│   │   ├── cart-handler.php
│   │   ├── categories.php
│   │   ├── checkout-handler.php
│   │   ├── delete-offer-handler.php
│   │   ├── edit-offer-handler.php
│   │   ├── forgot-password.php
│   │   ├── order_details.php
│   │   ├── reorder_handler.php
│   │   ├── reservation.php
│   │   ├── reset-password.php
│   │   ├── special-offer.php
│   │   └── update_order_status.php
│   ├── common/
│   │   ├── auth_handler.php
│   │   ├── logout.php
│   │   ├── profile_handler.php
│   │   └── register_handler.php
│   └── customer/
│       └── reservation.php
│
├── includes/           # Reusable PHP code snippets
│   ├── admin/
│   │   ├── footer.php
│   │   ├── header.php
│   │   └── sidebar.php
│   ├── common/
│   │   ├── Database.php
│   │   ├── Functions.php
│   │   └── validations.php
│   └── customer/
│       ├── footer.php
│       ├── header.php
│       └── nav.php
│
├── cart.php            # Shopping cart functionality
├── composer.json
├── composer.lock
├── forgot-password.php
├── index.php           # Customer-facing website entry point
├── init.php            # Initialization file
├── login.php
├── node_modules/       # Node.js dependencies
└── README.md
```

---

## Setup Instructions

### 1. Prerequisites

- Apache web server
- PHP 7.4+
- MySQL 5.7+

### 2. Installation

```bash
# Clone repository
git clone git@github.com:Abdo-hasen/PHP_Restaurant.git
cd PHP_Restaurant

# Import the database schema
mysql -u root -p restaurant_db < database/schema.sql

# Import sample data (optional)
mysql -u root -p restaurant_db < database/dummy.sql

# Set up the database configuration
# Edit the `includes/common/config.php` file to match your database credentials.

# Start the Apache server
sudo service apache2 start
```

### 3. Configuration

- Update the database credentials in `includes/common/config.php`.
- Ensure the `assets` directory is writable for file uploads (e.g., profile pictures).

### 4. Running the Application

- Open your browser and navigate to `http://localhost:8080/PHP_Restaurant/`.
- Use the following credentials to log in as an admin:
  - Email: `admin@example.com`
  - Password: `admin123`

---

## Usage

- **Admin Dashboard**: Manage users, menu items, orders, reservations, and inventory.
- **Customer Interface**: Browse the menu, place orders, make reservations, and track order status.

---

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes.

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## Acknowledgments

- Bootstrap for the responsive UI components.
- PHPMailer for email notifications.
- Chart.js for interactive charts in the admin dashboard.

---

## Screenshots

![Preview](assets/customer/images/preview.png)

---

For any questions or issues, please open an issue on the GitHub repository.

--- 

This version of the `README.md` aligns with the directory structure and provides a clear, organized overview of the project. Let me know if you need further adjustments!
