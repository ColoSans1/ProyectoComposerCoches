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
        isset($_POST['car_model'], $_POST['issue_description'], $_POST['repair_date'], $_POST['id_workshop'], $_POST['name_workshop']) &&
        isset($_FILES['photo_url']) && $_FILES['photo_url']['error'] === UPLOAD_ERR_OK 
    ) {
        $carModel = htmlspecialchars($_POST['car_model']);
        $licensePlate = isset($_POST['license_plate']) && !empty($_POST['license_plate']) ? htmlspecialchars($_POST['license_plate']) : 'DEFAULT_VALUE';
        $issueDescription = htmlspecialchars($_POST['issue_description']);
        $repairDate = $_POST['repair_date'];
        $idWorkshop = $_POST['id_workshop'];
        $nameWorkshop = htmlspecialchars($_POST['name_workshop']);

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $mimeType = mime_content_type($_FILES['photo_url']['tmp_name']);
        
        if (!in_array($mimeType, $allowedMimeTypes)) {
            echo "El archivo debe ser una imagen JPEG, PNG o GIF.";
            exit;
        }

        $photoContent = file_get_contents($_FILES['photo_url']['tmp_name']);
        
        if (!$photoContent) {
            echo "No se pudo leer el contenido del archivo.";
            exit;
        }

        $reparation = new Reparation(
            $idWorkshop,      
            $nameWorkshop,    
            $repairDate,      
            $licensePlate,    
            $photoContent     
        );

        $serviceReparation = new ServiceReparation();
        if ($serviceReparation->insertReparation($reparation)) {
            echo "Reparación registrada con éxito mediante ServiceReparation.";
        } else {
            echo "Error al registrar la reparación usando ServiceReparation.";
        }

        $query = "INSERT INTO reparation (id_taller, nombre_taller, fecha_registro, matricula_vehiculo, foto_vehiculo)
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $idWorkshop);
        $stmt->bindParam(2, $nameWorkshop);
        $stmt->bindParam(3, $repairDate);
        $stmt->bindParam(4, $licensePlate);
        $stmt->bindParam(5, $photoContent, PDO::PARAM_LOB);  // Usar PDO::PARAM_LOB para almacenar el archivo binario

        if ($stmt->execute()) {
            echo "Reparación registrada con éxito en la base de datos con la foto.";
        } else {
            echo "Error al registrar la reparación en la base de datos: " . implode(" - ", $stmt->errorInfo());
        }
    } else {
        echo "Faltan campos obligatorios o hay un problema con la imagen.";
    }
}

if (isset($_POST['action']) && $_POST['action'] === 'getReparation') {
    $reparationId = $_POST['reparation_id'];

    $query = "SELECT * FROM reparation WHERE id_reparacion = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $reparationId, PDO::PARAM_INT);
    $stmt->execute();

    $reparation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reparation) {
        header('Content-Type: image/jpeg');  
        echo $reparation['foto_vehiculo']; 
        exit;
    } else {
        echo "<div class='alert alert-danger'>Reparación no encontrada.</div>";
    }
}

?>
