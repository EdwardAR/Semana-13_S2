<?php
// admin/api/orders_read.php
header('Content-Type: application/json');
require_once 'db_config.php';

$response = ['success' => false, 'message' => 'Error desconocido.', 'data' => []];

try {
    // Obtener todos los pedidos
    // Se podría añadir JOIN con la tabla de usuarios si se tiene user_id
    $sql = "SELECT id, total_amount, status, customer_name, customer_email, customer_phone, created_at, updated_at FROM orders ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['message'] = 'Pedidos cargados exitosamente.';
    $response['data'] = $orders;

} catch (\PDOException $e) {
    $response['message'] = 'Error al leer pedidos: ' . $e->getMessage();
    error_log("Error al leer pedidos: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) {
    $response['message'] = $e->getMessage();
    error_log("Error en orders_read: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
