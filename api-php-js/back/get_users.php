<?php
include 'db.php';  // Se incluye el archivo de conexión a la base de datos

header('Content-Type: application/json; charset=UTF-8');  // Se establece el tipo de respuesta como JSON con UTF-8

try {
    // Se prepara la consulta para seleccionar todos los usuarios
    $query = "SELECT * FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();  // Ejecuta la consulta
    
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Recupera todos los registros como un array asociativo

    // Se devuelve el resultado como una respuesta JSON
    echo json_encode($users, JSON_UNESCAPED_UNICODE);  // Usamos JSON_UNESCAPED_UNICODE para evitar la codificación extra
} catch (PDOException $e) {
    // Si ocurre un error, se registra y se envía un mensaje genérico
    error_log("Error al obtener usuarios: " . $e->getMessage());
    echo json_encode(['message' => 'Ocurrió un error al obtener los usuarios.']);
}
?>
