# Restaurant Management System

A PHP-based web application for managing restaurant operations, including menu management, order processing, table reservations, and inventory tracking.

![Preview](assets/customer/images/preview.png) <!-- Add a screenshot later -->

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