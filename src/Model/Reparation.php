<?php
require_once 'C:\xampp_daw2\htdocs\ProyectoComposerCoches\src\Service\ServiceReparation.php';

class Reparation {
    private $id_taller;             
    private $nombre_taller;          
    private $fecha_registro;        
    private $matricula_vehiculo;    
    private $foto_vehiculo;          
    private $watermark_text;

    public function __construct($id_taller, $nombre_taller, $fecha_registro, $matricula_vehiculo = '', $foto_vehiculo, $watermark_text) {
        $this->id_taller = $id_taller;
        $this->nombre_taller = $nombre_taller;
        $this->fecha_registro = $fecha_registro;
        $this->matricula_vehiculo = $matricula_vehiculo;
        $this->foto_vehiculo = $foto_vehiculo;
        $this->watermark_text = $watermark_text;
    }

    // Métodos getter actualizados
    public function getIdTaller() {
        return $this->id_taller;
    }

    public function getNombreTaller() {
        return $this->nombre_taller;
    }

    public function getFechaRegistro() {
        return $this->fecha_registro;
    }

    public function getMatriculaVehiculo() {
        return $this->matricula_vehiculo;
    }

    public function getFotoVehiculo() {
        return $this->foto_vehiculo;
    }

    public function getWatermarkText() {
        return $this->watermark_text;
    }
}
?>
