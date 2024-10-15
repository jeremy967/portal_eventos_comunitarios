<?php
include 'includes/db.php';
include 'includes/header.php';
// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Solo iniciar la sesión si no ha sido iniciada
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}


// Obtener el ID del evento y del usuario
$evento_id = $_POST['evento_id'];
$usuario_id = $_SESSION['usuario'];

// Eliminar la inscripción del evento
$sql = "DELETE FROM inscripciones WHERE usuario_id = :usuario_id AND evento_id = :evento_id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'usuario_id' => $usuario_id,
    'evento_id' => $evento_id
]);
?>

<div class="container mt-4">
    <!-- Mostrar un mensaje de éxito al cancelar la inscripción -->
    <div class="alert alert-success" role="alert">
        Te has dado de baja del evento con éxito.
    </div>
    <a href="eventos.php" class="btn btn-primary mt-4">Volver a Eventos</a>
</div>

<?php include 'includes/footer.php'; ?>
