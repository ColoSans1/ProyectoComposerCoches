<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select User Role</title>
</head>
<body>
    <h1>Welcome to the Car Workshop System</h1>
    <p>Please select your role:</p>

    <form action="landing_page.php" method="POST">
        <label for="role">Select Role:</label><br>
        <input type="radio" id="employee" name="role" value="employee" required> Employee<br>
        <input type="radio" id="client" name="role" value="client" required> Client<br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
