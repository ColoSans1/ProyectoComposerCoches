<?php
require_once 'C:\xampp_daw2\htdocs\ProyectoComposerCoches\src\Service\ServiceReparation.php';

class Reparation {
    private $id_workshop;
    private $name_workshop;
    private $register_date;
    private $license_plate;
    private $photo_url;
    private $watermark_text;

    public function __construct($id_workshop, $name_workshop, $register_date, $license_plate = '', $photo_url, $watermark_text) {
        $this->id_workshop = $id_workshop;
        $this->name_workshop = $name_workshop;
        $this->register_date = $register_date;
        $this->license_plate = $license_plate; 
        $this->photo_url = $photo_url;
        $this->watermark_text = $watermark_text;
    }
    

    public function getIdWorkshop() {
        return $this->id_workshop;
    }

    public function getNameWorkshop() {
        return $this->name_workshop;
    }

    public function getRegisterDate() {
        return $this->register_date;
    }

    public function getLicensePlate() {
        return $this->license_plate;
    }

    public function getPhotoUrl() {
        return $this->photo_url;
    }

    public function getWatermarkText() {
        return $this->watermark_text;
    }
}

?>
