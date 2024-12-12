<?php
session_start();

// Verificar si el usuario está logueado y si es un empleado
if (isset($_SESSION['role']) && $_SESSION['role'] == 'employee') {
    // Mostrar formulario de reparación
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register Car Reparation</title>
    </head>
    <body>
        <h1>Register Car Reparation</h1>
        
        <!-- Formulario para registrar reparación -->
        <form action="submit_reparation.php" method="post" enctype="multipart/form-data">
            <label for="id_workshop">Workshop ID:</label>
            <input type="text" id="id_workshop" name="id_workshop" required><br><br>

            <label for="name_workshop">Workshop Name:</label>
            <input type="text" id="name_workshop" name="name_workshop" required><br><br>

            <label for="register_date">Register Date:</label>
            <input type="date" id="register_date" name="register_date" required><br><br>

            <label for="license_plate">License Plate:</label>
            <input type="text" id="license_plate" name="license_plate" pattern="[0-9]{4}-[A-Z]{3}" required><br><br>

            <label for="photo">Upload Vehicle Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required><br><br>

            <button type="submit">Submit Reparation</button>
        </form>
    </body>
    </html>
    <?php
} else {
    // Si no es empleado, redirigir a la página de landing
    header('Location: landing_page.php');
    exit();
}
?>
