<?php
// admin/api/cart_read.php
header('Content-Type: application/json');
require_once 'db_config.php';

$response = ['success' => false, 'message' => 'Error desconocido.', 'data' => []];

// Para simplificar, se leerá el carrito basado en un 'cart_id' enviado.
// Para un sistema real, se debería usar session_id o user_id para obtener el carrito correcto.
$cartId = isset($_GET['cart_id']) ? (int)$_GET['cart_id'] : null;

if (!$cartId) {
    $response['message'] = 'Se requiere un ID de carrito.';
    echo json_encode($response);
    exit();
}

try {
    // Obtener los ítems del carrito junto con los detalles del producto
    $sql = "SELECT ci.id AS cart_item_id, ci.product_id, ci.quantity, ci.price_at_addition, p.nombre AS product_name, p.imagen_url
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.cart_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cartId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['message'] = 'Carrito leído exitosamente.';
    $response['data'] = $cartItems;

} catch (\PDOException $e) {
    $response['message'] = 'Error al leer carrito: ' . $e->getMessage();
    error_log("Error al leer carrito: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) {
    $response['message'] = $e->getMessage();
    error_log("Error en cart_read: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
