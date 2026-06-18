<?php
// admin/api/logos_crear_editar.php

header('Content-Type: application/json');

require_once 'db_config.php';

$response = [
    'success' => false,
    'message' => 'Error desconocido.'
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método de solicitud no válido.';
    echo json_encode($response);
    exit();
}

$itemId = $_POST['id'] ?? null;
$nombreReferencia = $_POST['nombreReferencia'] ?? '';
// El campo altText ha sido eliminado y ya no se procesa aquí.
$estado = $_POST['estadoLogo'] ?? 'activo';

// Validar que el nombre de referencia no esté vacío
if (empty($nombreReferencia)) {
    $response['message'] = 'El nombre de referencia es un campo obligatorio.';
    echo json_encode($response);
    exit();
}

$ruta_imagen = ''; // Se inicializa vacío

try {
    $pdo->beginTransaction(); // Iniciar transacción

    // Manejo de la subida de la imagen
    if (isset($_FILES['imagenLogo']) && $_FILES['imagenLogo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagenLogo']['tmp_name'];
        $fileName = $_FILES['imagenLogo']['name'];
        $fileSize = $_FILES['imagenLogo']['size'];
        $fileType = $_FILES['imagenLogo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        // RUTA CORREGIDA: Necesita subir dos niveles para llegar a la carpeta 'images' en la raíz
        $uploadFileDir = '../../images/logos/'; 
        $dest_path = $uploadFileDir . $newFileName;

        // Asegurarse de que el directorio de subida exista
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg', 'svg']; // Añadir SVG si se permite
        if (!in_array($fileExtension, $allowedfileExtensions)) {
            $response['message'] = 'Tipo de archivo de imagen no permitido. Solo JPG, PNG, GIF, JPEG, SVG.';
            echo json_encode($response);
            exit();
        }

        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            $ruta_imagen = 'images/logos/' . $newFileName; // Ruta relativa para guardar en la BD
        } else {
            $response['message'] = 'Error al mover el archivo de imagen.';
            echo json_encode($response);
            exit();
        }
    } elseif ($itemId) {
        // Si es una edición y no se sube nueva imagen, mantener la imagen existente
        $stmt_current_image = $pdo->prepare("SELECT ruta_imagen FROM logos WHERE id = ?");
        $stmt_current_image->execute([$itemId]);
        $current_image = $stmt_current_image->fetchColumn();
        if ($current_image) {
            $ruta_imagen = $current_image;
        }
    }

    if ($itemId) {
        // Es una actualización
        // Se ha eliminado 'alt_text' de la consulta UPDATE
        $sql = "UPDATE logos SET nombre_referencia = ?, estado = ?, updated_at = NOW()";
        $params = [$nombreReferencia, $estado];

        if (!empty($ruta_imagen)) { // Solo actualiza la ruta_imagen si se subió una nueva
            $sql .= ", ruta_imagen = ?";
            $params[] = $ruta_imagen;
        }

        $sql .= " WHERE id = ?";
        $params[] = $itemId;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $response['message'] = 'Logo actualizado exitosamente.';
    } else {
        // Es una creación
        if (empty($ruta_imagen)) { // La imagen es obligatoria para nuevas creaciones
            $response['message'] = 'Debe seleccionar un archivo de imagen para un nuevo logo.';
            echo json_encode($response);
            exit();
        }
        // Se ha eliminado 'alt_text' de la consulta INSERT y de los parámetros
        $sql = "INSERT INTO logos (nombre_referencia, ruta_imagen, estado, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombreReferencia, $ruta_imagen, $estado]);
        $response['message'] = 'Nuevo logo creado exitosamente.';
    }
    $response['success'] = true;
    $pdo->commit();

} catch (\PDOException $e) {
    $pdo->rollBack();
    $response['message'] = 'Error al guardar el logo: ' . $e->getMessage();
    error_log("Error al guardar logo: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) {
    $pdo->rollBack();
    $response['message'] = 'Error en la operación del logo: ' . $e->getMessage();
    error_log("Error general al guardar logo: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
