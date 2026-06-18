<?php
// C:\\xampp\\htdocs\\catalogo\\admin\\gestion_productos.php

// Este archivo es la interfaz de usuario del panel de administración para la gestión de productos.
// No necesita incluir directamente db_config.php porque todas las interacciones con la base de datos
// se realizan a través de llamadas AJAX a los archivos API PHP (productos_leer.php, productos_crear_editar.php, etc.),
// que son los que sí incluyen db_config.php.

// Incluye tu lógica de autenticación aquí si la tienes configurada.
// Esto es CRUCIAL para asegurar que solo usuarios autorizados puedan acceder a esta página.
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
    <title>Admin - Gestión de Productos - Don Lucho</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilos generales para el cuerpo del panel de administración */
        body {
            background-color: #f5f5f0; /* Un fondo muy claro, casi crema, para una base elegante */
            font-family: 'Inter', sans-serif; /* Asegurando la fuente Inter */
            color: #333;
        }
        .admin-container {
            padding-top: 3.5rem; /* Más espacio superior */
            padding-bottom: 3.5rem; /* Más espacio inferior */
        }
        h1 {
            color: #4a1421; /* Un borgoña oscuro para un toque sofisticado */
            font-weight: 700;
            margin-bottom: 2.5rem; /* Más margen inferior */
            text-align: center;
            font-size: 2.5rem; /* Título más grande */
        }

        /* Navbar de administración mejorada */
        .admin-navbar {
            background-color: #4a1421 !important; /* Borgoña oscuro, elegante */
            padding-top: 18px; /* Más padding */
            padding-bottom: 18px; /* Más padding */
            box-shadow: 0 3px 8px rgba(0,0,0,0.2); /* Sombra más pronunciada para profundidad */
        }
        .admin-navbar .navbar-brand {
            font-weight: 800;
            color: #fff !important;
            font-size: 1.9rem; /* Fuente de marca más grande */
        }
        .admin-navbar .navbar-brand span {
            color: #daa520; /* Dorado para el acento, evocando licores */
        }
        .admin-navbar .nav-link {
            color: rgba(255,255,255,0.85) !important; /* Ligeramente más opaco */
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.6rem 1.1rem; /* Más padding */
            border-radius: 6px; /* Ligeramente más redondeado */
        }
        .admin-navbar .nav-link:hover,
        .admin-navbar .nav-item.active .nav-link {
            color: #fff !important;
            background-color: rgba(255,255,255,0.18); /* Fondo más visible al pasar el ratón */
        }

        /* Botones de acción */
        .btn-primary, .btn-info, .btn-warning, .btn-danger {
            border-radius: 10px; /* Más redondeado */
            padding: 0.7rem 1.4rem; /* Más padding */
            font-size: 1rem; /* Fuente ligeramente más grande */
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15); /* Sombra más pronunciada */
            border: none; /* Eliminar bordes para un aspecto más plano */
        }
        .btn-primary {
            background-color: #4a1421; /* Borgoña oscuro */
        }
        .btn-primary:hover {
            background-color: #3b101a; /* Borgoña aún más oscuro */
            transform: translateY(-3px); /* Efecto de elevación más notorio */
            box-shadow: 0 6px 12px rgba(0,0,0,0.25);
        }
        .btn-info {
            background-color: #2f4f4f; /* Gris pizarra oscuro, sofisticado */
        }
        .btn-info:hover {
            background-color: #263e3e;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }
        .btn-warning {
            background-color: #d2691e; /* Chocolate, un marrón rico */
            color: #fff; /* Texto blanco para contraste */
        }
        .btn-warning:hover {
            background-color: #b35919;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }
        .btn-danger {
            background-color: #8b0000; /* Rojo oscuro, clásico */
        }
        .btn-danger:hover {
            background-color: #6a0000;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }

        /* Estilo de la tabla */
        .table {
            background-color: #ffffff;
            border-radius: 12px; /* Más redondeado */
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.12); /* Sombra más suave y extendida */
        }
        .table thead th {
            background-color: #eeebe6; /* Un beige claro para el encabezado */
            color: #495057;
            font-weight: 700;
            vertical-align: middle;
            padding: 1.2rem; /* Más padding */
            border-bottom: 2px solid #e2e6ea; /* Borde más sutil */
        }
        .table tbody tr {
            transition: background-color 0.2s ease, transform 0.2s ease; /* Añadir transición para transform */
        }
        .table tbody tr:hover {
            background-color: #fffbf5; /* Color de hover más notorio y cálido */
            transform: translateY(-2px); /* Efecto de elevación ligera en filas */
        }
        .table td {
            vertical-align: middle;
            padding: 1rem 1.2rem; /* Más padding */
            border-top: 1px solid #ebf0f1; /* Borde más claro */
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,0.01); /* Color de banda aún más sutil */
        }

        /* Estilo para la imagen en la tabla */
        .product-table-image {
            width: 65px; /* Tamaño ligeramente más grande */
            height: 65px;
            object-fit: contain; /* Asegura que la imagen se ajuste sin recortar */
            border-radius: 8px; /* Más redondeado */
            border: 1px solid #e0e0e0; /* Borde más suave */
            box-shadow: 0 2px 6px rgba(0,0,0,0.08); /* Sombra más definida */
        }

        /* Estilos para badges de estado */
        .btn-estado {
            padding: 0.5em 1em; /* Más padding */
            font-size: 0.85rem; /* Fuente ligeramente más grande */
            font-weight: 700;
            border-radius: 50rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            letter-spacing: 0.03em; /* Espaciado entre letras */
            text-transform: uppercase; /* Mayúsculas */
        }
        .btn-estado.activo {
            background-color: #28a745; /* Verde estándar */
            color: #fff;
        }
        .btn-estado.inactivo {
            background-color: #6c757d; /* Gris estándar */
            color: #fff;
        }
        .btn-estado.eliminado {
            background-color: #dc3545; /* Rojo estándar */
            color: #fff;
        }

        /* Estilos para el formulario del modal */
        #productForm label {
            font-weight: 600;
            color: #444; /* Color ligeramente más oscuro */
            margin-bottom: 0.6rem; /* Más margen */
        }
        #productForm .form-control, #productForm .form-select {
            border-radius: 8px; /* Más redondeado */
            border: 1px solid #d0d7dd; /* Borde más definido */
            padding: 0.8rem 1.1rem; /* Más padding */
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.05); /* Sombra interior sutil */
        }
        #productForm input[type="file"] {
            border-radius: 8px;
        }
        .form-check-label {
            font-weight: 500 !important; /* Ligeramente más negrita que 400 */
        }


        /* Estilos para el modal personalizado */
        .modal-custom .modal-content {
            border-radius: 16px; /* Aún más redondeado */
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.25); /* Sombra más prominente */
            border: none;
        }
        .modal-custom .modal-header {
            background-color: #4a1421;
            color: white;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
            padding: 1.8rem; /* Más padding */
            border-bottom: none;
        }
        .modal-custom .modal-header .btn-close {
            filter: brightness(0) invert(1);
            font-size: 1.2rem; /* Icono de cerrar más grande */
        }
        .modal-custom .modal-title {
            font-weight: 700;
            font-size: 1.8rem; /* Título de modal más grande */
        }
        .modal-custom .modal-body {
            padding: 3rem; /* Más padding */
            text-align: center;
            font-size: 1.1rem;
            color: #555;
        }
        .modal-custom .modal-footer {
            border-top: none;
            padding: 1.8rem 3rem; /* Más padding */
            justify-content: center;
        }
        .modal-custom .btn {
            border-radius: 10px; /* Más redondeado */
            padding: 0.8rem 2.2rem; /* Más padding */
            font-size: 1.05rem; /* Fuente ligeramente más grande */
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 120px; /* Ancho mínimo para los botones del modal */
        }
        .modal-custom .btn-primary {
            background-color: #4a1421;
            border-color: #4a1421;
        }
        .modal-custom .btn-primary:hover {
            background-color: #3b101a;
            border-color: #3b101a;
            transform: translateY(-3px);
        }
        .modal-custom .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .modal-custom .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
            transform: translateY(-3px);
        }
        /* Imagen actual en el modal de producto */
        #currentProductImage {
            max-width: 130px; /* Un poco más grande */
            height: auto;
            border-radius: 10px; /* Más redondeado */
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); /* Sombra más suave */
        }
    </style>
</head>
<body>
    <nav class="admin-navbar navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Don Lucho<span>.</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_productos.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_categorias.php">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_slider.php">Slider</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_logos.php">Logos</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="gestion_navbar.php">Navbar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_pedidos.php">Pedidos</a>
                    </li>
                    <!-- Añadir más enlaces de administración aquí según sea necesario -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container admin-container">
        <h1 class="mb-4">Gestión de Productos</h1>

        <!-- Controles de búsqueda y añadir producto -->
        <div class="row mb-4">
            <div class="col-md-6">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal" onclick="resetProductForm()">
                    <i class="fas fa-plus-circle me-2"></i>Añadir Nuevo Producto
                </button>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="productSearchInput" placeholder="Buscar producto por nombre o ID...">
                    <button class="btn btn-outline-secondary" type="button" id="clearSearchButton">Limpiar</button>
                </div>
            </div>
        </div>

        <!-- Tabla de Productos -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Destacado</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="productsTableBody">
                    <!-- Los productos se cargarán aquí vía JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Crear/Editar Producto -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Añadir/Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm" enctype="multipart/form-data">
                        <input type="hidden" id="productId">
                        <div class="mb-3">
                            <label for="nombreProducto" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombreProducto" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoriaProducto" class="form-label">Categoría</label>
                            <select class="form-control" id="categoriaProducto" required>
                                <!-- Las categorías se cargarán aquí dinámicamente -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionCorta" class="form-label">Descripción Corta</label>
                            <textarea class="form-control" id="descripcionCorta" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionLarga" class="form-label">Descripción Larga</label>
                            <textarea class="form-control" id="descripcionLarga" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precioProducto" class="form-label">Precio</label>
                            <input type="number" step="0.01" class="form-control" id="precioProducto" required>
                        </div>
                        <div class="mb-3">
                            <label for="stockProducto" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stockProducto" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagenProducto" class="form-label">Imagen del Producto (JPG/PNG)</label>
                            <input type="file" class="form-control" id="imagenProducto" accept="image/jpeg, image/png">
                            <small class="form-text text-muted">Tamaño máximo: 5MB. Formatos permitidos: JPG, PNG.</small>
                            <img id="currentProductImage" src="" alt="Imagen Actual" class="img-thumbnail mt-2" style="max-width: 150px; display: none;">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="destacadoEnInicio">
                            <label class="form-check-label" for="destacadoEnInicio">Destacado en Inicio</label>
                        </div>
                        <div class="mb-3">
                            <label for="estadoProducto" class="form-label">Estado</label>
                            <select class="form-control" id="estadoProducto" required>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                                <option value="eliminado">Eliminado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Guardar Producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Notificación Personalizado -->
    <div class="modal fade modal-custom" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notificación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="notificationModalBody">
                    <!-- Mensaje de notificación aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación Personalizado -->
    <div class="modal fade modal-custom" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="confirmationModalBody">
                    <!-- Mensaje de confirmación aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmActionButton">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        // Variables globales para los modales de Bootstrap
        let bsNotificationModal;
        let bsConfirmationModal;
        let confirmActionButton;
        let notificationModalBody;
        let confirmationModalBody;
        let allProductsData = []; // Variable global para almacenar todos los productos

        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar los modales de Bootstrap una vez que el DOM esté cargado
            bsNotificationModal = new bootstrap.Modal(document.getElementById('notificationModal'), {
                backdrop: 'static', // Evita que se cierre al hacer clic fuera
                keyboard: false // Evita que se cierre con la tecla ESC
            });
            notificationModalBody = document.getElementById('notificationModalBody');

            bsConfirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'), {
                backdrop: 'static',
                keyboard: false
            });
            confirmationModalBody = document.getElementById('confirmationModalBody');
            confirmActionButton = document.getElementById('confirmActionButton');

            cargarProductos(); // Carga inicial de la tabla de productos
            cargarCategoriasDropdown(); // Carga las categorías en el dropdown

            // Event listener para previsualizar la imagen seleccionada
            document.getElementById('imagenProducto').addEventListener('change', function(event) {
                const [file] = event.target.files;
                if (file) {
                    const currentProductImage = document.getElementById('currentProductImage');
                    currentProductImage.src = URL.createObjectURL(file);
                    currentProductImage.style.display = 'block';
                }
            });

            // Event listener para el modal de producto cuando se cierra
            document.getElementById('productModal').addEventListener('hidden.bs.modal', function() {
                // Limpiar la previsualización de la imagen al cerrar el modal
                const currentProductImage = document.getElementById('currentProductImage');
                currentProductImage.src = '';
                currentProductImage.style.display = 'none';
                document.getElementById('imagenProducto').value = ''; // Limpiar el input file
            });

            // Event listener para el filtro de búsqueda
            document.getElementById('productSearchInput').addEventListener('keyup', function() {
                filterProductsTable(this.value);
            });

            // Event listener para limpiar la búsqueda
            document.getElementById('clearSearchButton').addEventListener('click', function() {
                document.getElementById('productSearchInput').value = '';
                filterProductsTable('');
            });
        });

        // Función para mostrar una notificación personalizada (reemplaza alert)
        function mostrarNotificacion(message, isSuccess = true) {
            // Asegurarse de que el modal de confirmación esté oculto si está abierto
            if (bsConfirmationModal && bsConfirmationModal._isShown) {
                bsConfirmationModal.hide();
            }
            notificationModalBody.innerHTML = message;
            // Opcional: Cambiar estilo del modal según éxito/error
            const modalHeader = document.querySelector('#notificationModal .modal-header');
            if (isSuccess) {
                modalHeader.style.backgroundColor = '#28a745'; // Verde para éxito
                modalHeader.classList.remove('bg-danger');
                modalHeader.classList.add('bg-success');
            } else {
                modalHeader.style.backgroundColor = '#dc3545'; // Rojo para error
                modalHeader.classList.remove('bg-success');
                modalHeader.classList.add('bg-danger');
            }

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
            // Asegurarse de que el header del modal de confirmación use el color por defecto (azul)
            const modalHeader = document.querySelector('#confirmationModal .modal-header');
            modalHeader.style.backgroundColor = '#007bff';
            modalHeader.classList.remove('bg-success', 'bg-danger'); // Limpiar clases si se aplicaron antes

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


        // Función para cargar los productos desde la API y renderizar la tabla
        async function cargarProductos() {
            try {
                const response = await fetch('api/productos_leer.php');
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                const text = await response.text();
                let result;
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error('Respuesta no JSON:', text.substring(0, 500));
                    throw new Error('La API devolvió una respuesta inesperada');
                }
                if (result.success) {
                    allProductsData = result.data;
                    renderProductsTable(allProductsData);
                } else {
                    mostrarNotificacion('Error al cargar productos: ' + result.message, false);
                }
            } catch (error) {
                console.error('Error al cargar productos:', error);
                mostrarNotificacion('Error al cargar productos: ' + error.message, false);
            }
        }

        // Función para renderizar la tabla de productos (usada por cargarProductos y filterProductsTable)
        function renderProductsTable(productsToRender) {
            const productsTableBody = document.getElementById('productsTableBody');
            productsTableBody.innerHTML = ''; // Limpiar tabla antes de añadir nuevos datos

            productsToRender.forEach(product => {
                const row = productsTableBody.insertRow();
                // Asegúrate de que la ruta de la imagen sea correcta desde el contexto de gestion_productos.php
                // Si imagen_url guarda 'images/products/nombre.jpg', y gestion_productos.php está en admin/,
                // entonces necesitas '../' para llegar a la raíz.
                const imageUrl = product.imagen_url ? '../' + product.imagen_url : 'https://placehold.co/70x70/e9e9e9/000000?text=No+Img';

                row.innerHTML = `
                    <td>${htmlspecialchars(product.id)}</td>
                    <td>
                        <img src="${htmlspecialchars(imageUrl)}"
                             alt="${htmlspecialchars(product.nombre)}"
                             class="product-table-image"
                             onerror="this.onerror=null;this.src='https://placehold.co/70x70/e9e9e9/000000?text=No+Img';">
                    </td>
                    <td>${htmlspecialchars(product.nombre)}</td>
                    <td>${htmlspecialchars(product.nombre_categoria || 'Sin Categoría')}</td>
                    <td>$${htmlspecialchars(parseFloat(product.precio).toFixed(2))}</td>
                    <td>${htmlspecialchars(product.stock)}</td>
                    <td>${product.destacado_en_inicio == 1 ? '<i class="fas fa-check-circle text-success"></i> Sí' : '<i class="fas fa-times-circle text-danger"></i> No'}</td>
                    <td><span class="btn-estado ${htmlspecialchars(product.estado)}">${htmlspecialchars(product.estado)}</span></td>
                    <td>
                        <button class="btn btn-sm btn-info me-2" onclick="editarProducto(${product.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-warning me-2" onclick="cambiarEstadoProducto(${product.id}, '${product.estado}')"><i class="fas fa-toggle-on"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarProducto(${product.id})"><i class="fas fa-trash"></i></button>
                    </td>
                `;
            });
        }

        // Función para filtrar los productos en la tabla
        function filterProductsTable(searchText) {
            const lowerCaseSearchText = searchText.toLowerCase();
            const filteredProducts = allProductsData.filter(product => {
                return (
                    product.nombre.toLowerCase().includes(lowerCaseSearchText) ||
                    product.id.toString().includes(lowerCaseSearchText) ||
                    (product.nombre_categoria && product.nombre_categoria.toLowerCase().includes(lowerCaseSearchText))
                );
            });
            renderProductsTable(filteredProducts);
        }

        // Función para cargar las categorías en el dropdown
        async function cargarCategoriasDropdown() {
            try {
                const response = await fetch('api/categorias_leer.php');
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                const text = await response.text();
                let result;
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error('Respuesta no JSON:', text.substring(0, 500));
                    throw new Error('API de categorías devolvió respuesta inesperada');
                }
                const categoriaSelect = document.getElementById('categoriaProducto');
                categoriaSelect.innerHTML = '<option value="">Selecciona una categoría</option>';

                if (result.success) {
                    result.data.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria.id;
                        option.textContent = htmlspecialchars(categoria.nombre);
                        categoriaSelect.appendChild(option);
                    });
                } else {
                    console.error('Error al cargar categorías:', result.message);
                    mostrarNotificacion('Error al cargar categorías: ' + result.message, false);
                }
            } catch (error) {
                console.error('Error de conexión al cargar categorías:', error);
                mostrarNotificacion('Error al cargar categorías: ' + error.message, false);
            }
        }

        // Función para resetear el formulario al añadir un nuevo producto
        function resetProductForm() {
            document.getElementById('productForm').reset();
            document.getElementById('productId').value = '';
            document.getElementById('productModalLabel').textContent = 'Añadir Nuevo Producto';
            const currentProductImage = document.getElementById('currentProductImage');
            currentProductImage.src = '';
            currentProductImage.style.display = 'none';
            document.getElementById('imagenProducto').required = true; // Imagen es obligatoria para nuevos productos
            document.getElementById('imagenProducto').value = ''; // Asegurar que el input file esté vacío
            // Resetear el estado a "activo" por defecto
            document.getElementById('estadoProducto').value = 'activo';
            // Deseleccionar cualquier categoría
            document.getElementById('categoriaProducto').value = '';
        }

        // Función para editar un producto
        async function editarProducto(id) {
            try {
                // Leer todos los productos para encontrar el que se quiere editar
                const response = await fetch(`api/productos_leer.php`);
                const result = await response.json();

                if (result.success && result.data) {
                    const productIdToFind = parseInt(id);
                    const product = result.data.find(p => parseInt(p.id) === productIdToFind);

                    if (product) {
                        document.getElementById('productId').value = product.id;
                        document.getElementById('nombreProducto').value = product.nombre;
                        document.getElementById('categoriaProducto').value = product.categoria_id;
                        document.getElementById('descripcionCorta').value = product.descripcion_corta;
                        document.getElementById('descripcionLarga').value = product.descripcion_larga;
                        document.getElementById('precioProducto').value = product.precio;
                        document.getElementById('stockProducto').value = product.stock;
                        document.getElementById('destacadoEnInicio').checked = product.destacado_en_inicio == 1;
                        document.getElementById('estadoProducto').value = product.estado;

                        const currentProductImage = document.getElementById('currentProductImage');
                        // Asegúrate de que la ruta de la imagen sea correcta desde el contexto de gestion_productos.php
                        // Si imagen_url guarda 'images/products/nombre.jpg', y gestion_productos.php está en admin/,
                        // entonces necesitas '../' para llegar a la raíz.
                        if (product.imagen_url) {
                            currentProductImage.src = '../' + htmlspecialchars(product.imagen_url);
                            currentProductImage.style.display = 'block';
                            document.getElementById('imagenProducto').required = false; // No es obligatoria si ya hay una
                        } else {
                            currentProductImage.style.display = 'none';
                            currentProductImage.src = '';
                            document.getElementById('imagenProducto').required = true; // Si no hay imagen, es obligatoria
                        }
                        // Limpiar el input file para evitar el "fakepath" visual, pero mantener la imagen actual
                        document.getElementById('imagenProducto').value = '';

                        document.getElementById('productModalLabel').textContent = 'Editar Producto: ' + product.nombre;
                        new bootstrap.Modal(document.getElementById('productModal')).show();
                    } else {
                        mostrarNotificacion('Producto no encontrado.', false);
                    }
                } else {
                    mostrarNotificacion('Error al obtener datos del producto para edición: ' + result.message, false);
                }
            } catch (error) {
                console.error('Error al editar producto:', error);
                mostrarNotificacion('Error de conexión al intentar editar el producto. Revisa la consola.', false);
            }
        }

        // Manejar el envío del formulario de producto
        document.getElementById('productForm').addEventListener('submit', async function (event) {
            event.preventDefault();

            const productId = document.getElementById('productId').value;
            const nombre = document.getElementById('nombreProducto').value;
            const categoriaId = document.getElementById('categoriaProducto').value;
            const descripcionCorta = document.getElementById('descripcionCorta').value;
            const descripcionLarga = document.getElementById('descripcionLarga').value;
            const precio = document.getElementById('precioProducto').value;
            const stock = document.getElementById('stockProducto').value;
            const destacadoEnInicio = document.getElementById('destacadoEnInicio').checked ? 1 : 0;
            const estadoProducto = document.getElementById('estadoProducto').value;
            const imagenProducto = document.getElementById('imagenProducto').files[0];

            if (!categoriaId) {
                mostrarNotificacion('Por favor, selecciona una categoría para el producto.', false);
                return;
            }

            const formData = new FormData();
            if (productId) {
                formData.append('id', productId);
            }
            formData.append('nombre', nombre);
            formData.append('categoriaId', categoriaId);
            formData.append('descripcionCorta', descripcionCorta);
            formData.append('descripcionLarga', descripcionLarga);
            formData.append('precio', precio);
            formData.append('stock', stock);
            formData.append('destacadoEnInicio', destacadoEnInicio);
            formData.append('estadoProducto', estadoProducto);
            if (imagenProducto) {
                formData.append('imagenProducto', imagenProducto);
            } else if (!productId && document.getElementById('imagenProducto').required) {
                 // Si es un nuevo producto y no hay imagen, y la imagen es requerida
                mostrarNotificacion('La imagen del producto es obligatoria para nuevos productos.', false);
                return;
            }


            try {
                const response = await fetch('api/productos_crear_editar.php', {
                    method: 'POST',
                    body: formData // FormData se envía directamente sin Content-Type
                });
                const result = await response.json();

                if (result.success) {
                    mostrarNotificacion(result.message, true);
                    bootstrap.Modal.getInstance(document.getElementById('productModal')).hide();
                    cargarProductos(); // Recargar la tabla
                } else {
                    mostrarNotificacion('Error al guardar producto: ' + result.message, false);
                }
            } catch (error) {
                console.error('Error al guardar producto:', error);
                mostrarNotificacion('Error de conexión al guardar el producto. Revisa la consola para más detalles.', false);
            }
        });

        // Función para cambiar el estado de un producto (activo, inactivo, eliminado lógicamente)
        async function cambiarEstadoProducto(id, estadoActual) {
            let nuevoEstado;
            let confirmMessage;

            if (estadoActual === 'activo') {
                nuevoEstado = 'inactivo';
                confirmMessage = '¿Estás seguro de inactivar este producto? No será visible para los clientes.';
            } else if (estadoActual === 'inactivo') {
                nuevoEstado = 'activo';
                confirmMessage = '¿Estás seguro de activar este producto? Será visible para los clientes.';
            } else { // Si ya está 'eliminado', solo se puede 'activar' o 'inactivar' si se desea un restablecimiento completo.
                mostrarNotificacion('El producto está en estado "eliminado". Si deseas restablecerlo, usa la opción de "Restaurar" o crea una nueva funcionalidad para ello.', false);
                return;
            }

            mostrarConfirmacion(confirmMessage, async () => {
                try {
                    const response = await fetch('api/productos_cambiar_estado.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: id, estado: nuevoEstado })
                    });
                    const result = await response.json();

                    if (result.success) {
                        mostrarNotificacion(result.message, true);
                        cargarProductos(); // Recargar la tabla
                    } else {
                        mostrarNotificacion('Error al cambiar el estado: ' + result.message, false);
                    }
                } catch (error) {
                    console.error('Error al cambiar el estado:', error);
                    mostrarNotificacion('Error de conexión al cambiar el estado del producto. Revisa la consola para más detalles.', false);
                }
            });
        }

        // Función para eliminar FÍSICAMENTE un producto (borrar registro y archivo)
        async function eliminarProducto(id) {
            mostrarConfirmacion('¿Estás seguro de ELIMINAR PERMANENTEMENTE este producto? Esta acción no se puede deshacer y el producto será borrado de la base de datos y su imagen del servidor. Esta acción podría afectar los pedidos existentes si no se maneja adecuadamente.', async () => {
                try {
                    const response = await fetch('api/productos_eliminar_fisico.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: id })
                    });
                    const result = await response.json();

                    if (result.success) {
                        mostrarNotificacion(result.message, true);
                        cargarProductos(); // Recargar la tabla
                    } else {
                        mostrarNotificacion('Error al eliminar el producto: ' + result.message, false);
                    }
                } catch (error) {
                    console.error('Error al eliminar físicamente el producto:', error);
                    mostrarNotificacion('Error de conexión al intentar eliminar el producto físicamente. Revisa la consola para más detalles.', false);
                }
            });
        }

        /**
         * Función de utilidad para escapar caracteres HTML en strings.
         * Previene ataques de inyección de HTML/XSS al renderizar contenido dinámico.
         * @param {string} str - La cadena de texto a escapar.
         * @returns {string} La cadena con los caracteres HTML escapados.
         */
        function htmlspecialchars(str) {
            if (str === null || str === undefined) return '';
            str = String(str);
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return str.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

    </script>
</body>
</html>
