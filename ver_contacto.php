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

// Eliminar mensaje si se ha enviado una solicitud de eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_id'])) {
    $eliminar_id = $_POST['eliminar_id'];
    $sql = "DELETE FROM contactos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $eliminar_id]);
    echo "Mensaje eliminado con éxito.";
}

// Consulta para obtener los mensajes de contacto
$sql = "SELECT * FROM contactos ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$contactos = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2 class="text-center">Mensajes de Contacto</h2>

    <!-- Tabla para mostrar los mensajes de contacto -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Acciones</th> <!-- Nueva columna para acciones -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contactos as $contacto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($contacto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($contacto['email']); ?></td>
                    <td><?php echo htmlspecialchars($contacto['mensaje']); ?></td>
                    <td><?php echo htmlspecialchars($contacto['fecha']); ?></td>
                    <td>
                        <!-- Formulario para eliminar el mensaje -->
                        <form method="POST" action="ver_contacto.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este mensaje?');">
                            <input type="hidden" name="eliminar_id" value="<?php echo $contacto['id']; ?>">
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
