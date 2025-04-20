USE ssw_training_reports;

-- Temporarily disable foreign key checks and unique key checks
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;

-- Set the proper character set
SET NAMES utf8mb4;

-- Load data from CSV file
LOAD DATA INFILE 'utils/data_files/update_names.csv'
INTO TABLE update_names
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(
    OldIdentifier,
    NewFirstName,
    NewLastName,
    NewIdentifier
);

-- Re-enable foreign key checks and unique key checks
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;