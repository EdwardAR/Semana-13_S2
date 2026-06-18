<?php
// admin/api/logos_eliminar_fisico.php

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
    $response['message'] = 'Falta el ID del logo para eliminar.';
    echo json_encode($response);
    exit();
}

$logoId = (int)$data['id'];

try {
    $pdo->beginTransaction(); // Iniciar transacción para asegurar la consistencia

    // 1. Obtener la ruta de la imagen antes de eliminar el registro de la BD
    $stmt_get_path = $pdo->prepare("SELECT ruta_imagen FROM logos WHERE id = ?");
    $stmt_get_path->execute([$logoId]);
    $logo_path = $stmt_get_path->fetchColumn();

    // 2. Eliminar el registro de la base de datos
    $sql = "DELETE FROM logos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$logoId]);

    if ($stmt->rowCount() > 0) {
        $response['success'] = true;
        $response['message'] = 'Logo eliminado exitosamente de la base de datos.';

        // 3. Si se encontró una ruta de imagen y el archivo existe, intentar eliminar el archivo físico
        if ($logo_path) {
            // Construir la ruta física completa al archivo de imagen
            // Subimos dos niveles (../) desde admin/api/ para llegar a la raíz (catalogo/)
            $full_path = '../../' . $logo_path;
            
            if (file_exists($full_path)) {
                if (unlink($full_path)) {
                    $response['message'] .= ' Y archivo de imagen borrado del servidor.';
                } else {
                    $response['message'] .= ' Pero hubo un error al borrar el archivo de imagen del servidor.';
                    error_log("Error al borrar el archivo de logo: " . $full_path, 3, 'php_error.log');
                }
            } else {
                $response['message'] .= ' (Archivo de imagen no encontrado en el servidor: ' . $full_path . ')';
            }
        }
        $pdo->commit(); // Confirmar la transacción si todo fue bien
    } else {
        $response['message'] = 'No se encontró el logo con el ID proporcionado.';
        $pdo->rollBack(); // Revertir si no se encontró el logo
    }

} catch (\PDOException $e) {
    $pdo->rollBack(); // Revertir la transacción en caso de error
    $response['message'] = 'Error al eliminar el logo: ' . $e->getMessage();
    error_log("Error al eliminar logo físicamente: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) {
    $pdo->rollBack();
    $response['message'] = 'Error general al eliminar logo: ' . $e->getMessage();
    error_log("Error general al eliminar logo físicamente: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
