USE ssw_training_reports;

CREATE TABLE IF NOT EXISTS update_names (
    OldIdentifier VARCHAR(50) PRIMARY KEY,
    NewFirstName VARCHAR(255) NOT NULL,
    NewLastName VARCHAR(255) NOT NULL,
    NewIdentifier VARCHAR(50) NULL,
    
    -- Add indexes with length limits to stay under 1000 bytes
    INDEX idx_new_identifier (NewIdentifier),
    INDEX idx_new_names (NewFirstName(125), NewLastName(125))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
