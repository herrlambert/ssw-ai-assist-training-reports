USE ssw_training_reports;

CREATE TABLE IF NOT EXISTS training_activities (
    TrainingActivityId INT AUTO_INCREMENT PRIMARY KEY,
    CertificationActivityId SMALLINT NOT NULL,
    Title VARCHAR(255) NOT NULL,
    ParticipationDate DATE NOT NULL,
    FirstName VARCHAR(255) NULL,
    LastName VARCHAR(255) NULL,
    OldIdentifier VARCHAR(50) NOT NULL,
    NewIdentifier VARCHAR(50) NULL,
    
    -- Add indexes for commonly queried fields
    INDEX idx_cert_activity (CertificationActivityId),
    INDEX idx_participation_date (ParticipationDate),
    INDEX idx_old_identifier (OldIdentifier),
    INDEX idx_new_identifier (NewIdentifier)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;