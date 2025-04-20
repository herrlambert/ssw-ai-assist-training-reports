USE ssw_training_reports;

-- Update training_activities table with new names and identifiers
UPDATE training_activities ta
JOIN update_names un ON ta.OldIdentifier = un.OldIdentifier
SET 
    ta.FirstName = un.NewFirstName,
    ta.LastName = un.NewLastName,
    ta.NewIdentifier = un.NewIdentifier;

-- Show summary of updates
SELECT 
    COUNT(*) as 'Total Records Updated'
FROM training_activities
WHERE NewIdentifier IS NOT NULL;