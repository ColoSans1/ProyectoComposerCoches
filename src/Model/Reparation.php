<?php

namespace Src\Model;

class Reparation {
    private string $uuid;
    private int $workshopId;
    private string $workshopName;
    private string $registerDate;
    private string $licensePlate;
    private $image;

    public function __construct($uuid, $workshopId = 0, $workshopName, $registerDate, $licensePlate, $photoContent) {
        $this->uuid = $uuid;
        $this->workshopId = $workshopId;
        $this->workshopName = $workshopName;
        $this->registerDate = $registerDate;
        $this->licensePlate = $licensePlate;
        $this->image = $photoContent;
    }

    public function getWorkshopName(): string {
        return $this->workshopName;
    }

    public function getWorkshopId(): int {
        return $this->workshopId;
    }

    public function getRegisterDate(): string {
        return $this->registerDate;
    }

    public function getLicensePlate(): string {
        return $this->licensePlate;
    }

    public function getImage() {
        if ($this->image) {
            $imageData = base64_encode($this->image);
            $mimeType = 'image/jpeg'; 
            return "data:$mimeType;base64,$imageData";
        }
        return null;
    }

    public function getUuid(): string {
        return $this->uuid;
    }
}
