<?php
// admin/api/productos_leer.php

header('Content-Type: application/json');

// Incluir la configuración de la base de datos
require_once 'db_config.php';

$response = [
    'success' => false,
    'message' => 'Error desconocido.',
    'data' => []
];

try {
    // Consulta para obtener todos los productos, incluyendo los eliminados para gestión en el admin
    // Se añade un JOIN con la tabla categories para obtener el nombre de la categoría
    $sql = "SELECT p.id, p.nombre, p.descripcion_corta, p.descripcion_larga, p.precio, p.imagen_url, p.stock, p.destacado_en_inicio, p.estado, p.created_at, p.updated_at, p.categoria_id, c.nombre AS nombre_categoria FROM products p LEFT JOIN categories c ON p.categoria_id = c.id ORDER BY p.id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['message'] = 'Productos cargados exitosamente.';
    $response['data'] = $products;

} catch (\PDOException $e) {
    $response['message'] = 'Error al leer productos: ' . $e->getMessage();
    error_log("Error al leer productos: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
