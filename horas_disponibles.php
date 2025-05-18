<?php
$mysqli = new mysqli('localhost', 'root', '', 'peluqueria');

if ($mysqli->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Error de conexión"]);
  exit;
}

$fecha = $_GET['fecha'] ?? null;

if (!$fecha) {
  http_response_code(400);
  echo json_encode(["error" => "Fecha no proporcionada"]);
  exit;
}

$todasLasHoras = [
  "10:00", "10:30", "11:00", "11:30",
  "12:00", "12:30", "13:00",
  "16:00", "16:30", "17:00", "17:30",
  "18:00", "18:30", "19:00"
];

// Consulta las horas ocupadas ese día
$stmt = $mysqli->prepare("SELECT hora FROM reservas WHERE fecha = ?");
$stmt->bind_param("s", $fecha);
$stmt->execute();
$result = $stmt->get_result();

$horasOcupadas = [];
while ($row = $result->fetch_assoc()) {
  $hora = substr(trim($row['hora']), 0, 5);
  $horasOcupadas[] = $hora;
}

$horasDisponibles = array_values(array_diff($todasLasHoras, $horasOcupadas));

header('Content-Type: application/json');
echo json_encode($horasDisponibles);
?>
