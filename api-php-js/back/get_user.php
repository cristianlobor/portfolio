<?php
include 'db.php';  // Conexión a la base de datos

header('Content-Type: application/json; charset=UTF-8');  // Establecer tipo de respuesta como JSON

// Verificar si el ID fue pasado correctamente por URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];  // Obtener el ID desde la URL

    try {
        // Preparamos la consulta para obtener un solo usuario por su ID
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Devolver el usuario en formato JSON
            echo json_encode($user);
        } else {
            echo json_encode(['message' => 'Usuario no encontrado']);
        }
    } catch (PDOException $e) {
        echo json_encode(['message' => 'Error al obtener el usuario']);
    }
} else {
    echo json_encode(['message' => 'ID inválido o no proporcionado']);
}
?>
