<?php
include 'includes/db.php';
include 'includes/header.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Obtener el ID del usuario
$usuario_id = $_SESSION['usuario'];

// Consulta para obtener los eventos en los que el usuario está inscrito
$sql = "SELECT eventos.* FROM eventos 
        INNER JOIN inscripciones ON eventos.id = inscripciones.evento_id 
        WHERE inscripciones.usuario_id = :usuario_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['usuario_id' => $usuario_id]);
$eventos = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2 class="text-center">Mis Eventos</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Ubicación</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eventos as $evento): ?>
                <tr>
                    <td><?php echo htmlspecialchars($evento['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($evento['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($evento['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($evento['ubicacion']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
