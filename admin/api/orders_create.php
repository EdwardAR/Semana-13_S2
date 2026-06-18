<?php
// admin/api/orders_create.php
header('Content-Type: application/json');
require_once 'db_config.php';

$response = ['success' => false, 'message' => 'Error desconocido.'];
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['cart_id']) || !isset($data['customer_name']) || !isset($data['customer_email']) || !isset($data['customer_phone']) || !isset($data['shipping_address'])) {
    $response['message'] = 'Datos incompletos para crear el pedido.';
    echo json_encode($response);
    exit();
}

$cartId = (int)$data['cart_id'];
$customerName = $data['customer_name'];
$customerEmail = $data['customer_email'];
$customerPhone = $data['customer_phone'];
$shippingAddress = $data['shipping_address'];
$orderNotes = $data['order_notes'] ?? null;
$userId = null; // Asume ID de usuario nulo por ahora (invitado). Implementa lógica de sesión/autenticación si es necesario.

try {
    $pdo->beginTransaction();

    // 1. Obtener los ítems del carrito
    $stmt_cart_items = $pdo->prepare("SELECT ci.product_id, ci.quantity, ci.price_at_addition FROM cart_items ci WHERE ci.cart_id = ?");
    $stmt_cart_items->execute([$cartId]);
    $cartItems = $stmt_cart_items->fetchAll(PDO::FETCH_ASSOC);

    if (empty($cartItems)) {
        throw new Exception("El carrito está vacío. No se puede crear un pedido.");
    }

    $totalAmount = 0;
    foreach ($cartItems as $item) {
        $totalAmount += $item['quantity'] * $item['price_at_addition'];
    }

    // 2. Crear el nuevo pedido
    $stmt_create_order = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status, customer_name, customer_email, customer_phone, shipping_address, order_notes) VALUES (?, ?, 'pending', ?, ?, ?, ?, ?)");
    $stmt_create_order->execute([$userId, $totalAmount, $customerName, $customerEmail, $customerPhone, $shippingAddress, $orderNotes]);
    $orderId = $pdo->lastInsertId();

    // 3. Mover los ítems del carrito a order_items y actualizar stock
    foreach ($cartItems as $item) {
        $stmt_add_order_item = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_order) VALUES (?, ?, ?, ?)");
        $stmt_add_order_item->execute([$orderId, $item['product_id'], $item['quantity'], $item['price_at_addition']]);

        // Actualizar stock del producto
        $stmt_update_stock = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?");
        $stmt_update_stock->execute([$item['quantity'], $item['product_id'], $item['quantity']]);

        if ($stmt_update_stock->rowCount() === 0) {
            throw new Exception("Stock insuficiente para el producto ID: " . $item['product_id']);
        }
    }

    // 4. Vaciar el carrito después de crear el pedido
    $stmt_clear_cart = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = ?");
    $stmt_clear_cart->execute([$cartId]);
    // Opcional: Eliminar el carrito si era temporal y no asociado a un usuario
    // $stmt_delete_cart = $pdo->prepare("DELETE FROM carts WHERE id = ? AND user_id IS NULL");
    // $stmt_delete_cart->execute([$cartId]);


    $response['success'] = true;
    $response['message'] = 'Pedido creado exitosamente con ID: ' . $orderId;
    $response['order_id'] = $orderId;
    $pdo->commit();

} catch (\PDOException $e) {
    $pdo->rollBack();
    $response['message'] = 'Error en la base de datos al crear el pedido: ' . $e->getMessage();
    error_log("Error DB orders_create: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) {
    $pdo->rollBack();
    $response['message'] = 'Error al crear el pedido: ' . $e->getMessage();
    error_log("Error orders_create: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
