<?php

require_once '../Service/ServiceReparation.php';

class ControllerReparation {
    private $serviceReparation;

    public function __construct() {
        $this->serviceReparation = new ServiceReparation();
    }

    public function insertReparation() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST; 
            $photo = $_FILES['photo'];
            $watermark = $data['license_plate'] . '-' . uniqid();
            $photoUrl = $this->uploadPhotoWithWatermark($photo, $watermark);

            if ($photoUrl) {
                $reparation = new Reparation($data['id_workshop'], $data['name_workshop'], $data['register_date'], $data['license_plate'], $photoUrl, $watermark);
                $insertSuccess = $this->serviceReparation->insertReparation($reparation);

                if ($insertSuccess) {
                    $this->renderView('insert_success', ['id_reparation' => $this->serviceReparation->getLastInsertId()]);
                } else {
                    $this->renderView('insert_error', ['message' => 'Error: Unable to register reparation.']);
                }
            } else {
                $this->renderView('insert_error', ['message' => 'Error: Unable to upload photo.']);
            }
        } else {
            $this->renderView('reparation_form');
        }
    }

    public function getReparation() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id_reparation'])) {
            $reparation = $this->serviceReparation->getReparation($_GET['id_reparation']);
            if ($reparation) {
                if ($_SESSION['role'] == 'client') {
                    $reparation['license_plate'] = '****-***'; 
                }
                $this->renderView('reparation_details', $reparation);
            } else {
                $this->renderView('query_error', ['message' => 'Error: Reparation not found.']);
            }
        } else {
            $this->renderView('query_error', ['message' => 'Error: No reparation ID provided.']);
        }
    }

    private function uploadPhotoWithWatermark($photo, $watermark) {
        if ($photo['error'] == UPLOAD_ERR_OK) {
            $fileName = uniqid() . '.' . pathinfo($photo['name'], PATHINFO_EXTENSION);
            $filePath = '../uploads/' . $fileName;
            if (move_uploaded_file($photo['tmp_name'], $filePath)) {
                $this->addWatermarkToImage($filePath, $watermark);
                return $filePath;
            }
        }
        return null;
    }

    private function addWatermarkToImage($imagePath, $watermarkText) {
        $image = imagecreatefromjpeg($imagePath);
        $color = imagecolorallocate($image, 255, 255, 255);
        $font = 'arial.ttf';
        list($width, $height) = getimagesize($imagePath);
        $bbox = imagettfbbox(20, 0, $font, $watermarkText);
        $x = $width - $bbox[2] - 10;
        $y = $height - 10;
        imagettftext($image, 20, 0, $x, $y, $color, $font, $watermarkText);
        imagejpeg($image, $imagePath);
        imagedestroy($image);
    }

    private function renderView($viewName, $data = []) {
        extract($data);
        include "../views/$viewName.php";
    }
}

?>
