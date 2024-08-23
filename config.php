<?php
$servername = "APPCEK";  // o el nombre de tu servidor de base de datos
$username = "root";
$password = "Qwerty12345";
$dbname = "appcek";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
