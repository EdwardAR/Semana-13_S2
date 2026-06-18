<?php
// admin/api/orders_update_status.php
header('Content-Type: application/json');
require_once 'db_config.php';

$response = ['success' => false, 'message' => 'Error desconocido.'];
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['order_id']) || !isset($data['status'])) {
    $response['message'] = 'Datos incompletos para actualizar el estado del pedido.';
    echo json_encode($response);
    exit();
}

$orderId = (int)$data['order_id'];
$newStatus = $data['status'];

$allowedStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
if (!in_array($newStatus, $allowedStatuses)) {
    $response['message'] = 'Estado no válido proporcionado.';
    echo json_encode($response);
    exit();
}

try {
    $pdo->beginTransaction();

    $stmt_update_order = $pdo->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
    $stmt_update_order->execute([$newStatus, $orderId]);

    if ($stmt_update_order->rowCount() > 0) {
        $response['success'] = true;
        $response['message'] = 'Estado del pedido actualizado a "' . $newStatus . '" exitosamente.';
    } else {
        $response['message'] = 'No se encontró el pedido o el estado ya es el mismo.';
    }
    $pdo->commit();

} catch (\PDOException $e) {
    $pdo->rollBack();
    $response['message'] = 'Error al actualizar estado del pedido: ' . $e->getMessage();
    error_log("Error al actualizar estado del pedido: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) {
    $pdo->rollBack();
    $response['message'] = $e->getMessage();
    error_log("Error en orders_update_status: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
