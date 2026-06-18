<?php
// admin/api/cart_update.php
header('Content-Type: application/json');
require_once 'db_config.php';

$response = ['success' => false, 'message' => 'Error desconocido.'];
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['cart_item_id']) || !isset($data['quantity'])) {
    $response['message'] = 'Datos incompletos para actualizar el carrito.';
    echo json_encode($response);
    exit();
}

$cartItemId = (int)$data['cart_item_id'];
$quantity = (int)$data['quantity'];

if ($quantity <= 0) {
    $response['message'] = 'La cantidad debe ser mayor que cero. Para eliminar, usa la función de eliminar.';
    echo json_encode($response);
    exit();
}

try {
    $pdo->beginTransaction();

    $stmt_update_item = $pdo->prepare("UPDATE cart_items SET quantity = ?, updated_at = NOW() WHERE id = ?");
    $stmt_update_item->execute([$quantity, $cartItemId]);

    if ($stmt_update_item->rowCount() > 0) {
        $response['success'] = true;
        $response['message'] = 'Cantidad del ítem del carrito actualizada exitosamente.';
    } else {
        $response['message'] = 'No se encontró el ítem del carrito o la cantidad no cambió.';
    }
    $pdo->commit();

} catch (\PDOException $e) {
    $pdo->rollBack();
    $response['message'] = 'Error al actualizar ítem del carrito: ' . $e->getMessage();
    error_log("Error al actualizar carrito: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) {
    $pdo->rollBack();
    $response['message'] = $e->getMessage();
    error_log("Error en cart_update: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
