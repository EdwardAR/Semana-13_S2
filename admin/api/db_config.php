<?php
// admin/api/db_config.php

// Define la configuración de la base de datos
$host = 'localhost'; // O la IP/nombre de host de tu servidor de base de datos
$db_name = 'catalogo'; // El nombre de la base de datos que creaste
$username = 'root'; // Tu nombre de usuario para la base de datos
$password = ''; // Tu contraseña para el usuario de la base de datos (vacío si no tienes)

try {
    // Crea una nueva instancia de PDO para la conexión a la base de datos
    // DSN (Data Source Name) para MySQL
    $pdo = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8", $username, $password);
    
    // Configura el modo de errores de PDO para que lance excepciones en caso de problemas
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Opcional: Establecer el modo de fetch por defecto a asociativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch(PDOException $exception) {
    // Captura cualquier excepción de PDO (errores de conexión o consulta)
    // Muestra un mensaje de error y detiene la ejecución del script
    echo "Error de conexión a la base de datos: " . $exception->getMessage();
    // Registra el error en un log para depuración sin exponer detalles al usuario
    error_log("Error de conexión a la base de datos: " . $exception->getMessage(), 0);
    exit(); // Detiene el script si la conexión falla
}
?>
