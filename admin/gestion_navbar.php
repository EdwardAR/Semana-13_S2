<?php
// C:\xampp\htdocs\catalogo\admin\gestion_navbar.php

// Aquí puedes incluir cualquier lógica PHP adicional necesaria para el panel de administración,
// como verificaciones de sesión/autenticación para asegurar que solo usuarios autorizados accedan a esta página.
// Por ejemplo:
/*
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirige a la página de login si no está autenticado
    exit;
}
*/
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Gestión de Navbar - Don Lucho</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Un fondo más típico de admin */
        }
        .admin-container {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-estado {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
            cursor: pointer;
            border: 1px solid transparent;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            white-space: nowrap; /* Prevent text wrapping for status buttons */
        }
        .btn-estado.activo { background-color: #28a745; color: white; border-color: #28a745;}
        .btn-estado.inactivo { background-color: #ffc107; color: black; border-color: #ffc107;}
        .btn-estado.eliminado { background-color: #6c757d; color: white; border-color: #6c757d; } /* Gris para eliminado */

        /* Estilos generales para los botones de acción en tabla */
        .btn-table-action {
            padding: 0.375rem 0.75rem; /* Bootstrap default for btn-sm */
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
            margin-right: 5px; /* Space between buttons */
            margin-bottom: 5px; /* For stacking on smaller screens */
        }
        .btn-table-action:last-child {
            margin-right: 0;
        }

        /* Estilos para el navbar de administración */
        .admin-navbar {
            background-color: #343a40 !important; /* Dark background for admin navbar */
        }
        .admin-navbar .navbar-brand {
            color: #fff;
            font-weight: bold;
        }
        .admin-navbar .navbar-brand span {
            color: #8D5B18; /* Or your brand's accent color */
        }
        .admin-navbar .nav-link {
            color: rgba(255,255,255,0.75) !important; /* Lighter white for non-active links */
            transition: color 0.3s ease;
        }
        .admin-navbar .nav-link:hover,
        .admin-navbar .nav-link:focus {
            color: rgba(255,255,255,1) !important; /* Pure white on hover/focus */
        }
        .admin-navbar .nav-item.active .nav-link,
        .admin-navbar .nav-link.active {
            font-weight: bold;
            color: #fff !important; /* Active link is pure white and bold */
        }

        /* Alineación del brand en el navbar */
        .admin-navbar .navbar-brand {
            margin-right: auto; /* Pushes nav links to the right */
        }
        .admin-navbar .navbar-nav {
            margin-left: auto; /* Pushes nav links to the right */
        }
    </style>
</head>
<body>

    <nav class="custom-navbar admin-navbar navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Don Lucho Admin<span>.</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item active"><a class="nav-link" href="gestion_navbar.php">Navbar</a></li>
                    <li class="nav-item"><a class="nav-link" href="gestion_slider.php">Slider</a></li>
                    <li class="nav-item"><a class="nav-link" href="gestion_logos.php">Logos</a></li>
                    <li class="nav-item"><a class="nav-link" href="gestion_productos.php">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="gestion_pedidos.php">Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="../index.php" target="_blank">Ver Sitio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container admin-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Elementos del Navbar</h1>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCrearEditarItem">
                <i class="fas fa-plus me-1"></i> Crear Nuevo Item
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Texto Visible</th>
                        <th>URL Enlace</th>
                        <th>Orden</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaNavbarItemsBody">
                    </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalCrearEditarItem" tabindex="-1" aria-labelledby="modalCrearEditarItemLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearEditarItemLabel">Crear Item del Navbar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNavbarItem">
                        <input type="hidden" id="itemId" name="itemId">
                        <div class="mb-3">
                            <label for="textoVisible" class="form-label">Texto Visible</label>
                            <input type="text" class="form-control" id="textoVisible" name="textoVisible" required>
                        </div>
                        <div class="mb-3">
                            <label for="urlEnlace" class="form-label">URL del Enlace</label>
                            <input type="text" class="form-control" id="urlEnlace" name="urlEnlace" required>
                        </div>
                        <div class="mb-3">
                            <label for="orden" class="form-label">Orden</label>
                            <input type="number" class="form-control" id="orden" name="orden" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="estadoItem" class="form-label">Estado</label>
                            <select class="form-select" id="estadoItem" name="estadoItem">
                                <option value="activo" selected>Activo</option>
                                <option value="inactivo">Inactivo</option>
                                </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarItemNavbar()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        let navbarItemsData = []; // Los datos se cargarán desde la API

        function renderizarTablaNavbar() {
            const tbody = document.getElementById('tablaNavbarItemsBody');
            tbody.innerHTML = ''; // Limpiar tabla
            navbarItemsData.forEach(item => {
                const tr = document.createElement('tr');
                let estadoClass = '';
                let estadoTexto = '';
                switch(item.estado) {
                    case 'activo': estadoClass = 'activo'; estadoTexto = 'Activo'; break;
                    case 'inactivo': estadoClass = 'inactivo'; estadoTexto = 'Inactivo'; break;
                    case 'eliminado': estadoClass = 'eliminado'; estadoTexto = 'Eliminado'; break;
                }

                // Importante: Escapar comillas simples en los strings para el onclick
                // Esto previene errores si texto_visible o url_enlace contienen una comilla simple (').
                const escapedTexto = item.texto_visible.replace(/'/g, "\\'");
                const escapedUrl = item.url_enlace.replace(/'/g, "\\'");

                tr.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.texto_visible}</td>
                    <td>${item.url_enlace}</td>
                    <td>${item.orden}</td>
                    <td><button class="btn btn-sm btn-estado ${estadoClass}" onclick="ciclarEstado(${item.id}, this)">${estadoTexto}</button></td>
                    <td>
                        <button class="btn btn-primary btn-sm btn-table-action" data-bs-toggle="modal" data-bs-target="#modalCrearEditarItem"
                                 onclick="cargarDatosParaEditar(${item.id}, '${escapedTexto}', '${escapedUrl}', ${item.orden}, '${item.estado}')">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm btn-table-action" onclick="confirmarEliminacionLogica(${item.id})" title="Marcar como eliminado">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function cargarDatosParaEditar(id, texto, url, orden, estado) {
            document.getElementById('itemId').value = id;
            document.getElementById('textoVisible').value = texto;
            document.getElementById('urlEnlace').value = url;
            document.getElementById('orden').value = orden;
            // Si el estado es 'eliminado', lo mostramos como 'inactivo' en el selector para edición,
            // ya que 'eliminado' es un estado final que se maneja con el botón de eliminación lógica.
            document.getElementById('estadoItem').value = estado === 'eliminado' ? 'inactivo' : estado;
            document.getElementById('modalCrearEditarItemLabel').textContent = 'Editar Item del Navbar';
        }

        document.getElementById('modalCrearEditarItem').addEventListener('show.bs.modal', function (event) {
            // Verifica si el modal se está abriendo para "Crear" (botón "Crear Nuevo Item")
            // o para "Editar" (botón "Editar" en la tabla).
            const button = event.relatedTarget; // Botón que disparó el modal
            if (button && button.getAttribute('data-bs-target') === '#modalCrearEditarItem' && !button.hasAttribute('onclick')) {
                // Es el botón "Crear Nuevo Item", o un botón "Editar" sin la función onclick para cargar datos
                document.getElementById('formNavbarItem').reset();
                document.getElementById('itemId').value = ''; // Asegura que el ID esté vacío para una creación
                document.getElementById('estadoItem').value = 'activo'; // Por defecto a 'activo' al crear
                document.getElementById('modalCrearEditarItemLabel').textContent = 'Crear Nuevo Item del Navbar';
            }
            // Si el modal se abre por un botón de "Editar", la función cargarDatosParaEditar ya habrá establecido los valores.
        });


        async function guardarItemNavbar() {
            const itemId = document.getElementById('itemId').value;
            const payload = {
                id: itemId ? parseInt(itemId) : null,
                // ¡Importante! Asegúrate de que estos nombres de campo coincidan exactamente con tu base de datos
                // y con lo que espera tu API (navbar_crear_editar.php).
                texto_visible: document.getElementById('textoVisible').value,
                url_enlace: document.getElementById('urlEnlace').value,
                orden: parseInt(document.getElementById('orden').value) || 0,
                estado: document.getElementById('estadoItem').value
            };

            try {
                const response = await fetch('api/navbar_crear_editar.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const result = await response.json();

                if (result.success) {
                    alert(result.message);
                    cargarItemsNavbar(); // Recargar la tabla para ver los cambios
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalCrearEditarItem'));
                    if (modal) {
                        modal.hide(); // Ocultar el modal si existe
                    }
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error al guardar:', error);
                alert('Error de conexión al guardar el item. Revisa la consola para más detalles.');
            }
        }

        async function ciclarEstado(id, buttonElement) {
            const item = navbarItemsData.find(item => item.id == id);
            if (!item) return;

            let nuevoEstado, nuevaClase, nuevoTexto;

            if (item.estado === 'activo') {
                nuevoEstado = 'inactivo'; nuevaClase = 'inactivo'; nuevoTexto = 'Inactivo';
            } else if (item.estado === 'inactivo') {
                nuevoEstado = 'eliminado'; nuevaClase = 'eliminado'; nuevoTexto = 'Eliminado';
            } else { // de eliminado a activo (solo si tiene sentido en tu flujo de trabajo)
                nuevoEstado = 'activo'; nuevaClase = 'activo'; nuevoTexto = 'Activo';
            }
            
            try {
                const response = await fetch('api/navbar_cambiar_estado.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id, estado: nuevoEstado })
                });
                const result = await response.json();

                if (result.success) {
                    item.estado = nuevoEstado; // Actualizar el estado localmente
                    buttonElement.className = 'btn btn-sm btn-estado ' + nuevaClase;
                    buttonElement.textContent = nuevoTexto;
                    alert(result.message);
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error al cambiar estado:', error);
                alert('Error de conexión al cambiar el estado. Revisa la consola para más detalles.');
            }
        }

        async function confirmarEliminacionLogica(id) {
            if (confirm(`¿Estás seguro de que quieres marcar como "eliminado" el item ${id}? Esto es una eliminación lógica y el item no aparecerá en el sitio principal.`)) {
                try {
                    const response = await fetch('api/navbar_cambiar_estado.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id, estado: 'eliminado' })
                    });
                    const result = await response.json();

                    if (result.success) {
                        alert(result.message);
                        cargarItemsNavbar(); // Recargar la tabla para reflejar el estado 'eliminado'
                    } else {
                        alert('Error al eliminar: ' + result.message); // Corrección del alert duplicado
                    }
                } catch (error) {
                    console.error('Error al eliminar lógicamente:', error);
                    alert('Error de conexión al eliminar el item. Revisa la consola para más detalles.');
                }
            }
        }

        async function cargarItemsNavbar() {
            try {
                const response = await fetch('api/navbar_leer.php');
                const result = await response.json();
                if (result.success) {
                    navbarItemsData = result.data;
                    renderizarTablaNavbar();
                } else {
                    alert('Error al cargar items: ' + result.message);
                }
            } catch (error) {
                console.error('Error al cargar items:', error);
                alert('Error de conexión al cargar los items. Revisa la consola para más detalles.');
            }
        }

        // Carga inicial de la tabla al cargar el DOM
        document.addEventListener('DOMContentLoaded', cargarItemsNavbar);
    </script>
</body>
</html>