<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BellaStyle</title>
  <link rel="stylesheet" href="style.css">

  <!-- Bootstrap 5.3 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    html {
      scroll-behavior: smooth;
    }
    .servicio img {
      width: 100%;
      max-width: 300px;
      border-radius: 8px;
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

<header class="p-5 text-white text-center" style="background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%)">
  <div class="container">
    <h1 class="display-5 fw-bold">
      <?php
        if (isset($_SESSION['usuario_nombre'])) {
          echo "Bienvenido/a, " . htmlspecialchars($_SESSION['usuario_nombre']);
        } else {
          echo "Peluquería BellaStyle";
        }
      ?>
    </h1>
  </div>
</header>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">BellaStyle</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
        <li class="nav-item"><a class="nav-link" href="#reservas">Reservas</a></li>
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

<main class="container my-5">
  <section id="inicio" class="mb-5">
    <h2 class="mb-3">Bienvenido a BellaStyle</h2>
    <p class="lead">Tu espacio de belleza y cuidado personal. Reserva tu cita online de forma rápida y sencilla.</p>
  </section>

  <section id="servicios" class="mb-5">
    <h2 class="mb-4 text-center">Nuestros Servicios</h2>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 rounded">
          <img src="imagenes/corte.jpg" class="card-img-top" alt="Corte" style="border-radius: 10px;">
          <div class="card-body text-center">
            <h5 class="card-title">Corte de pelo</h5>
            <p class="card-text">Corte personalizado según tu estilo</p>
            <p class="card-price">Precio: 12€</p>
          </div>
          <!-- Descripción detallada oculta por defecto -->
          <div class="detalle">
            <p>Un corte único que se adapta a tu estilo y personalidad. Usamos las mejores técnicas para lograr un acabado perfecto.</p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 rounded">
          <img src="imagenes/coloracion.jpg" class="card-img-top" alt="Coloración" style="border-radius: 10px;">
          <div class="card-body text-center">
            <h5 class="card-title">Coloración</h5>
            <p class="card-text">Elige el color que resalta tu personalidad</p>
            <p class="card-price">Precio: 30€</p>
          </div>
          <!-- Descripción detallada oculta por defecto -->
          <div class="detalle">
            <p>Aplicamos técnicas avanzadas de coloración para lograr tonos brillantes y duraderos, cuidando siempre la salud de tu cabello.</p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 rounded">
          <img src="imagenes/barba.jpg" class="card-img-top" alt="Barba" style="border-radius: 10px;">
          <div class="card-body text-center">
            <h5 class="card-title">Barba</h5>
            <p class="card-text">Recorte y diseño de barba a la perfección</p>
            <p class="card-price">Precio: 8€</p>
          </div>
          <!-- Descripción detallada oculta por defecto -->
          <div class="detalle">
            <p>Recorte y forma perfecta para que tu barba luzca impecable. Cuidamos cada detalle para que te sientas seguro y a la moda.</p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 rounded">
          <img src="imagenes/tratamiento.jpg" class="card-img-top" alt="Tratamiento" style="border-radius: 10px;">
          <div class="card-body text-center">
            <h5 class="card-title">Tratamiento capilar</h5>
            <p class="card-text">Tratamiento para rejuvenecer tu cabello</p>
            <p class="card-price">Precio: 20€</p>
          </div>
          <!-- Descripción detallada oculta por defecto -->
          <div class="detalle">
            <p>Tratamientos especializados para revitalizar y fortalecer tu cabello, dándole brillo y salud con productos de alta calidad.</p>
          </div>
        </div>
      </div>
    </div>
</section>


  <section id="reservas" class="mb-5">
  <h2 class="mb-4">Reservar cita</h2>

  <?php if (isset($_SESSION['usuario_id'])): ?>
    <form action="reservar.php" method="POST" class="row g-3">
      <div class="col-md-6">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" class="form-control" name="nombre" id="nombre" required value="<?= htmlspecialchars($_SESSION['usuario_nombre']) ?>">
      </div>
      <div class="col-md-6">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="tel" class="form-control" name="telefono" id="telefono" required>
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
    <div class="alert alert-warning text-center">
      Debes <a href="login.php" class="alert-link">iniciar sesión</a> para reservar una cita.
    </div>
  <?php endif; ?>
</section>


  <section id="contacto" class="mb-5">
    <h2 class="mb-3">Contacto</h2>
    <p><strong>Dirección:</strong> Calle Belleza, 123 - Ciudad</p>
    <p><strong>Horario:</strong> De lunes a viernes de 10:00 a 13:00 y de 16:00 a 19:00</p>
    <p><strong>Teléfono:</strong> 900 123 456</p>
    <p><strong>Email:</strong> contacto@bellastyle.com</p>
  </section>
</main>

<footer class="bg-light py-4 mt-auto">
  <div class="container text-center">
    <p class="mb-0">&copy; 2025 BellaStyle. Todos los derechos reservados.</p>
  </div>
</footer>

<!-- Scripts de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
