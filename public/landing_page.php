<?php
// Verifica que el formulario envió datos mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene el rol seleccionado por el usuario
    $role = $_POST['role'] ?? null;

    // Redirige según el rol seleccionado
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
