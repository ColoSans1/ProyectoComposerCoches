<?php

require_once __DIR__ . '/../Model/Reparation.php';

class ServiceReparation {
    private $connection = null;

    public function __construct() {
        if ($this->connection === null) {
            $this->connect();
        }
    }

    private function connect() {
        $config = parse_ini_file(__DIR__ . '/../../db_config.ini');
        if (!$config) {
            die("Error: No se pudo cargar el archivo de configuración.");
        } else {
            print_r($config); 
        }

        if (!isset($config['servername'], $config['username'], $config['password'], $config['dbname'])) {
            die("Error: Faltan algunas claves en el archivo de configuración.");
        }

        try {
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
    public function insertReparation($reparation)
    {
        $sql = "INSERT INTO reparation 
                (id_taller, nombre_taller, fecha_registro, matricula_vehiculo, foto_vehiculo)
                VALUES (:id_taller, :nombre_taller, :fecha_registro, :matricula_vehiculo, :foto_vehiculo)";
        $stmt = $this->connection->prepare($sql);
    
        $idTaller = $reparation->getIdTaller();
        $nombreTaller = $reparation->getNombreTaller();
        $fechaRegistro = $reparation->getFechaRegistro();
        $matriculaVehiculo = $reparation->getMatriculaVehiculo();
        $fotoVehiculo = $reparation->getFotoVehiculo(); 
    
        $stmt->bindParam(':id_taller', $idTaller, PDO::PARAM_INT);
        $stmt->bindParam(':nombre_taller', $nombreTaller, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_registro', $fechaRegistro, PDO::PARAM_STR);
        $stmt->bindParam(':matricula_vehiculo', $matriculaVehiculo, PDO::PARAM_STR);
        $stmt->bindParam(':foto_vehiculo', $fotoVehiculo, PDO::PARAM_LOB);
    
        try {
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return false;
        }
    }
    
    
}

?>
