<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reparation Query</title>
</head>
<body>
    <h1>Reparation Query</h1>
    <form action="../src/Controller/ControllerRepaation.php" method="POST">
        <label for="reparation_id">Reparation ID:</label>
        <input type="text" id="reparation_id" name="reparation_id" required><br><br>

        <button type="submit" name="action" value="getReparation">Search</button>
    </form>
</body>
</html>
