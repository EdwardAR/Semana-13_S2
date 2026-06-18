<?php
// admin/api/cart_add.php
header('Content-Type: application/json');
require_once 'db_config.php';

$response = ['success' => false, 'message' => 'Error desconocido.'];
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['product_id']) || !isset($data['quantity']) || !isset($data['price'])) {
    $response['message'] = 'Datos incompletos para añadir al carrito.';
    echo json_encode($response);
    exit();
}

$productId = (int)$data['product_id'];
$quantity = (int)$data['quantity'];
$price = (float)$data['price'];
$userId = null; // Asume ID de usuario nulo para carrito de invitado por ahora. Implementa lógica de sesión/autenticación si es necesario.

if ($quantity <= 0) {
    $response['message'] = 'La cantidad debe ser mayor que cero.';
    echo json_encode($response);
    exit();
}

try {
    $pdo->beginTransaction();

    // 1. Encontrar o crear un carrito para el usuario/sesión
    // Para simplificar, si no hay user_id, se usará un cart_id temporal/sesión si se gestiona en JS.
    // Aquí, siempre crearemos uno nuevo o asumiremos que el frontend gestiona un 'cart_id' persistente si el user_id es null
    // Si user_id es null, esto crea un nuevo carrito en cada llamada si no se envía un cart_id existente.
    // Para una gestión real de carritos de invitado, se necesitaría un mecanismo de sesión en el backend.
    
    // Si la solicitud incluye un cart_id existente (para carritos de invitado o persistentes)
    $cartId = $data['cart_id'] ?? null;
    if ($cartId) {
        $stmt_check_cart = $pdo->prepare("SELECT id FROM carts WHERE id = ? AND user_id IS NULL"); // O WHERE user_id = ? para usuarios autenticados
        $stmt_check_cart->execute([$cartId]);
        $existingCart = $stmt_check_cart->fetch(PDO::FETCH_ASSOC);
        if (!$existingCart) {
            $cartId = null; // El cart_id proporcionado no es válido para un carrito de invitado o no existe
        }
    }

    if (!$cartId) {
        $stmt_create_cart = $pdo->prepare("INSERT INTO carts (user_id) VALUES (?)");
        $stmt_create_cart->execute([$userId]);
        $cartId = $pdo->lastInsertId();
    }

    // 2. Verificar si el producto ya existe en el carrito
    $stmt_check_item = $pdo->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
    $stmt_check_item->execute([$cartId, $productId]);
    $existingItem = $stmt_check_item->fetch(PDO::FETCH_ASSOC);

    if ($existingItem) {
        // Si el producto existe, actualizar la cantidad
        $newQuantity = $existingItem['quantity'] + $quantity;
        $stmt_update_item = $pdo->prepare("UPDATE cart_items SET quantity = ?, updated_at = NOW() WHERE id = ?");
        $stmt_update_item->execute([$newQuantity, $existingItem['id']]);
        $response['message'] = 'Cantidad del producto actualizada en el carrito.';
    } else {
        // Si el producto no existe, añadirlo como un nuevo ítem
        $stmt_add_item = $pdo->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, price_at_addition) VALUES (?, ?, ?, ?)");
        $stmt_add_item->execute([$cartId, $productId, $quantity, $price]);
        $response['message'] = 'Producto añadido al carrito.';
    }

    $response['success'] = true;
    $response['cart_id'] = $cartId; // Devolver el cart_id para que el frontend lo pueda almacenar/usar
    $pdo->commit();

} catch (\PDOException $e) {
    $pdo->rollBack();
    $response['message'] = 'Error al añadir producto al carrito: ' . $e->getMessage();
    error_log("Error al añadir al carrito: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) {
    $pdo->rollBack();
    $response['message'] = $e->getMessage();
    error_log("Error en cart_add: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
