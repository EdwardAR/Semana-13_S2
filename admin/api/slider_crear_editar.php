<?php
// admin/api/slider_crear_editar.php

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
$titulo = $_POST['titulo'] ?? '';
$subtitulo = $_POST['subtitulo'] ?? '';
$textoBoton1 = $_POST['textoBoton1'] ?? null; // Puede ser opcional
$urlBoton1 = $_POST['urlBoton1'] ?? null;   // Puede ser opcional
$textoBoton2 = $_POST['textoBoton2'] ?? null; // Puede ser opcional
$urlBoton2 = $_POST['urlBoton2'] ?? null;   // Puede ser opcional
$orden = isset($_POST['orden']) ? (int)$_POST['orden'] : 0;
$estado = $_POST['estadoSlider'] ?? 'activo';

if (empty($titulo) || empty($subtitulo)) {
    $response['message'] = 'El título y el subtítulo son campos obligatorios.';
    echo json_encode($response);
    exit();
}

$ruta_imagen = ''; // Se inicializa vacío

try {
    $pdo->beginTransaction(); // Iniciar transacción

    // Manejo de la subida de la imagen
    if (isset($_FILES['imagenSlider']) && $_FILES['imagenSlider']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagenSlider']['tmp_name'];
        $fileName = $_FILES['imagenSlider']['name'];
        $fileSize = $_FILES['imagenSlider']['size'];
        $fileType = $_FILES['imagenSlider']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        // La ruta de subida es '../../images/sliders/' desde admin/api/
        $uploadFileDir = '../../images/sliders/'; 
        $dest_path = $uploadFileDir . $newFileName;

        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg', 'svg'];
        if (!in_array($fileExtension, $allowedfileExtensions)) {
            $response['message'] = 'Tipo de archivo de imagen no permitido. Solo JPG, PNG, GIF, JPEG, SVG.';
            echo json_encode($response);
            exit();
        }

        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            $ruta_imagen = 'images/sliders/' . $newFileName; // Ruta relativa para guardar en la BD
        } else {
            $response['message'] = 'Error al mover el archivo de imagen.';
            echo json_encode($response);
            exit();
        }
    } elseif ($itemId) {
        // Si es una edición y no se sube nueva imagen, mantener la imagen existente
        $stmt_current_image = $pdo->prepare("SELECT imagen FROM slider_items WHERE id = ?");
        $stmt_current_image->execute([$itemId]);
        $current_image = $stmt_current_image->fetchColumn();
        if ($current_image) {
            $ruta_imagen = $current_image;
        }
    }

    if ($itemId) {
        // Es una actualización
        $sql = "UPDATE slider_items SET titulo = ?, subtitulo = ?, texto_boton_1 = ?, url_boton_1 = ?, texto_boton_2 = ?, url_boton_2 = ?, orden = ?, estado = ?, updated_at = NOW()";
        $params = [$titulo, $subtitulo, $textoBoton1, $urlBoton1, $textoBoton2, $urlBoton2, $orden, $estado];

        if (!empty($ruta_imagen)) { // Solo actualiza la ruta_imagen si se subió una nueva
            $sql .= ", imagen = ?";
            $params[] = $ruta_imagen;
        }

        $sql .= " WHERE id = ?";
        $params[] = $itemId;

    } else {
        // Es una creación
        if (empty($ruta_imagen)) { // La imagen es obligatoria para nuevas creaciones
            $response['message'] = 'Debe seleccionar un archivo de imagen para un nuevo ítem de slider.';
            echo json_encode($response);
            exit();
        }
        $sql = "INSERT INTO slider_items (titulo, subtitulo, imagen, texto_boton_1, url_boton_1, texto_boton_2, url_boton_2, orden, estado, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $params = [$titulo, $subtitulo, $ruta_imagen, $textoBoton1, $urlBoton1, $textoBoton2, $urlBoton2, $orden, $estado];
    }

    // --- Líneas de depuración añadidas ---
    error_log("SQL Query for Slider: " . $sql, 3, 'php_error.log');
    error_log("Parameters for Slider (Count: " . count($params) . "): " . print_r($params, true), 3, 'php_error.log');
    // --- Fin de líneas de depuración ---

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    if ($itemId) {
        $response['message'] = 'Ítem de slider actualizado exitosamente.';
    } else {
        $response['message'] = 'Nuevo ítem de slider creado exitosamente.';
    }
    $response['success'] = true;
    $pdo->commit();

} catch (\PDOException $e) {
    $pdo->rollBack();
    $response['message'] = 'Error al guardar el ítem del slider: ' . $e->getMessage();
    error_log("Error al guardar ítem del slider: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) {
    $pdo->rollBack();
    $response['message'] = 'Error en la operación del ítem del slider: ' . $e->getMessage();
    error_log("Error general al guardar ítem del slider: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>
