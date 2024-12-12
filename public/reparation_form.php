<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reparation Form</title>
</head>
<body>
    <h1>Reparation Form</h1>
    <form action="../src/Controller/ControllerRepaation.php" method="POST">
        <label for="car_model">Car Model:</label>
        <input type="text" id="car_model" name="car_model" required><br><br>

        <label for="issue_description">Issue Description:</label>
        <textarea id="issue_description" name="issue_description" required></textarea><br><br>

        <label for="repair_date">Repair Date:</label>
        <input type="date" id="repair_date" name="repair_date" required><br><br>

        <button type="submit" name="action" value="insertReparation">Submit</button>
    </form>
</body>
</html>
