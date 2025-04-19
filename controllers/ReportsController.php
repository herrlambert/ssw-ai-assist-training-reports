<?php
class ReportsController {
    public function byPerson() {
        try {
            $trainings = [];
            $csvFile = APP_ROOT . '/utils/data_files/training_activities.csv';
            
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
            }
            
            require_once APP_ROOT . '/views/reports/by_person.php';
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "An error occurred while retrieving the report.";
        }
    }
}
