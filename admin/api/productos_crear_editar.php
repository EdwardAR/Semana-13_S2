<?php
// admin/api/productos_crear_editar.php

header('Content-Type: application/json');

require_once 'db_config.php';

$response = [
    'success' => false,
    'message' => 'Error desconocido.'
];

// Comprobar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método de solicitud no válido.';
    echo json_encode($response);
    exit();
}

// Obtener los datos del formulario (FormData)
$itemId = $_POST['id'] ?? null;
$nombre = $_POST['nombre'] ?? '';
$descripcionCorta = $_POST['descripcionCorta'] ?? '';
$descripcionLarga = $_POST['descripcionLarga'] ?? '';
$precio = $_POST['precio'] ?? 0;
$stock = $_POST['stock'] ?? 0;
$destacadoEnInicio = isset($_POST['destacadoEnInicio']) && $_POST['destacadoEnInicio'] == '1' ? 1 : 0;
$estado = $_POST['estadoProducto'] ?? 'activo';
$categoriaId = $_POST['categoriaId'] ?? null; // Captura el ID de la categoría

// Validar datos básicos
if (empty($nombre) || empty($precio) || empty($stock) || empty($categoriaId)) {
    $response['message'] = 'El nombre, precio, stock y categoría son campos obligatorios.';
    echo json_encode($response);
    exit();
}

// Asegurarse de que precio y stock sean números válidos
$precio = floatval($precio);
$stock = intval($stock);

if ($precio <= 0) {
    $response['message'] = 'El precio debe ser un número positivo.';
    echo json_encode($response);
    exit();
}
if ($stock < 0) {
    $response['message'] = 'El stock no puede ser negativo.';
    echo json_encode($response);
    exit();
}

$ruta_imagen = ''; // Se inicializa vacío, se llenará si se sube una nueva imagen

try {
    $pdo->beginTransaction(); // Iniciar transacción

    // Manejo de la subida de la imagen
    if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagenProducto']['tmp_name'];
        $fileName = $_FILES['imagenProducto']['name'];
        $fileSize = $_FILES['imagenProducto']['size'];
        $fileType = $_FILES['imagenProducto']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = '../../images/products/'; // Ruta para guardar imágenes de productos
        $dest_path = $uploadFileDir . $newFileName;

        // Validar tipo de archivo (solo JPG y PNG)
        $allowedFileTypes = ['jpg', 'png', 'jpeg'];
        if (!in_array($fileExtension, $allowedFileTypes)) {
            throw new Exception("Tipo de archivo no permitido. Solo se aceptan JPG y PNG.");
        }

        // Validar tamaño del archivo (ej. máximo 5MB)
        if ($fileSize > 5 * 1024 * 1024) { // 5 MB
            throw new Exception("El tamaño del archivo excede el límite de 5MB.");
        }

        // Crear el directorio si no existe
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $ruta_imagen = 'images/products/' . $newFileName; // Ruta relativa para guardar en BD
        } else {
            throw new Exception('Error al mover el archivo de imagen subido.');
        }
    } else if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Manejar otros errores de subida
        throw new Exception('Error en la subida de la imagen: Código ' . $_FILES['imagenProducto']['error']);
    }

    if ($itemId) {
        // Es una actualización
        $sql = "UPDATE products SET nombre = ?, descripcion_corta = ?, descripcion_larga = ?, precio = ?, stock = ?, destacado_en_inicio = ?, estado = ?, categoria_id = ?, updated_at = NOW()";
        $params = [$nombre, $descripcionCorta, $descripcionLarga, $precio, $stock, $destacadoEnInicio, $estado, $categoriaId];

        if (!empty($ruta_imagen)) { // Si se subió una nueva imagen
            // Antes de actualizar la ruta de la imagen, obtener la antigua para eliminarla
            $stmt_old_image = $pdo->prepare("SELECT imagen_url FROM products WHERE id = ?");
            $stmt_old_image->execute([$itemId]);
            $old_image_path = $stmt_old_image->fetchColumn();

            if ($old_image_path && file_exists('../../' . $old_image_path)) {
                unlink('../../' . $old_image_path); // Eliminar la antigua imagen física
            }

            $sql .= ", imagen_url = ?";
            $params[] = $ruta_imagen;
        }

        $sql .= " WHERE id = ?";
        $params[] = $itemId;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $response['message'] = 'Producto actualizado exitosamente.';
    } else {
        // Es una creación
        // Asegurarse de que $imagen_url no esté vacío para una nueva creación
        if (empty($ruta_imagen)) {
            $response['message'] = 'Debe seleccionar un archivo de imagen para un nuevo producto.';
            echo json_encode($response);
            exit();
        }
        $sql = "INSERT INTO products (nombre, descripcion_corta, descripcion_larga, precio, imagen_url, stock, destacado_en_inicio, estado, categoria_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())"; // Añadido categoria_id
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $descripcionCorta, $descripcionLarga, $precio, $ruta_imagen, $stock, $destacadoEnInicio, $estado, $categoriaId]); // Añadido $categoriaId
        $response['message'] = 'Nuevo producto creado exitosamente.';
    }
    $response['success'] = true;
    $pdo->commit(); // Confirmar la transacción

} catch (\PDOException $e) {
    $pdo->rollBack(); // Revertir la transacción en caso de error
    $response['message'] = 'Error al guardar el producto: ' . $e->getMessage();
    error_log("Error al guardar producto: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) { // Capturar errores generales como los de subida de archivos
    $pdo->rollBack();
    $response['message'] = 'Error en la operación del producto: ' . $e->getMessage();
    error_log("Error en la operación del producto: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
