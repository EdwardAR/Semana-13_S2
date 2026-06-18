<?php include 'header.php'; ?>

<div class="hero">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Blog</h1>
                    <p class="mb-4">Consejos, guías y todo sobre el fascinante mundo de los licores, vinos y coctelería.</p>
                    <p><a href="shop.php" class="btn btn-secondary me-2">Visitar Tienda</a></p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-img-wrap">
                    <img src="images/products/2121e8c42250c5cb71030328e0f85915.jpg" class="img-fluid hero-img-page" alt="Blog de licores" onerror="this.onerror=null;this.src='https://placehold.co/400x300/3b5d50/ffffff?text=Blog';">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="blog-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title">Nuestros Artículos</h2>
                <p class="text-muted">Explora contenido exclusivo sobre el mundo de la coctelería y licores premium.</p>
            </div>
        </div>

        <div class="row g-4">
            <?php
            $posts = [
                ['img' => 'images/post-1.jpg', 'cat' => 'Vinos', 'titulo' => 'Descubre la Magia de los Vinos de Autor', 'fecha' => 'Abr 15, 2024', 'resumen' => 'Un viaje por los secretos de la viticultura y las bodegas más exclusivas del mundo.'],
                ['img' => 'images/post-2.jpg', 'cat' => 'Cervezas', 'titulo' => 'Guía Definitiva de Cervezas Artesanales', 'fecha' => 'Feb 01, 2024', 'resumen' => 'Explora los diferentes estilos y encuentra tu favorita entre las mejores microcervecerías.'],
                ['img' => 'images/post-3.jpg', 'cat' => 'Coctelería', 'titulo' => 'Cócteles Clásicos que Debes Probar en Casa', 'fecha' => 'Mar 10, 2024', 'resumen' => 'Aprende a preparar tus tragos favoritos con nuestras sencillas recetas y consejos de experto.'],
                ['img' => 'images/post-1.jpg', 'cat' => 'Whisky', 'titulo' => 'Cómo Degustar un Whisky como un Experto', 'fecha' => 'Ene 20, 2024', 'resumen' => 'Los pasos esenciales para apreciar cada nota y matiz de un buen whisky single malt.'],
                ['img' => 'images/post-2.jpg', 'cat' => 'Tequila', 'titulo' => 'Tequila vs Mezcal: Diferencias Clave', 'fecha' => 'Dic 05, 2023', 'resumen' => 'Conoce las características que hacen únicos a estos dos destilados mexicanos.'],
                ['img' => 'images/post-3.jpg', 'cat' => 'Maridajes', 'titulo' => 'Los Mejores Maridajes con Vino Tinto', 'fecha' => 'Nov 18, 2023', 'resumen' => 'Descubre qué platillos resaltan los sabores de un buen vino tinto reserva.'],
                ['img' => 'images/post-1.jpg', 'cat' => 'Ginebra', 'titulo' => 'Gin Tonics Creativos para el Verano', 'fecha' => 'Oct 02, 2023', 'resumen' => 'Recetas innovadoras con ginebras botánicas y acompañamientos frescos.'],
                ['img' => 'images/post-2.jpg', 'cat' => 'Ron', 'titulo' => 'Ron Añejo: Guía de Compra y Degustación', 'fecha' => 'Sep 14, 2023', 'resumen' => 'Todo lo que necesitas saber para elegir y disfrutar un buen ron añejo.'],
                ['img' => 'images/post-3.jpg', 'cat' => 'Eventos', 'titulo' => 'Cómo Organizar una Barra de Licores en Casa', 'fecha' => 'Ago 22, 2023', 'resumen' => 'Consejos prácticos para montar tu propio bar y sorprender a tus invitados.'],
            ];

            foreach ($posts as $p):
            ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 blog-card">
                        <div class="position-relative overflow-hidden" style="border-radius: 12px 12px 0 0; max-height: 200px;">
                            <span class="position-absolute top-0 start-0 badge bg-success m-3 text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;"><?= $p['cat'] ?></span>
                            <img src="<?= $p['img'] ?>" alt="<?= $p['titulo'] ?>" class="img-fluid w-100" style="object-fit: cover; height: 200px; transition: transform .3s;" onerror="this.onerror=null;this.src='https://placehold.co/400x200/3b5d50/ffffff?text=Blog';">
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <small class="text-muted mb-2"><i class="far fa-calendar-alt me-1"></i><?= $p['fecha'] ?></small>
                            <h5 class="fw-bold"><?= $p['titulo'] ?></h5>
                            <p class="text-muted small flex-grow-1"><?= $p['resumen'] ?></p>
                            <a href="blog.php" class="btn btn-sm btn-outline-success rounded-pill align-self-start mt-auto">Leer más <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <nav aria-label="Navegación del blog">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

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
                        <div class="item">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 mx-auto">
                                    <div class="testimonial-block text-center">
                                        <blockquote class="mb-5">
                                            <p>&ldquo;Excelente atención y la mejor selección de licores. Siempre encuentro lo que busco y los precios son inmejorables.&rdquo;</p>
                                        </blockquote>
                                        <div class="author-info">
                                            <div class="author-pic">
                                                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Carlos Mendoza" class="img-fluid">
                                            </div>
                                            <h3 class="font-weight-bold">Carlos Mendoza</h3>
                                            <span class="position d-block mb-3">Cliente frecuente</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 mx-auto">
                                    <div class="testimonial-block text-center">
                                        <blockquote class="mb-5">
                                            <p>&ldquo;La entrega fue súper rápida y el producto llegó en perfecto estado. Sin duda mi tienda de confianza.&rdquo;</p>
                                        </blockquote>
                                        <div class="author-info">
                                            <div class="author-pic">
                                                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="María Fernanda López" class="img-fluid">
                                            </div>
                                            <h3 class="font-weight-bold">María Fernanda López</h3>
                                            <span class="position d-block mb-3">Cliente verificada</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 mx-auto">
                                    <div class="testimonial-block text-center">
                                        <blockquote class="mb-5">
                                            <p>&ldquo;Gran variedad de whiskys importados y un asesoramiento muy profesional. Recomendado al 100%.&rdquo;</p>
                                        </blockquote>
                                        <div class="author-info">
                                            <div class="author-pic">
                                                <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Andrés Rivera" class="img-fluid">
                                            </div>
                                            <h3 class="font-weight-bold">Andrés Rivera</h3>
                                            <span class="position d-block mb-3">Socio Premium</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Testimonial Slider -->

<?php include 'footer.php'; ?>
