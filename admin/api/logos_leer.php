<?php
// admin/api/logos_leer.php

header('Content-Type: application/json');

require_once 'db_config.php';

$response = [
    'success' => false,
    'message' => 'Error desconocido.',
    'data' => []
];

try {
    // Seleccionar todos los logos, excluyendo 'alt_text' como solicitado.
    // Incluimos los eliminados para que puedan gestionarse desde el panel de administración.
    $sql = "SELECT id, nombre_referencia, ruta_imagen, estado, created_at, updated_at FROM logos ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $logos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['message'] = 'Logos cargados exitosamente.';
    $response['data'] = $logos;

} catch (\PDOException $e) {
    $response['message'] = 'Error al leer logos: ' . $e->getMessage();
    error_log("Error al leer logos: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
