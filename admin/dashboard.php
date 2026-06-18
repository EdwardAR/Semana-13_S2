<?php
// session_start();
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header('Location: login.php');
//     exit;
// }
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Dashboard - Don Lucho</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f5f7;
            font-family: 'Segoe UI', sans-serif;
        }
        .admin-navbar {
            background-color: #2c2f33;
        }
        .admin-navbar .navbar-brand {
            color: #fff;
            font-weight: 600;
        }
        .admin-navbar .navbar-brand span {
            color: #f0ad4e;
        }
        .admin-navbar .nav-link {
            color: rgba(255,255,255,0.8) !important;
        }
        .admin-navbar .nav-link:hover,
        .admin-navbar .nav-item.active .nav-link {
            color: #fff !important;
            font-weight: bold;
        }

        .dashboard-heading {
            margin-top: 2rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .dashboard-section {
            margin-bottom: 3rem;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            padding: 1.5rem;
            text-align: center;
            height: 100%;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .dashboard-card .icon {
            font-size: 2.5rem;
            color: #f0ad4e;
            margin-bottom: 1rem;
        }
        .dashboard-card h3 {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .dashboard-card p {
            color: #777;
            font-size: 0.95rem;
        }
        a.dashboard-link {
            text-decoration: none;
            color: inherit;
        }

        @media (max-width: 767px) {
            .dashboard-heading {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-md navbar-dark admin-navbar">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Don Lucho Admin<span>.</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item active"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="gestion_navbar.php">Navbar</a></li>
                <li class="nav-item"><a class="nav-link" href="gestion_slider.php">Slider</a></li>
                <li class="nav-item"><a class="nav-link" href="gestion_logos.php">Logos</a></li>
                <li class="nav-item"><a class="nav-link" href="gestion_productos.php">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="gestion_pedidos.php">Pedidos</a></li>
                <li class="nav-item"><a class="nav-link" href="../index.php" target="_blank">Ver Sitio</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTENIDO -->
<div class="container">
    <h1 class="dashboard-heading">Bienvenido al Panel de Administración</h1>

    <div class="row g-4 dashboard-section">
        <div class="col-md-6 col-lg-4">
            <a href="gestion_productos.php" class="dashboard-link">
                <div class="dashboard-card">
                    <div class="icon"><i class="fas fa-box-open"></i></div>
                    <h3>Productos</h3>
                    <p>Gestiona el catálogo de productos.</p>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="gestion_categorias.php" class="dashboard-link">
                <div class="dashboard-card">
                    <div class="icon"><i class="fas fa-tags"></i></div>
                    <h3>Categorías</h3>
                    <p>Administra las categorías de productos.</p>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="gestion_navbar.php" class="dashboard-link">
                <div class="dashboard-card">
                    <div class="icon"><i class="fas fa-bars"></i></div>
                    <h3>Navbar</h3>
                    <p>Configura los enlaces de navegación.</p>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="gestion_slider.php" class="dashboard-link">
                <div class="dashboard-card">
                    <div class="icon"><i class="fas fa-images"></i></div>
                    <h3>Slider Principal</h3>
                    <p>Controla imágenes del inicio.</p>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="gestion_logos.php" class="dashboard-link">
                <div class="dashboard-card">
                    <div class="icon"><i class="fas fa-building"></i></div>
                    <h3>Logos</h3>
                    <p>Actualiza la identidad visual del sitio.</p>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="gestion_pedidos.php" class="dashboard-link">
                <div class="dashboard-card">
                    <div class="icon"><i class="fas fa-truck"></i></div>
                    <h3>Pedidos</h3>
                    <p>Administra los pedidos de clientes.</p>
                </div>
            </a>
        </div>
    </div>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
