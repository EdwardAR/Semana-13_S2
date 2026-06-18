<?php
// C:\xampp\htdocs\catalogo\admin\gestion_slider.php

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
    <title>Admin - Gestión de Slider - Don Lucho</title>
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
        /* El estado 'eliminado' ya no se mostrará con un botón, pero la clase se mantiene por si acaso */
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
        .slider-img-preview { max-width: 150px; max-height: 80px; object-fit: contain; }
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
                    <li class="nav-item active"><a class="nav-link" href="gestion_slider.php">Slider</a></li>
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
            <h1>Gestión de Slider</h1>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCrearEditarSlider">
                <i class="fas fa-plus me-1"></i> Crear Nuevo Ítem de Slider
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Subtítulo</th>
                        <th>Imagen</th>
                        <th>Botón 1</th>
                        <th>URL 1</th>
                        <th>Botón 2</th>
                        <th>URL 2</th>
                        <th>Orden</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaSliderBody">
                    <!-- Los ítems del slider se cargarán aquí dinámicamente mediante JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Crear/Editar Slider Item -->
    <div class="modal fade" id="modalCrearEditarSlider" tabindex="-1" aria-labelledby="modalCrearEditarSliderLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearEditarSliderLabel">Crear Ítem de Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formSlider" enctype="multipart/form-data">
                        <input type="hidden" id="sliderId" name="sliderId">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="subtitulo" class="form-label">Subtítulo</label>
                            <textarea class="form-control" id="subtitulo" name="subtitulo" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imagenSlider" class="form-label">Archivo de Imagen del Slider</label>
                            <input type="file" class="form-control" id="imagenSlider" name="imagenSlider" accept="image/*">
                            <small class="form-text text-muted">Deja en blanco si no quieres cambiar la imagen en una edición.</small>
                            <div class="mt-2" id="imagenSliderPreviewContainer" style="display: none;">
                                <img id="imagenSliderPreview" src="#" alt="Vista previa del slider" class="slider-img-preview border rounded">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="textoBoton1" class="form-label">Texto Botón 1</label>
                            <input type="text" class="form-control" id="textoBoton1" name="textoBoton1">
                        </div>
                        <div class="mb-3">
                            <label for="urlBoton1" class="form-label">URL Botón 1</label>
                            <input type="url" class="form-control" id="urlBoton1" name="urlBoton1">
                        </div>
                        <div class="mb-3">
                            <label for="textoBoton2" class="form-label">Texto Botón 2</label>
                            <input type="text" class="form-control" id="textoBoton2" name="textoBoton2">
                        </div>
                        <div class="mb-3">
                            <label for="urlBoton2" class="form-label">URL Botón 2</label>
                            <input type="url" class="form-control" id="urlBoton2" name="urlBoton2">
                        </div>
                        <div class="mb-3">
                            <label for="orden" class="form-label">Orden</label>
                            <input type="number" class="form-control" id="orden" name="orden" value="0" required>
                            <small class="form-text text-muted">Define el orden de aparición en el slider.</small>
                        </div>
                        <div class="mb-3">
                            <label for="estadoSlider" class="form-label">Estado</label>
                            <select class="form-select" id="estadoSlider" name="estadoSlider">
                                <option value="activo" selected>Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarSliderItem()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Estático para Notificaciones -->
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

    <!-- Modal Estático para Confirmaciones -->
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
        let sliderItemsData = []; // Almacenará los datos de los ítems del slider cargados

        /**
         * Renderiza la tabla de ítems del slider en el DOM.
         * Limpia la tabla existente y la rellena con los datos de 'sliderItemsData'.
         * Solo renderiza ítems con estado 'activo' o 'inactivo'.
         */
        function renderizarTablaSlider() {
            const tbody = document.getElementById('tablaSliderBody');
            tbody.innerHTML = ''; // Limpiar la tabla antes de renderizar

            // Filtrar los datos para mostrar solo 'activo' o 'inactivo'
            const filteredItems = sliderItemsData.filter(item => item.estado === 'activo' || item.estado === 'inactivo');

            filteredItems.forEach(item => {
                const tr = document.createElement('tr');
                let estadoClass = '';
                let estadoTexto = '';
                switch(item.estado) {
                    case 'activo': estadoClass = 'activo'; estadoTexto = 'Activo'; break;
                    case 'inactivo': estadoClass = 'inactivo'; estadoTexto = 'Inactivo'; break;
                    // 'eliminado' ya no se mostrará en esta tabla
                }

                const imageUrl = item.imagen ? `../${htmlspecialchars(item.imagen)}` : 'https://placehold.co/150x80/e9e9e9/000000?text=No+Image';

                tr.innerHTML = `
                    <td>${htmlspecialchars(item.id)}</td>
                    <td>${htmlspecialchars(item.titulo)}</td>
                    <td>${htmlspecialchars(item.subtitulo.substring(0, 50))}...</td>
                    <td><img src="${imageUrl}" alt="${htmlspecialchars(item.titulo)}" class="slider-img-preview"></td>
                    <td>${htmlspecialchars(item.texto_boton_1)}</td>
                    <td>${htmlspecialchars(item.url_boton_1)}</td>
                    <td>${htmlspecialchars(item.texto_boton_2)}</td>
                    <td>${htmlspecialchars(item.url_boton_2)}</td>
                    <td>${htmlspecialchars(item.orden)}</td>
                    <td><button class="btn btn-sm btn-estado ${estadoClass}" 
                                 onclick="ciclarEstadoSliderItem(${htmlspecialchars(item.id)}, this)">
                                 ${estadoTexto}</button></td>
                    <td>
                        <button class="btn btn-primary btn-sm btn-table-action" data-bs-toggle="modal" data-bs-target="#modalCrearEditarSlider"
                                 onclick="cargarDatosSliderItemParaEditar(${htmlspecialchars(item.id)})">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm btn-table-action" onclick="eliminarSliderItemFisico(${htmlspecialchars(item.id)})" title="Eliminar permanentemente">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        /**
         * Carga los datos de un ítem de slider específico en el modal de edición.
         * @param {number} id - El ID del ítem del slider a cargar.
         */
        function cargarDatosSliderItemParaEditar(id) {
            const item = sliderItemsData.find(i => i.id == id);
            if (item) {
                document.getElementById('sliderId').value = item.id;
                document.getElementById('titulo').value = item.titulo;
                document.getElementById('subtitulo').value = item.subtitulo;
                document.getElementById('textoBoton1').value = item.texto_boton_1;
                document.getElementById('urlBoton1').value = item.url_boton_1;
                document.getElementById('textoBoton2').value = item.texto_boton_2;
                document.getElementById('urlBoton2').value = item.url_boton_2;
                document.getElementById('orden').value = item.orden;
                // Al cargar para editar, si el estado es 'eliminado', lo mostramos como 'inactivo' para evitar confusión
                document.getElementById('estadoSlider').value = item.estado === 'eliminado' ? 'inactivo' : item.estado;

                // Mostrar la vista previa de la imagen actual
                const imagenSliderPreview = document.getElementById('imagenSliderPreview');
                const imagenSliderPreviewContainer = document.getElementById('imagenSliderPreviewContainer');
                if (item.imagen) {
                    imagenSliderPreview.src = `../${item.imagen}`;
                    imagenSliderPreviewContainer.style.display = 'block';
                } else {
                    imagenSliderPreview.src = '#';
                    imagenSliderPreviewContainer.style.display = 'none';
                }

                document.getElementById('modalCrearEditarSliderLabel').textContent = 'Editar Ítem de Slider';
            }
        }

        // Evento para limpiar el modal al abrirlo para crear un nuevo ítem de slider
        document.getElementById('modalCrearEditarSlider').addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button && button.getAttribute('data-bs-target') === '#modalCrearEditarSlider' && !button.hasAttribute('onclick')) {
                // Es el botón "Crear Nuevo Ítem de Slider"
                document.getElementById('formSlider').reset();
                document.getElementById('sliderId').value = ''; // Asegura que el ID esté vacío para una creación
                document.getElementById('estadoSlider').value = 'activo'; // Por defecto a 'activo'
                document.getElementById('orden').value = '0'; // Por defecto el orden
                document.getElementById('imagenSliderPreview').src = '#'; // Limpiar preview de imagen
                document.getElementById('imagenSliderPreviewContainer').style.display = 'none';
                document.getElementById('modalCrearEditarSliderLabel').textContent = 'Crear Nuevo Ítem de Slider';
            }
        });

        // Evento para manejar la vista previa de la imagen seleccionada
        document.getElementById('imagenSlider').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const imagenSliderPreview = document.getElementById('imagenSliderPreview');
            const imagenSliderPreviewContainer = document.getElementById('imagenSliderPreviewContainer');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagenSliderPreview.src = e.target.result;
                    imagenSliderPreviewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagenSliderPreview.src = '#';
                imagenSliderPreviewContainer.style.display = 'none';
            }
        });

        /**
         * Guarda (crea o edita) un ítem de slider enviando los datos del formulario a la API.
         * Utiliza FormData para manejar la subida de archivos (imágenes).
         */
        async function guardarSliderItem() {
            const form = document.getElementById('formSlider');
            const formData = new FormData(form);

            const sliderId = document.getElementById('sliderId').value;
            if (sliderId) {
                formData.append('id', sliderId);
            }
            
            // Asegúrate que los nombres de los campos en formData coincidan con lo que espera el PHP
            formData.set('titulo', document.getElementById('titulo').value);
            formData.set('subtitulo', document.getElementById('subtitulo').value);
            formData.set('textoBoton1', document.getElementById('textoBoton1').value);
            formData.set('urlBoton1', document.getElementById('urlBoton1').value);
            formData.set('textoBoton2', document.getElementById('textoBoton2').value);
            formData.set('urlBoton2', document.getElementById('urlBoton2').value);
            formData.set('orden', document.getElementById('orden').value);
            formData.set('estadoSlider', document.getElementById('estadoSlider').value);

            try {
                const response = await fetch('api/slider_crear_editar.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cargarSliderItems(); // Recargar la tabla para ver los cambios
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalCrearEditarSlider'));
                    if (modal) {
                        modal.hide();
                    }
                } else {
                    mostrarNotificacion('Error: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error al guardar el ítem del slider:', error);
                mostrarNotificacion('Error de conexión al guardar el ítem del slider. Revisa la consola para más detalles.', 'danger');
            }
        }

        /**
         * Cambia el estado de un ítem de slider (activo/inactivo).
         * El estado 'eliminado' ahora se gestiona con `eliminarSliderItemFisico`.
         * @param {number} id - El ID del ítem del slider.
         * @param {HTMLElement} buttonElement - El botón de estado que fue clickeado.
         */
        async function ciclarEstadoSliderItem(id, buttonElement) {
            const item = sliderItemsData.find(i => i.id == id);
            if (!item) return;

            let nuevoEstado, nuevaClase, nuevoTexto;

            // Cicla solo entre 'activo' e 'inactivo'
            if (item.estado === 'activo') {
                nuevoEstado = 'inactivo'; nuevaClase = 'inactivo'; nuevoTexto = 'Inactivo';
            } else { // Si es 'inactivo'
                nuevoEstado = 'activo'; nuevaClase = 'activo'; nuevoTexto = 'Activo';
            }
            
            try {
                const response = await fetch('api/slider_cambiar_estado.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id, estado: nuevoEstado })
                });
                const result = await response.json();

                if (result.success) {
                    item.estado = nuevoEstado; // Actualizar el estado localmente
                    buttonElement.className = 'btn btn-sm btn-estado ' + nuevaClase;
                    buttonElement.textContent = nuevoTexto;
                    mostrarNotificacion(result.message, 'success');
                    cargarSliderItems(); // Recargar para reflejar cambios
                } else {
                    mostrarNotificacion('Error: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error al cambiar el estado del ítem del slider:', error);
                mostrarNotificacion('Error de conexión al cambiar el estado del ítem del slider. Revisa la consola para más detalles.', 'danger');
            }
        }

        /**
         * Realiza la eliminación física de un ítem de slider de la base de datos y del servidor.
         * @param {number} id - El ID del ítem del slider a eliminar físicamente.
         */
        async function eliminarSliderItemFisico(id) {
            mostrarConfirmacion(`¿Estás seguro de que quieres ELIMINAR PERMANENTEMENTE el ítem de slider ${id}? Esta acción no se puede deshacer.`, async () => {
                try {
                    const response = await fetch('api/slider_eliminar_fisico.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id })
                    });
                    const result = await response.json();

                    if (result.success) {
                        mostrarNotificacion(result.message, 'success');
                        cargarSliderItems(); // Recargar la tabla para reflejar la eliminación
                    } else {
                        mostrarNotificacion('Error al eliminar: ' + result.message, 'danger');
                    }
                } catch (error) {
                    console.error('Error al eliminar físicamente el ítem del slider:', error);
                    mostrarNotificacion('Error de conexión al eliminar el ítem del slider. Revisa la consola para más detalles.', 'danger');
                }
            });
        }

        /**
         * Carga los ítems del slider desde la API y actualiza la tabla.
         */
        async function cargarSliderItems() {
            try {
                const response = await fetch('api/slider_leer.php');
                const result = await response.json();
                if (result.success) {
                    sliderItemsData = result.data;
                    renderizarTablaSlider();
                } else {
                    mostrarNotificacion('Error al cargar ítems del slider: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error al cargar ítems del slider:', error);
                mostrarNotificacion('Error de conexión al cargar los ítems del slider. Revisa la consola para más detalles.', 'danger');
            }
        }

        /**
         * Función de utilidad para escapar caracteres HTML en strings.
         * Previene ataques de inyección de HTML/XSS al renderizar contenido dinámico.
         * @param {string} str - La cadena de texto a escapar.
         * @returns {string} La cadena con los caracteres HTML escapados.
         */
        function htmlspecialchars(str) {
            if (typeof str !== 'string') {
                return str; // Retorna el valor tal cual si no es string (ej. null, number)
            }
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return str.replace(/[&<>"']/g, function(m) { return map[m]; });
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
        document.addEventListener('DOMContentLoaded', cargarSliderItems);
    </script>
</body>
</html>
