<?php
// admin/api/categorias_leer.php

header('Content-Type: application/json');

require_once 'db_config.php';

$response = [
    'success' => false,
    'message' => 'Error desconocido.',
    'data' => []
];

try {
    // Seleccionar todas las categorías activas. Si necesitas mostrar también inactivas,
    // puedes ajustar la cláusula WHERE o eliminarla.
    $sql = "SELECT id, nombre, estado FROM categories WHERE estado = 'activo' ORDER BY nombre ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['message'] = 'Categorías cargadas exitosamente.';
    $response['data'] = $categories;

} catch (\PDOException $e) {
    $response['message'] = 'Error al leer categorías: ' . $e->getMessage();
    error_log("Error al leer categorías: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>