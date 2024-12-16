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
        } else {
            print_r($config); 
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
        $sql = "INSERT INTO reparation 
                (name_workshop, register_date, license_plate, photo_url, watermark_text)
                VALUES (:name_workshop, :register_date, :license_plate, :photo_url, :watermark_text)";
        $stmt = $this->connection->prepare($sql);
    
        $nameWorkshop = $reparation->getNameWorkshop();
        $registerDate = $reparation->getRegisterDate();
        $licensePlate = $reparation->getLicensePlate();
        $photoUrl = $reparation->getPhotoUrl();
        $watermarkText = $reparation->getWatermarkText();
    
        $stmt->bindParam(':name_workshop', $nameWorkshop);
        $stmt->bindParam(':register_date', $registerDate);
        $stmt->bindParam(':license_plate', $licensePlate);
        $stmt->bindParam(':photo_url', $photoUrl);
        $stmt->bindParam(':watermark_text', $watermarkText);
    
        try {
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            // Imprimir el error para depurar
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return false;
        }
    }
    
}

?>
