<?php
// admin/api/slider_leer.php

header('Content-Type: application/json');

// Incluye el archivo de configuración de la base de datos
require_once 'db_config.php';

$response = [
    'success' => false,
    'message' => 'Error desconocido.',
    'data' => []
];

try {
    // Seleccionar solo ítems del slider con estado 'activo' o 'inactivo'
    // Los ítems con estado 'eliminado' no se mostrarán en la gestión del CRUD ni en el frontend.
    $sql = "SELECT id, titulo, subtitulo, imagen, texto_boton_1, url_boton_1, texto_boton_2, url_boton_2, orden, estado, created_at, updated_at FROM slider_items WHERE estado IN ('activo', 'inactivo') ORDER BY orden ASC, id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $slider_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['message'] = 'Ítems del slider cargados exitosamente.';
    $response['data'] = $slider_items;

} catch (\PDOException $e) {
    // Captura cualquier error de PDO y lo registra
    $response['message'] = 'Error al leer ítems del slider: ' . $e->getMessage();
    error_log("Error al leer ítems del slider: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
