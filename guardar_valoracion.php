<?php
session_start();

// Conexión directa a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'peluqueria');
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $puntuacion = intval($_POST['puntuacion']);
    $comentario = trim($_POST['comentario']);
    $fecha = date('Y-m-d H:i:s');

    if ($puntuacion >= 1 && $puntuacion <= 5 && !empty($comentario)) {
        $stmt = $mysqli->prepare("INSERT INTO valoraciones (usuario_id, puntuacion, comentario, fecha) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $usuario_id, $puntuacion, $comentario, $fecha);

        if ($stmt->execute()) {
            header("Location: index.php#valoraciones");
            exit();
        } else {
            echo "Error al guardar la valoración: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    } else {
        echo "Datos no válidos.";
    }

    $mysqli->close();
} else {
    header("Location: index.php");
    exit();
}
