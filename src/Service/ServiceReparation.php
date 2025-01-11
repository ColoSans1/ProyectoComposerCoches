<?php

namespace Src\Service;

require_once __DIR__ . '/../../vendor/autoload.php';
use Src\Model\Reparation;

class ServiceReparation {
    private $connection = null;

    public function __construct() {
        if ($this->connection === null) {
            $this->connect();
        }
    }

    private function connect() {
        $host = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "Workshop";

        try {
            $this->connection = new \PDO(
                "mysql:host={$host};dbname={$dbname}",
                $username,
                $password,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        } catch (\PDOException $e) {
            throw new \Exception("Error de conexión: " . $e->getMessage());
        }
    }

    public function insertReparation(Reparation $reparation): bool {
        $sql = "INSERT INTO reparation 
                (uuid, workshopId, workshopName, registerDate, licensePlate, photo)
                VALUES (:uuid, :workshopId, :workshopName, :registerDate, :licensePlate, :photo)";
        
        $stmt = $this->connection->prepare($sql);

        $uuid = $reparation->getUuid();
        $workshopId = $reparation->getWorkshopId();
        $workshopName = $reparation->getWorkshopName();
        $registerDate = $reparation->getRegisterDate();
        $licensePlate = $reparation->getLicensePlate();
        $photo = $reparation->getImage();

        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':workshopId', $workshopId, \PDO::PARAM_INT);
        $stmt->bindParam(':workshopName', $workshopName);
        $stmt->bindParam(':registerDate', $registerDate);
        $stmt->bindParam(':licensePlate', $licensePlate);
        $stmt->bindParam(':photo', $photo, \PDO::PARAM_LOB);

        try {
            $result = $stmt->execute();
            return $result;
        } catch (\PDOException $e) {
            throw new \Exception("Error al ejecutar la consulta: " . $e->getMessage());
        }
    }

    public function getReparationByUuid($uuid): ?Reparation {
        $sql = "SELECT * FROM reparation WHERE uuid = :uuid";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':uuid', $uuid);
        
        try {
            $stmt->execute();
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        
            if ($row) {
                $photo = null;
                if ($row['photo']) {
                    $photoData = base64_encode($row['photo']); 
                    $photoMime = 'image/jpeg'; 
                    $photo = "data:$photoMime;base64,$photoData"; 
                }
        
                return new Reparation(
                    $row["uuid"],
                    $row["workshopId"],
                    $row["workshopName"],
                    $row["registerDate"],
                    $row["licensePlate"],
                    $photo
                );
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            throw new \Exception("Error al ejecutar la consulta: " . $e->getMessage());
        }
    }
    
}
?>
