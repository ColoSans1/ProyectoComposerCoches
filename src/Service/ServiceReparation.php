<?php

require_once '../Model/Reparation.php';

class ServiceReparation {
    private $connection;

    // Function to connect to the database
    public function connect() {
        // Load the database configuration from the .ini file
        $config = parse_ini_file('../db_config.ini');

        // Database connection parameters
        $servername = $config['servername'];
        $username = $config['username'];
        $password = $config['password'];
        $dbname = $config['dbname'];

        // Create a new PDO connection
        try {
            $this->connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->log("Database connected successfully", "INFO");
        } catch (PDOException $e) {
            $this->log("Connection failed: " . $e->getMessage(), "ERROR");
        }
    }

    // Function to insert a reparation record into the database
    public function insertReparation($reparation) {
        if ($this->connection == null) {
            $this->connect(); // Ensure database connection is established
        }

        // Prepare SQL statement to insert the reparation
        $sql = "INSERT INTO reparation (id_workshop, name_workshop, register_date, license_plate, photo_url, watermark_text)
                VALUES (:id_workshop, :name_workshop, :register_date, :license_plate, :photo_url, :watermark_text)";
        
        try {
            $stmt = $this->connection->prepare($sql);

            // Bind parameters to the SQL query
            $stmt->bindParam(':id_workshop', $reparation->getIdWorkshop());
            $stmt->bindParam(':name_workshop', $reparation->getNameWorkshop());
            $stmt->bindParam(':register_date', $reparation->getRegisterDate());
            $stmt->bindParam(':license_plate', $reparation->getLicensePlate());
            $stmt->bindParam(':photo_url', $reparation->getPhotoUrl());
            $stmt->bindParam(':watermark_text', $reparation->getWatermarkText());

            // Execute the query
            $stmt->execute();
            $this->log("Reparation inserted successfully", "INFO");
            return true; // Return true if insertion is successful
        } catch (PDOException $e) {
            $this->log("Error inserting reparation: " . $e->getMessage(), "ERROR");
            return false; // Return false if an error occurs
        }
    }

    // Function to get a reparation record from the database by ID
    public function getReparation($id_reparation) {
        if ($this->connection == null) {
            $this->connect(); // Ensure database connection is established
        }

        // Prepare SQL statement to fetch reparation by ID
        $sql = "SELECT * FROM reparation WHERE id_reparation = :id_reparation";
        
        try {
            $stmt = $this->connection->prepare($sql);

            // Bind parameter to the SQL query
            $stmt->bindParam(':id_reparation', $id_reparation);

            // Execute the query
            $stmt->execute();

            // Fetch the result as an associative array
            $reparation = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($reparation) {
                $this->log("Reparation fetched successfully", "INFO");
                return $reparation; // Return reparation data if found
            } else {
                $this->log("No reparation found with ID: $id_reparation", "WARNING");
                return null; // Return null if no reparation is found
            }
        } catch (PDOException $e) {
            $this->log("Error fetching reparation: " . $e->getMessage(), "ERROR");
            return null; // Return null if an error occurs
        }
    }

    // Function to log database operations
    private function log($message, $level) {
        // Log the message to a file with the specified log level
        $logFile = '../logs/app_workshop.log';
        $timestamp = date("Y-m-d H:i:s");
        $logMessage = "[$timestamp] [$level] $message\n";

        // Write log message to the file
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    // Function to get the last inserted ID for reparation
    public function getLastInsertId() {
        return $this->connection->lastInsertId();
    }
}

?>
