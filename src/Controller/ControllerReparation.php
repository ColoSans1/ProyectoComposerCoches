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
        isset($_POST['car_model'], $_POST['issue_description'], $_POST['repair_date'], $_POST['name_workshop']) &&
        isset($_FILES['photo_url']) && $_FILES['photo_url']['error'] === UPLOAD_ERR_OK
    ) {
        $carModel = htmlspecialchars($_POST['car_model']);
        $issueDescription = htmlspecialchars($_POST['issue_description']);
        $repairDate = $_POST['repair_date'];  // Validar formato de fecha
        $workshopName = htmlspecialchars($_POST['name_workshop']);
        
        $licensePlate = !empty($_POST['license_plate']) ? htmlspecialchars($_POST['license_plate']) : 'DEFAULT_VALUE';

        // Validar carga de imagen
        $photo = $_FILES['photo_url'];
        if ($photo['error'] !== UPLOAD_ERR_OK) {
            die("Error al cargar la foto. Código de error: " . $photo['error']);
        }

        // Verificar si el archivo es una imagen válida
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($photo['type'], $allowedTypes)) {
            die("El archivo no es una imagen válida.");
        }

        // Obtener el contenido de la imagen
        $photoContent = file_get_contents($photo['tmp_name']);

        // Aquí insertamos la reparación
        $reparation = new Reparation(
            strtoupper(uniqid('WS', true)), // ID único del taller
            $workshopName,
            $repairDate,
            $licensePlate,
            $photoContent
        );

        $serviceReparation = new ServiceReparation();
        
        try {
            if ($serviceReparation->insertReparation($reparation)) {
                echo "Reparación registrada con éxito.";
            } else {
                echo "Error al registrar la reparación.";
            }
        } catch (Exception $e) {
            echo "Error al insertar la reparación: " . $e->getMessage();
        }
    } else {
        echo "Faltan datos para insertar la reparación o error en la carga de archivo.";
    }
}


    if (isset($_POST['action']) && $_POST['action'] === 'getReparation') {
        if (isset($_POST['reparation_id'])) {
            $reparationId = $_POST['reparation_id'];

            // Preparar la consulta para obtener la reparación por ID
            $stmt = $pdo->prepare("SELECT * FROM reparation WHERE id_reparacion = :id_reparacion");
            $stmt->bindParam(':id_reparacion', $reparationId, PDO::PARAM_INT);
            $stmt->execute();

            $reparation = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($reparation) {
                // Incluir la vista de la reparación
                require_once '../View/ViewReparation.php';
            } else {
                echo "No se encontró la reparación.";
            }
        } else {
            echo "ID de reparación no proporcionado.";
        }
    }

?>
