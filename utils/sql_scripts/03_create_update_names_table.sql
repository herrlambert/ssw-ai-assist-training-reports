USE ssw_training_reports;

CREATE TABLE IF NOT EXISTS update_names (
    OldIdentifier VARCHAR(50) PRIMARY KEY,
    NewFirstName VARCHAR(255) NOT NULL,
    NewLastName VARCHAR(255) NOT NULL,
    NewIdentifier VARCHAR(50) NULL,
    
    -- Add indexes for commonly queried fields
    INDEX idx_new_identifier (NewIdentifier),
    INDEX idx_new_names (NewFirstName, NewLastName)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;