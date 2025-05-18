<?php
session_start();

// Mostrar errores para depuración (quitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'peluqueria');
if ($mysqli->connect_error) {
  die("Error de conexión: " . $mysqli->connect_error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Corte y Arte</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />

  <!-- Bootstrap 5.3 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

  <style>
    /* Tu CSS aquí (lo dejé igual que antes para no alargar) */
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f7f7f7;
      color: #3F3D56;
    }
    .navbar {
      background-color: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(6px);
    }
    .navbar-brand {
      font-weight: 700;
      color: #3F3D56;
    }
    .nav-link {
      color: #3F3D56;
      font-weight: 500;
    }
    .nav-link:hover {
      color: #5A6782;
    }
    header {
      background-color: #3F3D56;
      color: white;
    }
    .btn-primary,
    .btn-outline-primary:hover {
      background-color: #5A6782;
      border-color: #5A6782;
    }
    .btn-outline-primary {
      color: #5A6782;
      border-color: #5A6782;
    }
    .hero {
      background-image: url('imagenes/fondo-peluqueria.jpg');
      background-size: cover;
      background-position: center;
      height: 100vh;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
    }
    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.6);
      z-index: 1;
    }
    .hero-content {
      position: relative;
      z-index: 2;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    footer {
      background: #3F3D56;
      color: white;
    }
    .form-control, .form-select {
      border-radius: 10px;
    }
    .btn-success {
      background-color: #3F3D56;
      border-color: #3F3D56;
    }
    .btn-success:hover {
      background-color: #2D2B3E;
      border-color: #2D2B3E;
    }
  </style>
</head>
<body>

<div class="container mt-4">
  <?php if (isset($_GET['reserva']) && $_GET['reserva'] === 'ok'): ?>
    <div class="alert alert-success text-center" role="alert">
      ¡La reserva se ha realizado correctamente!
    </div>
  <?php endif; ?>

  <?php if (isset($_GET['reserva']) && $_GET['reserva'] === 'ocupada'): ?>
    <div class="alert alert-danger text-center" role="alert">
      Ya hay una reserva para esa fecha y hora. Por favor, elige otro horario.
    </div>
  <?php endif; ?>
</div>

<header class="p-5 text-white text-center">
  <div class="container">
    <h1 class="display-5 fw-bold">
      <?php
        if (isset($_SESSION['usuario_nombre'])) {
          echo "Bienvenido/a, " . htmlspecialchars($_SESSION['usuario_nombre']);
        } else {
          echo "Peluquería Corte y Arte";
        }
      ?>
    </h1>
  </div>
</header>

<nav class="navbar navbar-expand-lg sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">Corte y Arte</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
        <li class="nav-item"><a class="nav-link" href="#reservas">Reservas</a></li>
        <li class="nav-item"><a class="nav-link" href="#valoraciones">Valoraciones</a></li>
        <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
        <?php if (isset($_SESSION['usuario_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="perfil.php">Mi perfil</a></li>
          <li class="nav-item"><a class="btn btn-outline-secondary ms-2" href="cerrar_sesion.php">Cerrar sesión</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="btn btn-primary ms-2" href="login.php">Iniciar sesión</a></li>
          <li class="nav-item"><a class="btn btn-outline-primary ms-2" href="registro.php">Registrarse</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<section id="inicio" class="hero">
  <div class="hero-content">
    <h1 class="display-4 fw-bold mb-3">Bienvenido a Corte y Arte</h1>
    <p class="lead mb-4">Donde la creatividad se convierte en corte</p>
    <a href="#reservas" class="btn btn-outline-light btn-lg">Reservar cita</a>
  </div>
</section>

<main class="container my-5">
  <section id="servicios" class="mb-5">
    <h2 class="mb-4 text-center">Nuestros Servicios</h2>
    <div class="row g-4">
      <?php
        $servicios = [
          ["Corte de pelo", "imagenes/corte.jpg", "Corte personalizado según tu estilo", "12€"],
          ["Coloración", "imagenes/coloracion.jpg", "Elige el color que resalta tu personalidad", "30€"],
          ["Barba", "imagenes/barba.jpg", "Recorte y diseño de barba a la perfección", "8€"],
          ["Tratamiento capilar", "imagenes/tratamiento.jpg", "Tratamiento para rejuvenecer tu cabello", "20€"]
        ];
        foreach ($servicios as $s):
      ?>
      <div class="col-md-6 col-lg-3" data-aos="fade-up">
        <div class="card h-100 shadow-sm border-0">
          <img src="<?= $s[1] ?>" class="card-img-top" alt="<?= $s[0] ?>">
          <div class="card-body text-center">
            <h5 class="card-title"><?= $s[0] ?></h5>
            <p class="card-text"><?= $s[2] ?></p>
            <p class="fw-bold text-primary"><?= $s[3] ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>
  
<section id="reservas" class="mb-5 text-center">
  <h2 class="mb-4">Reservar cita</h2>

  <?php if (isset($_SESSION['usuario_id'])): ?>
    <form action="reservar.php" method="POST" class="row g-3">
      <div class="col-md-6">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" class="form-control" name="nombre" id="nombre" required value="<?= htmlspecialchars($_SESSION['usuario_nombre']) ?>">
      </div>
      <div class="col-md-6">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="tel" class="form-control" name="telefono" id="telefono" required value="<?= htmlspecialchars($_SESSION['telefono']) ?>" readonly>

      </div>
      <div class="col-md-6">
        <label for="servicio" class="form-label">Servicio:</label>
        <select class="form-select" name="servicio" id="servicio">
          <option value="corte">Corte</option>
          <option value="color">Coloración</option>
          <option value="peinado">Barba</option>
          <option value="tratamiento">Tratamiento</option>
        </select>
      </div>
      <div class="col-md-3">
        <label for="fecha" class="form-label">Fecha:</label>
        <input type="date" class="form-control" name="fecha" id="fecha" required min="<?= date('Y-m-d'); ?>">
      </div>
      <div class="col-md-3">
        <label for="hora" class="form-label">Hora:</label>
        <select class="form-select" name="hora" id="hora" required>
          <option value="">Selecciona una hora</option>
          <option value="10:00">10:00</option>
          <option value="10:30">10:30</option>
          <option value="11:00">11:00</option>
          <option value="11:30">11:30</option>
          <option value="12:00">12:00</option>
          <option value="12:30">12:30</option>
          <option value="13:00">13:00</option>
          <option value="16:00">16:00</option>
          <option value="16:30">16:30</option>
          <option value="17:00">17:00</option>
          <option value="17:30">17:30</option>
          <option value="18:00">18:00</option>
          <option value="18:30">18:30</option>
          <option value="19:00">19:00</option>
        </select>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-success w-100">Reservar</button>
      </div>
    </form>
  <?php else: ?>
    <div>
      Debes <a href="login.php">iniciar sesión</a> para reservar una cita.
    </div>
  <?php endif; ?>
</section>

<section id="valoraciones" class="mb-5" data-aos="fade-up">
  <h2 class="mb-4 text-center">Valoraciones de clientes</h2>

  <?php if (isset($_SESSION['usuario_id'])): ?>
    <form action="guardar_valoracion.php" method="POST" class="mb-4">
      <div class="mb-3">
        <label for="puntuacion" class="form-label">Puntuación (1-5):</label>
        <select name="puntuacion" id="puntuacion" class="form-select" required>
          <option value="" selected disabled>Selecciona</option>
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="comentario" class="form-label">Comentario:</label>
        <textarea name="comentario" id="comentario" class="form-control" rows="3" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Enviar valoración</button>
    </form>
  <?php else: ?>
    <p class="text-center">Debes <a href="login.php">iniciar sesión</a> para dejar una valoración.</p>
  <?php endif; ?>
  <h3 class="mb-4 text-start">Últimas valoraciones</h3>
  <?php
  $query = "SELECT usuarios.nombre, valoraciones.comentario, valoraciones.puntuacion, valoraciones.fecha 
            FROM valoraciones 
            JOIN usuarios ON valoraciones.usuario_id = usuarios.id 
            ORDER BY valoraciones.fecha DESC LIMIT 3";
  $result = $mysqli->query($query);

  if (!$result) {
      echo "<p class='text-danger text-center'>Error al cargar las valoraciones: " . htmlspecialchars($mysqli->error) . "</p>";
  } elseif ($result->num_rows > 0) {
      while ($val = $result->fetch_assoc()) {
          ?>
          <div class="card mb-3 shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($val['nombre']) ?></h5>
              <h6 class="card-subtitle mb-2 text-muted">Valoración: <?= intval($val['puntuacion']) ?>/5</h6>
              <p class="card-text"><?= nl2br(htmlspecialchars($val['comentario'])) ?></p>
              <small class="text-muted">Fecha: <?= date('d/m/Y', strtotime($val['fecha'])) ?></small>
            </div>
          </div>
          <?php
      }
  } else {
      echo "<p class='text-center'>No hay valoraciones todavía. ¡Sé el primero en dejar la tuya!</p>";
  }
  ?>
  <div class="text-center mt-3">
    <a href="valoraciones_todas.php" class="btn btn-outline-primary">Ver todas las valoraciones</a>
  </div>
</section>


  <section id="contacto" class="mb-5" data-aos="fade-up">
    <h2 class="mb-3">Contacto</h2>
    <p><strong>Dirección:</strong> Calle Mayor, 123 - Vila-real</p>
    <p><strong>Horario:</strong> Lunes a viernes de 10:00h a 13:00h y de 16:00h a 19:00h</p>
    <p><strong>Teléfono:</strong> 900 123 456</p>
    <p><strong>Email:</strong> contacto@corteyarte.com</p>
  </section>
</main>

<footer class="py-4 text-center">
  <div class="container">
    <p class="mb-0">&copy; <?= date('Y') ?> Peluquería Corte y Arte. Todos los derechos reservados.</p>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
<script src="script.js?v=1.0.1"></script>
</body>
</html>

<?php
// Cerrar conexión a la base de datos
$mysqli->close();
?>
