<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select User Role</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-center mb-4">Welcome to the Car Workshop System</h1>
                        <p class="text-center">Please select your role:</p>

                        <form action="landing_page.php" method="POST">
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
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
