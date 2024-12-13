<?php

require_once '../Model/Reparation.php';

class ServiceReparation {
    private $connection = null;

    // Constructor para asegurarse de que la conexión esté establecida
    public function __construct() {
        if ($this->connection === null) {
            $this->connect(); // Conexión al crear la instancia.
        }
    }

    // Función para conectar a la base de datos
    public function connect() {
        // Cargar la configuración de la base de datos desde el archivo .ini
        $config = parse_ini_file(__DIR__ . '/../../db_config.ini');

        // Parámetros de conexión a la base de datos
        $servername = $config['servername'];
        $username = $config['username'];
        $password = $config['password'];
        $dbname = $config['dbname'];

        // Crear una nueva conexión PDO
        try {
            $this->connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->log("Database connected successfully", "INFO");
        } catch (PDOException $e) {
            $this->log("Connection failed: " . $e->getMessage(), "ERROR");
        }
    }

    // Función para insertar un registro de reparación en la base de datos
    public function insertReparation($reparation) {
        // Validar datos de entrada
        if (empty($reparation->getLicensePlate())) {
            $this->log("License plate is required", "ERROR");
            return false; // Devolver false si falta la matrícula
        }

        if ($this->connection === null) {
            $this->connect(); // Asegurarse de que la conexión esté establecida
        }

        // Preparar la declaración SQL para insertar la reparación
        $sql = "INSERT INTO reparation (id_workshop, name_workshop, register_date, license_plate, photo_url, watermark_text)
                VALUES (:id_workshop, :name_workshop, :register_date, :license_plate, :photo_url, :watermark_text)";
        
        try {
            $stmt = $this->connection->prepare($sql);

            // Vincular los parámetros con la consulta SQL
            $stmt->bindParam(':id_workshop', $reparation->getIdWorkshop());
            $stmt->bindParam(':name_workshop', $reparation->getNameWorkshop());
            $stmt->bindParam(':register_date', $reparation->getRegisterDate());
            $stmt->bindParam(':license_plate', $reparation->getLicensePlate());
            $stmt->bindParam(':photo_url', $reparation->getPhotoUrl());
            $stmt->bindParam(':watermark_text', $reparation->getWatermarkText());

            // Ejecutar la consulta
            $stmt->execute();
            $this->log("Reparation inserted successfully", "INFO");
            return true; // Devolver true si la inserción es exitosa
        } catch (PDOException $e) {
            $this->log("Error inserting reparation: " . $e->getMessage(), "ERROR");
            return false; // Devolver false si ocurre un error
        }
    }

    // Función para obtener un registro de reparación de la base de datos por ID
    public function getReparation($id_reparation) {
        if ($this->connection === null) {
            $this->connect(); // Asegurarse de que la conexión esté establecida
        }

        // Preparar la declaración SQL para obtener la reparación por ID
        $sql = "SELECT * FROM reparation WHERE id_reparation = :id_reparation";
        
        try {
            $stmt = $this->connection->prepare($sql);

            // Vincular el parámetro con la consulta SQL
            $stmt->bindParam(':id_reparation', $id_reparation);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener el resultado como un array asociativo
            $reparation = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($reparation) {
                $this->log("Reparation fetched successfully", "INFO");
                return $reparation; // Devolver los datos de la reparación si se encuentra
            } else {
                $this->log("No reparation found with ID: $id_reparation", "WARNING");
                return null; // Devolver null si no se encuentra ninguna reparación
            }
        } catch (PDOException $e) {
            $this->log("Error fetching reparation: " . $e->getMessage(), "ERROR");
            return null; // Devolver null si ocurre un error
        }
    }

    // Función para registrar las operaciones de la base de datos
    private function log($message, $level, $logFile = '../logs/app_workshop.log') {
        // Asegurarse de que el archivo de log esté definido
        $timestamp = date("Y-m-d H:i:s");
        $logMessage = "[$timestamp] [$level] $message\n";

        // Escribir el mensaje en el archivo de log
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    // Función para obtener el último ID insertado de la reparación
    public function getLastInsertId() {
        return $this->connection->lastInsertId();
    }
}

?>
