<?php
include 'db.php';  // Conexión a la base de datos

header('Content-Type: application/json; charset=UTF-8');  // Establecer tipo de respuesta como JSON

// Verificar si el ID fue pasado correctamente por URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];  // Obtener el ID desde la URL

    try {
        // Preparamos la consulta para eliminar el usuario
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Usuario eliminado correctamente']);
        } else {
            echo json_encode(['message' => 'Error al eliminar el usuario']);
        }
    } catch (PDOException $e) {
        echo json_encode(['message' => 'Error en la consulta de eliminación']);
    }
} else {
    echo json_encode(['message' => 'ID inválido o no proporcionado']);
}
?>
