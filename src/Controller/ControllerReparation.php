<?php

require_once '../Model/Reparation.php';
require_once '../Service/ServiceReparation.php';

use Src\Model\Reparation;
use Src\Service\ServiceReparation;

$serviceReparation = new ServiceReparation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['insertReparation'])) {
        $workshopId = $_POST['workshopId'];
        $workshopName = $_POST['workshopName'];
        $registerDate = $_POST['registerDate'];
        $licensePlate = $_POST['licensePlate'];
        $photo = $_FILES['photo'];

        if ($photo['error'] === UPLOAD_ERR_OK && validateImage($photo)) {
            $photoContent = file_get_contents($photo['tmp_name']);
            $uuid = strtoupper(uniqid('REP-', true));

            $reparation = new Reparation($uuid, $workshopId, $workshopName, $registerDate, $licensePlate, $photoContent);

            $serviceReparation->insertReparation($reparation);

            header("Location: ../View/viewReparation.php?message=Reparation Registered Successfully");
            exit;
        } else {
            header("Location: ../View/viewReparation.php?message=Invalid Image Upload");
            exit;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['getReparation']) && !empty($_GET['uuid'])) {
        $uuid = $_GET['uuid'];
        $reparation = $serviceReparation->getReparationByUuid($uuid);

        if ($reparation) {
            header("Location: ../View/viewReparation.php?uuid=" . urlencode($uuid));
            exit;
        } else {
            header("Location: ../View/viewReparation.php?message=Reparation Not Found");
            exit;
        }
    }
}

/**
 * Valida el archivo de imagen.
 * 
 * @param array $file El archivo a validar.
 * @return bool Retorna true si la imagen es válida, false en caso contrario.
 */
function validateImage($file): bool {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    $maxSize = 2 * 1024 * 1024;

    return in_array($file['type'], $allowedTypes) && $file['size'] <= $maxSize;
}
