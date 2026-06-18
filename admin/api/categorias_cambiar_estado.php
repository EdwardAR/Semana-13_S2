<?php
// admin/api/categorias_cambiar_estado.php

header('Content-Type: application/json');

require_once 'db_config.php';

$response = [
    'success' => false,
    'message' => 'Error desconocido.'
];

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['id']) || !isset($data['estado'])) {
    $response['message'] = 'Faltan datos obligatorios para cambiar el estado de la categoría.';
    echo json_encode($response);
    exit();
}

$itemId = (int)$data['id'];
$nuevoEstado = $data['estado']; // 'activo', 'inactivo', 'eliminado'

$allowedStates = ['activo', 'inactivo', 'eliminado'];
if (!in_array($nuevoEstado, $allowedStates)) {
    $response['message'] = 'Estado no válido proporcionado.';
    echo json_encode($response);
    exit();
}

try {
    $sql = "UPDATE categories SET estado = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nuevoEstado, $itemId]);

    if ($stmt->rowCount() > 0) {
        $response['success'] = true;
        $response['message'] = 'Estado de la categoría actualizado a "' . $nuevoEstado . '" exitosamente.';
    } else {
        $response['message'] = 'No se encontró la categoría con el ID proporcionado o el estado ya es el mismo.';
    }

} catch (\PDOException $e) {
    $response['message'] = 'Error al cambiar el estado de la categoría: ' . $e->getMessage();
    error_log("Error al cambiar estado de categoría: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>