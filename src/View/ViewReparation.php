<?php
// Incluir clases necesarias
require_once '../Model/Reparation.php';
require_once '../Service/ServiceReparation.php';

use Src\Model\Reparation;
use Src\Service\ServiceReparation;

if (!isset($_GET['role'])) {
    die('Access denied: Role is required.');
}

$role = htmlspecialchars($_GET['role']); // Sanitizar el rol
$serviceReparation = new ServiceReparation();
$reparation = null;

if (isset($_GET['uuid'])) {
    $uuid = htmlspecialchars($_GET['uuid']); // Sanitize input
    $reparation = $serviceReparation->getReparationByUuid($uuid);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reparation Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center">Car Reparation Menu</h1>
        
        <h2>Search for Reparation</h2>
        <form action="viewReparation.php" method="get" class="mb-4">
            <input type="hidden" name="role" value="<?= htmlspecialchars($role); ?>">
            <div class="mb-3">
                <label for="uuid" class="form-label">Reparation ID:</label>
                <input type="text" name="uuid" id="uuid" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" name="getReparation">Search</button>
        </form>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <?php if ($reparation): ?>
            <h2>Reparation Details</h2>
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr><th>UUID</th><td><?= htmlspecialchars($reparation->getUuid()) ?></td></tr>
                    <tr><th>Workshop ID</th><td><?= htmlspecialchars($reparation->getWorkshopId()) ?></td></tr>
                    <tr><th>Workshop Name</th><td><?= htmlspecialchars($reparation->getWorkshopName()) ?></td></tr>
                    <tr><th>Register Date</th><td><?= htmlspecialchars($reparation->getRegisterDate()) ?></td></tr>
                    <tr><th>License Plate</th><td><?= htmlspecialchars($reparation->getLicensePlate()) ?></td></tr>
                    <tr>
                        <th>Photo</th>
                        <td>
                            <?php if ($reparation->getImage()): ?>
                                <img src="<?= htmlspecialchars($reparation->getImage()) ?>" alt="Vehicle Photo" class="img-fluid rounded" style="max-width: 300px; height: auto; <?= ($role === 'client') ? 'filter: blur(5px);' : ''; ?>">
                            <?php else: ?>
                                <span class="text-muted">No photo uploaded.</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning">
                No reparation found with the provided UUID.
            </div>
        <?php endif; ?>

        <!-- Mostrar el formulario de registro solo si el rol es empleado -->
        <?php if ($role === 'employee'): ?>
            <h2>Register Reparation</h2>
            <form action="../Controller/controllerReparation.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="workshopId" class="form-label">Workshop ID:</label>
                    <input type="number" name="workshopId" id="workshopId" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="workshopName" class="form-label">Workshop Name:</label>
                    <input type="text" name="workshopName" id="workshopName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="registerDate" class="form-label">Register Date:</label>
                    <input type="date" name="registerDate" id="registerDate" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="licensePlate" class="form-label">License Plate:</label>
                    <input type="text" name="licensePlate" id="licensePlate" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Upload Photo:</label>
                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-success" name="insertReparation">Submit</button>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
