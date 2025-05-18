<?php
session_start();

// Configuración de la base de datos
$host = 'localhost';  
$dbname = 'peluqueria'; 
$username = 'root';
$password = ''; 

// Conexión a la base de datos usando MySQLi
$mysqli = new mysqli($host, $username, $password, $dbname);

// Verificar si hay error en la conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error . " - Revisar credenciales.");
}

// Verifica si se enviaron los datos del formulario
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT id, nombre, email, telefono, password FROM usuarios WHERE email = ?";
if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['telefono'] = $usuario['telefono'];

            header("Location: index.php");
            exit();
        } else {
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        header("Location: login.php?error=1");
        exit();
    }

    $stmt->close();
}

    
} else {
    // Datos no enviados
    header("Location: login.php?error=1");
    exit();
}

// Cierra la conexión a la base de datos
$mysqli->close();
?>

