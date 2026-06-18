<?php
include 'header.php';

// Incluye tu archivo de conexión a la base de datos
// Asegúrate de que esta ruta sea correcta y que db_config.php sea accesible
include __DIR__ . '/admin/api/db_config.php';

// Lógica para obtener los items del slider desde la base de datos
try {
    // Asegúrate de que la columna 'imagen' existe en tu tabla 'slider_items'.
    // Si no, ejecuta el SQL para crear/actualizar la tabla.
    $stmt_slider = $pdo->prepare("SELECT titulo, subtitulo, imagen, texto_boton_1, url_boton_1, texto_boton_2, url_boton_2 FROM slider_items WHERE estado = 'activo' ORDER BY orden ASC, id DESC");
    $stmt_slider->execute();
    $slider_items = $stmt_slider->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los resultados
    $has_slides = count($slider_items) > 0; // Variable para verificar si hay slides
} catch (PDOException $e) {
    // Manejo de errores de la consulta
    error_log("Error al cargar slider_items en index.php: " . $e->getMessage(), 3, 'php_error.log');
    $has_slides = false; // No hay slides si hay un error
    $slider_items = []; // Asegurarse de que sea un array vacío
}

// Lógica para obtener productos destacados (popular)
$destacados = [];
try {
    // La consulta selecciona los productos activos y destacados, y los ordena por fecha de creación descendente
    $stmt_destacados = $pdo->prepare("SELECT id, nombre, descripcion_corta, precio, imagen_url FROM products WHERE estado = 'activo' AND destacado_en_inicio = 1 ORDER BY created_at DESC LIMIT 8"); // Limita a 8 productos
    $stmt_destacados->execute();
    $destacados = $stmt_destacados->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al cargar productos destacados en index.php: " . $e->getMessage(), 3, 'php_error.log');
    $destacados = [];
}

?>

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <!-- Contenido del Slider Dinámico -->
        <?php if ($has_slides): ?>
            <div class="intro-slider-wrap">
                <div class="intro-slider">
                    <?php foreach ($slider_items as $item): ?>
                        <div class="item">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-lg-5">
                                    <div class="intro-excerpt">
                                        <h1><?php echo htmlspecialchars($item['titulo']); ?></h1>
                                        <p class="mb-4"><?php echo htmlspecialchars($item['subtitulo']); ?></p>
                                        <p>
                                            <?php if (!empty($item['texto_boton_1']) && !empty($item['url_boton_1'])): ?>
                                                <a href="<?php echo htmlspecialchars($item['url_boton_1']); ?>" class="btn btn-secondary me-2"><?php echo htmlspecialchars($item['texto_boton_1']); ?></a>
                                            <?php endif; ?>
                                            <?php if (!empty($item['texto_boton_2']) && !empty($item['url_boton_2'])): ?>
                                                <a href="<?php echo htmlspecialchars($item['url_boton_2']); ?>" class="btn btn-white-outline"><?php echo htmlspecialchars($item['texto_boton_2']); ?></a>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="hero-img-wrap">
                                        <?php if (!empty($item['imagen'])): ?>
                                            <img src="<?php echo htmlspecialchars($item['imagen']); ?>" class="img-fluid hero-img-page" alt="<?php echo htmlspecialchars($item['titulo']); ?>" onerror="this.onerror=null;this.src='images/products/237480cb614f0870acffc0643fbcd36b.png';">
                                        <?php else: ?>
                                            <img src="images/products/237480cb614f0870acffc0643fbcd36b.png" class="img-fluid hero-img-page" alt="Imagen por defecto" onerror="this.onerror=null;this.src='https://placehold.co/400x300/3b5d50/ffffff?text=Licorería';">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <!-- Contenido Estático si no hay Slides -->
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Licorería Don Lucho</h1>
                        <p class="mb-4">Descubre la mejor selección de licores, vinos y cervezas artesanales. Envíos a domicilio.</p>
                        <p><a href="shop.php" class="btn btn-secondary me-2">Comprar Ahora</a><a href="#" class="btn btn-white-outline">Explorar</a></p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="hero-img-wrap">
                        <img src="images/products/237480cb614f0870acffc0643fbcd36b.png" class="img-fluid hero-img-page" alt="Botellas" onerror="this.onerror=null;this.src='https://placehold.co/400x300/3b5d50/ffffff?text=Licorería';">
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- End Hero Section -->

<!-- Start Why Choose Us Section - Mantenido para coherencia -->
<div class="why-choose-section">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">Por qué Elegirnos</h2>
                <p>Ofrecemos una selección curada de los mejores licores, vinos y cervezas artesanales, garantizando calidad y precios competitivos. Nuestra pasión por las bebidas nos impulsa a buscar la excelencia en cada botella que ofrecemos.</p>

                <div class="row my-5">
                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="images/truck.svg" alt="Image" class="imf-fluid">
                            </div>
                            <h3>Envío Rápido y Seguro</h3>
                            <p>Tu pedido llegará a tiempo y en perfectas condiciones, cuidando cada detalle del embalaje.</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="images/bag.svg" alt="Image" class="imf-fluid">
                            </div>
                            <h3>Fácil de Comprar</h3>
                            <p>Navega por nuestro catálogo intuitivo y haz tu pedido en pocos clics. ¡Comodidad garantizada!</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="images/support.svg" alt="Image" class="imf-fluid">
                            </div>
                            <h3>Soporte 24/7</h3>
                            <p>Estamos siempre disponibles para resolver tus dudas y ayudarte en todo lo que necesites.</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="images/return.svg" alt="Image" class="imf-fluid">
                            </div>
                            <h3>Devoluciones sin Problemas</h3>
                            <p>Si no estás satisfecho con tu compra, te ofrecemos una política de devolución sencilla y justa.</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-5">
                <div class="img-wrap">
                    <img src="images/products/237480cb614f0870acffc0643fbcd36b.png" alt="Imagen de botella de whisky" class="img-fluid" onerror="this.onerror=null;this.src='https://placehold.co/400x400/3b5d50/ffffff?text=Licores';">
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Why Choose Us Section -->

<!-- Start Product Section - Productos Populares -->
<div class="product-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 mb-5">
                <h2 class="section-title text-center">Nuestros Productos Populares</h2>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($destacados)): ?>
                <?php foreach ($destacados as $product): ?>
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                        <a class="product-item-custom" href="product-single.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                            <img src="<?php echo htmlspecialchars($product['imagen_url'] ?: 'https://placehold.co/300x300/e9e9e9/000000?text=No+Image'); ?>"
                                 class="img-fluid product-thumbnail-custom"
                                 alt="<?php echo htmlspecialchars($product['nombre']); ?>"
                                 onerror="this.onerror=null;this.src='https://placehold.co/300x300/e9e9e9/000000?text=No+Image';">
                            <h3 class="product-title-custom"><?php echo htmlspecialchars($product['nombre']); ?></h3>
                            <strong class="product-price-custom">$<?php echo htmlspecialchars(number_format($product['precio'], 2)); ?></strong>
                            <span class="icon-plus-custom"
                                  data-product-id="<?php echo htmlspecialchars($product['id']); ?>"
                                  data-product-name="<?php echo htmlspecialchars($product['nombre']); ?>"
                                  data-product-price="<?php echo htmlspecialchars($product['precio']); ?>">
                                <i class="fas fa-plus"></i>
                            </span>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>No hay productos destacados disponibles en este momento.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- End Product Section -->

<!-- Start We Help Section -->
<div class="we-help-section">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <div class="imgs-grid">
                    <div class="grid grid-1"><img src="images/products/4bdc743f510800f49050f73c695b22b3.jpg" alt="Imagen de vino" onerror="this.onerror=null;this.src='https://placehold.co/200x200/8b0000/ffffff?text=Vino';"></div>
                    <div class="grid grid-2"><img src="images/products/01cb3cc57142fa8b6815cc78673653c4.jpg" alt="Imagen de coctel" onerror="this.onerror=null;this.src='https://placehold.co/200x200/ff8c00/ffffff?text=Coctel';"></div>
                    <div class="grid grid-3"><img src="images/products/2121e8c42250c5cb71030328e0f85915.jpg" alt="Imagen de cerveza" onerror="this.onerror=null;this.src='https://placehold.co/200x200/daa520/ffffff?text=Cerveza';"></div>
                </div>
            </div>
            <div class="col-lg-5 ps-lg-5">
                <h2 class="section-title mb-4">La Experiencia Premium en Cada Botella</h2>
                <p>Nos dedicamos a ofrecerte no solo productos, sino una experiencia completa. Desde la cuidadosa selección de nuestros proveedores hasta la entrega en tu puerta, cada paso está diseñado para garantizar tu satisfacción.</p>
                <ul class="list-unstyled custom-list my-4">
                    <li>Descubre rarezas y ediciones limitadas.</li>
                    <li>Asesoramiento experto para tus elecciones.</li>
                    <li>Envío seguro y discreto.</li>
                    <li>Regalos perfectos para cualquier ocasión.</li>
                </ul>
                <p><a href="shop.php" class="btn">Explora Nuestro Catálogo</a></p>
            </div>
        </div>
    </div>
</div>
<!-- End We Help Section -->

<!-- Start Testimonial Slider -->
<div class="testimonial-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto text-center">
                <h2 class="section-title">Lo que dicen nuestros clientes</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="testimonial-slider-wrap">
                    <div id="testimonial-nav">
                        <span class="prev" data-controls="prev"><span class="icon-chevron-left"></span></span>
                        <span class="next" data-controls="next"><span class="icon-chevron-right"></span></span>
                    </div>

                    <div class="testimonial-slider">
                        <?php
                        // Intenta cargar testimonios desde la base de datos
                        try {
                            // Asegúrate de que la conexión PDO ($pdo) esté disponible. Si no, necesitarás incluir db_config.php aquí también
                            // o asegurarte de que header.php lo haga globalmente.
                            if (!isset($pdo)) {
                                require_once __DIR__ . '/admin/api/db_config.php';
                            }
                            $stmt_testimonios = $pdo->prepare("SELECT nombre_autor, cargo_autor, testimonio_texto, imagen_autor_url FROM testimonials WHERE estado = 'activo' ORDER BY created_at DESC");
                            $stmt_testimonios->execute();
                            $testimonios = $stmt_testimonios->fetchAll(PDO::FETCH_ASSOC);

                            if (!empty($testimonios)) {
                                foreach ($testimonios as $testimonio) {
                                    echo '<div class="item">';
                                    echo '    <div class="row justify-content-center">';
                                    echo '        <div class="col-lg-8 mx-auto">';
                                    echo '            <div class="testimonial-block text-center">';
                                    echo '                <blockquote class="mb-5">';
                                    echo '                    <p>&ldquo;' . htmlspecialchars($testimonio['testimonio_texto']) . '&rdquo;</p>';
                                    echo '                </blockquote>';
                                    echo '                <div class="author-info">';
                                    echo '                    <div class="author-pic">';
                                    echo '                        <img src="' . htmlspecialchars($testimonio['imagen_autor_url'] ?: 'images/person-1.png') . '" alt="' . htmlspecialchars($testimonio['nombre_autor']) . '" class="img-fluid">';
                                    echo '                    </div>';
                                    echo '                    <h3 class="font-weight-bold">' . htmlspecialchars($testimonio['nombre_autor']) . '</h3>';
                                    echo '                    <span class="position d-block mb-3">' . htmlspecialchars($testimonio['cargo_autor']) . '</span>';
                                    echo '                </div>';
                                    echo '            </div>';
                                    echo '        </div>';
                                    echo '    </div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="item">';
                                echo '    <div class="row justify-content-center">';
                                echo '        <div class="col-lg-8 mx-auto">';
                                echo '            <div class="testimonial-block text-center">';
                                echo '                <blockquote class="mb-5">';
                                echo '                    <p>&ldquo;Aún no hay testimonios disponibles. ¡Sé el primero en compartir tu experiencia!&rdquo;</p>';
                                echo '                </blockquote>';
                                echo '                <div class="author-info">';
                                echo '                    <div class="author-pic">';
                                echo '                        <img src="images/person-1.png" alt="Usuario Anónimo" class="img-fluid">';
                                echo '                    </div>';
                                echo '                    <h3 class="font-weight-bold">Don Lucho</h3>';
                                echo '                    <span class="position d-block mb-3">Administrador</span>';
                                echo '                </div>';
                                echo '            </div>';
                                echo '        </div>';
                                echo '    </div>';
                                echo '</div>';
                            }
                        } catch (PDOException $e) {
                            error_log("Error al cargar testimonios en index.php: " . $e->getMessage(), 3, 'php_error.log');
                            echo '<div class="item">';
                            echo '    <div class="row justify-content-center">';
                            echo '        <div class="col-lg-8 mx-auto">';
                            echo '            <div class="testimonial-block text-center">';
                            echo '                <blockquote class="mb-5">';
                            echo '                    <p>&ldquo;Pronto tendremos opiniones de nuestros clientes. Vuelve a consultar más tarde.&rdquo;</p>';
                            echo '                </blockquote>';
                            echo '                <div class="author-info">';
                            echo '                    <div class="author-pic">';
                            echo '                        <img src="images/person-1.png" alt="Informativo" class="img-fluid">';
                            echo '                    </div>';
                            echo '                    <h3 class="font-weight-bold">Don Lucho</h3>';
                            echo '                    <span class="position d-block mb-3">Equipo</span>';
                            echo '                </div>';
                            echo '            </div>';
                            echo '        </div>';
                            echo '    </div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Testimonial Slider -->

<!-- Start Blog Section -->
<div class="blog-section">
    <div class="container">
        <div class="row mb-5 align-items-end">
            <div class="col-md-8">
                <h2 class="section-title mb-2">Artículos Recientes del Blog</h2>
                <p class="text-muted">Consejos, guías y novedades sobre el mundo de los licores y coctelería.</p>
            </div>
            <div class="col-md-4 text-start text-md-end">
                <a href="blog.php" class="btn btn-outline-dark btn-sm rounded-pill px-4">Ver todos los artículos <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>

        <div class="row">
            <?php
            $default_posts = [
                ['titulo' => 'Descubre la Magia de los Vinos de Autor', 'imagen' => 'images/post-1.jpg', 'fecha' => 'Abr 15, 2024', 'resumen' => 'Un viaje por los secretos de la viticultura y las bodegas más exclusivas del mundo.'],
                ['titulo' => 'Guía Definitiva de Cervezas Artesanales', 'imagen' => 'images/post-2.jpg', 'fecha' => 'Feb 01, 2024', 'resumen' => 'Explora los diferentes estilos y encuentra tu favorita entre las mejores microcervecerías.'],
                ['titulo' => 'Cócteles Clásicos que Debes Probar en Casa', 'imagen' => 'images/post-3.jpg', 'fecha' => 'Mar 10, 2024', 'resumen' => 'Aprende a preparar tus tragos favoritos con nuestras sencillas recetas y consejos de experto.'],
            ];

            try {
                if (!isset($pdo)) {
                    require_once __DIR__ . '/admin/api/db_config.php';
                }
                $stmt_blog = $pdo->prepare("SELECT id, titulo, fecha_publicacion, imagen_url, resumen FROM blog_posts WHERE estado = 'activo' ORDER BY fecha_publicacion DESC LIMIT 3");
                $stmt_blog->execute();
                $blog_posts = $stmt_blog->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Error al cargar posts de blog en index.php: " . $e->getMessage(), 3, 'php_error.log');
                $blog_posts = [];
            }

            $posts = !empty($blog_posts) ? $blog_posts : $default_posts;

            foreach ($posts as $post):
                $id = $post['id'] ?? '';
                $titulo = htmlspecialchars($post['titulo']);
                $imagen = htmlspecialchars($post['imagen_url'] ?? $post['imagen'] ?? 'images/post-1.jpg');
                $fecha = isset($post['fecha_publicacion']) ? date('M d, Y', strtotime($post['fecha_publicacion'])) : ($post['fecha'] ?? '');
                $resumen = htmlspecialchars($post['resumen']);
                $link = $id ? "blog.php?id=$id" : 'blog.php';
            ?>
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 blog-card">
                        <a href="<?= $link ?>" class="d-block overflow-hidden" style="border-radius: 12px 12px 0 0; max-height: 220px;">
                            <img src="<?= $imagen ?>" alt="<?= $titulo ?>" class="img-fluid w-100" style="object-fit: cover; height: 220px; transition: transform .3s;" onerror="this.onerror=null;this.src='https://placehold.co/400x220/3b5d50/ffffff?text=Blog';">
                        </a>
                        <div class="card-body p-4">
                            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i><?= $fecha ?></small>
                            <h5 class="mt-2"><a href="<?= $link ?>" class="text-decoration-none text-dark"><?= $titulo ?></a></h5>
                            <p class="text-muted small mb-3"><?= $resumen ?></p>
                            <a href="<?= $link ?>" class="btn btn-sm btn-outline-success rounded-pill">Leer más <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- End Blog Section -->
<?php include 'footer.php'; ?>

<!-- Botón flotante de WhatsApp -->
<a href="https://wa.me/XXXXXXXXXXX" class="whatsapp-float" target="_blank"> <!-- Reemplaza XXXXXXXXXXX con tu número de WhatsApp -->
    <i class="fab fa-whatsapp"></i>
</a>

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

        document.querySelectorAll('.icon-plus-custom').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
                const productId = this.dataset.productId;
                const productName = this.dataset.productName;
                const productPrice = this.dataset.productPrice;

                // Llamar a la función del carrito desde custom.js
                // Asegúrate de que window.cartManager esté definido en custom.js
                if (window.cartManager && typeof window.cartManager.addToCart === 'function') {
                    window.cartManager.addToCart({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        quantity: 1 // Por defecto, añadir 1 unidad
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
