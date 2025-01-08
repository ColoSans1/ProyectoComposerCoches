<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? null;

    if ($role === 'employee') {
        header('Location: reparation_form.php');
        exit();
    } elseif ($role === 'client') {
        header('Location: reparation_query.php'); 
        exit();
    } else {
        echo "Error: Rol no válido.";
        exit();
    }
} else {
    echo "Error: Acceso no permitido.";
}
?>
