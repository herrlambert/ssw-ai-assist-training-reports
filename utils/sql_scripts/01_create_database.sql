-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS ssw_training_reports
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Switch to using the database
USE ssw_training_reports;

-- Create a test table to verify database creation
-- (You can remove this later)
CREATE TABLE IF NOT EXISTS test (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Grant privileges (adjust username and password as needed)
-- GRANT ALL PRIVILEGES ON ssw_training_reports.* TO 'your_username'@'localhost';
-- FLUSH PRIVILEGES;