<?php
header('Content-Type: application/json');

// Incluir conexión
require_once 'conexion.php';

// Configuración de paginación
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registrosPorPagina = 5;
$comienzo = ($pagina - 1) * $registrosPorPagina;

// Construir consulta con filtros
$where = [];

if (!empty($_GET['tipo'])) {
    $where[] = "tipo = '" . mysqli_real_escape_string($conexion, $_GET['tipo']) . "'";
}

if (!empty($_GET['zona'])) {
    $where[] = "zona = '" . mysqli_real_escape_string($conexion, $_GET['zona']) . "'";
}

if (!empty($_GET['dormitorios'])) {
    $where[] = "dormitorios >= " . (int)$_GET['dormitorios'];
}

if (!empty($_GET['extras'])) {
    $where[] = "FIND_IN_SET('" . mysqli_real_escape_string($conexion, $_GET['extras']) . "', extras) > 0";
}

$whereSQL = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

// Contar total de registros
$totalQuery = mysqli_query($conexion, "SELECT COUNT(*) as total FROM viviendas $whereSQL");
$totalRow = mysqli_fetch_assoc($totalQuery);
$totalRegistros = $totalRow['total'];
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Consulta con límite y filtros
$query = "SELECT * FROM viviendas $whereSQL LIMIT $comienzo, $registrosPorPagina";
$registros = mysqli_query($conexion, $query);

// Preparar respuesta
$viviendas = [];
while ($reg = mysqli_fetch_assoc($registros)) {
    $vivienda = [
        'id' => $reg['id'],
        'tipo' => $reg['tipo'],
        'zona' => $reg['zona'],
        'direccion' => $reg['direccion'],
        'dormitorios' => (int)$reg['dormitorios'],
        'precio' => (float)$reg['precio'],
        'tamano' => (int)$reg['tamano'],
        'extras' => !empty($reg['extras']) ? explode(',', $reg['extras']) : []
    ];
    $viviendas[] = $vivienda;
}

// Respuesta JSON
$respuesta = [
    'viviendas' => $viviendas,
    'paginaActual' => $pagina,
    'totalPaginas' => $totalPaginas,
    'total' => $totalRegistros,
    'cantidad' => count($viviendas)
];

echo json_encode($respuesta);

mysqli_close($conexion);
?>