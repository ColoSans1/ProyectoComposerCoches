<?php

require_once '../Model/Reparation.php';
require_once '../Service/ServiceReparation.php';

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=Workshop", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['car_model'], $_POST['issue_description'], $_POST['repair_date'], $_POST['id_workshop'], $_POST['name_workshop']) &&
        isset($_FILES['photo_url']) && $_FILES['photo_url']['error'] === UPLOAD_ERR_OK
    ) {
        $licensePlate = !empty($_POST['license_plate']) ? htmlspecialchars($_POST['license_plate']) : 'DEFAULT_VALUE';
        $photoContent = file_get_contents($_FILES['photo_url']['tmp_name']);

        $reparation = new Reparation(
            $_POST['id_workshop'],
            htmlspecialchars($_POST['name_workshop']),
            $_POST['repair_date'],
            $licensePlate,
            $photoContent
        );

        // Usar el servicio para insertar la reparación
        $serviceReparation = new ServiceReparation();
        if ($serviceReparation->insertReparation($reparation)) {
            echo "Reparación registrada con éxito.";
        } else {
            echo "Error al registrar la reparación.";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'getReparation') {
        $reparationId = $_POST['reparation_id'];
    
        $stmt = $pdo->prepare("SELECT * FROM reparation WHERE id_reparacion = :id_reparacion");
        $stmt->bindParam(':id_reparacion', $reparationId, PDO::PARAM_INT);
        $stmt->execute();
    
        $reparation = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($reparation) {
            require_once '../View/ViewReparation.php';
        } else {
            echo "No se encontró la reparación.";
        }
    }
    
}
?>
