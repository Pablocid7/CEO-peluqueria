<?php
// Conexión a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'peluqueria');
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Consulta para obtener todas las valoraciones ordenadas por fecha
$query = "SELECT usuarios.nombre, valoraciones.comentario, valoraciones.puntuacion, valoraciones.fecha
          FROM valoraciones
          JOIN usuarios ON valoraciones.usuario_id = usuarios.id
          ORDER BY valoraciones.fecha DESC";

$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Todas las Valoraciones - Corte y Arte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container my-5">
    <h1 class="mb-4">Todas las Valoraciones</h1>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($val = $result->fetch_assoc()): ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($val['nombre']) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Valoración: <?= intval($val['puntuacion']) ?>/5</h6>
                    <p class="card-text"><?= nl2br(htmlspecialchars($val['comentario'])) ?></p>
                    <small class="text-muted">Fecha: <?= date('d/m/Y', strtotime($val['fecha'])) ?></small>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No hay valoraciones para mostrar.</p>
    <?php endif; ?>

    <div class="mt-4">
        <a href="index.php#valoraciones" class="btn btn-secondary">Volver a la página principal</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$mysqli->close();
?>
