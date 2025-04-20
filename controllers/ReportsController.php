<?php
class ReportsController {
    public function byPerson() {
        try {
            $trainings = [];
            $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
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
                    
                    // If search term is provided, filter based on it
                    if (!empty($searchTerm)) {
                        $searchMatch = stripos($row['FirstName'], $searchTerm) !== false ||
                                     stripos($row['LastName'], $searchTerm) !== false ||
                                     stripos($row['Identifier'], $searchTerm) !== false;
                        
                        if ($searchMatch) {
                            $trainings[] = $row;
                        }
                    }
                }
                fclose($handle);
                
                // Sort trainings first by Identifier, then by ParticipationDate in reverse chronological order
                usort($trainings, function($a, $b) {
                    // First compare Identifiers
                    $identifierCompare = strcmp($a['Identifier'], $b['Identifier']);
                    if ($identifierCompare !== 0) {
                        return $identifierCompare;
                    }
                    // If Identifiers are equal, sort by date in reverse chronological order
                    return strtotime($b['ParticipationDate']) - strtotime($a['ParticipationDate']);
                });
            } else {
                throw new Exception("Could not open training data file");
            }
            
            require_once APP_ROOT . '/views/reports/by_person.php';
        } catch (Exception $e) {
            error_log("Report generation error: " . $e->getMessage());
            echo "An error occurred while retrieving the report: " . $e->getMessage();
        }
    }

    public function expired() {
        try {
            $trainings = [];
            $uniqueTitles = [];
            $selectedTitle = isset($_GET['training']) ? trim($_GET['training']) : '';
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

            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                // Skip the header row but store it for column names
                $headers = fgetcsv($handle);
                
                // First pass: collect unique titles
                while (($data = fgetcsv($handle)) !== FALSE) {
                    $row = array_combine($headers, $data);
                    if (!in_array($row['Title'], $uniqueTitles)) {
                        $uniqueTitles[] = $row['Title'];
                    }
                }
                
                // Sort titles alphabetically
                sort($uniqueTitles);
                
                // If a training is selected, make a second pass to find expired trainings
                if (!empty($selectedTitle)) {
                    // Rewind the file pointer
                    rewind($handle);
                    // Skip header row again
                    fgetcsv($handle);
                    
                    $personTrainings = [];
                    
                    // Collect all trainings for the selected title
                    while (($data = fgetcsv($handle)) !== FALSE) {
                        $row = array_combine($headers, $data);
                        if ($row['Title'] === $selectedTitle) {
                            $identifier = $row['Identifier'];
                            $date = strtotime($row['ParticipationDate']);
                            
                            // Keep track of the most recent training for each person
                            if (!isset($personTrainings[$identifier]) || 
                                $date > strtotime($personTrainings[$identifier]['ParticipationDate'])) {
                                $personTrainings[$identifier] = $row;
                            }
                        }
                    }
                    
                    // Calculate the date 2 years ago
                    $twoYearsAgo = strtotime('-2 years');
                    
                    // Filter for expired trainings
                    foreach ($personTrainings as $training) {
                        if (strtotime($training['ParticipationDate']) <= $twoYearsAgo) {
                            $trainings[] = $training;
                        }
                    }
                    
                    // Sort by LastName, FirstName
                    usort($trainings, function($a, $b) {
                        $lastNameCompare = strcmp($a['LastName'], $b['LastName']);
                        if ($lastNameCompare !== 0) {
                            return $lastNameCompare;
                        }
                        return strcmp($a['FirstName'], $b['FirstName']);
                    });
                }
                
                fclose($handle);
            } else {
                throw new Exception("Could not open training data file");
            }
            
            require_once APP_ROOT . '/views/reports/expired.php';
        } catch (Exception $e) {
            error_log("Report generation error: " . $e->getMessage());
            echo "An error occurred while retrieving the report: " . $e->getMessage();
        }
    }
}

