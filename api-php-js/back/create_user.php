<?php
include 'db.php';  // Conexión a la base de datos

header('Content-Type: application/json; charset=UTF-8');  // Establecer tipo de respuesta como JSON

// Obtener los datos JSON enviados por el cliente
$input = json_decode(file_get_contents('php://input'), true);  // Leer el cuerpo de la solicitud JSON

// Verificar si se recibieron los datos necesarios (name y email)
if (isset($input['name']) && isset($input['email'])) {
    $name = $input['name'];
    $email = $input['email'];

    // Validar los datos (esto es básico, puedes agregar más validaciones según lo necesites)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['message' => 'El correo electrónico no es válido']);
        http_response_code(400);  // Bad Request
        exit;
    }

    try {
        // Preparar la consulta para insertar el nuevo usuario (sin necesidad de incluir 'created_at')
        $query = "INSERT INTO users (name, email) VALUES (:name, :email)";
        $stmt = $pdo->prepare($query);
        
        // Bind de los parámetros
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si el usuario se insertó correctamente, devolver la respuesta en formato JSON
            echo json_encode([
                'message' => 'Usuario creado correctamente',
                'user' => [
                    'name' => $name,
                    'email' => $email
                ]
            ]);
            http_response_code(201);  // Código de éxito para creación (201 Created)
        } else {
            echo json_encode(['message' => 'Error al crear el usuario']);
            http_response_code(500);  // Internal Server Error
        }
    } catch (PDOException $e) {
        // Si ocurre un error en la base de datos
        echo json_encode(['message' => 'Error al procesar la solicitud']);
        http_response_code(500);  // Internal Server Error
    }
} else {
    // Si falta algún campo necesario
    echo json_encode(['message' => 'Faltan datos requeridos (name, email)']);
    http_response_code(400);  // Bad Request
}
?>
