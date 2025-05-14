<?php
// Iniciar la sesión
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir a la página de login o a la página principal
header("Location: index.php");  // O redirige a index.php si lo prefieres
exit();
?>
