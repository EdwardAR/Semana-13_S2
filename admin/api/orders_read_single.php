<?php
// admin/api/orders_read_single.php
header('Content-Type: application/json');
require_once 'db_config.php';

$response = ['success' => false, 'message' => 'Error desconocido.', 'order_data' => null, 'order_items' => []];

$orderId = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$orderId) {
    $response['message'] = 'Se requiere un ID de pedido.';
    echo json_encode($response);
    exit();
}

try {
    // Obtener los detalles del pedido
    $stmt_order = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt_order->execute([$orderId]);
    $orderData = $stmt_order->fetch(PDO::FETCH_ASSOC);

    if (!$orderData) {
        throw new Exception("Pedido no encontrado.");
    }

    // Obtener los ítems del pedido
    $sql_items = "SELECT oi.id AS order_item_id, oi.product_id, oi.quantity, oi.price_at_order, p.nombre AS product_name, p.imagen_url
                  FROM order_items oi
                  JOIN products p ON oi.product_id = p.id
                  WHERE oi.order_id = ?";
    $stmt_items = $pdo->prepare($sql_items);
    $stmt_items->execute([$orderId]);
    $orderItems = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['message'] = 'Pedido y sus ítems cargados exitosamente.';
    $response['order_data'] = $orderData;
    $response['order_items'] = $orderItems;

} catch (\PDOException $e) {
    $response['message'] = 'Error en la base de datos al leer el pedido: ' . $e->getMessage();
    error_log("Error DB orders_read_single: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) {
    $response['message'] = 'Error al leer el pedido: ' . $e->getMessage();
    error_log("Error orders_read_single: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
