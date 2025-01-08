<?php
$role = isset($_POST['role']) ? $_POST['role'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Workshop System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <?php if ($role == ''): ?>
            <!-- Form to choose the role -->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1 class="text-center mb-4">Welcome to the Car Workshop System</h1>
                            <p class="text-center">Please select your role:</p>

                            <form action="index.php" method="POST">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Select Role:</label>
                                    <div class="form-check">
                                        <input type="radio" id="employee" name="role" value="employee" class="form-check-input" required>
                                        <label for="employee" class="form-check-label">Employee</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" id="client" name="role" value="client" class="form-check-input" required>
                                        <label for="client" class="form-check-label">Client</label>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif ($role == 'employee'): ?>
            <!-- Employee options form -->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1 class="text-center mb-4">Employee Options</h1>
                            <p class="text-center">You can create a new repair or search for an existing one.</p>

                            <h3>Create Reparation</h3>
                            <form action="../src/Controller/ControllerRepaation.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="car_model" class="form-label">Car Model:</label>
                                    <input type="text" id="car_model" name="car_model" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="license_plate" class="form-label">License Plate:</label>
                                    <input type="text" id="license_plate" name="license_plate" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="issue_description" class="form-label">Issue Description:</label>
                                    <textarea id="issue_description" name="issue_description" class="form-control" rows="4" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="repair_date" class="form-label">Repair Date:</label>
                                    <input type="date" id="repair_date" name="repair_date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="id_workshop" class="form-label">Workshop ID:</label>
                                    <input type="text" id="id_workshop" name="id_workshop" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name_workshop" class="form-label">Workshop Name:</label>
                                    <input type="text" id="name_workshop" name="name_workshop" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="photo_url" class="form-label">Photo Upload:</label>
                                    <input type="file" id="photo_url" name="photo_url" class="form-control" accept="image/*" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="action" value="insertReparation" class="btn btn-primary">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <br>
                
                <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1 class="text-center mb-4">Employee Options</h1>
                            <p class="text-center">You can only search for your repair.</p>

                            <h3>Reparation Query</h3>
                            <form action="../src/Controller/ControllerRepaation.php" method="POST">
                                <div class="mb-3">
                                    <label for="reparation_id" class="form-label">Reparation ID:</label>
                                    <input type="text" id="reparation_id" name="reparation_id" class="form-control" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="action" value="getReparation" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        <?php elseif ($role == 'client'): ?>
            <!-- Client options form -->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1 class="text-center mb-4">Client Options</h1>
                            <p class="text-center">You can only search for your repair.</p>

                            <h3>Reparation Query</h3>
                            <form action="../src/View/ViewReparation.php" method="POST">
                            <div class="mb-3">
                                    <label for="reparation_id" class="form-label">Reparation ID:</label>
                                    <input type="text" id="reparation_id" name="reparation_id" class="form-control" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="action" value="getReparation" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
