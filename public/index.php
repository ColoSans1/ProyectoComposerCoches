<?php
// Incluir la clase Reparation
require_once '../src/Reparation.php';

// Usar la clase Reparation
$reparation = new Reparation(1, '2024-12-11', '1234-XYZ', 'path/to/photo.jpg', '1234-XYZ - REPAIR-ID');
$id_reparation = $reparation->registerReparation();

if ($id_reparation) {
    echo "Reparación registrada con éxito. ID: " . $id_reparation;
} else {
    echo "Error al registrar la reparación.";
}
?>
