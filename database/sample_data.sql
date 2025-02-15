-- Insert sample data into the users table
INSERT INTO users (full_name, email, password, role, profile_picture) VALUES
('Admin User', 'admin@restaurant.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 'admin.jpg'), -- Password: password
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 'john.jpg'), -- Password: password
('Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 'jane.jpg'); -- Password: password

-- Insert sample data into the categories table
INSERT INTO categories (category_name, description) VALUES
('Appetizers', 'Start your meal with our delicious appetizers.'),
('Main Course', 'Hearty and satisfying main dishes.'),
('Desserts', 'Sweet treats to end your meal.'),
('Beverages', 'Refreshing drinks to complement your meal.');

-- Insert sample data into the menu_items table
INSERT INTO menu_items (category_id, item_name, description, price, image_url, is_available) VALUES
(1, 'Garlic Bread', 'Freshly baked bread with garlic butter.', 5.99, 'garlic_bread.jpg', TRUE),
(1, 'Bruschetta', 'Toasted bread topped with tomatoes and basil.', 6.99, 'bruschetta.jpg', TRUE),
(2, 'Grilled Salmon', 'Fresh salmon grilled to perfection.', 15.99, 'grilled_salmon.jpg', TRUE),
(2, 'Chicken Alfredo', 'Creamy Alfredo sauce with grilled chicken.', 12.99, 'chicken_alfredo.jpg', TRUE),
(3, 'Chocolate Cake', 'Rich and decadent chocolate cake.', 7.99, 'chocolate_cake.jpg', TRUE),
(3, 'Cheesecake', 'Classic New York-style cheesecake.', 8.99, 'cheesecake.jpg', TRUE),
(4, 'Iced Tea', 'Refreshing iced tea with lemon.', 3.99, 'iced_tea.jpg', TRUE),
(4, 'Cappuccino', 'Rich and creamy cappuccino.', 4.99, 'cappuccino.jpg', TRUE);

-- Insert sample data into the special_offers table
INSERT INTO special_offers (item_id, discount_percent, start_date, expiry_date) VALUES
(1, 10.00, '2023-10-01', '2023-10-31'), -- 10% off Garlic Bread
(3, 15.00, '2023-10-01', '2023-10-31'); -- 15% off Grilled Salmon

-- Insert sample data into the orders table
INSERT INTO orders (user_id, total_amount, status, special_instructions) VALUES
(2, 22.97, 'Delivered', 'Extra sauce on the side.'),
(3, 15.99, 'Ready', 'No onions in the Bruschetta.'),
(2, 30.97, 'Pending', 'Well-done salmon.');

-- Insert sample data into the order_items table
INSERT INTO order_items (order_id, item_id, quantity, notes) VALUES
(1, 1, 2, 'Extra garlic butter.'),
(1, 3, 1, 'Well-done.'),
(2, 2, 1, 'No onions.'),
(3, 3, 2, 'Extra lemon.'),
(3, 5, 1, 'Add whipped cream.');

-- Insert sample data into the tables table
INSERT INTO tables (table_number, capacity, status) VALUES
(1, 4, 'Available'),
(2, 6, 'Available'),
(3, 2, 'Reserved'),
(4, 8, 'Available');

-- Insert sample data into the reservations table
INSERT INTO reservations (user_id, table_id, reservation_date, time_slot, guests, status) VALUES
(2, 1, '2023-10-15', '18:00:00', 4, 'Confirmed'),
(3, 2, '2023-10-16', '19:30:00', 6, 'Confirmed'),
(2, 3, '2023-10-17', '20:00:00', 2, 'Cancelled');

-- Insert sample data into the payments table
INSERT INTO payments (order_id, payment_method, amount, status, invoice_number, invoice_date) VALUES
(1, 'Credit/Debit Card', 22.97, 'Completed', 'INV-1001', '2023-10-01'),
(2, 'Cash on Delivery', 15.99, 'Completed', 'INV-1002', '2023-10-02'),
(3, 'Credit/Debit Card', 30.97, 'Pending', 'INV-1003', '2023-10-03');

-- Insert sample data into the inventory table
INSERT INTO inventory (item_id, quantity, unit, reorder_level, last_restocked) VALUES
(1, 50, 'pieces', 10, '2023-10-01'),
(2, 30, 'pieces', 10, '2023-10-01'),
(3, 20, 'kg', 5, '2023-10-01'),
(4, 15, 'kg', 5, '2023-10-01'),
(5, 25, 'pieces', 10, '2023-10-01'),
(6, 20, 'pieces', 10, '2023-10-01'),
(7, 100, 'liters', 20, '2023-10-01'),
(8, 50, 'liters', 10, '2023-10-01');

-- Insert sample data into the suppliers table
INSERT INTO suppliers (supplier_name, contact_email, phone) VALUES
('Fresh Produce Co.', 'info@freshproduce.com', '+1234567890'),
('Seafood Suppliers Ltd.', 'sales@seafoodsuppliers.com', '+0987654321'),
('Beverage Distributors Inc.', 'sales@beveragedistributors.com', '+1122334455');

-- Insert sample data into the notifications table
INSERT INTO notifications (user_id, message, type, is_read) VALUES
(2, 'Your order #1 has been delivered.', 'Order', FALSE),
(3, 'Your reservation for table #2 is confirmed.', 'Reservation', FALSE),
(2, 'Your order #3 is being prepared.', 'Order', FALSE);