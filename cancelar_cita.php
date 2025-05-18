<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reserva_id'])) {
    $reserva_id = $_POST['reserva_id'];
    $usuario_id = $_SESSION['usuario_id'];

    $mysqli = new mysqli('localhost', 'root', '', 'peluqueria');
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("DELETE FROM reservas WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $reserva_id, $usuario_id);
    $stmt->execute();
    $stmt->close();

    $mysqli->close();
}

header("Location: perfil.php");
exit();
