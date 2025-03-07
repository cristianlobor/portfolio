<?php
require 'vendor/autoload.php'; // Asegúrate de que esta ruta sea correcta

include 'db.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Verificar la acción solicitada
$action = $_GET['action'] ?? null;

switch ($action) {
    case 'get_users':
        // Obtener todos los usuarios
        $sql = "SELECT * FROM usuarios";
        $stmt = $pdo->query($sql);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($usuarios);
        break;

    case 'get_user':
        // Obtener detalles de un usuario específico
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
            $sql = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $userId]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($usuario);
        }
        break;

        case 'edit_user':
            // Actualizar la información del usuario
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtener los datos del formulario
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
    
                // Verificar si el usuario existe
                $sql = "SELECT * FROM usuarios WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['id' => $id]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if ($usuario) {
                    // Actualizar la información del usuario en la base de datos
                    $updateSql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
                    $updateStmt = $pdo->prepare($updateSql);
                    $updateStmt->execute(['nombre' => $nombre, 'email' => $email, 'id' => $id]);
    
                    // Devolver una respuesta exitosa
                    echo json_encode(['success' => true]);
                } else {
                    // Si el usuario no existe
                    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
                }
            }
            break;

        case 'add_user':
            // Agregar un nuevo usuario
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
        
                // Insertar el nuevo usuario
                $sql = "INSERT INTO usuarios (nombre, email, visitas) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nombre, $email, 0]);
        
                // Obtener ID del usuario recién insertado
                $userId = $pdo->lastInsertId();
        
                // Generar el link para registrar visita
                $registerVisitLink = "http://localhost/qr-code/api.php?action=register_visit&id=$userId";
        
                // Generar QR con el link para registrar visita
                $qrDir = 'qrs';
                if (!is_dir($qrDir)) {
                    mkdir($qrDir, 0777, true); // Crear el directorio si no existe
                }
        
                // Ahora generamos el QR con el link para registrar visita
                $qrCode = new QrCode($registerVisitLink);
                $qrFilePath = $qrDir . '/user_' . $userId . '.png';
                $writer = new PngWriter();
                $result = $writer->write($qrCode);
                $result->saveToFile($qrFilePath);
        
                // Actualizar la base de datos con el QR
                $updateSql = "UPDATE usuarios SET qr_code = ? WHERE id = ?";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->execute([$qrFilePath, $userId]);
        
                echo json_encode(['success' => true]);
            }
            break;
        

            case 'delete_user':
                // Eliminar un usuario y sus visitas
                if (isset($_GET['id'])) {
                    $userId = $_GET['id'];
            
                    // Eliminar las visitas asociadas al usuario
                    $deleteVisitsSql = "DELETE FROM visitas WHERE usuario_id = :usuario_id";
                    $deleteVisitsStmt = $pdo->prepare($deleteVisitsSql);
                    $deleteVisitsStmt->execute(['usuario_id' => $userId]);
            
                    // Primero, obtener el archivo QR asociado al usuario para poder eliminarlo
                    $sql = "SELECT qr_code FROM usuarios WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['id' => $userId]);
                    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
                    if ($usuario) {
                        // Eliminar el archivo QR de la carpeta qrs si existe
                        $qrFilePath = $usuario['qr_code'];
                        if (file_exists($qrFilePath)) {
                            unlink($qrFilePath); // Elimina el archivo QR
                        }
                    }
            
                    // Luego, eliminar el usuario de la base de datos
                    $sql = "DELETE FROM usuarios WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['id' => $userId]);
            
                    echo json_encode(['success' => true]);
                }
            break;
            
            

                case 'register_visit':
                    try {
                        // Verificar que 'id' y 'fecha' estén presentes
                        if (isset($_GET['id'])) {
                            $userId = $_GET['id'];
                
                            // Asegurarse de que el usuario existe
                            $sql = "SELECT * FROM usuarios WHERE id = :id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(['id' => $userId]);
                            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                
                            if ($usuario) {
                                // Consulta SQL para insertar una nueva visita sin especificar la fecha
                                $insertVisitSql = "INSERT INTO visitas (usuario_id) VALUES (:usuario_id)";
                                $insertVisitStmt = $pdo->prepare($insertVisitSql);
                                $insertVisitStmt->execute(['usuario_id' => $userId]);
                
                                // Incrementar el contador de visitas en la tabla de usuarios
                                $updateSql = "UPDATE usuarios SET visitas = visitas + 1 WHERE id = :id";
                                $updateStmt = $pdo->prepare($updateSql);
                                $updateStmt->execute(['id' => $userId]);
                
                                // Responder con éxito
                                echo json_encode(['success' => true]);
                            } else {
                                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
                            }
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Faltan parámetros']);
                        }
                    } catch (Exception $e) {
                        // Captura de cualquier error y respuesta con mensaje de error
                        echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
                    }
                    break;
                
        

    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}
?>
