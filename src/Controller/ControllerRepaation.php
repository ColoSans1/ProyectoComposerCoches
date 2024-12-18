<?php

require_once '../Model/Reparation.php';
require_once '../Service/ServiceReparation.php';

// Configuración de la conexión a la base de datos
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
    // Validación de los campos
    if (
        isset($_POST['car_model'], $_POST['issue_description'], $_POST['repair_date'], $_POST['id_workshop'], $_POST['name_workshop'], $_POST['watermark_text']) &&
        isset($_FILES['photo_url']) && $_FILES['photo_url']['error'] === UPLOAD_ERR_OK
    ) {
        // Capturar datos del formulario
        $carModel = htmlspecialchars($_POST['car_model']);
        $licensePlate = isset($_POST['license_plate']) && !empty($_POST['license_plate']) ? htmlspecialchars($_POST['license_plate']) : 'DEFAULT_VALUE';
        $issueDescription = htmlspecialchars($_POST['issue_description']);
        $repairDate = $_POST['repair_date'];
        $idWorkshop = $_POST['id_workshop'];
        $nameWorkshop = htmlspecialchars($_POST['name_workshop']);
        $watermarkText = htmlspecialchars($_POST['watermark_text']);

        // Manejar subida de la imagen
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Crea la carpeta si no existe
        }

        $photoName = basename($_FILES['photo_url']['name']);
        $photoPath = $uploadDir . $photoName;

        if (move_uploaded_file($_FILES['photo_url']['tmp_name'], $photoPath)) {
            // Crear instancia de la clase Reparation
            $reparation = new Reparation(
                $idWorkshop,      // ID del taller
                $nameWorkshop,    // Nombre del taller
                $repairDate,      // Fecha de reparación
                $licensePlate,    // Matrícula (con valor por defecto si falta)
                $photoPath,       // Ruta de la imagen
                $watermarkText    // Texto de la marca de agua
            );

            // Insertar usando el servicio ServiceReparation
            $serviceReparation = new ServiceReparation();
            if ($serviceReparation->insertReparation($reparation)) {
                echo "Reparación registrada con éxito mediante ServiceReparation.";
            } else {
                echo "Error al registrar la reparación usando ServiceReparation.";
            }

            // Opcional: Inserción directa en la base de datos
            $query = "INSERT INTO repairs (car_model, issue_description, repair_date, id_workshop, name_workshop, photo_url, watermark_text)
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$carModel, $issueDescription, $repairDate, $idWorkshop, $nameWorkshop, $photoPath, $watermarkText]);

            echo "Reparación registrada con éxito en la base de datos.";
        } else {
            echo "Error al subir la imagen. Verifica permisos de la carpeta uploads.";
        }
    } else {
        echo "Faltan campos obligatorios o hay un problema con la imagen.";
    }
}
?>
