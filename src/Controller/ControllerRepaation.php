<?php

require_once '../Model/Reparation.php';
require_once '../Service/ServiceReparation.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $carModel = $_POST['car_model'];
    $licensePlate = isset($_POST['license_plate']) && !empty($_POST['license_plate']) ? $_POST['license_plate'] : 'DEFAULT_VALUE';
    $issueDescription = $_POST['issue_description'];
    $repairDate = $_POST['repair_date'];
    $idWorkshop = $_POST['id_workshop'];
    $nameWorkshop = $_POST['name_workshop'];
    $photoUrl = $_POST['photo_url'];
    $watermarkText = $_POST['watermark_text'];

    $reparation = new Reparation(
        $idWorkshop, // ID del taller
        $nameWorkshop, // Nombre del taller
        $repairDate, 
        $licensePlate, 
        $photoUrl, 
        $watermarkText
    );

    // Inserción de la reparación (utilizando el servicio de inserción)
    $serviceReparation = new ServiceReparation();
    if ($serviceReparation->insertReparation($reparation)) {
        echo "Reparación registrada con éxito.";
    } else {
        echo "Hubo un error al registrar la reparación.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['car_model'], $_POST['issue_description'], $_POST['repair_date'], $_POST['id_workshop'], $_POST['name_workshop'], $_POST['photo_url'], $_POST['watermark_text'])) {
        $carModel = $_POST['car_model'];
        $issueDescription = $_POST['issue_description'];
        $repairDate = $_POST['repair_date'];
        $idWorkshop = $_POST['id_workshop'];
        $nameWorkshop = $_POST['name_workshop'];
        $photoUrl = $_FILES['photo_url'];
        $watermarkText = $_POST['watermark_text'];

        // Aquí va la lógica para registrar la reparación en la base de datos
        $query = "INSERT INTO repairs (car_model, issue_description, repair_date, id_workshop, name_workshop, photo_url, watermark_text)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$carModel, $issueDescription, $repairDate, $idWorkshop, $nameWorkshop, $photoUrl, $watermarkText]);

        echo "Reparación registrada con éxito.";
    } else {
        echo "Faltan algunos campos. Por favor, verifica que todos los campos estén completos.";
    }
}



?>
