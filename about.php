<?php
// about.php
// Incluye el encabezado del sitio, que ya gestiona la conexión a la base de datos
// y carga dinámicamente la barra de navegación.
include_once 'header.php';
?>

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Nosotros</h1>
                    <p class="mb-4">Somos una licorería apasionada por ofrecerte las mejores bebidas nacionales e importadas. Calidad, variedad y el mejor precio garantizado.</p>
                    <p><a href="shop.php" class="btn btn-secondary me-2">Comprar Ahora</a><a href="contact.php" class="btn btn-white-outline">Contáctanos</a></p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-img-wrap">
                    <img src="images/products/4bdc743f510800f49050f73c695b22b3.jpg" class="img-fluid hero-img-page" alt="Selección de vinos" onerror="this.onerror=null;this.src='https://placehold.co/400x300/3b5d50/ffffff?text=Licorería';">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<!-- Start Why Choose Us Section -->
<div class="why-choose-section">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">Por qué Elegirnos</h2>
                <p>En Licorería Don Lucho nos comprometemos a brindarte la mejor experiencia de compra con productos auténticos, atención personalizada y precios justos.</p>

                <div class="row my-5">
                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="images/truck.svg" alt="Icono de camión" class="imf-fluid">
                            </div>
                            <h3>Envío Rápido y Gratis</h3>
                            <p>Recibe tus pedidos en la puerta de tu casa sin costo adicional. Entregas en 24-48 horas en Lima y Callao.</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="images/bag.svg" alt="Icono de bolsa" class="imf-fluid">
                            </div>
                            <h3>Fácil de Comprar</h3>
                            <p>Selecciona tus productos favoritos, agrégalos al carrito y pide por WhatsApp o web. Así de sencillo.</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="images/support.svg" alt="Icono de soporte" class="imf-fluid">
                            </div>
                            <h3>Soporte 24/7</h3>
                            <p>Nuestro equipo está disponible para resolver tus dudas y recomendarte la mejor bebida para cada ocasión.</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="images/return.svg" alt="Icono de devolución" class="imf-fluid">
                            </div>
                            <h3>Devoluciones Sin Problemas</h3>
                            <p>Si algo no está conforme, puedes cambiar o devolver tu producto dentro de los primeros 7 días.</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-5">
                <div class="img-wrap">
                    <img src="images/products/4bdc743f510800f49050f73c695b22b3.jpg" alt="Por qué elegirnos" class="img-fluid" onerror="this.onerror=null;this.src='https://placehold.co/400x400/3b5d50/ffffff?text=Licores';">
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Why Choose Us Section -->

<!-- Start Team Section -->
<div class="untree_co-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-5 mx-auto text-center">
                <h2 class="section-title">Nuestro Equipo</h2>
                <p class="text-muted">Profesionales apasionados por brindarte la mejor experiencia en licores.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
                <img src="images/person_1.jpg" class="img-fluid mb-5" alt="Miembro del equipo">
                <h3><a href="#"><span>Luis</span> Mendoza</a></h3>
                <span class="d-block position mb-4">CEO & Fundador</span>
                <p>Más de 15 años en la industria de licores, seleccionando personalmente cada producto para garantizar calidad superior.</p>
            </div>

            <div class="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
                <img src="images/person_2.jpg" class="img-fluid mb-5" alt="Miembro del equipo">
                <h3><a href="#"><span>Carmen</span> Gutiérrez</a></h3>
                <span class="d-block position mb-4">Sommelier & Catadora</span>
                <p>Experta en vinos y destilados, encargada de curar nuestra selección y asesorar a nuestros clientes.</p>
            </div>

            <div class="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
                <img src="images/person_3.jpg" class="img-fluid mb-5" alt="Miembro del equipo">
                <h3><a href="#"><span>Diego</span> Torres</a></h3>
                <span class="d-block position mb-4">Jefe de Logística</span>
                <p>Garantiza que cada pedido llegue en perfecto estado y en el menor tiempo posible a tu domicilio.</p>
            </div>

            <div class="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
                <img src="images/person_4.jpg" class="img-fluid mb-5" alt="Miembro del equipo">
                <h3><a href="#"><span>Andrea</span> Paredes</a></h3>
                <span class="d-block position mb-4">Atención al Cliente</span>
                <p>Siempre lista para resolver tus consultas y ayudarte a encontrar la bebida perfecta para cada ocasión.</p>
            </div>
        </div>
    </div>
</div>
<!-- End Team Section -->

<!-- Start Testimonial Slider -->
<div class="testimonial-section before-footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto text-center">
                <h2 class="section-title">Testimonios</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="testimonial-slider-wrap text-center">
                    <div id="testimonial-nav">
                        <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                        <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                    </div>

                    <div class="testimonial-slider">
                        <?php
                        try {
                            $stmt_testimonials = $pdo->prepare("SELECT testimonio_texto, nombre_autor, cargo_autor, imagen_autor_url FROM testimonials WHERE estado = 'activo' ORDER BY created_at DESC");
                            $stmt_testimonials->execute();
                            if ($stmt_testimonials->rowCount() > 0) {
                                while ($testimonial = $stmt_testimonials->fetch(PDO::FETCH_ASSOC)) {
                                    $author_img = !empty($testimonial['imagen_autor_url']) ? htmlspecialchars($testimonial['imagen_autor_url']) : 'images/person-1.png';
                                    echo '<div class="item">';
                                    echo '    <div class="row justify-content-center">';
                                    echo '        <div class="col-lg-8 mx-auto">';
                                    echo '            <div class="testimonial-block text-center">';
                                    echo '                <blockquote class="mb-5">';
                                    echo '                    <p>&ldquo;' . htmlspecialchars($testimonial['testimonio_texto']) . '&rdquo;</p>';
                                    echo '                </blockquote>';
                                    echo '                <div class="author-info">';
                                    echo '                    <div class="author-pic">';
                                    echo '                        <img src="' . $author_img . '" alt="' . htmlspecialchars($testimonial['nombre_autor']) . '" class="img-fluid">';
                                    echo '                    </div>';
                                    echo '                    <h3 class="font-weight-bold">' . htmlspecialchars($testimonial['nombre_autor']) . '</h3>';
                                    echo '                    <span class="position d-block mb-3">' . htmlspecialchars($testimonial['cargo_autor']) . '</span>';
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
                                echo '                    <p>&ldquo;Excelente atención y la mejor selección de licores. Siempre encuentro lo que busco a buen precio.&rdquo;</p>';
                                echo '                </blockquote>';
                                echo '                <div class="author-info">';
                                echo '                    <div class="author-pic">';
                                echo '                        <img src="images/person-1.png" alt="Cliente" class="img-fluid">';
                                echo '                    </div>';
                                echo '                    <h3 class="font-weight-bold">Carlos Mendoza</h3>';
                                echo '                    <span class="position d-block mb-3">Cliente frecuente</span>';
                                echo '                </div>';
                                echo '            </div>';
                                echo '        </div>';
                                echo '    </div>';
                                echo '</div>';
                            }
                        } catch (PDOException $e) {
                            error_log("Error al cargar testimonios: " . $e->getMessage(), 3, 'php_error.log');
                            echo '<div class="item">';
                            echo '    <div class="row justify-content-center">';
                            echo '        <div class="col-lg-8 mx-auto">';
                            echo '            <div class="testimonial-block text-center">';
                            echo '                <blockquote class="mb-5">';
                            echo '                    <p>&ldquo;La calidad y variedad de productos es excelente. Muy recomendados.&rdquo;</p>';
                            echo '                </blockquote>';
                            echo '                <div class="author-info">';
                            echo '                    <div class="author-pic">';
                            echo '                        <img src="images/person-1.png" alt="Cliente" class="img-fluid">';
                            echo '                    </div>';
                            echo '                    <h3 class="font-weight-bold">María Fernanda López</h3>';
                            echo '                    <span class="position d-block mb-3">Cliente verificada</span>';
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

<?php
// Incluye el pie de página del sitio
include_once 'footer.php';
?>
