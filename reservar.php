<?php
session_start();

$host = 'localhost';
$dbname = 'peluqueria';
$username = 'root';
$password = '';
$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $servicio = $_POST['servicio'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;

    // Primero comprobamos si ya existe una reserva para esa fecha y hora
    $stmt = $mysqli->prepare("SELECT id FROM reservas WHERE fecha = ? AND hora = ?");
    $stmt->bind_param("ss", $fecha, $hora);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Ya existe una reserva en esa fecha y hora
        $stmt->close();
        header("Location: index.php?reserva=ocupada");
        exit();
    }

    $stmt->close();

    // Si no hay reserva, insertamos la nueva
    $stmt = $mysqli->prepare("INSERT INTO reservas (nombre, telefono, servicio, fecha, hora, usuario_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $nombre, $telefono, $servicio, $fecha, $hora, $usuario_id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php?reserva=ok");
    exit();
}

$mysqli->close();
?>
