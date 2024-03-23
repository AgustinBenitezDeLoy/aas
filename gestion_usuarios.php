<?php
session_start();
// Asegúrate de que solo administradores puedan ejecutar esto
if ($_SESSION['rol'] !== 'administrador') {
    exit('Acceso denegado');
}

// Datos de conexión a la base de datos
$host = 'localhost';
$dbname = 'reentraste';
$username = 'root';
$password = '';

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recoger los datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$rol = $_POST['rol'];

// Preparar la consulta SQL para prevenir inyecciones SQL
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, rol) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $correo, $rol);

// Ejecutar y verificar el éxito de la consulta
if ($stmt->execute()) {
    echo "Nuevo usuario agregado con éxito.";
} else {
    echo "Error al agregar el usuario.";
}

$stmt->close();
$conn->close();
?>
