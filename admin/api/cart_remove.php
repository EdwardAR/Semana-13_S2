<?php
// admin/api/cart_remove.php
header('Content-Type: application/json');
require_once 'db_config.php';

$response = ['success' => false, 'message' => 'Error desconocido.'];
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['cart_item_id'])) {
    $response['message'] = 'ID de ítem de carrito incompleto para eliminar.';
    echo json_encode($response);
    exit();
}

$cartItemId = (int)$data['cart_item_id'];

try {
    $pdo->beginTransaction();

    $stmt_delete_item = $pdo->prepare("DELETE FROM cart_items WHERE id = ?");
    $stmt_delete_item->execute([$cartItemId]);

    if ($stmt_delete_item->rowCount() > 0) {
        $response['success'] = true;
        $response['message'] = 'Ítem del carrito eliminado exitosamente.';
    } else {
        $response['message'] = 'No se encontró el ítem del carrito.';
    }
    $pdo->commit();

} catch (\PDOException $e) {
    $pdo->rollBack();
    $response['message'] = 'Error al eliminar ítem del carrito: ' . $e->getMessage();
    error_log("Error al eliminar del carrito: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) {
    $pdo->rollBack();
    $response['message'] = $e->getMessage();
    error_log("Error en cart_remove: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
