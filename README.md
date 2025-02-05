# Restaurant Management System

A PHP-based web application for managing restaurant operations, including menu management, order processing, table reservations, and inventory tracking.

![Preview](assets/customer/images/preview.png) <!-- Add a screenshot later -->

## Directory Structure
restaurant-app/
│
├── assets/ # Static assets (CSS, JS, images)
│ ├── admin/ # Staff dashboard assets
│ │ ├── css/
│ │ ├── js/
│ │ └── images/
│ │
│ └── customer/ # Customer interface assets
│ ├── css/
│ ├── js/
│ └── images/
│
├── includes/ # Reusable PHP components
│ ├── admin/ # Staff dashboard includes
│ │ ├── header.php
│ │ ├── footer.php
│ │ └── sidebar.php
│ │
│ ├── customer/ # Customer interface includes
│ │ ├── header.php
│ │ └── footer.php
│ │
│ └── common/ # Shared components
│ ├── db.php # Database connection
│ ├── auth.php # Authentication logic
│ └── config.php # Global settings
│
├── admin/ # Staff dashboard
│ ├── dashboard.php # Main dashboard
│ ├── manage_users.php
│ ├── manage_menu.php
│ ├── manage_orders.php
│ └── manage_reservations.php
│
├── customer/ # Customer interface
│ ├── menu.php
│ ├── order.php
│ ├── reservation.php
│ ├── order_tracking.php
│ └── profile.php
│
├── functions/ # Business logic
│ ├── orders.php
│ ├── payments.php
│ └── notifications.php
│
├── config/ # Configuration files
│ └── constants.php # Environment constants
│
├── database/ # Database schemas
│ ├── schema.sql # Table structure
│ └── sample_data.sql # Initial test data
│
├── index.php # Landing page
├── login.php # Shared login
├── register.php # Registration
├── logout.php # Session destroy
└── .htaccess # URL routing (optional)

## Features
- **User Management**: Staff/customer registration, login, and role-based access
- **Menu Management**: CRUD operations for categories/items (staff-only)
- **Order System**: Customizable orders with real-time status tracking
- **Table Reservations**: Online booking with email/SMS confirmation
- **Payment Integration**: Credit card and cash-on-delivery support
- **Staff Dashboard**: Sales reports, inventory tracking, and user management
- **Responsive UI**: Built with Bootstrap for mobile-friendly experience

## Technologies Used
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Server**: Apache
- **Dependencies**: PHPMailer (for notifications), Stripe/PayPal SDK (for payments)

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

# # Set up database
# mysql -u root -p < database/schema.sql
# mysql -u root -p restaurant_db < database/sample_data.sql