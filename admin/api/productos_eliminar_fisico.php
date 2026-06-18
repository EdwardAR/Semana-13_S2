<?php
// admin/api/productos_eliminar_fisico.php

header('Content-Type: application/json');

require_once 'db_config.php';

$response = [
    'success' => false,
    'message' => 'Error desconocido.'
];

// Obtener los datos enviados por la solicitud POST
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validar que el ID necesario esté presente
if (!isset($data['id'])) {
    $response['message'] = 'Falta el ID del producto para eliminar.';
    echo json_encode($response);
    exit();
}

$productId = (int)$data['id'];

try {
    $pdo->beginTransaction(); // Iniciar transacción para asegurar la consistencia

    // 1. Obtener la ruta de la imagen antes de eliminar el registro de la BD
    $stmt_get_path = $pdo->prepare("SELECT imagen_url FROM products WHERE id = ?");
    $stmt_get_path->execute([$productId]);
    $image_path = $stmt_get_path->fetchColumn();

    // 2. Eliminar el registro de la base de datos
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$productId]);

    if ($stmt->rowCount() > 0) {
        $response['success'] = true;
        $response['message'] = 'Producto eliminado exitosamente de la base de datos.';

        // 3. Si se encontró una ruta de imagen y el archivo existe, intentar eliminar el archivo físico
        if ($image_path) {
            // La ruta de la imagen en la base de datos es relativa a la raíz del sitio (ej. images/products/...)
            // Necesitamos la ruta absoluta o relativa correcta desde este archivo PHP.
            // Subimos dos niveles (../) desde admin/api/ para llegar a la raíz (catalogo/)
            $full_path = '../../' . $image_path;
            
            if (file_exists($full_path)) {
                if (unlink($full_path)) {
                    $response['message'] .= ' Y archivo de imagen borrado del servidor.';
                } else {
                    $response['message'] .= ' Pero hubo un error al borrar el archivo de imagen del servidor.';
                    error_log("Error al borrar el archivo de producto: " . $full_path, 3, 'php_error.log');
                    // Si falla la eliminación de la imagen, podrías decidir hacer un rollBack aquí
                    // o simplemente loguearlo y continuar, dependiendo de la criticidad.
                    // Para una eliminación "física completa", deberíamos hacer rollback si falla unlink.
                    throw new Exception("Error al borrar el archivo de imagen físico.");
                }
            } else {
                $response['message'] .= ' (Archivo de imagen no encontrado en el servidor: ' . $full_path . ')';
            }
        }
        $pdo->commit(); // Confirmar la transacción si todo fue bien
    } else {
        $response['message'] = 'No se encontró el producto con el ID proporcionado.';
        $pdo->rollBack(); // Revertir si no se encontró el ítem
    }

} catch (\PDOException $e) {
    $pdo->rollBack(); // Revertir la transacción en caso de error
    $response['message'] = 'Error al eliminar el producto: ' . $e->getMessage();
    error_log("Error al eliminar producto físicamente: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) { // Capturar errores generales como los de subida de archivos
    $pdo->rollBack();
    $response['message'] = 'Error general al eliminar producto: ' . $e->getMessage();
    error_log("Error general al eliminar producto físicamente: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
