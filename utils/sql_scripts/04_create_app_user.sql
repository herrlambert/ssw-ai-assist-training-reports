-- Create the application user
CREATE USER IF NOT EXISTS 'ssw_training_app'@'localhost' 
IDENTIFIED BY 'change_this_password_in_production';

-- Grant specific permissions on ssw_training_reports database
GRANT SELECT, INSERT, UPDATE, DELETE 
ON ssw_training_reports.* 
TO 'ssw_training_app'@'localhost';

-- Make sure the privileges are applied
FLUSH PRIVILEGES;