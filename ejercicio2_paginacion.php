<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado con Paginación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .navegacion {
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f0f0;
        }
        .navegacion a {
            margin: 0 10px;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }
        .navegacion a:hover {
            background-color: #0056b3;
        }
        .navegacion a.disabled {
            background-color: #ccc;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <h1>🏠 Listado con Paginación - Ejercicio 2</h1>
    <hr>

<?php
$conexion = mysqli_connect("localhost", "root", "", "inmobiliaria")
    or die("Problemas con la conexión");

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registrosPorPagina = 5;
$comienzo = ($pagina - 1) * $registrosPorPagina;

// Consulta con límite
$registros = mysqli_query($conexion,
    "SELECT * FROM viviendas LIMIT $comienzo, $registrosPorPagina")
    or die("Problemas en la consulta: " . mysqli_error($conexion));

// Mostrar registros
echo "<p><strong>Página actual: $pagina</strong></p>";

while ($reg = mysqli_fetch_array($registros)) {
    echo "ID: " . $reg['id'] . " - " . $reg['tipo'] . " en " . $reg['zona'] . " - $" . $reg['precio'] . "<br>";
}

// Navegación mejorada
echo "<div class='navegacion'>";

// Botón Anterior
if ($pagina > 1) {
    echo "<a href='ejercicio2_paginacion.php?pagina=" . ($pagina - 1) . "'>⬅️ Anterior</a>";
} else {
    echo "<a class='disabled'>⬅️ Anterior</a>";
}

// Botón Siguiente
echo "<a href='ejercicio2_paginacion.php?pagina=" . ($pagina + 1) . "'>Siguiente ➡️</a>";

echo "</div>";

mysqli_close($conexion);
?>

</body>
</html>