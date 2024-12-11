<?php
$config = parse_ini_file('db_config.ini', true);

// Retrieve database connection details
$host = $config['database']['host'];
$username = $config['database']['username'];
$password = $config['database']['password'];
$dbname = $config['database']['dbname'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to the database: $dbname"; 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
