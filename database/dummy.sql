-- note  :
-- insert that quries on empty Database to ensure refrentional Integration

-- Insert fake data into users table
INSERT INTO users (full_name, email, password, role, profile_picture) VALUES
('John Doe', 'john.doe@example.com', 'password123', 'customer', 'profile1.jpg'),
('Jane Smith', 'jane.smith@example.com', 'password456', 'customer', 'profile2.jpg'),
('Alice Johnson', 'alice.johnson@example.com', 'password789', 'staff', 'profile3.jpg'),
('Bob Brown', 'bob.brown@example.com', 'password101', 'staff', 'profile4.jpg'),
('Charlie Davis', 'charlie.davis@example.com', 'password112', 'customer', 'profile5.jpg');

-- Insert fake data into categories table
INSERT INTO categories (category_name, description) VALUES
('Appetizers', 'Small dishes served before the main course.'),
('Main Course', 'Primary dishes served as the main part of the meal.'),
('Desserts', 'Sweet dishes served at the end of the meal.'),
('Beverages', 'Drinks to accompany the meal.'),
('Salads', 'Fresh and healthy salad options.');

-- Insert fake data into menu_items table
INSERT INTO menu_items (category_id, item_name, description, price, image_url) VALUES
(1, 'Garlic Bread', 'Toasted bread with garlic butter.', 5.99, 'garlic_bread.jpg'),
(1, 'Bruschetta', 'Grilled bread topped with tomatoes and basil.', 6.99, 'bruschetta.jpg'),
(2, 'Grilled Salmon', 'Fresh salmon grilled to perfection.', 18.99, 'grilled_salmon.jpg'),
(2, 'Beef Steak', 'Juicy beef steak with mashed potatoes.', 22.99, 'beef_steak.jpg'),
(3, 'Chocolate Cake', 'Rich and moist chocolate cake.', 8.99, 'chocolate_cake.jpg'),
(3, 'Cheesecake', 'Creamy cheesecake with strawberry topping.', 9.99, 'cheesecake.jpg'),
(4, 'Orange Juice', 'Freshly squeezed orange juice.', 3.99, 'orange_juice.jpg'),
(4, 'Iced Tea', 'Refreshing iced tea with lemon.', 2.99, 'iced_tea.jpg'),
(5, 'Caesar Salad', 'Classic Caesar salad with croutons and parmesan.', 7.99, 'caesar_salad.jpg'),
(5, 'Greek Salad', 'Fresh Greek salad with feta cheese.', 8.99, 'greek_salad.jpg');

-- Insert fake data into special_offers table
INSERT INTO special_offers (item_id, discount_percent, start_date, expiry_date) VALUES
(1, 10.00, '2023-10-01', '2023-10-15'),
(3, 15.00, '2023-10-05', '2023-10-20'),
(5, 20.00, '2023-10-10', '2023-10-25');

-- Insert fake data into orders table
INSERT INTO orders (user_id, status, total_amount, special_instructions) VALUES
(1, 'Delivered', 25.98, 'No onions in the salad.'),
(2, 'Preparing', 18.99, 'Extra sauce on the side.'),
(3, 'Pending', 32.97, 'Gluten-free options only.'),
(4, 'Ready', 12.98, 'No ice in the drinks.'),
(5, 'Delivered', 45.96, 'Pack separately.');

-- Insert fake data into order_items table
INSERT INTO order_items (order_id, item_id, quantity, notes) VALUES
(1, 1, 2, 'Extra garlic butter.'),
(1, 9, 1, 'No croutons.'),
(2, 3, 1, 'Medium rare.'),
(3, 5, 2, 'Add whipped cream.'),
(4, 7, 3, 'No sugar.'),
(5, 2, 4, 'Extra tomatoes.');

-- Insert fake data into tables table
INSERT INTO tables (table_number, capacity, status) VALUES
(1, 4, 'Available'),
(2, 6, 'Reserved'),
(3, 2, 'Available'),
(4, 8, 'Available'),
(5, 4, 'Reserved');

-- Insert fake data into reservations table
INSERT INTO reservations (user_id, table_id, reservation_date, time_slot, guests, status) VALUES
(1, 1, '2023-10-15', '18:00:00', 4, 'Confirmed'),
(2, 2, '2023-10-16', '19:00:00', 6, 'Confirmed'),
(3, 3, '2023-10-17', '20:00:00', 2, 'Cancelled'),
(4, 4, '2023-10-18', '21:00:00', 8, 'Confirmed'),
(5, 5, '2023-10-19', '22:00:00', 4, 'Confirmed');

-- Insert fake data into payments table
INSERT INTO payments (order_id, payment_method, amount, status, invoice_number, invoice_date) VALUES
(1, 'Credit/Debit Card', 25.98, 'Completed', 'INV001', '2023-10-15'),
(2, 'Cash on Delivery', 18.99, 'Completed', 'INV002', '2023-10-16'),
(3, 'Credit/Debit Card', 32.97, 'Failed', 'INV003', '2023-10-17'),
(4, 'Cash on Delivery', 12.98, 'Completed', 'INV004', '2023-10-18'),
(5, 'Credit/Debit Card', 45.96, 'Completed', 'INV005', '2023-10-19');

-- Insert fake data into inventory table
INSERT INTO inventory (item_id, quantity, unit, reorder_level, last_restocked) VALUES
(1, 50, 'pieces', 10, '2023-09-30'),
(2, 30, 'pieces', 10, '2023-09-30'),
(3, 20, 'kg', 5, '2023-09-30'),
(4, 15, 'kg', 5, '2023-09-30'),
(5, 25, 'pieces', 10, '2023-09-30');

-- Insert fake data into suppliers table
INSERT INTO suppliers (supplier_name, contact_email, phone) VALUES
('Fresh Produce Co.', 'info@freshproduce.com', '+1234567890'),
('Meat & More', 'sales@meatandmore.com', '+0987654321'),
('Beverage World', 'contact@beverageworld.com', '+1122334455'),
('Dairy Delights', 'support@dairydelights.com', '+5566778899'),
('Bakery Bliss', 'orders@bakerybliss.com', '+9988776655');

-- Insert fake data into notifications table
INSERT INTO notifications (user_id, message, type, is_read) VALUES
(1, 'Your order has been delivered.', 'Order', TRUE),
(2, 'Your reservation is confirmed.', 'Reservation', FALSE),
(3, 'Your payment failed. Please try again.', 'Order', FALSE),
(4, 'Your order is ready for pickup.', 'Order', TRUE),
(5, 'Your reservation has been cancelled.', 'Reservation', FALSE);