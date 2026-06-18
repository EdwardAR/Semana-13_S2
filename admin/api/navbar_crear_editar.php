<?php
// api/navbar_crear_editar.php

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
if (!isset($data['textoVisible']) || !isset($data['urlEnlace']) || !isset($data['orden']) || !isset($data['estado'])) {
    $response['message'] = 'Faltan datos obligatorios para crear/editar el item del navbar.';
    echo json_encode($response);
    exit();
}

$itemId = $data['id'] ?? null; // ID será null si es una creación, o el ID si es edición
$textoVisible = $data['textoVisible'];
$urlEnlace = $data['urlEnlace'];
$orden = (int)$data['orden'];
$estado = $data['estado']; // 'activo', 'inactivo'

try {
    if ($itemId) {
        // Es una actualización
        $sql = "UPDATE navbar_items SET texto_visible = ?, url_enlace = ?, orden = ?, estado = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$textoVisible, $urlEnlace, $orden, $estado, $itemId]);
        $response['message'] = 'Item del navbar actualizado exitosamente.';
    } else {
        // Es una creación
        $sql = "INSERT INTO navbar_items (texto_visible, url_enlace, orden, estado, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$textoVisible, $urlEnlace, $orden, $estado]);
        $response['message'] = 'Nuevo item del navbar creado exitosamente.';
    }
    $response['success'] = true;

} catch (\PDOException $e) {
    $response['message'] = 'Error al guardar el item del navbar: ' . $e->getMessage();
    error_log("Error al guardar navbar_item: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>