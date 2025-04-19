<?php
class ReportsController {
    public function byPerson() {
        try {
            $trainings = [];
            $csvFile = APP_ROOT . '/utils/data_files/training_activities.csv';
            
            // Check if file exists and is readable
            if (!file_exists($csvFile)) {
                error_log("CSV file not found: " . $csvFile);
                throw new Exception("Training data file not found");
            }

            if (!is_readable($csvFile)) {
                error_log("CSV file not readable: " . $csvFile);
                throw new Exception("Training data file not accessible");
            }

            // Log the full path for debugging
            error_log("Attempting to open CSV file at: " . $csvFile);
            
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                // Skip the header row but store it for column names
                $headers = fgetcsv($handle);
                
                // Read data rows
                while (($data = fgetcsv($handle)) !== FALSE) {
                    // Create associative array using headers as keys
                    $row = array_combine($headers, $data);
                    
                    // Filter for records where Identifier = 'sanp'
                    if ($row['Identifier'] === 'sanp') {
                        $trainings[] = $row;
                    }
                }
                fclose($handle);
            } else {
                throw new Exception("Could not open training data file");
            }
            
            require_once APP_ROOT . '/views/reports/by_person.php';
        } catch (Exception $e) {
            error_log("Report generation error: " . $e->getMessage());
            echo "An error occurred while retrieving the report: " . $e->getMessage();
        }
    }
}

