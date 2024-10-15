
<?php
$host = 'localhost';
$dbname = 'eventos_db';
$username = 'root';
$password = ''; // Si usas contraseña para root, agrégala aquí.

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error en la conexión: ' . $e->getMessage();
    exit();
}
?>
