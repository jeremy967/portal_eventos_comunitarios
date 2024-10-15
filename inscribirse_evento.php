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

// Verificar si ya está inscrito
$sql = "SELECT * FROM inscripciones WHERE usuario_id = :usuario_id AND evento_id = :evento_id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'usuario_id' => $usuario_id,
    'evento_id' => $evento_id
]);

$inscripcion = $stmt->fetch();
?>

<div class="container mt-4">
    <?php if ($inscripcion): ?>
        <!-- Mostrar un mensaje de alerta si ya está inscrito -->
        <div class="alert alert-warning" role="alert">
            Ya estás inscrito en este evento.
        </div>
    <?php else: ?>
        <?php
        // Insertar la inscripción en la base de datos
        $sql = "INSERT INTO inscripciones (usuario_id, evento_id) VALUES (:usuario_id, :evento_id)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'usuario_id' => $usuario_id,
            'evento_id' => $evento_id
        ]);
        ?>
        <!-- Mostrar un mensaje de éxito -->
        <div class="alert alert-success" role="alert">
            Te has inscrito en el evento con éxito.
        </div>
    <?php endif; ?>
    <a href="eventos.php" class="btn btn-primary mt-4">Volver a Eventos</a>
</div>

<?php include 'includes/footer.php'; ?>
