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
            // Procesar la imagen si el rol es cliente
            if (isset($_GET['role']) && $_GET['role'] === 'client') {
                $photoPath = saveTemporaryImage($reparation->getImage(), $uuid);
                pixelateImage($photoPath);
                $reparation->setImage($photoPath);
            }

            header("Location: ../View/viewReparation.php?uuid=" . urlencode($uuid) . "&role=" . urlencode($_GET['role']));
            exit;
        } else {
            header("Location: ../View/viewReparation.php?message=Reparation Not Found");
            exit;
        }
    }
}

function validateImage($file): bool {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    $maxSize = 2 * 1024 * 1024;

    return in_array($file['type'], $allowedTypes) && $file['size'] <= $maxSize;
}

function saveTemporaryImage(string $imageData, string $uuid): string {
    $filePath = "../tmp/{$uuid}.png";
    file_put_contents($filePath, $imageData);
    return $filePath;
}

function pixelateImage(string $filePath): void {
    $image = imagecreatefromstring(file_get_contents($filePath));
    if ($image !== false) {
        $width = imagesx($image);
        $height = imagesy($image);

        $pixelSize = 10;

        for ($y = 0; $y < $height; $y += $pixelSize) {
            for ($x = 0; $x < $width; $x += $pixelSize) {
                $rgb = imagecolorat($image, $x, $y);
                imagefilledrectangle($image, $x, $y, $x + $pixelSize - 1, $y + $pixelSize - 1, $rgb);
            }
        }

        // Guardar la imagen pixelada
        imagepng($image, $filePath);
        imagedestroy($image);
    }
}
