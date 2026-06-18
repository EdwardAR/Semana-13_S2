<?php
// api/navbar_cambiar_estado.php

header('Content-Type: application/json');

// Incluir la configuración de la base de datos
require_once 'db_config.php';

$response = [
    'success' => false,
    'message' => 'Error desconocido.'
];

// Obtener los datos enviados por la solicitud POST
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validar que los datos necesarios estén presentes
if (!isset($data['id']) || !isset($data['estado'])) {
    $response['message'] = 'Faltan datos obligatorios para cambiar el estado.';
    echo json_encode($response);
    exit();
}

$itemId = (int)$data['id'];
$nuevoEstado = $data['estado']; // 'activo', 'inactivo', 'eliminado'

// Asegurarse de que el nuevo estado sea uno de los valores permitidos
$allowedStates = ['activo', 'inactivo', 'eliminado'];
if (!in_array($nuevoEstado, $allowedStates)) {
    $response['message'] = 'Estado no válido proporcionado.';
    echo json_encode($response);
    exit();
}

try {
    $sql = "UPDATE navbar_items SET estado = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nuevoEstado, $itemId]);

    if ($stmt->rowCount() > 0) {
        $response['success'] = true;
        $response['message'] = 'Estado del item del navbar actualizado a "' . $nuevoEstado . '" exitosamente.';
    } else {
        $response['message'] = 'No se encontró el item del navbar con el ID proporcionado o el estado ya es el mismo.';
    }

} catch (\PDOException $e) {
    $response['message'] = 'Error al cambiar el estado del item del navbar: ' . $e->getMessage();
    error_log("Error al cambiar estado de navbar_item: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>