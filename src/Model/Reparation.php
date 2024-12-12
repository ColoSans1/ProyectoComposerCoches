<?php

class Reparation {
    private $id_reparation;
    private $id_workshop;
    private $name_workshop;
    private $register_date;
    private $license_plate;
    private $photo_url;
    private $watermark_text;

    public function __construct($id_workshop, $name_workshop, $register_date, $license_plate, $photo_url, $watermark_text = null, $id_reparation = null) {
        $this->id_reparation = $id_reparation;
        $this->id_workshop = $id_workshop;
        $this->name_workshop = $name_workshop;
        $this->register_date = $register_date;
        $this->license_plate = $license_plate;
        $this->photo_url = $photo_url;
        $this->watermark_text = $watermark_text;
    }

    // Getter and Setter for id_reparation
    public function getIdReparation() {
        return $this->id_reparation;
    }

    public function setIdReparation($id_reparation) {
        $this->id_reparation = $id_reparation;
    }

    // Getter and Setter for id_workshop
    public function getIdWorkshop() {
        return $this->id_workshop;
    }

    public function setIdWorkshop($id_workshop) {
        $this->id_workshop = $id_workshop;
    }

    // Getter and Setter for name_workshop
    public function getNameWorkshop() {
        return $this->name_workshop;
    }

    public function setNameWorkshop($name_workshop) {
        $this->name_workshop = $name_workshop;
    }

    // Getter and Setter for register_date
    public function getRegisterDate() {
        return $this->register_date;
    }

    public function setRegisterDate($register_date) {
        $this->register_date = $register_date;
    }

    // Getter and Setter for license_plate
    public function getLicensePlate() {
        return $this->license_plate;
    }

    public function setLicensePlate($license_plate) {
        $this->license_plate = $license_plate;
    }

    // Getter and Setter for photo_url
    public function getPhotoUrl() {
        return $this->photo_url;
    }

    public function setPhotoUrl($photo_url) {
        $this->photo_url = $photo_url;
    }

    // Getter and Setter for watermark_text
    public function getWatermarkText() {
        return $this->watermark_text;
    }

    public function setWatermarkText($watermark_text) {
        $this->watermark_text = $watermark_text;
    }

    // This method would be used to return an array representation of the reparation data
    public function toArray() {
        return [
            'id_reparation' => $this->id_reparation,
            'id_workshop' => $this->id_workshop,
            'name_workshop' => $this->name_workshop,
            'register_date' => $this->register_date,
            'license_plate' => $this->license_plate,
            'photo_url' => $this->photo_url,
            'watermark_text' => $this->watermark_text
        ];
    }
}

?>
