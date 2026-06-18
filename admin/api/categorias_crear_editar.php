<?php
// admin/api/categorias_crear_editar.php

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

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$categoryId = $data['id'] ?? null; // ID será null si es una creación, o el ID si es edición
$nombre = $data['nombre'] ?? '';
$estado = $data['estado'] ?? 'activo'; // 'activo', 'inactivo', 'eliminado'

// Validar datos básicos
if (empty($nombre)) {
    $response['message'] = 'El nombre de la categoría es obligatorio.';
    echo json_encode($response);
    exit();
}

// Función para generar un slug
function generateSlug($string) {
    $string = strtolower(trim($string));
    $string = str_replace(' ', '-', $string);
    $string = preg_replace('/[^a-z0-9-]/', '', $string); // Elimina caracteres no alfanuméricos excepto guiones
    $string = preg_replace('/-+/', '-', $string); // Reemplaza múltiples guiones por uno solo
    return $string;
}

$slug = generateSlug($nombre);

try {
    $pdo->beginTransaction();

    // Verificar si el slug ya existe (excepto si es el mismo ítem en edición)
    $sql_check_slug = "SELECT COUNT(*) FROM categories WHERE slug = ? AND estado != 'eliminado'" . ($categoryId ? " AND id != ?" : "");
    $stmt_check_slug = $pdo->prepare($sql_check_slug);
    $params_check_slug = [$slug];
    if ($categoryId) {
        $params_check_slug[] = $categoryId;
    }
    $stmt_check_slug->execute($params_check_slug);
    if ($stmt_check_slug->fetchColumn() > 0) {
        // Si el slug ya existe, añade un sufijo numérico para hacerlo único
        $original_slug = $slug;
        $counter = 1;
        do {
            $slug = $original_slug . '-' . $counter++;
            $sql_check_slug_unique = "SELECT COUNT(*) FROM categories WHERE slug = ? AND estado != 'eliminado'" . ($categoryId ? " AND id != ?" : "");
            $stmt_check_slug_unique = $pdo->prepare($sql_check_slug_unique);
            $params_check_slug_unique = [$slug];
            if ($categoryId) {
                $params_check_slug_unique[] = $categoryId;
            }
            $stmt_check_slug_unique->execute($params_check_slug_unique);
        } while ($stmt_check_slug_unique->fetchColumn() > 0);
    }


    if ($categoryId) {
        // Es una actualización
        $sql = "UPDATE categories SET nombre = ?, slug = ?, estado = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $slug, $estado, $categoryId]);
        $response['message'] = 'Categoría actualizada exitosamente.';
    } else {
        // Es una creación
        $sql = "INSERT INTO categories (nombre, slug, estado, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $slug, $estado]);
        $response['message'] = 'Nueva categoría creada exitosamente.';
    }
    $response['success'] = true;
    $pdo->commit();

} catch (\PDOException $e) {
    $pdo->rollBack();
    // Error 23000 es para violación de restricción de unicidad (aunque ya lo manejamos con el slug)
    // Es posible que el nombre también sea único, si es el caso, también lo capturamos aquí.
    if ($e->getCode() == '23000') {
        $response['message'] = 'Ya existe una categoría con ese nombre o slug. Por favor, elige uno diferente.';
    } else {
        $response['message'] = 'Error al guardar la categoría: ' . $e->getMessage();
    }
    error_log("Error al guardar categoría: " . $e->getMessage(), 3, 'php_error.log');
} catch (\Exception $e) {
    $pdo->rollBack();
    $response['message'] = 'Error en la operación de la categoría: ' . $e->getMessage();
    error_log("Error general en categoría: " . $e->getMessage(), 3, 'php_error.log');
}

echo json_encode($response);
?>