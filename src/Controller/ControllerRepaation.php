<?php

require_once '../Model/Reparation.php';
require_once '../Service/ServiceReparation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'insertReparation') {
            // Obtener los datos del formulario
            $car_model = $_POST['car_model'];
            $issue_description = $_POST['issue_description'];
            $repair_date = $_POST['repair_date'];

            // Crear una instancia de Reparation
            $reparation = new Reparation(
                null, // ID se genera automáticamente
                $car_model, 
                $repair_date,
                null, // License plate no está en el formulario, puedes dejarlo nulo
                null, // Foto, puedes agregar un campo de archivo si es necesario
                $issue_description
            );

            // Llamar al servicio de inserción
            $serviceReparation = new ServiceReparation();
            $inserted = $serviceReparation->insertReparation($reparation);

            if ($inserted) {
                echo "Reparación registrada con éxito.";
            } else {
                echo "Hubo un error al registrar la reparación.";
            }
        }
    }
}
?>
