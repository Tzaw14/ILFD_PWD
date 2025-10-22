<?php
// Incluir conexión al inicio del archivo
require_once 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏠 Sistema de Viviendas - Inmobiliaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="titulo-principal">🏠 Sistema de Gestión de Viviendas</h1>
        
        <!-- Sección de Filtros -->
        <div class="filtros-section">
            <h4>🔍 Filtros de Búsqueda</h4>
            <form method="GET" action="">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Tipo de Vivienda</label>
                        <select name="tipo" class="form-select">
                            <option value="">Todos</option>
                            <option value="Casa" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 'Casa') ? 'selected' : ''; ?>>Casa</option>
                            <option value="Departamento" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 'Departamento') ? 'selected' : ''; ?>>Departamento</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Zona</label>
                        <select name="zona" class="form-select">
                            <option value="">Todas</option>
                            <option value="Norte" <?php echo (isset($_GET['zona']) && $_GET['zona'] == 'Norte') ? 'selected' : ''; ?>>Norte</option>
                            <option value="Sur" <?php echo (isset($_GET['zona']) && $_GET['zona'] == 'Sur') ? 'selected' : ''; ?>>Sur</option>
                            <option value="Este" <?php echo (isset($_GET['zona']) && $_GET['zona'] == 'Este') ? 'selected' : ''; ?>>Este</option>
                            <option value="Oeste" <?php echo (isset($_GET['zona']) && $_GET['zona'] == 'Oeste') ? 'selected' : ''; ?>>Oeste</option>
                            <option value="Centro" <?php echo (isset($_GET['zona']) && $_GET['zona'] == 'Centro') ? 'selected' : ''; ?>>Centro</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Dormitorios mínimos</label>
                        <select name="dormitorios" class="form-select">
                            <option value="">Todos</option>
                            <option value="1" <?php echo (isset($_GET['dormitorios']) && $_GET['dormitorios'] == '1') ? 'selected' : ''; ?>>1+</option>
                            <option value="2" <?php echo (isset($_GET['dormitorios']) && $_GET['dormitorios'] == '2') ? 'selected' : ''; ?>>2+</option>
                            <option value="3" <?php echo (isset($_GET['dormitorios']) && $_GET['dormitorios'] == '3') ? 'selected' : ''; ?>>3+</option>
                            <option value="4" <?php echo (isset($_GET['dormitorios']) && $_GET['dormitorios'] == '4') ? 'selected' : ''; ?>>4+</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Extras</label>
                        <select name="extras" class="form-select">
                            <option value="">Todos</option>
                            <option value="Piscina" <?php echo (isset($_GET['extras']) && $_GET['extras'] == 'Piscina') ? 'selected' : ''; ?>>Con Piscina</option>
                            <option value="Jardín" <?php echo (isset($_GET['extras']) && $_GET['extras'] == 'Jardín') ? 'selected' : ''; ?>>Con Jardín</option>
                            <option value="Garage" <?php echo (isset($_GET['extras']) && $_GET['extras'] == 'Garage') ? 'selected' : ''; ?>>Con Garage</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btn-filtro">🔍 Aplicar Filtros</button>
                        <a href="index.php" class="btn btn-secondary btn-filtro">🔄 Limpiar Filtros</a>
                    </div>
                </div>
            </form>
        </div>

        <div id="resultados">
<?php
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
$registros = mysqli_query($conexion, $query)
    or die("<div class='alert alert-danger'>❌ Problemas en la consulta: " . mysqli_error($conexion) . "</div>");

// Mostrar información de resultados
echo "<div class='alert alert-info'>";
echo "📊 Mostrando <strong>" . mysqli_num_rows($registros) . "</strong> viviendas de un total de <strong>$totalRegistros</strong>";
echo " | Página <strong>$pagina</strong> de <strong>$totalPaginas</strong>";
echo "</div>";

// Mostrar registros
if (mysqli_num_rows($registros) > 0) {
    while ($reg = mysqli_fetch_array($registros)) {
        echo "<div class='vivienda-card'>";
        echo "<div class='row'>";
        echo "<div class='col-md-8'>";
        echo "<h4>🏘️ " . htmlspecialchars($reg['tipo']) . " - ID: " . $reg['id'] . "</h4>";
        echo "<p><strong>📍 Ubicación:</strong> " . htmlspecialchars($reg['direccion']) . " - Zona " . htmlspecialchars($reg['zona']) . "</p>";
        echo "<p><strong>🛏️ Dormitorios:</strong> " . $reg['dormitorios'] . " | ";
        echo "<strong>📏 Tamaño:</strong> " . number_format($reg['tamano']) . " m²</p>";
        
        // Mostrar extras con badges
        if (!empty($reg['extras'])) {
            echo "<p><strong>✨ Extras:</strong> ";
            $extras = explode(',', $reg['extras']);
            foreach ($extras as $extra) {
                $color = '';
                $icon = '';
                switch(trim($extra)) {
                    case 'Piscina':
                        $color = 'bg-info';
                        $icon = '🏊';
                        break;
                    case 'Jardín':
                        $color = 'bg-success';
                        $icon = '🌳';
                        break;
                    case 'Garage':
                        $color = 'bg-warning';
                        $icon = '🚗';
                        break;
                }
                echo "<span class='badge $color badge-extra'>$icon " . htmlspecialchars(trim($extra)) . "</span> ";
            }
            echo "</p>";
        } else {
            echo "<p><strong>✨ Extras:</strong> <span class='badge bg-secondary'>Sin extras</span></p>";
        }
        
        echo "</div>";
        echo "<div class='col-md-4 text-end'>";
        echo "<div class='precio'>💰 $" . number_format($reg['precio'], 2) . "</div>";
        echo "<button class='btn btn-success mt-2'>Ver Detalles</button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<div class='alert alert-warning'>⚠️ No se encontraron viviendas con los filtros seleccionados.</div>";
}

// Construir URL con parámetros de filtro
$urlParams = [];
foreach ($_GET as $key => $value) {
    if ($key != 'pagina' && !empty($value)) {
        $urlParams[] = $key . '=' . urlencode($value);
    }
}
$baseUrl = '?' . implode('&', $urlParams);
if (!empty($urlParams)) {
    $baseUrl .= '&';
}

// Paginación
if ($totalPaginas > 1) {
    echo "<nav aria-label='Navegación de páginas'>";
    echo "<ul class='pagination'>";
    
    // Botón Anterior
    if ($pagina > 1) {
        echo "<li class='page-item'>";
        echo "<a class='page-link' href='{$baseUrl}pagina=" . ($pagina - 1) . "'>⬅️ Anterior</a>";
        echo "</li>";
    } else {
        echo "<li class='page-item disabled'>";
        echo "<span class='page-link'>⬅️ Anterior</span>";
        echo "</li>";
    }
    
    // Números de página
    for ($i = 1; $i <= $totalPaginas; $i++) {
        $active = ($i == $pagina) ? 'active' : '';
        echo "<li class='page-item $active'>";
        echo "<a class='page-link' href='{$baseUrl}pagina=$i'>$i</a>";
        echo "</li>";
    }
    
    // Botón Siguiente
    if ($pagina < $totalPaginas) {
        echo "<li class='page-item'>";
        echo "<a class='page-link' href='{$baseUrl}pagina=" . ($pagina + 1) . "'>Siguiente ➡️</a>";
        echo "</li>";
    } else {
        echo "<li class='page-item disabled'>";
        echo "<span class='page-link'>Siguiente ➡️</span>";
        echo "</li>";
    }
    
    echo "</ul>";
    echo "</nav>";
}

mysqli_close($conexion);
?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>