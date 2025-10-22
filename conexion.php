<?php
// ================================================
// ARCHIVO: conexion.php
// Archivo de conexión a la base de datos
// ================================================

// Configuración de la base de datos
$host = 'localhost';
$usuario = 'root';
$password = '';
$base_datos = 'inmobiliaria';

// Crear conexión
$conexion = mysqli_connect($host, $usuario, $password, $base_datos);

// Verificar conexión
if (!$conexion) {
    die("❌ Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Establecer charset UTF-8
mysqli_set_charset($conexion, "utf8");

// Comentar esta línea después de verificar que funciona
// echo "✅ Conexión exitosa a la base de datos<br>";
?>