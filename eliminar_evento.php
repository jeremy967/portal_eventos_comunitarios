<?php
include 'includes/db.php';
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header('Location: no_access.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Eliminar el evento de la base de datos
    $sql = "DELETE FROM eventos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);

    // Redirigir a la página de gestión de eventos
    header('Location: gestionar_eventos.php');
    exit();
}
?>
