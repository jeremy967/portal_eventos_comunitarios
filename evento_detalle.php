<?php
include 'includes/db.php';
include 'includes/header.php';

// Verificar si el parámetro 'id' está presente en la URL
if (isset($_GET['id'])) {
    $evento_id = $_GET['id'];

    // Consulta para obtener los detalles del evento
    $sql = "SELECT * FROM eventos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $evento_id]);
    $evento = $stmt->fetch();

    // Verificar si se encontró el evento
    if ($evento) {
        ?>
        <div class="container mt-4">
            <h2><?php echo htmlspecialchars($evento['titulo']); ?></h2>
            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($evento['descripcion']); ?></p>
            <p><strong>Fecha:</strong> <?php echo htmlspecialchars($evento['fecha']); ?></p>
            <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($evento['ubicacion']); ?></p>
            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($evento['categoria']); ?></p>
            <p><strong>Cupo máximo:</strong> <?php echo htmlspecialchars($evento['cupo']); ?></p>
        </div>
        <?php
    } else {
        echo "<p>Evento no encontrado.</p>";
    }
} else {
    echo "<p>ID de evento no proporcionado.</p>";
}

include 'includes/footer.php';
?>
