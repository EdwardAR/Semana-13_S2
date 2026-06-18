<?php
// admin/gestion_logos.php

// Aquí puedes incluir cualquier lógica PHP adicional necesaria para el panel de administración,
// como verificaciones de sesión/autenticación para asegurar que solo usuarios autorizados accedan a esta página.
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
    <title>Admin - Gestión de Logos - Don Lucho</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .admin-container { padding-top: 2rem; padding-bottom: 2rem; }
        .table th, .table td { vertical-align: middle; }
        .btn-estado {
            padding: 0.25rem 0.5rem; font-size: 0.875rem; border-radius: 0.2rem; cursor: pointer;
            border: 1px solid transparent; transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            white-space: nowrap;
        }
        .btn-estado.activo { background-color: #28a745; color: white; border-color: #28a745;}
        .btn-estado.inactivo { background-color: #ffc107; color: black; border-color: #ffc107;}
        .btn-estado.eliminado { background-color: #6c757d; color: white; border-color: #6c757d; }

        .btn-table-action {
            padding: 0.375rem 0.75rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem;
            margin-right: 5px; margin-bottom: 5px;
        }
        .btn-table-action:last-child { margin-right: 0; }

        .admin-navbar { background-color: #343a40 !important; }
        .admin-navbar .navbar-brand { color: #fff; font-weight: bold; }
        .admin-navbar .navbar-brand span { color: #8D5B18; }
        .admin-navbar .nav-link { color: rgba(255,255,255,0.75) !important; transition: color 0.3s ease; }
        .admin-navbar .nav-link:hover, .admin-navbar .nav-link:focus { color: rgba(255,255,255,1) !important; }
        .admin-navbar .nav-item.active .nav-link, .admin-navbar .nav-link.active { font-weight: bold; color: #fff !important; }
        .admin-navbar .navbar-brand { margin-right: auto; }
        .admin-navbar .navbar-nav { margin-left: auto; }
        .logo-img-preview { max-width: 100px; max-height: 50px; object-fit: contain; } /* Ajuste para previsualización de logos */
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
                    <li class="nav-item"><a class="nav-link" href="gestion_navbar.php">Navbar</a></li>
                    <li class="nav-item"><a class="nav-link" href="gestion_slider.php">Slider</a></li>
                    <li class="nav-item active"><a class="nav-link" href="gestion_logos.php">Logos</a></li>
                    <li class="nav-item"><a class="nav-link" href="gestion_productos.php">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="gestion_pedidos.php">Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="../index.php" target="_blank">Ver Sitio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container admin-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Logos</h1>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCrearEditarLogo">
                <i class="fas fa-plus me-1"></i> Crear Nuevo Logo
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Referencia</th>
                        <th>Imagen</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaLogosBody">
                    <!-- Los logos se cargarán aquí dinámicamente mediante JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Crear/Editar Logo -->
    <div class="modal fade" id="modalCrearEditarLogo" tabindex="-1" aria-labelledby="modalCrearEditarLogoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearEditarLogoLabel">Crear Logo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formLogo" enctype="multipart/form-data">
                        <input type="hidden" id="logoId" name="logoId">
                        <div class="mb-3">
                            <label for="nombreReferencia" class="form-label">Nombre de Referencia</label>
                            <input type="text" class="form-control" id="nombreReferencia" name="nombreReferencia" required>
                            <small class="form-text text-muted">Nombre interno para identificar el logo (ej: "Logo Principal", "Logo Footer"). Este también será el texto alternativo para la imagen.</small>
                        </div>
                        <div class="mb-3">
                            <label for="imagenLogo" class="form-label">Archivo de Imagen del Logo</label>
                            <input type="file" class="form-control" id="imagenLogo" name="imagenLogo" accept="image/*">
                            <small class="form-text text-muted">Deja en blanco si no quieres cambiar la imagen en una edición.</small>
                            <div class="mt-2" id="imagenLogoPreviewContainer" style="display: none;">
                                <img id="imagenLogoPreview" src="#" alt="Vista previa del logo" class="logo-img-preview border rounded">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="estadoLogo" class="form-label">Estado</label>
                            <select class="form-select" id="estadoLogo" name="estadoLogo">
                                <option value="activo" selected>Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarLogo()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Estático para Notificaciones (Reemplaza alert()) -->
    <div class="modal fade" id="staticNotificationModal" tabindex="-1" aria-labelledby="staticNotificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticNotificationModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="staticNotificationModalBody">
                    <!-- Mensaje se inserta aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Estático para Confirmaciones (Reemplaza confirm()) -->
    <div class="modal fade" id="staticConfirmationModal" tabindex="-1" aria-labelledby="staticConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="staticConfirmationModalLabel">Confirmación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="staticConfirmationModalBody">
                    <!-- Mensaje se inserta aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-warning" id="confirmActionButton">Confirmar</button>
                </div>
            </div>
        </div>
    </div>


    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        let logosData = []; // Almacenará los datos de los logos cargados

        /**
         * Renderiza la tabla de logos en el DOM.
         * Limpia la tabla existente y la rellena con los datos de 'logosData'.
         */
        function renderizarTablaLogos() {
            const tbody = document.getElementById('tablaLogosBody');
            tbody.innerHTML = ''; // Limpiar la tabla antes de renderizar

            logosData.forEach(logo => {
                const tr = document.createElement('tr');
                let estadoClass = '';
                let estadoTexto = '';
                switch(logo.estado) {
                    case 'activo': estadoClass = 'activo'; estadoTexto = 'Activo'; break;
                    case 'inactivo': estadoClass = 'inactivo'; estadoTexto = 'Inactivo'; break;
                    case 'eliminado': estadoClass = 'eliminado'; estadoTexto = 'Eliminado'; break; // Solo por si persiste algún 'eliminado'
                }

                // Determina la URL de la imagen del logo, con un fallback si no hay imagen
                const logoImageUrl = logo.ruta_imagen ? `../${htmlspecialchars(logo.ruta_imagen)}` : 'https://placehold.co/100x50/e9e9e9/000000?text=No+Logo';

                tr.innerHTML = `
                    <td>${htmlspecialchars(logo.id)}</td>
                    <td>${htmlspecialchars(logo.nombre_referencia)}</td>
                    <td><img src="${logoImageUrl}" alt="${htmlspecialchars(logo.nombre_referencia)}" class="logo-img-preview"></td>
                    <td><button class="btn btn-sm btn-estado ${estadoClass}" 
                                 onclick="ciclarEstadoLogo(${htmlspecialchars(logo.id)}, this)">
                                 ${estadoTexto}</button></td>
                    <td>
                        <button class="btn btn-primary btn-sm btn-table-action" data-bs-toggle="modal" data-bs-target="#modalCrearEditarLogo"
                                 onclick="cargarDatosLogoParaEditar(${htmlspecialchars(logo.id)})">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm btn-table-action" onclick="eliminarLogoFisico(${htmlspecialchars(logo.id)})" title="Eliminar permanentemente">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        /**
         * Carga los datos de un logo específico en el modal de edición.
         * @param {number} id - El ID del logo a cargar.
         */
        function cargarDatosLogoParaEditar(id) {
            const logo = logosData.find(l => l.id == id);
            if (logo) {
                document.getElementById('logoId').value = logo.id;
                document.getElementById('nombreReferencia').value = logo.nombre_referencia;
                // El estado 'eliminado' no debe ser editable directamente aquí, solo 'activo'/'inactivo'
                document.getElementById('estadoLogo').value = logo.estado === 'eliminado' ? 'inactivo' : logo.estado;

                // Mostrar la vista previa de la imagen actual
                const imagenLogoPreview = document.getElementById('imagenLogoPreview');
                const imagenLogoPreviewContainer = document.getElementById('imagenLogoPreviewContainer');
                if (logo.ruta_imagen) {
                    imagenLogoPreview.src = `../${logo.ruta_imagen}`;
                    imagenLogoPreviewContainer.style.display = 'block';
                } else {
                    imagenLogoPreview.src = '#';
                    imagenLogoPreviewContainer.style.display = 'none';
                }

                document.getElementById('modalCrearEditarLogoLabel').textContent = 'Editar Logo';
            }
        }

        // Evento para limpiar el modal al abrirlo para crear un nuevo logo
        document.getElementById('modalCrearEditarLogo').addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button && button.getAttribute('data-bs-target') === '#modalCrearEditarLogo' && !button.hasAttribute('onclick')) {
                // Es el botón "Crear Nuevo Logo"
                document.getElementById('formLogo').reset();
                document.getElementById('logoId').value = ''; // Asegura que el ID esté vacío para una creación
                document.getElementById('estadoLogo').value = 'activo'; // Por defecto a 'activo'
                document.getElementById('imagenLogoPreview').src = '#'; // Limpiar preview de imagen
                document.getElementById('imagenLogoPreviewContainer').style.display = 'none';
                document.getElementById('modalCrearEditarLogoLabel').textContent = 'Crear Nuevo Logo';
            }
        });

        // Evento para manejar la vista previa de la imagen seleccionada
        document.getElementById('imagenLogo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const imagenLogoPreview = document.getElementById('imagenLogoPreview');
            const imagenLogoPreviewContainer = document.getElementById('imagenLogoPreviewContainer');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagenLogoPreview.src = e.target.result;
                    imagenLogoPreviewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagenLogoPreview.src = '#';
                imagenLogoPreviewContainer.style.display = 'none';
            }
        });

        /**
         * Guarda (crea o edita) un logo enviando los datos del formulario a la API.
         * Utiliza FormData para manejar la subida de archivos (imágenes).
         */
        async function guardarLogo() {
            const form = document.getElementById('formLogo');
            const formData = new FormData(form);

            const logoId = document.getElementById('logoId').value;
            if (logoId) {
                formData.append('id', logoId);
            }
            
            formData.set('nombreReferencia', document.getElementById('nombreReferencia').value);
            formData.set('estadoLogo', document.getElementById('estadoLogo').value);

            try {
                const response = await fetch('api/logos_crear_editar.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cargarLogos(); // Recargar la tabla para ver los cambios
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalCrearEditarLogo'));
                    if (modal) {
                        modal.hide();
                    }
                } else {
                    mostrarNotificacion('Error: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error al guardar el logo:', error);
                mostrarNotificacion('Error de conexión al guardar el logo. Revisa la consola para más detalles.', 'danger');
            }
        }

        /**
         * Cambia el estado de un logo (activo/inactivo).
         * El estado 'eliminado' ahora se gestiona con `eliminarLogoFisico`.
         * @param {number} id - El ID del logo.
         * @param {HTMLElement} buttonElement - El botón de estado que fue clickeado.
         */
        async function ciclarEstadoLogo(id, buttonElement) {
            const logo = logosData.find(l => l.id == id);
            if (!logo) return;

            let nuevoEstado, nuevaClase, nuevoTexto;

            // Cicla solo entre 'activo' e 'inactivo'
            if (logo.estado === 'activo') {
                nuevoEstado = 'inactivo'; nuevaClase = 'inactivo'; nuevoTexto = 'Inactivo';
            } else { // Si es 'inactivo'
                nuevoEstado = 'activo'; nuevaClase = 'activo'; nuevoTexto = 'Activo';
            }
            
            try {
                const response = await fetch('api/logos_cambiar_estado.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id, estado: nuevoEstado })
                });
                const result = await response.json();

                if (result.success) {
                    logo.estado = nuevoEstado; // Actualizar el estado localmente
                    buttonElement.className = 'btn btn-sm btn-estado ' + nuevaClase;
                    buttonElement.textContent = nuevoTexto;
                    mostrarNotificacion(result.message, 'success');
                    cargarLogos(); // Recargar para reflejar cambios
                } else {
                    mostrarNotificacion('Error: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error al cambiar el estado del logo:', error);
                mostrarNotificacion('Error de conexión al cambiar el estado del logo. Revisa la consola para más detalles.', 'danger');
            }
        }

        /**
         * Realiza la eliminación física de un logo de la base de datos y del servidor.
         * @param {number} id - El ID del logo a eliminar físicamente.
         */
        async function eliminarLogoFisico(id) {
            mostrarConfirmacion(`¿Estás seguro de que quieres ELIMINAR PERMANENTEMENTE el logo ${id}? Esta acción no se puede deshacer.`, async () => {
                try {
                    const response = await fetch('api/logos_eliminar_fisico.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id })
                    });
                    const result = await response.json();

                    if (result.success) {
                        mostrarNotificacion(result.message, 'success');
                        cargarLogos(); // Recargar la tabla para reflejar la eliminación
                    } else {
                        mostrarNotificacion('Error al eliminar: ' + result.message, 'danger');
                    }
                } catch (error) {
                    console.error('Error al eliminar físicamente el logo:', error);
                    mostrarNotificacion('Error de conexión al eliminar el logo. Revisa la consola para más detalles.', 'danger');
                }
            });
        }

        /**
         * Carga los logos desde la API y actualiza la tabla.
         */
        async function cargarLogos() {
            try {
                const response = await fetch('api/logos_leer.php');
                const result = await response.json();
                if (result.success) {
                    logosData = result.data;
                    renderizarTablaLogos();
                } else {
                    mostrarNotificacion('Error al cargar logos: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error al cargar logos:', error);
                mostrarNotificacion('Error de conexión al cargar los logos. Revisa la consola para más detalles.', 'danger');
            }
        }

        /**
         * Función de utilidad para escapar caracteres HTML en strings.
         * Previene ataques de inyección de HTML/XSS al renderizar contenido dinámico.
         * @param {string} str - La cadena de texto a escapar.
         * @returns {string} La cadena con los caracteres HTML escapados.
         */
        function htmlspecialchars(str) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return String(str).replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // --- Funciones para Notificaciones Modales Personalizadas (Reemplazo de alert/confirm) ---

        // Referencias a los modales estáticos
        const notificationModalElement = document.getElementById('staticNotificationModal');
        const notificationModalTitle = document.getElementById('staticNotificationModalLabel');
        const notificationModalBody = document.getElementById('staticNotificationModalBody');
        let bsNotificationModal = null; // Instancia de Bootstrap Modal

        const confirmationModalElement = document.getElementById('staticConfirmationModal');
        const confirmationModalTitle = document.getElementById('staticConfirmationModalLabel');
        const confirmationModalBody = document.getElementById('staticConfirmationModalBody');
        const confirmActionButton = document.getElementById('confirmActionButton');
        let bsConfirmationModal = null; // Instancia de Bootstrap Modal

        // Inicializar los modales de Bootstrap una vez que el DOM esté cargado
        document.addEventListener('DOMContentLoaded', () => {
            bsNotificationModal = new bootstrap.Modal(notificationModalElement);
            bsConfirmationModal = new bootstrap.Modal(confirmationModalElement);
        });

        // Función para mostrar una notificación personalizada (reemplaza alert)
        function mostrarNotificacion(message, type = 'info') {
            // Si el modal de confirmación está abierto, ocúltalo primero para evitar conflictos de aria-hidden
            if (bsConfirmationModal && bsConfirmationModal._isShown) {
                bsConfirmationModal.hide();
            }

            notificationModalTitle.textContent = type === 'success' ? 'Éxito' : (type === 'danger' ? 'Error' : 'Información');
            notificationModalBody.innerHTML = message;
            
            // Actualizar la clase del encabezado del modal
            notificationModalTitle.parentElement.classList.remove('bg-success', 'bg-danger', 'bg-info', 'bg-warning');
            notificationModalTitle.parentElement.classList.add(`bg-${type}`, 'text-white');

            if (bsNotificationModal) {
                bsNotificationModal.show();
            } else {
                console.error("Error: El modal de notificación no está inicializado.");
                alert(message); // Fallback
            }
        }

        // Función para mostrar una confirmación personalizada (reemplaza confirm)
        function mostrarConfirmacion(message, onConfirmCallback) {
            // Si el modal de notificación está abierto, ocúltalo primero para evitar conflictos de aria-hidden
            if (bsNotificationModal && bsNotificationModal._isShown) {
                bsNotificationModal.hide();
            }

            confirmationModalBody.innerHTML = message;
            
            if (bsConfirmationModal) {
                // Eliminar cualquier listener anterior para evitar duplicados
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

        // Carga inicial de la tabla al cargar el DOM
        document.addEventListener('DOMContentLoaded', cargarLogos);
    </script>
</body>
</html>
