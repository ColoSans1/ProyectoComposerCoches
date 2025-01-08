<?php

require_once '../Model/Reparation.php';
require_once '../Service/ServiceReparation.php';

$servername = '127.0.0.1';
$username = 'root';
$password = '';
$dbname = 'Workshop';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['car_model'], $_POST['issue_description'], $_POST['repair_date'], $_POST['id_workshop'], $_POST['name_workshop'], $_POST['watermark_text']) &&
        isset($_FILES['photo_url']) && $_FILES['photo_url']['error'] === UPLOAD_ERR_OK
    ) {
        $carModel = htmlspecialchars($_POST['car_model']);
        $licensePlate = isset($_POST['license_plate']) && !empty($_POST['license_plate']) ? htmlspecialchars($_POST['license_plate']) : 'DEFAULT_VALUE';
        $issueDescription = htmlspecialchars($_POST['issue_description']);
        $repairDate = $_POST['repair_date'];
        $idWorkshop = $_POST['id_workshop'];
        $nameWorkshop = htmlspecialchars($_POST['name_workshop']);
        $watermarkText = htmlspecialchars($_POST['watermark_text']);
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); 
        }

        $photoName = basename($_FILES['photo_url']['name']);
        $photoPath = $uploadDir . $photoName;

        if (move_uploaded_file($_FILES['photo_url']['tmp_name'], $photoPath)) {
            $reparation = new Reparation(
                $idWorkshop,      
                $nameWorkshop,    
                $repairDate,      
                $licensePlate,    
                $photoPath,       
                $watermarkText    
            );

            $serviceReparation = new ServiceReparation();
            if ($serviceReparation->insertReparation($reparation)) {
                echo "Reparación registrada con éxito mediante ServiceReparation.";
            } else {
                echo "Error al registrar la reparación usando ServiceReparation.";
            }

            $query = "INSERT INTO reparation (name_workshop, register_date, license_plate, photo_url, watermark_text)
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$nameWorkshop, $repairDate, $licensePlate, $photoPath, $watermarkText]);

            echo "Reparación registrada con éxito en la base de datos.";
        } else {
            echo "Error al subir la imagen. Verifica permisos de la carpeta uploads.";
        }
    } else {
        echo "Faltan campos obligatorios o hay un problema con la imagen.";
    }
}

if ($_POST['action'] === 'getReparation') {
    $reparationId = $_POST['reparation_id'];

    $query = "SELECT * FROM reparation WHERE id_reparation = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $reparationId, PDO::PARAM_INT);
    $stmt->execute();

    $reparation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reparation) {
        include '../view/ViewReparation.php';
    } else {
        echo "<div class='alert alert-danger'>Reparation not found.</div>";
    }
}


?>
