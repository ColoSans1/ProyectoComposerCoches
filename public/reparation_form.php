<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reparation Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h1 class="text-center mb-4">Reparation Query</h1>

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


<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h1 class="text-center mb-4">Reparation Form</h1>

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

    <div class="mb-3">
        <label for="watermark_text" class="form-label">Watermark Text:</label>
        <input type="text" id="watermark_text" name="watermark_text" class="form-control" required>
    </div>

    <div class="text-center">
        <button type="submit" name="action" value="insertReparation" class="btn btn-primary">Submit</button>
    </div>
</form>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
