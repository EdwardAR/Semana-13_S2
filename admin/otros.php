<?php
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Otros - Licorería Don Lucho</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Inter', sans-serif; }
        .sidebar { background: #2c3e50; min-height: 100vh; padding-top: 20px; }
        .sidebar a { color: #bdc3c7; padding: 12px 20px; display: block; text-decoration: none; }
        .sidebar a:hover, .sidebar a.active { color: #fff; background: #34495e; }
        .sidebar a i { margin-right: 10px; }
        .content { padding: 30px; }
        .card { border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .card-header { background: #fff; border-bottom: 1px solid #eee; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <h5 class="text-white text-center mb-4"><i class="fas fa-crown"></i> Admin</h5>
                <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="gestion_navbar.php"><i class="fas fa-bars"></i> Navbar</a>
                <a href="gestion_slider.php"><i class="fas fa-images"></i> Slider</a>
                <a href="gestion_logos.php"><i class="fas fa-building"></i> Logos</a>
                <a href="gestion_productos.php"><i class="fas fa-box-open"></i> Productos</a>
                <a href="gestion_categorias.php"><i class="fas fa-tags"></i> Categorías</a>
                <a href="gestion_pedidos.php"><i class="fas fa-truck"></i> Pedidos</a>
                <a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> Ver Sitio</a>
            </div>
            <div class="col-md-10 content">
                <h2 class="mb-4"><i class="fas fa-ellipsis-h"></i> Otras Configuraciones</h2>
                <div class="card">
                    <div class="card-header">Enlaces Útiles</div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body text-center py-5">
                                        <i class="fas fa-database fa-3x text-primary mb-3"></i>
                                        <h5>Base de Datos</h5>
                                        <p class="text-muted">Administra la base de datos del sistema.</p>
                                        <a href="http://localhost/phpmyadmin" class="btn btn-primary" target="_blank">Ir a phpMyAdmin</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body text-center py-5">
                                        <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                                        <h5>Reportes</h5>
                                        <p class="text-muted">Genera reportes de ventas y pedidos.</p>
                                        <a href="gestion_pedidos.php" class="btn btn-success">Ver Pedidos</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
