<?php
// Incluir la conexión a la base de datos y el encabezado
include 'includes/db.php';
include 'includes/header.php';

// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión solo si no ha sido iniciada
}

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header('Location: no_access.php');
    exit();
}

// Eliminar evento si se ha enviado una solicitud de eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_id'])) {
    $eliminar_id = $_POST['eliminar_id'];
    $sql = "DELETE FROM eventos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $eliminar_id]);
    echo "Evento eliminado con éxito.";
}

// Consulta para obtener todos los eventos
$sql = "SELECT * FROM eventos";
$stmt = $conn->prepare($sql);
$stmt->execute();
$eventos = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2 class="text-center">Gestión de Eventos</h2>

    <a href="crear_evento.php" class="btn btn-success mb-4">Crear Evento</a>

    <!-- Tabla para mostrar los eventos -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Ubicación</th>
                <th>Acciones</th> <!-- Nueva columna para acciones -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eventos as $evento): ?>
                <tr>
                    <td><?php echo htmlspecialchars($evento['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($evento['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($evento['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($evento['ubicacion']); ?></td>
                    <td>
                        <!-- Formulario para eliminar el evento con confirmación -->
                        <form method="POST" action="gestionar_eventos.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este evento?');">
                            <input type="hidden" name="eliminar_id" value="<?php echo $evento['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include 'includes/footer.php';
?>
