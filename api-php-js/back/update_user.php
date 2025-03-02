<?php
include 'db.php';  // Conexión a la base de datos

header('Content-Type: application/json; charset=UTF-8');  // Establecer tipo de respuesta como JSON

// Obtener el ID desde la URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Obtener los datos del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['name'], $data['email'])) {
        $name = $data['name'];
        $email = $data['email'];

        try {
            // Preparar la consulta SQL para actualizar el usuario
            $query = "UPDATE users SET name = :name, email = :email WHERE id = :id";
            $stmt = $pdo->prepare($query);

            // Vincular los parámetros
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);

            // Ejecutar la consulta
            $stmt->execute();

            // Responder con un mensaje de éxito
            echo json_encode(['message' => 'Usuario actualizado correctamente']);
        } catch (PDOException $e) {
            // En caso de error, se muestra un mensaje genérico
            error_log("Error al actualizar el usuario: " . $e->getMessage());
            echo json_encode(['message' => 'Error al actualizar el usuario']);
        }
    } else {
        echo json_encode(['message' => 'Faltan datos para actualizar el usuario']);
    }
} else {
    echo json_encode(['message' => 'Faltan parámetros en la URL']);
}
?>
