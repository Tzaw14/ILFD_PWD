<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Sistema de Viviendas AJAX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .ajax-badge {
            background: linear-gradient(45deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            display: inline-block;
            margin-left: 10px;
        }
        .vivienda-card {
            opacity: 0;
            animation: fadeInCard 0.5s forwards;
        }
        @keyframes fadeInCard {
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="titulo-principal">
            🚀 Sistema de Viviendas con AJAX
        </h1>
        
        <!-- Sección de Filtros -->
        <div class="filtros-section">
            <h4>🔍 Filtros de Búsqueda Dinámicos</h4>
            <form id="formFiltros">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Tipo de Vivienda</label>
                        <select name="tipo" id="tipo" class="form-select">
                            <option value="">Todos</option>
                            <option value="Casa">Casa</option>
                            <option value="Departamento">Departamento</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Zona</label>
                        <select name="zona" id="zona" class="form-select">
                            <option value="">Todas</option>
                            <option value="Norte">Norte</option>
                            <option value="Sur">Sur</option>
                            <option value="Este">Este</option>
                            <option value="Oeste">Oeste</option>
                            <option value="Centro">Centro</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Dormitorios mínimos</label>
                        <select name="dormitorios" id="dormitorios" class="form-select">
                            <option value="">Todos</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Extras</label>
                        <select name="extras" id="extras" class="form-select">
                            <option value="">Todos</option>
                            <option value="Piscina">Con Piscina</option>
                            <option value="Jardín">Con Jardín</option>
                            <option value="Garage">Con Garage</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btn-filtro">🔍 Aplicar Filtros</button>
                        <button type="button" id="btnLimpiar" class="btn btn-secondary btn-filtro">🔄 Limpiar Filtros</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="loading">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2">Cargando viviendas...</p>
        </div>

        <div id="resultados"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>