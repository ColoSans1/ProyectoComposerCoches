<?php
// Configuración de la base de datos
$host = '127.0.0.1'; // Cambia esto si tu base de datos está en otro servidor
$dbname = 'Workshop'; // Reemplaza con el nombre de tu base de datos
$user = 'root'; // Reemplaza con tu usuario de base de datos
$password = ''; // Reemplaza con tu contraseña de base de datos

try {
    // Crear una conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión a la base de datos exitosa.";
} catch (PDOException $e) {
    echo "Error al conectar con la base de datos: " . $e->getMessage();
}
