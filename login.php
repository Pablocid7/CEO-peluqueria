<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar Sesión - BellaStyle</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font opcional -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(315deg, #d9a7c7 0%, #fffcdc 74%);
      font-family: 'Arial', sans-serif;
    }

    .login-box {
      max-width: 400px;
      margin: 80px auto;
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    h2 {
      font-family: 'Playfair Display', serif;
    }
  </style>
</head>
<body>

  <div class="login-box">
    <h2 class="text-center mb-4">Iniciar Sesión</h2>

    <!-- Mostrar mensaje de error -->
    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger text-center" role="alert">
        Correo o contraseña incorrectos.
      </div>
    <?php endif; ?>

    <form action="autenticar.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" name="email" id="email" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" name="password" id="password" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>

    <p class="mt-3 text-center">
      ¿No tienes cuenta? <a href="registro.php">Regístrate</a>
    </p>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
