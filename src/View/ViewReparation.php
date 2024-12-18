<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == 'employee') {
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
        
        <form action="../src/Controller/ControllerRepaation.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="id_workshop" class="form-label">Workshop ID:</label>
                <input type="text" id="id_workshop" name="id_workshop" class="form-control" required><br><br>
            </div>

            <div class="mb-3">
                <label for="name_workshop" class="form-label">Workshop Name:</label>
                <input type="text" id="name_workshop" name="name_workshop" class="form-control" required><br><br>
            </div>

            <div class="mb-3">
                <label for="register_date" class="form-label">Register Date:</label>
                <input type="date" id="register_date" name="register_date" class="form-control" required><br><br>
            </div>

            <div class="mb-3">
                <label for="license_plate" class="form-label">License Plate:</label>
                <input type="text" id="license_plate" name="license_plate" class="form-control" pattern="[0-9]{4}-[A-Z]{3}" required><br><br>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Upload Vehicle Photo:</label>
                <input type="file" id="photo" name="photo" class="form-control" accept="image/*" required><br><br>
            </div>

            <div class="text-center">
                <button type="submit" name="action" value="submitReparation" class="btn btn-primary">Submit Reparation</button>
            </div>
        </form>
    </body>
    </html>
    <?php
} else {
    header('Location: landing_page.php');
    exit();
}
?>
