<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="Licorería Don Lucho - Los mejores licores, vinos y cervezas artesanales al mejor precio. Envíos a domicilio." />
  <meta name="keywords" content="licores, vinos, cervezas, whisky, ron, ginebra, licorería, bebidas alcohólicas, Don Lucho" />

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link href="css/tiny-slider.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">


        <title>Licoreria - Don Lucho</title>
    </head>

    <body>

        <?php
        // Incluye el archivo de configuración de la base de datos
        require_once __DIR__ . '/admin/api/db_config.php';

        $logo_principal_url = 'images/default-logo.png'; // Fallback por si la DB no tiene logo
        $logo_alt_text = 'Logo de Licorería Don Lucho';

        try {
            // Consulta para obtener el logo principal activo
            // Asume que 'logos' tiene 'nombre_referencia', 'ruta_imagen', 'estado'
            $stmt_logo = $pdo->prepare("SELECT ruta_imagen FROM logos WHERE nombre_referencia = 'logo_principal' AND estado = 'activo' LIMIT 1");
            $stmt_logo->execute();
            $logo_data = $stmt_logo->fetch(PDO::FETCH_ASSOC);

            if ($logo_data && !empty($logo_data['ruta_imagen'])) {
                $logo_principal_url = htmlspecialchars($logo_data['ruta_imagen']);
            }
        } catch (PDOException $e) {
            error_log("Error al cargar logo principal en header.php: " . $e->getMessage(), 3, 'php_error.log');
            // Continúa con el logo por defecto si hay un error
        }

        // Función auxiliar para escapar HTML (si no está definida globalmente)
        if (!function_exists('htmlspecialchars_custom')) {
            function htmlspecialchars_custom($string) {
                return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
            }
        }
        ?>

        <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Barra de navegación">

            <div class="container">
                <a class="navbar-brand" href="index.php">Don Lucho<span>.</span></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsFurni">
                    <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                        <?php
                        // Lógica para obtener los items del navbar desde la base de datos
                        // Asegúrate de que esta ruta sea correcta y que db_config.php sea accesible
                        try {
                            $stmt_navbar = $pdo->prepare("SELECT texto_visible, url_enlace FROM navbar_items WHERE estado = 'activo' ORDER BY orden ASC, id DESC");
                            $stmt_navbar->execute();
                            $navbar_items = $stmt_navbar->fetchAll(PDO::FETCH_ASSOC);
                            $current_page = basename($_SERVER['PHP_SELF']);

                            if (!empty($navbar_items)) {
                                foreach ($navbar_items as $item) {
                                    $item_url = $item['url_enlace'];
                                    // Normalizar URL: quitar dominio/ruta antigua si existe
                                    $item_url = preg_replace('#^https?://[^/]+/catalogo/#i', '', $item_url);
                                    $item_url = preg_replace('#^/catalogo/#i', '', $item_url);
                                    // Corregir .html → .php
                                    $item_url = preg_replace('/\.html$/i', '.php', $item_url);
                                    $item_url_basename = basename($item_url);
                                    $is_active = ($current_page == $item_url_basename) ? 'active' : '';

                                    echo '<li class="nav-item ' . $is_active . '"><a class="nav-link" href="' . htmlspecialchars_custom($item_url) . '">' . htmlspecialchars_custom($item['texto_visible']) . '</a></li>';
                                }
                            } else {
                                // Mostrar un navbar estático si no hay items en la base de datos o hubo un error
                                echo '<li class="nav-item active"><a class="nav-link" href="index.php">Inicio</a></li>';
                                echo '<li><a class="nav-link" href="shop.php">Tienda</a></li>';
                                echo '<li><a class="nav-link" href="about.php">Acerca de nosotros</a></li>';
                                echo '<li><a class="nav-link" href="services.php">Servicios</a></li>';
                                echo '<li><a class="nav-link" href="blog.php">Blog</a></li>';
                                echo '<li><a class="nav-link" href="contact.php">Contacto</a></li>';
                            }
                        } catch (PDOException $e) {
                             error_log("Error al cargar navbar_items en header.php: " . $e->getMessage(), 3, 'php_error.log');
                            // Mostrar un navbar estático si hay un error en la base de datos
                            echo '<li class="nav-item active"><a class="nav-link" href="index.php">Inicio</a></li>';
                            echo '<li><a class="nav-link" href="shop.php">Tienda</a></li>';
                            echo '<li><a class="nav-link" href="about.php">Acerca de nosotros</a></li>';
                            echo '<li><a class="nav-link" href="services.php">Servicios</a></li>';
                            echo '<li><a class="nav-link" href="blog.php">Blog</a></li>';
                            echo '<li><a class="nav-link" href="contact.php">Contacto</a></li>';
                        }
                        ?>
                    </ul>

                    <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                        <li><a class="nav-link" href="admin/dashboard.php"><i class="fas fa-user fa-lg"></i></a></li>
                        <li class="position-relative">
                            <a class="nav-link" href="cart.php">
                                <img src="images/cart.svg">
                                <span class="cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
                                    0
                                    <span class="visually-hidden">items in cart</span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>
