<?php
$host = 'localhost';
$dbname = 'api-php';
$username = 'root';
$password = '';

try {
    // Establece la conexión a la base de datos usando PDO
    // La conexión utiliza el DSN (Data Source Name) con la base de datos 'api-php'
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configura la codificación para que MySQL use UTF-8 (utf8mb4 es la mejor opción)
    // Esto ayuda a manejar correctamente caracteres especiales (acentos, emojis, etc.)
    $pdo->exec("SET NAMES 'utf8mb4'");
    
    // Configura el manejo de errores de PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //menseje para verificar si la conexion es exitosa
    //echo "¡Conexión exitosa a la base de datos!";
} catch (PDOException $e) {
    // Si la conexión falla, se captura la excepción y se muestra un error genérico al usuario
    // El error específico se registra en los logs del servidor para seguridad
    error_log("Error de conexión: " . $e->getMessage());
    die("Error en la conexión a la base de datos.");
}
?>
