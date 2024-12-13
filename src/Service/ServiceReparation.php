<?php

require_once __DIR__ . '/../Model/Reparation.php';

class ServiceReparation {
    private $connection = null;

    // Constructor: Se conecta a la base de datos
    public function __construct() {
        if ($this->connection === null) {
            $this->connect();
        }
    }

    // Conexión a la base de datos
    private function connect() {
        // Cargar la configuración del archivo INI
        $config = parse_ini_file(__DIR__ . '/../../db_config.ini');
        if (!$config) {
            die("Error: No se pudo cargar el archivo de configuración.");
        }
        
        // Verificar que existan todas las claves necesarias en el archivo de configuración
        if (!isset($config['servername'], $config['username'], $config['password'], $config['dbname'])) {
            die("Error: Faltan algunas claves en el archivo de configuración.");
        }

        try {
            // Conexión PDO a la base de datos
            $this->connection = new PDO(
                "mysql:host={$config['servername']};dbname={$config['dbname']}",
                $config['username'],
                $config['password'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Inserción de una nueva reparación
    public function insertReparation($reparation) {
        // Preparar la consulta SQL de inserción
        $sql = "INSERT INTO reparation 
                (name_workshop, register_date, license_plate, photo_url, watermark_text)
                VALUES (:name_workshop, :register_date, :license_plate, :photo_url, :watermark_text)";

        // Preparar la sentencia
        $stmt = $this->connection->prepare($sql);

        // Obtener los valores del objeto $reparation
        $nameWorkshop = $reparation->getNameWorkshop();
        $registerDate = $reparation->getRegisterDate();
        $licensePlate = $reparation->getLicensePlate();
        $photoUrl = $reparation->getPhotoUrl();
        $watermarkText = $reparation->getWatermarkText();

        // Vincular los parámetros de la consulta con las variables
        $stmt->bindParam(':name_workshop', $nameWorkshop);
        $stmt->bindParam(':register_date', $registerDate);
        $stmt->bindParam(':license_plate', $licensePlate);
        $stmt->bindParam(':photo_url', $photoUrl);
        $stmt->bindParam(':watermark_text', $watermarkText);

        // Ejecutar la consulta y devolver el resultado
        return $stmt->execute();
    }
}
