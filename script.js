// ================================================
// ARCHIVO: script.js
// JavaScript para funcionalidad AJAX
// ================================================

let paginaActual = 1;

// Cargar viviendas al iniciar la página
document.addEventListener('DOMContentLoaded', function() {
    cargarViviendas();
});

// Manejar envío del formulario
document.getElementById('formFiltros').addEventListener('submit', function(e) {
    e.preventDefault();
    paginaActual = 1;
    cargarViviendas();
});

// Botón limpiar filtros
document.getElementById('btnLimpiar').addEventListener('click', function() {
    document.getElementById('formFiltros').reset();
    paginaActual = 1;
    cargarViviendas();
});

// Cambio automático en cualquier filtro
document.querySelectorAll('#formFiltros select').forEach(select => {
    select.addEventListener('change', function() {
        paginaActual = 1;
        cargarViviendas();
    });
});

// Función principal para cargar viviendas
function cargarViviendas(pagina = paginaActual) {
    const loading = document.querySelector('.loading');
    const resultados = document.getElementById('resultados');
    
    // Mostrar loading
    loading.classList.add('show');
    resultados.style.opacity = '0.5';

    // Obtener valores del formulario
    const tipo = document.getElementById('tipo').value;
    const zona = document.getElementById('zona').value;
    const dormitorios = document.getElementById('dormitorios').value;
    const extras = document.getElementById('extras').value;

    // Construir URL con parámetros
    const params = new URLSearchParams({
        ajax: '1',
        pagina: pagina,
        tipo: tipo,
        zona: zona,
        dormitorios: dormitorios,
        extras: extras
    });

    // Hacer petición AJAX con fetch
    fetch('api_viviendas.php?' + params.toString())
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            mostrarResultados(data);
            paginaActual = pagina;
            loading.classList.remove('show');
            resultados.style.opacity = '1';
        })
        .catch(error => {
            console.error('Error:', error);
            resultados.innerHTML = '<div class="alert alert-danger">❌ Error al cargar las viviendas. Por favor, intenta nuevamente.</div>';
            loading.classList.remove('show');
            resultados.style.opacity = '1';
        });
}

// Función para mostrar los resultados
function mostrarResultados(data) {
    const resultados = document.getElementById('resultados');
    let html = '';

    // Información de resultados
    html += `<div class="alert alert-info">
        📊 Mostrando <strong>${data.cantidad}</strong> viviendas de un total de <strong>${data.total}</strong>
        | Página <strong>${data.paginaActual}</strong> de <strong>${data.totalPaginas}</strong>
    </div>`;

    // Mostrar viviendas
    if (data.viviendas.length > 0) {
        data.viviendas.forEach((vivienda, index) => {
            html += `<div class="vivienda-card" style="animation-delay: ${index * 0.1}s">
                <div class="row">
                    <div class="col-md-8">
                        <h4>🏘️ ${escapeHtml(vivienda.tipo)} - ID: ${vivienda.id}</h4>
                        <p><strong>📍 Ubicación:</strong> ${escapeHtml(vivienda.direccion)} - Zona ${escapeHtml(vivienda.zona)}</p>
                        <p><strong>🛏️ Dormitorios:</strong> ${vivienda.dormitorios} | 
                        <strong>📏 Tamaño:</strong> ${vivienda.tamano.toLocaleString()} m²</p>`;
            
            // Mostrar extras
            if (vivienda.extras && vivienda.extras.length > 0) {
                html += '<p><strong>✨ Extras:</strong> ';
                vivienda.extras.forEach(extra => {
                    let color = '';
                    let icon = '';
                    switch(extra) {
                        case 'Piscina':
                            color = 'bg-info';
                            icon = '🏊';
                            break;
                        case 'Jardín':
                            color = 'bg-success';
                            icon = '🌳';
                            break;
                        case 'Garage':
                            color = 'bg-warning';
                            icon = '🚗';
                            break;
                    }
                    html += `<span class="badge ${color} badge-extra">${icon} ${escapeHtml(extra)}</span> `;
                });
                html += '</p>';
            } else {
                html += '<p><strong>✨ Extras:</strong> <span class="badge bg-secondary">Sin extras</span></p>';
            }
            
            html += `</div>
                    <div class="col-md-4 text-end">
                        <div class="precio">💰 $${vivienda.precio.toLocaleString('es-AR', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                        <button class="btn btn-success mt-2" onclick="verDetalles(${vivienda.id})">Ver Detalles</button>
                    </div>
                </div>
            </div>`;
        });
    } else {
        html += '<div class="alert alert-warning">⚠️ No se encontraron viviendas con los filtros seleccionados.</div>';
    }

    // Crear paginación
    if (data.totalPaginas > 1) {
        html += '<nav aria-label="Navegación de páginas"><ul class="pagination">';
        
        // Botón Anterior
        if (data.paginaActual > 1) {
            html += `<li class="page-item">
                <a class="page-link" href="#" onclick="event.preventDefault(); cargarViviendas(${data.paginaActual - 1})">⬅️ Anterior</a>
            </li>`;
        } else {
            html += `<li class="page-item disabled">
                <span class="page-link">⬅️ Anterior</span>
            </li>`;
        }
        
        // Números de página
        for (let i = 1; i <= data.totalPaginas; i++) {
            const active = (i === data.paginaActual) ? 'active' : '';
            html += `<li class="page-item ${active}">
                <a class="page-link" href="#" onclick="event.preventDefault(); cargarViviendas(${i})">${i}</a>
            </li>`;
        }
        
        // Botón Siguiente
        if (data.paginaActual < data.totalPaginas) {
            html += `<li class="page-item">
                <a class="page-link" href="#" onclick="event.preventDefault(); cargarViviendas(${data.paginaActual + 1})">Siguiente ➡️</a>
            </li>`;
        } else {
            html += `<li class="page-item disabled">
                <span class="page-link">Siguiente ➡️</span>
            </li>`;
        }
        
        html += '</ul></nav>';
    }

    // Actualizar contenido
    resultados.innerHTML = html;
    
    // Scroll suave hacia arriba
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Función para escapar HTML y prevenir XSS
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.toString().replace(/[&<>"']/g, m => map[m]);
}

// Función para ver detalles (ejemplo)
function verDetalles(id) {
    alert(`Ver detalles de la vivienda ID: ${id}\n\nEsta funcionalidad se puede expandir para mostrar un modal con más información.`);
}