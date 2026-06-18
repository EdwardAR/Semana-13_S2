<?php
// admin/gestion_pedidos.php

// Lógica de autenticación si es necesaria
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
    <title>Admin - Gestión de Pedidos - Don Lucho</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .admin-container { padding-top: 2rem; padding-bottom: 2rem; }
        .table th, .table td { vertical-align: middle; }
        .badge-status {
            padding: 0.5em 0.7em;
            border-radius: 0.25rem;
            font-size: 0.8em;
            font-weight: bold;
            color: #fff;
            white-space: nowrap;
        }
        .badge-status.pending { background-color: #ffc107; color: #212529; } /* Amarillo */
        .badge-status.processing { background-color: #0d6efd; } /* Azul */
        .badge-status.shipped { background-color: #17a2b8; } /* Turquesa */
        .badge-status.delivered { background-color: #28a745; } /* Verde */
        .badge-status.cancelled { background-color: #dc3545; } /* Rojo */

        /* Estilos para el modal personalizado */
        .modal-custom .modal-content {
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .modal-custom .modal-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            padding: 1rem;
            border-bottom: none;
        }
        .modal-custom .modal-header .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        .modal-custom .modal-body {
            padding: 2rem;
            text-align: center;
            font-size: 1.1rem;
        }
        .modal-custom .modal-footer {
            border-top: none;
            padding: 1rem 2rem;
            justify-content: center;
        }
        .modal-custom .btn {
            border-radius: 0.3rem;
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
        }
        .modal-custom .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .modal-custom .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .order-item-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 10px;
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
                    <li class="nav-item active">
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
        <h1 class="mb-4">Gestión de Pedidos</h1>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Monto Total</th>
                        <th>Estado</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                    <!-- Los pedidos se cargarán aquí vía JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Detalles del Pedido -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Detalles del Pedido #<span id="detailOrderId"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Cliente:</strong> <span id="detailCustomerName"></span><br>
                            <strong>Email:</strong> <span id="detailCustomerEmail"></span><br>
                            <strong>Teléfono:</strong> <span id="detailCustomerPhone"></span><br>
                        </div>
                        <div class="col-md-6">
                            <strong>Estado:</strong> <span id="detailOrderStatus" class="badge-status"></span><br>
                            <strong>Monto Total:</strong> $<span id="detailTotalAmount"></span><br>
                            <strong>Fecha Creación:</strong> <span id="detailCreatedAt"></span><br>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Dirección de Envío:</strong> <span id="detailShippingAddress"></span>
                    </div>
                    <div class="mb-3">
                        <strong>Notas del Pedido:</strong> <span id="detailOrderNotes"></span>
                    </div>

                    <h5>Ítems del Pedido:</h5>
                    <ul id="orderItemsList" class="list-group">
                        <!-- Los ítems del pedido se cargarán aquí -->
                    </ul>

                    <div class="mt-4">
                        <label for="updateOrderStatus" class="form-label">Cambiar Estado:</label>
                        <select class="form-select" id="updateOrderStatus">
                            <option value="pending">Pendiente</option>
                            <option value="processing">Procesando</option>
                            <option value="shipped">Enviado</option>
                            <option value="delivered">Entregado</option>
                            <option value="cancelled">Cancelado</option>
                        </select>
                        <button class="btn btn-primary mt-3" id="saveOrderStatusBtn"><i class="fas fa-save me-2"></i>Guardar Estado</button>
                    </div>
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
        let bsNotificationModal;
        let bsConfirmationModal;
        let confirmActionButton;
        let notificationModalBody;
        let confirmationModalBody;
        let currentOrderIdForStatusUpdate; // Variable para guardar el ID del pedido a actualizar

        document.addEventListener('DOMContentLoaded', function() {
            bsNotificationModal = new bootstrap.Modal(document.getElementById('notificationModal'), {
                backdrop: 'static',
                keyboard: false
            });
            notificationModalBody = document.getElementById('notificationModalBody');

            bsConfirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'), {
                backdrop: 'static',
                keyboard: false
            });
            confirmationModalBody = document.getElementById('confirmationModalBody');
            confirmActionButton = document.getElementById('confirmActionButton');

            cargarPedidos();

            document.getElementById('saveOrderStatusBtn').addEventListener('click', function() {
                const newStatus = document.getElementById('updateOrderStatus').value;
                if (currentOrderIdForStatusUpdate && newStatus) {
                    cambiarEstadoPedido(currentOrderIdForStatusUpdate, newStatus);
                }
            });
        });

        function mostrarNotificacion(message, isSuccess = true) {
            if (bsConfirmationModal && bsConfirmationModal._isShown) {
                bsConfirmationModal.hide();
            }
            notificationModalBody.innerHTML = message;
            const modalHeader = document.querySelector('#notificationModal .modal-header');
            if (isSuccess) {
                modalHeader.style.backgroundColor = '#28a745'; // Verde para éxito
            } else {
                modalHeader.style.backgroundColor = '#dc3545'; // Rojo para error
            }
            if (bsNotificationModal) {
                bsNotificationModal.show();
            } else {
                console.error("Error: El modal de notificación no está inicializado.");
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
                if (confirm(message)) {
                    onConfirmCallback();
                }
            }
        }

        async function cargarPedidos() {
            try {
                const response = await fetch('api/orders_read.php');
                const result = await response.json();
                const ordersTableBody = document.getElementById('ordersTableBody');
                ordersTableBody.innerHTML = '';

                if (result.success) {
                    result.data.forEach(order => {
                        const row = ordersTableBody.insertRow();
                        row.innerHTML = `
                            <td>${htmlspecialchars(order.id)}</td>
                            <td>${htmlspecialchars(order.customer_name)}</td>
                            <td>${htmlspecialchars(order.customer_email)}</td>
                            <td>${htmlspecialchars(order.customer_phone)}</td>
                            <td>$${htmlspecialchars(parseFloat(order.total_amount).toFixed(2))}</td>
                            <td><span class="badge-status ${htmlspecialchars(order.status)}">${htmlspecialchars(order.status)}</span></td>
                            <td>${new Date(order.created_at).toLocaleString()}</td>
                            <td>
                                <button class="btn btn-sm btn-info me-2" onclick="verDetallePedido(${order.id})"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning" onclick="abrirModalCambiarEstado(${order.id}, '${order.status}')"><i class="fas fa-edit"></i></button>
                            </td>
                        `;
                    });
                } else {
                    mostrarNotificacion('Error al cargar pedidos: ' + result.message, false);
                }
            } catch (error) {
                console.error('Error al cargar pedidos:', error);
                mostrarNotificacion('Error de conexión al cargar los pedidos. Revisa la consola para más detalles.', false);
            }
        }

        async function verDetallePedido(orderId) {
            try {
                const response = await fetch(`api/orders_read_single.php?id=${orderId}`);
                const result = await response.json();

                if (result.success) {
                    const order = result.order_data;
                    const items = result.order_items;

                    document.getElementById('detailOrderId').textContent = htmlspecialchars(order.id);
                    document.getElementById('detailCustomerName').textContent = htmlspecialchars(order.customer_name);
                    document.getElementById('detailCustomerEmail').textContent = htmlspecialchars(order.customer_email);
                    document.getElementById('detailCustomerPhone').textContent = htmlspecialchars(order.customer_phone);
                    document.getElementById('detailTotalAmount').textContent = parseFloat(order.total_amount).toFixed(2);
                    document.getElementById('detailOrderStatus').textContent = htmlspecialchars(order.status);
                    document.getElementById('detailOrderStatus').className = `badge-status ${htmlspecialchars(order.status)}`;
                    document.getElementById('detailCreatedAt').textContent = new Date(order.created_at).toLocaleString();
                    document.getElementById('detailShippingAddress').textContent = htmlspecialchars(order.shipping_address);
                    document.getElementById('detailOrderNotes').textContent = htmlspecialchars(order.order_notes || 'N/A');

                    const orderItemsList = document.getElementById('orderItemsList');
                    orderItemsList.innerHTML = '';
                    items.forEach(item => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item d-flex align-items-center';
                        li.innerHTML = `
                            <img src="${htmlspecialchars(item.imagen_url || 'https://placehold.co/50x50/e9e9e9/000000?text=No+Img')}"
                                 alt="${htmlspecialchars(item.product_name)}" class="order-item-image"
                                 onerror="this.onerror=null;this.src='https://placehold.co/50x50/e9e9e9/000000?text=No+Img';">
                            <div>
                                <strong>${htmlspecialchars(item.product_name)}</strong><br>
                                Cantidad: ${htmlspecialchars(item.quantity)} | Precio Unitario: $${htmlspecialchars(parseFloat(item.price_at_order).toFixed(2))}
                            </div>
                        `;
                        orderItemsList.appendChild(li);
                    });

                    // Establecer el estado actual en el select
                    document.getElementById('updateOrderStatus').value = order.status;
                    currentOrderIdForStatusUpdate = order.id; // Guarda el ID para el botón de guardar estado

                    new bootstrap.Modal(document.getElementById('orderDetailModal')).show();
                } else {
                    mostrarNotificacion('Error al cargar detalles del pedido: ' + result.message, false);
                }
            } catch (error) {
                console.error('Error al ver detalle del pedido:', error);
                mostrarNotificacion('Error de conexión al ver el detalle del pedido. Revisa la consola.', false);
            }
        }

        function abrirModalCambiarEstado(orderId, currentStatus) {
            currentOrderIdForStatusUpdate = orderId;
            document.getElementById('detailOrderId').textContent = htmlspecialchars(orderId); // Muestra el ID en el modal
            document.getElementById('updateOrderStatus').value = currentStatus;
            new bootstrap.Modal(document.getElementById('orderDetailModal')).show();
        }

        async function cambiarEstadoPedido(orderId, newStatus) {
            mostrarConfirmacion(`¿Estás seguro de cambiar el estado del pedido #${orderId} a "${newStatus}"?`, async () => {
                try {
                    const response = await fetch('api/orders_update_status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ order_id: orderId, status: newStatus })
                    });
                    const result = await response.json();

                    if (result.success) {
                        mostrarNotificacion(result.message, true);
                        bootstrap.Modal.getInstance(document.getElementById('orderDetailModal')).hide(); // Cierra el modal de detalle
                        cargarPedidos(); // Recargar la tabla
                    } else {
                        mostrarNotificacion('Error al cambiar el estado del pedido: ' + result.message, false);
                    }
                } catch (error) {
                    console.error('Error al cambiar el estado del pedido:', error);
                    mostrarNotificacion('Error de conexión al cambiar el estado del pedido. Revisa la consola para más detalles.', false);
                }
            });
        }


        function htmlspecialchars(str) {
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
