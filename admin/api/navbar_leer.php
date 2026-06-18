<?php
// admin/api/navbar_leer.php

// Establece el tipo de contenido de la respuesta a JSON
header('Content-Type: application/json');

// Incluye el archivo de configuración de la base de datos
// Asegúrate de que esta ruta sea correcta con respecto a este archivo (navbar_leer.php)
require_once 'db_config.php';

// Inicializa la respuesta con un estado de fallo por defecto
$response = [
    'success' => false,
    'message' => 'Error desconocido.',
    'data' => [] // Para almacenar los datos del navbar
];

try {
    // Prepara la consulta SQL para seleccionar todos los items del navbar.
    // Es importante seleccionar todos los items (incluyendo 'eliminado') para que el panel de administración
    // pueda gestionarlos y cambiar su estado. El frontend solo mostrará los 'activo'.
    // Los ordenamos por la columna 'orden' y luego por 'id' descendente para consistencia.
    $sql = "SELECT id, texto_visible, url_enlace, orden, estado, created_at, updated_at FROM navbar_items ORDER BY orden ASC, id DESC";
    $stmt = $pdo->prepare($sql); // Prepara la sentencia para seguridad (PDO)
    $stmt->execute(); // Ejecuta la consulta
    
    // Obtiene todos los resultados como un array asociativo
    $navbar_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si la consulta fue exitosa, actualiza la respuesta
    $response['success'] = true;
    $response['message'] = 'Items del navbar cargados exitosamente.';
    $response['data'] = $navbar_items;

} catch (\PDOException $e) {
    // Si ocurre un error de PDO (base de datos), registra el error y devuelve un mensaje
    $response['message'] = 'Error al leer items del navbar: ' . $e->getMessage();
    // Registra el error completo en el log de PHP para depuración
    error_log("Error al leer navbar_items: " . $e->getMessage(), 3, 'php_error.log');
}

// Devuelve la respuesta en formato JSON
echo json_encode($response);
?>
