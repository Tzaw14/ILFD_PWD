<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Viviendas</title>
</head>
<body>
    <h1>🏠 Listado de Viviendas - Ejercicio 1</h1>
    <hr>

<?php
// Conexión a la BD
$conexion = mysqli_connect("localhost", "root", "", "inmobiliaria")
    or die("Problemas con la conexión");

// Consulta
$registros = mysqli_query($conexion, "SELECT * FROM viviendas")
    or die("Problemas en la consulta: " . mysqli_error($conexion));

// Mostrar resultados
while ($reg = mysqli_fetch_array($registros)) {
    echo "ID: " . $reg['id'] . "<br>";
    echo "Tipo: " . $reg['tipo'] . "<br>";
    echo "Zona: " . $reg['zona'] . "<br>";
    echo "Dirección: " . $reg['direccion'] . "<br>";
    echo "Dormitorios: " . $reg['dormitorios'] . "<br>";
    echo "Precio: $" . $reg['precio'] . "<br>";
    echo "Tamaño: " . $reg['tamano'] . " m²<br>";
    echo "Extras: " . $reg['extras'] . "<br><hr>";
}

mysqli_close($conexion);
?>

</body>
</html>