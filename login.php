<?php
session_start();
include 'config.php';  // Incluir el archivo de configuración

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario_email = $_POST['nombre_usuario_email'];
    $password = $_POST['password'];

    // Preparar la consulta SQL
    $sql = "SELECT id, nombre_usuario, email, password FROM usuarios WHERE (nombre_usuario = ? OR email = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre_usuario_email, $nombre_usuario_email);
    $stmt->execute();
    $stmt->store_result();

    // Verificar si se encontró un usuario
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nombre_usuario, $email, $hashed_password);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $hashed_password)) {
            // Iniciar sesión
            $_SESSION['user_id'] = $id;
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            header("Location: dashboard.php");  // Redirigir a la página principal
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró ningún usuario con ese nombre de usuario o correo electrónico.";
    }

    $stmt->close();
}

$conn->close();
?>

<!-- HTML para el formulario de inicio de sesión -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invernadero - Iniciar Sesión</title>
    <!-- Aquí va el resto de tu código HTML/CSS -->
</head>
<body>
    <div class="container">
        <h2>Iniciar sesión</h2>
        <form method="post" action="">
            <input type="text" name="nombre_usuario_email" placeholder="Nombre de usuario/correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar sesión</button>
        </form>
        <!-- Aquí va el resto de tu código HTML -->
    </div>
</body>
</html>
