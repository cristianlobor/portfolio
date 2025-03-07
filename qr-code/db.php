<?php
$host = 'localhost';
$dbname = 'app_qr';
$username = 'root'; // o el usuario de tu base de datos
$password = ''; // o la contraseña de tu base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
