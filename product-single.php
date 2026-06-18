<?php
// product-single.php
// Incluye el encabezado del sitio
include_once 'header.php';

// Asegúrate de que $pdo esté disponible desde db_config.php incluido en header.php
if (!isset($pdo)) {
    echo '<div class="alert alert-danger" role="alert">Error: La conexión a la base de datos no está disponible.</div>';
    exit();
}

$product = null;
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id > 0) {
    try {
        // Prepara la consulta para obtener los detalles del producto por su ID
        // Se une con la tabla de categorías para obtener el nombre de la categoría
        $stmt_product = $pdo->prepare("SELECT p.id, p.nombre, p.descripcion_corta, p.descripcion_larga, p.precio, p.imagen_url, p.stock, c.nombre AS nombre_categoria FROM products p LEFT JOIN categories c ON p.categoria_id = c.id WHERE p.id = ? AND p.estado = 'activo'");
        $stmt_product->execute([$product_id]);
        $product = $stmt_product->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al cargar producto individual en product-single.php: " . $e->getMessage(), 3, 'php_error.log');
        echo '<div class="alert alert-danger" role="alert">Hubo un error al cargar los detalles del producto. Por favor, inténtalo de nuevo más tarde.</div>';
    }
}

if (!$product) {
    // Si no se encuentra el producto o no se proporcionó un ID válido
    echo '<!-- Start Hero Section - Producto No Encontrado -->';
    echo '<div class="hero">';
    echo '    <div class="container">';
    echo '        <div class="row justify-content-between">';
    echo '            <div class="col-lg-5">';
    echo '                <div class="intro-excerpt">';
    echo '                    <h1>Producto No Encontrado</h1>';
    echo '                    <p class="mb-4">Lo sentimos, el producto que estás buscando no está disponible o no existe.</p>';
    echo '                    <p><a href="shop.php" class="btn btn-secondary me-2">Volver a la Tienda</a></p>';
    echo '                </div>';
    echo '            </div>';
    echo '            <div class="col-lg-7">';
    echo '                <div class="hero-img-wrap">';
    echo '                    <img src="images/products/237480cb614f0870acffc0643fbcd36b.png" class="img-fluid" alt="Producto no encontrado" onerror="this.onerror=null;this.src=\'https://placehold.co/400x300/3b5d50/ffffff?text=Producto\';">';
    echo '                </div>';
    echo '            </div>';
    echo '        </div>';
    echo '    </div>';
    echo '</div>';
    echo '<!-- End Hero Section - Producto No Encontrado -->';
} else {
    // Si se encontró el producto, muestra sus detalles
    ?>
    <!-- Start Product Detail Section -->
    <div class="product-single-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-image-large">
                        <img src="<?php echo htmlspecialchars($product['imagen_url']); ?>" alt="<?php echo htmlspecialchars($product['nombre']); ?>" class="img-fluid rounded-lg shadow-sm" onerror="this.onerror=null;this.src='https://placehold.co/600x400/e9e9e9/000000?text=Imagen+No+Disponible';">
                    </div>
                </div>
                <div class="col-md-6">
                    <h1 class="product-title-single"><?php echo htmlspecialchars($product['nombre']); ?></h1>
                    <p class="product-category-single text-muted">Categoría: <?php echo htmlspecialchars($product['nombre_categoria'] ?: 'Sin Categoría'); ?></p>
                    <p class="product-price-single">$<?php echo htmlspecialchars(number_format($product['precio'], 2)); ?></p>
                    <p class="product-short-description-single"><?php echo htmlspecialchars($product['descripcion_corta']); ?></p>

                    <div class="product-stock-info mt-3">
                        <?php if ($product['stock'] > 0) { ?>
                            <span class="badge bg-success">En Stock: <?php echo htmlspecialchars($product['stock']); ?> unidades</span>
                        <?php } else { ?>
                            <span class="badge bg-danger">Agotado</span>
                        <?php } ?>
                    </div>

                    <div class="product-actions mt-4">
                        <?php if ($product['stock'] > 0) { ?>
                            <button class="btn btn-primary add-to-cart-btn me-3"
                                    data-product-id="<?php echo htmlspecialchars($product['id']); ?>"
                                    data-product-name="<?php echo htmlspecialchars($product['nombre']); ?>"
                                    data-product-price="<?php echo htmlspecialchars($product['precio']); ?>">
                                <i class="fas fa-shopping-cart me-2"></i> Añadir al Carrito
                            </button>
                             <button class="btn btn-success order-whatsapp-btn"
                                    data-product-id="<?php echo htmlspecialchars($product['id']); ?>"
                                    data-product-name="<?php echo htmlspecialchars($product['nombre']); ?>"
                                    data-product-price="<?php echo htmlspecialchars($product['precio']); ?>">
                                <i class="fab fa-whatsapp me-2"></i> Pedir por WhatsApp
                            </button>
                        <?php } else { ?>
                            <button class="btn btn-secondary me-3" disabled>Producto Agotado</button>
                        <?php } ?>
                        <a href="shop.php" class="btn btn-outline-secondary back-to-shop-btn mt-3 mt-md-0">Volver a la Tienda</a>
                    </div>
                </div>
            </div>

            <!-- Separador visual -->
            <hr class="my-5 product-section-divider">

            <!-- Sección de Descripción Completa -->
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title-custom">Descripción Completa</h2>
                    <div class="product-long-description-text">
                        <p><?php echo nl2br(htmlspecialchars($product['descripcion_larga'])); ?></p>
                    </div>
                </div>
            </div>

            <!-- Placeholder para productos relacionados o reseñas (futuras implementaciones) -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <h2 class="section-title-custom">También te podría interesar</h2>
                    <p>Aquí se mostrarán productos relacionados.</p>
                    <!-- Lógica para cargar productos relacionados -->
                </div>
            </div>

        </div>
    </div>
    <!-- End Product Detail Section -->

    <!-- Modal de Notificación Personalizado (para mensajes de añadir al carrito) -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="notificationModalLabel">Notificación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="notificationModalBody">
                    <!-- Mensaje de notificación aquí -->
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'));
            const notificationModalBody = document.getElementById('notificationModalBody');

            // Funcionalidad para el botón "Añadir al Carrito"
            const addToCartBtn = document.querySelector('.add-to-cart-btn');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    const productName = this.dataset.productName;
                    const productPrice = this.dataset.productPrice;

                    window.addToCart({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        quantity: 1
                    });

                    notificationModalBody.innerHTML = `"${productName}" ha sido añadido al carrito.`;
                    notificationModal.show();
                });
            }

            // Funcionalidad para el botón "Pedir por WhatsApp"
            const orderWhatsappBtn = document.querySelector('.order-whatsapp-btn');
            if (orderWhatsappBtn) {
                orderWhatsappBtn.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    const productName = this.dataset.productName;
                    const productPrice = this.dataset.productPrice;

                    const message = `Hola, me gustaría pedir el producto:
                    - ${productName} (ID: ${productId})
                    - Precio: $${parseFloat(productPrice).toFixed(2)}
                    Por favor, confírmame la disponibilidad y cómo proceder.`;

                    // Asume un número de WhatsApp del vendedor
                    const whatsappNumber = '51987654321'; // ¡Cambia esto por el número real del vendedor!
                    const whatsappLink = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

                    window.open(whatsappLink, '_blank');
                });
            }
        });
    </script>
    <?php
} // Fin del if ($product)
// Incluye el pie de página del sitio
include_once 'footer.php';
?>
