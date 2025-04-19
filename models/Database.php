<?php
class Database {
    private $connection;

    public function __construct() {
        try {
            // Add charset and additional options for better compatibility
            $dsn = "mysql:host=" . DB_HOST . 
                   ";dbname=" . DB_NAME . 
                   ";charset=utf8mb4";
            
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            );

            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
            
        } catch (PDOException $e) {
            // Log detailed error information
            error_log("Database Connection Error: " . $e->getMessage());
            error_log("DSN: mysql:host=" . DB_HOST . ";dbname=" . DB_NAME);
            error_log("User: " . DB_USER);
            
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public function query($sql) {
        try {
            $stmt = $this->connection->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
            error_log("SQL: " . $sql);
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }
}
