<?php
// admin/gestion_categorias.php

// Incluir lógica de autenticación si es necesario
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
    <title>Admin - Gestión de Categorías - Don Lucho</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .admin-container { padding-top: 2rem; padding-bottom: 2rem; }
        .table th, .table td { vertical-align: middle; }
        .btn-estado {
            padding: 0.25rem 0.5rem; font-size: 0.875rem; border-radius: 0.2rem; cursor: pointer;
            border: 1px solid transparent; transition: all 0.2s ease-in-out;
        }
        .btn-estado.activo { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
        .btn-estado.inactivo { background-color: #fff3cd; color: #856404; border-color: #ffeeba; }
        .btn-estado.eliminado { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        /* Estilos para el campo de búsqueda */
        .search-container {
            margin-bottom: 1rem;
        }
        .search-input {
            border-radius: .25rem;
            border: 1px solid #ced4da;
            padding: .375rem .75rem;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="admin-container container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestión de Categorías</h2>
            <div>
                <a href="dashboard.php" class="btn btn-secondary me-2">Volver al Dashboard</a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoriaModal" onclick="abrirModalCrear()">
                    <i class="fas fa-plus"></i> Nueva Categoría
                </button>
            </div>
        </div>

        <div class="search-container">
            <input type="text" id="searchInput" class="form-control search-input" placeholder="Buscar categorías...">
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Slug</th>
                        <th>Estado</th>
                        <th>Creado</th>
                        <th>Actualizado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="categoriasTableBody">
                    <tr>
                        <td colspan="7" class="text-center">Cargando categorías...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="categoriaModal" tabindex="-1" aria-labelledby="categoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoriaModalLabel">Crear/Editar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoriaForm">
                    <div class="modal-body">
                        <input type="hidden" id="categoriaId">
                        <div class="mb-3">
                            <label for="nombreCategoria" class="form-label">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="nombreCategoria" required>
                        </div>
                        <div class="mb-3">
                            <label for="estadoCategoria" class="form-label">Estado</label>
                            <select class="form-select" id="estadoCategoria">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                                <option value="eliminado">Eliminado Lógicamente</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Categoría</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notificación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="notificationModalBody">
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="confirmationModalBody">
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmActionButton">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        // Variables globales para los modales de Bootstrap
        let bsNotificationModal;
        let bsConfirmationModal;
        let notificationModalBody;
        let confirmationModalBody;
        let confirmActionButton;

        let categoriasData = []; // Para almacenar los datos de las categorías

        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar modales de Bootstrap
            const notificationModalElement = document.getElementById('notificationModal');
            const confirmationModalElement = document.getElementById('confirmationModal');

            if (notificationModalElement) {
                bsNotificationModal = new bootstrap.Modal(notificationModalElement);
                notificationModalBody = document.getElementById('notificationModalBody');
            } else {
                console.error("Elemento 'notificationModal' no encontrado.");
            }

            if (confirmationModalElement) {
                bsConfirmationModal = new bootstrap.Modal(confirmationModalElement);
                confirmationModalBody = document.getElementById('confirmationModalBody');
                confirmActionButton = document.getElementById('confirmActionButton');
            } else {
                console.error("Elemento 'confirmationModal' no encontrado.");
            }

            // Manejar el submit del formulario de categoría
            document.getElementById('categoriaForm').addEventListener('submit', async function(event) {
                event.preventDefault(); // Prevenir el envío tradicional del formulario

                const id = document.getElementById('categoriaId').value;
                const nombre = document.getElementById('nombreCategoria').value;
                const estado = document.getElementById('estadoCategoria').value;

                const data = {
                    id: id ? parseInt(id) : null,
                    nombre: nombre,
                    estado: estado
                };

                try {
                    const response = await fetch('api/categorias_crear_editar.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });
                    const result = await response.json();

                    mostrarNotificacion(result.message);
                    if (result.success) {
                        bsCategoriaModal.hide(); // Ocultar el modal después de guardar
                        cargarCategorias(); // Recargar la tabla
                    }
                } catch (error) {
                    console.error('Error al guardar la categoría:', error);
                    mostrarNotificacion('Error de conexión al guardar la categoría.');
                }
            });

            // Campo de búsqueda
            document.getElementById('searchInput').addEventListener('keyup', function() {
                renderizarTablaCategorias(this.value);
            });

            // Carga inicial de la tabla
            cargarCategorias();
        });

        // Funciones de utilidad para modales
        function mostrarNotificacion(message) {
            notificationModalBody.innerHTML = message;
            if (bsNotificationModal) {
                bsNotificationModal.show();
            } else {
                alert(message); // Fallback
            }
        }

        function mostrarConfirmacion(message, onConfirmCallback) {
            if (bsNotificationModal && bsNotificationModal._isShown) {
                bsNotificationModal.hide();
            }

            confirmationModalBody.innerHTML = message;
            
            if (bsConfirmationModal) {
                confirmActionButton.onclick = null;
                confirmActionButton.onclick = () => {
                    onConfirmCallback();
                    bsConfirmationModal.hide();
                };
                bsConfirmationModal.show();
            } else {
                console.error("Error: El modal de confirmación no está inicializado.");
                if (confirm(message)) { // Fallback
                    onConfirmCallback();
                }
            }
        }

        // Variable global para el modal de categorías
        let bsCategoriaModal = null; // Se inicializará al cargar el DOM

        document.addEventListener('DOMContentLoaded', () => {
            const categoriaModalElement = document.getElementById('categoriaModal');
            if (categoriaModalElement) {
                bsCategoriaModal = new bootstrap.Modal(categoriaModalElement);
            }
        });


        async function cargarCategorias() {
            try {
                const response = await fetch('api/categorias_leer.php');
                const result = await response.json();
                if (result.success) {
                    categoriasData = result.data; // Almacena los datos
                    renderizarTablaCategorias();
                } else {
                    mostrarNotificacion('Error al cargar categorías: ' + result.message);
                }
            } catch (error) {
                console.error('Error al cargar categorías:', error);
                mostrarNotificacion('Error de conexión al cargar las categorías. Revisa la consola para más detalles.');
            }
        }

        function renderizarTablaCategorias(searchTerm = '') {
            const tableBody = document.getElementById('categoriasTableBody');
            tableBody.innerHTML = ''; // Limpiar tabla antes de renderizar

            const filteredData = categoriasData.filter(categoria =>
                categoria.nombre.toLowerCase().includes(searchTerm.toLowerCase()) ||
                categoria.slug.toLowerCase().includes(searchTerm.toLowerCase()) ||
                categoria.estado.toLowerCase().includes(searchTerm.toLowerCase())
            );

            if (filteredData.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="7" class="text-center">No se encontraron categorías.</td></tr>`;
                return;
            }

            filteredData.forEach(categoria => {
                const row = tableBody.insertRow();
                row.insertCell().textContent = categoria.id;
                row.insertCell().textContent = categoria.nombre;
                row.insertCell().textContent = categoria.slug;
                
                const estadoCell = row.insertCell();
                const estadoSpan = document.createElement('span');
                estadoSpan.textContent = categoria.estado;
                estadoSpan.classList.add('btn-estado', categoria.estado); // Añade clases para estilos
                estadoCell.appendChild(estadoSpan);

                row.insertCell().textContent = new Date(categoria.created_at).toLocaleString();
                row.insertCell().textContent = new Date(categoria.updated_at).toLocaleString();

                const actionsCell = row.insertCell();
                
                // Botón Editar
                const editButton = document.createElement('button');
                editButton.classList.add('btn', 'btn-info', 'btn-sm', 'me-2');
                editButton.innerHTML = '<i class="fas fa-edit"></i>';
                editButton.title = 'Editar';
                editButton.onclick = () => abrirModalEditar(categoria.id);
                actionsCell.appendChild(editButton);

                // Botón Cambiar Estado (Activo/Inactivo/Eliminado)
                const estadoButton = document.createElement('button');
                estadoButton.classList.add('btn', 'btn-warning', 'btn-sm');
                estadoButton.innerHTML = '<i class="fas fa-toggle-on"></i>'; // Icono por defecto
                estadoButton.title = 'Cambiar Estado';
                
                if (categoria.estado === 'activo') {
                    estadoButton.innerHTML = '<i class="fas fa-toggle-off"></i>';
                    estadoButton.classList.remove('btn-warning');
                    estadoButton.classList.add('btn-secondary');
                    estadoButton.title = 'Desactivar';
                    estadoButton.onclick = () => cambiarEstadoCategoria(categoria.id, 'inactivo');
                } else if (categoria.estado === 'inactivo') {
                    estadoButton.innerHTML = '<i class="fas fa-toggle-on"></i>';
                    estadoButton.classList.remove('btn-secondary');
                    estadoButton.classList.add('btn-success');
                    estadoButton.title = 'Activar';
                    estadoButton.onclick = () => cambiarEstadoCategoria(categoria.id, 'activo');
                } else if (categoria.estado === 'eliminado') {
                    estadoButton.innerHTML = '<i class="fas fa-undo"></i>';
                    estadoButton.classList.remove('btn-warning', 'btn-secondary', 'btn-success');
                    estadoButton.classList.add('btn-info');
                    estadoButton.title = 'Restaurar';
                    estadoButton.onclick = () => cambiarEstadoCategoria(categoria.id, 'activo');
                }
                actionsCell.appendChild(estadoButton);

                // Botón Eliminar Físicamente (Opcional, si se desea borrar permanentemente)
                // En este caso, solo implementaremos el cambio de estado a 'eliminado'
                // Si quieres un borrado físico, necesitarías un archivo `categorias_eliminar_fisico.php`
                // y una confirmación más fuerte. Por ahora, 'eliminado' es suficiente.
            });
        }

        function abrirModalCrear() {
            document.getElementById('categoriaForm').reset(); // Limpiar el formulario
            document.getElementById('categoriaId').value = ''; // Asegurar que el ID esté vacío
            document.getElementById('categoriaModalLabel').textContent = 'Crear Nueva Categoría';
            document.getElementById('estadoCategoria').value = 'activo'; // Estado por defecto
            if (bsCategoriaModal) {
                bsCategoriaModal.show();
            }
        }

        function abrirModalEditar(id) {
            const categoria = categoriasData.find(c => c.id === id);
            if (categoria) {
                document.getElementById('categoriaId').value = categoria.id;
                document.getElementById('nombreCategoria').value = categoria.nombre;
                document.getElementById('estadoCategoria').value = categoria.estado;
                document.getElementById('categoriaModalLabel').textContent = 'Editar Categoría: ' + categoria.nombre;
                if (bsCategoriaModal) {
                    bsCategoriaModal.show();
                }
            } else {
                mostrarNotificacion('Categoría no encontrada.');
            }
        }

        async function cambiarEstadoCategoria(id, nuevoEstado) {
            mostrarConfirmacion(`¿Estás seguro de cambiar el estado de la categoría a "${nuevoEstado}"?`, async () => {
                try {
                    const response = await fetch('api/categorias_cambiar_estado.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: id, estado: nuevoEstado })
                    });
                    const result = await response.json();
                    mostrarNotificacion(result.message);
                    if (result.success) {
                        cargarCategorias(); // Recargar la tabla
                    }
                } catch (error) {
                    console.error('Error al cambiar el estado:', error);
                    mostrarNotificacion('Error de conexión al cambiar el estado. Revisa la consola para más detalles.');
                }
            });
        }
    </script>
</body>
</html>