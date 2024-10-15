<?php
include 'includes/db.php';
include 'includes/header.php';

// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Consulta para obtener todos los eventos
$sql = "SELECT * FROM eventos";
$stmt = $conn->prepare($sql);
$stmt->execute();
$eventos = $stmt->fetchAll();

// Verificar si el usuario ha iniciado sesión
$usuario_logueado = isset($_SESSION['usuario']);
$usuario_id = $_SESSION['usuario'] ?? null;
?>

<div class="container mt-4">
    <h2 class="text-center">Eventos Disponibles</h2>

    <!-- Tabla para mostrar los eventos -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Ubicación</th>
                <th>Acciones</th>
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
                        <?php if ($usuario_logueado): ?>
                            <?php
                            // Verificar si el usuario está inscrito en este evento
                            $sql = "SELECT * FROM inscripciones WHERE usuario_id = :usuario_id AND evento_id = :evento_id";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([
                                'usuario_id' => $usuario_id,
                                'evento_id' => $evento['id']
                            ]);
                            $inscrito = $stmt->fetch();
                            ?>
                            <?php if ($inscrito): ?>
                                <!-- Botón para cancelar la inscripción -->
                                <form method="POST" action="cancelar_inscripcion.php">
                                    <input type="hidden" name="evento_id" value="<?php echo $evento['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Cancelar Inscripción</button>
                                </form>
                            <?php else: ?>
                                <!-- Botón para inscribirse en el evento -->
                                <form method="POST" action="inscribirse_evento.php">
                                    <input type="hidden" name="evento_id" value="<?php echo $evento['id']; ?>">
                                    <button type="submit" class="btn btn-primary">Inscribirse</button>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <p>Inicia sesión para inscribirte.</p>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
