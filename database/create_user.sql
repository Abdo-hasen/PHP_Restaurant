-- Create a new user for the restaurant application
CREATE USER IF NOT EXISTS 'restaurant_user'@'localhost' IDENTIFIED BY 'secure_password';

-- Grant necessary permissions to the user
GRANT ALL PRIVILEGES ON restaurant_db.* TO 'restaurant_user'@'localhost';

-- Flush privileges to apply changes
FLUSH PRIVILEGES;