<?php
// shop.php
// Incluye el encabezado del sitio, que ya gestiona la conexión a la base de datos
// y carga dinámicamente la barra de navegación.
include_once 'header.php';

// Asegúrate de que $pdo esté disponible desde db_config.php incluido en header.php
if (!isset($pdo)) {
    echo '<div class="alert alert-danger" role="alert">Error: La conexión a la base de datos no está disponible.</div>';
    exit();
}

// Lógica para obtener todos los productos activos desde la base de datos
$productos = [];
try {
    // La consulta selecciona los productos activos y los ordena por fecha de creación descendente
    $stmt_products = $pdo->prepare("SELECT id, nombre, descripcion_corta, precio, imagen_url FROM products WHERE estado = 'activo' ORDER BY created_at DESC");
    $stmt_products->execute();
    $productos = $stmt_products->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Manejo de errores de la consulta
    error_log("Error al cargar productos en shop.php: " . $e->getMessage(), 3, 'php_error.log');
    echo '<div class="alert alert-danger" role="alert">Hubo un error al cargar los productos. Por favor, inténtalo de nuevo más tarde.</div>';
    $productos = []; // Asegurarse de que sea un array vacío para no romper el bucle
}
?>

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Tienda</h1>
                    <p class="mb-4">Explora nuestra exquisita selección de bebidas. Desde vinos finos hasta licores premium, encuentra tu botella perfecta.</p>
                    <p><a href="shop.php" class="btn btn-secondary me-2">Ver Productos</a><a href="#featured-products" class="btn btn-white-outline">Destacados</a></p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-img-wrap">
                    <img src="images/products/ed5763b1d1cd7e3373a3b5c43c4cdb00.jpg" class="img-fluid hero-img-page" alt="Botellas de licor" onerror="this.onerror=null;this.src='images/products/237480cb614f0870acffc0643fbcd36b.png';"> <!-- Imagen genérica para la tienda -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section product-section pt-0">
    <div class="container">
        <div class="row">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $product): ?>
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                        <a class="product-item" href="product-single.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                            <?php
                            // Asegúrate de que la ruta de la imagen sea correcta
                            $product_image = !empty($product['imagen_url']) ? htmlspecialchars($product['imagen_url']) : 'https://placehold.co/300x300/e9e9e9/000000?text=No+Image'; // Fallback
                            ?>
                            <img src="<?php echo $product_image; ?>" class="img-fluid product-thumbnail" alt="<?php echo htmlspecialchars($product['nombre']); ?>" onerror="this.onerror=null;this.src='https://placehold.co/300x300/e9e9e9/000000?text=No+Image';">
                            <h3 class="product-title"><?php echo htmlspecialchars($product['nombre']); ?></h3>
                            <strong class="product-price">$<?php echo htmlspecialchars(number_format($product['precio'], 2)); ?></strong>
                            <span class="icon-cross"
                                  data-product-id="<?php echo htmlspecialchars($product['id']); ?>"
                                  data-product-name="<?php echo htmlspecialchars($product['nombre']); ?>"
                                  data-product-price="<?php echo htmlspecialchars($product['precio']); ?>"
                                  data-product-image="<?php echo htmlspecialchars($product_image); ?>">
                                <img src="images/cross.svg" class="img-fluid" alt="Añadir al carrito">
                            </span>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>No hay productos disponibles en este momento.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Incluye el pie de página del sitio
include_once 'footer.php';
?>

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

        document.querySelectorAll('.icon-cross').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
                const productId = this.dataset.productId;
                const productName = this.dataset.productName;
                const productPrice = this.dataset.productPrice;

                if (window.cartManager && typeof window.cartManager.addToCart === 'function') {
                    window.cartManager.addToCart({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        quantity: 1,
                        image: this.dataset.productImage || 'https://placehold.co/70x70/e9e9e9/000000?text=No+Img'
                    });

                    // Mostrar notificación visual
                    notificationModalBody.innerHTML = `"${productName}" ha sido añadido al carrito.`;
                    notificationModal.show();
                } else {
                    console.error("cartManager o addToCart no están definidos. Asegúrate de que custom.js se cargue correctamente.");
                    notificationModalBody.innerHTML = `Error: No se pudo añadir "${productName}" al carrito.`;
                    notificationModal.show();
                }
            });
        });
    });
</script>
