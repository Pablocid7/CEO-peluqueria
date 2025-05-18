<?php
session_start(); // Iniciar sesión al principio del archivo

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $host = 'localhost';
    $dbname = 'peluqueria';
    $username = 'root';
    $password = '';

    $mysqli = new mysqli($host, $username, $password, $dbname);

    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($nombre) && !empty($telefono) && !empty($email) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare("INSERT INTO usuarios (nombre, telefono, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $telefono, $email, $hashed_password);

        if ($stmt->execute()) {
            $usuario_id = $stmt->insert_id;

            // Guardar info en la sesión
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['email'] = $email;
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['telefono']= $telefono;

            // Redirigir a index con sesión iniciada
            header("Location: index.php");
            exit();
        } else {
            $error = "Error al registrar el usuario. Es posible que el correo ya esté registrado.";
        }

        $stmt->close();
        $mysqli->close();
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5" style="max-width: 500px;">
    <h2 class="text-center mb-4">Registrarse</h2>

    <!-- Mostrar errores si existen -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form action="registro.php" method="POST">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" class="form-control" name="nombre" id="nombre" required>
    </div>

    <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="tel" class="form-control" name="telefono" id="telefono" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico:</label>
        <input type="email" class="form-control" name="email" id="email" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Contraseña:</label>
        <input type="password" class="form-control" name="password" id="password" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Registrar</button>
    </form>


    <p class="mt-3 text-center">
        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
    </p>
</div>

<script src="script.js?v=1.0.1"></script>

</body>
</html>


