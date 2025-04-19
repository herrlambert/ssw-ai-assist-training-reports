<?php
require_once APP_ROOT . '/models/Database.php';

class ReportsController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function byPerson() {
        try {
            $query = "SELECT 
                        TrainingActivityId,
                        CertificationActivityId,
                        Title,
                        ParticipationDate,
                        FirstName,
                        LastName,
                        NewIdentifier
                    FROM training_activities 
                    WHERE NewIdentifier = 'sanp'
                    ORDER BY ParticipationDate DESC";
            
            $trainings = $this->db->query($query);
            
            require_once APP_ROOT . '/views/reports/by_person.php';
        } catch (Exception $e) {
            // Log error and show user-friendly message
            error_log($e->getMessage());
            echo "An error occurred while retrieving the report.";
        }
    }
}