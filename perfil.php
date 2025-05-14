<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli('localhost', 'root', '', 'peluqueria');
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

$id = $_SESSION['usuario_id'];
$result = $mysqli->query("SELECT nombre, email, telefono FROM usuarios WHERE id = $id");
$usuario = $result->fetch_assoc();

// Obtener la próxima cita
$proxima_cita = null;
$stmt = $mysqli->prepare("SELECT id,fecha, hora, servicio FROM reservas WHERE usuario_id = ? AND fecha >= CURDATE() ORDER BY fecha, hora LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($reserva_id,$fecha, $hora, $servicio);
if ($stmt->fetch()) {
    $proxima_cita = [
        'id'=> $reserva_id,
        'fecha' => $fecha,
        'hora' => $hora,
        'servicio' => $servicio
    ];
}
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Mi Perfil</h2>
    <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
    <p><strong>Teléfono:</strong> <?= htmlspecialchars($usuario['telefono']) ?></p>
    <a href="editar_perfil.php" class="btn btn-primary mb-4">Editar</a>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Próxima Cita</h5>
            <?php if ($proxima_cita): ?>
                <p class="card-text">📅 <?= $proxima_cita['fecha'] ?> a las 🕒 <?= $proxima_cita['hora'] ?></p>
                <p class="card-text">💇 Servicio: <?= htmlspecialchars($proxima_cita['servicio']) ?></p>

                <form action="cancelar_cita.php" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres cancelar tu cita?');">
                    <input type="hidden" name="reserva_id" value="<?= $proxima_cita['id'] ?>">
                    <button type="submit" class="btn btn-danger">Cancelar Cita</button>
                </form>
            <?php else: ?>
                <p class="text-muted">No tienes ninguna cita agendada.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
