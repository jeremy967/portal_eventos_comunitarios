
<?php
include 'includes/header.php';
?>

<h1 class="text-center">Bienvenido al Portal de Eventos Comunitarios</h1>

<div class="row">
    <?php
    include 'includes/db.php';
    $sql = "SELECT * FROM eventos ORDER BY fecha DESC LIMIT 3";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $eventos = $stmt->fetchAll();

    foreach ($eventos as $evento) {
        echo "<div class='col-md-4'>";
        echo "<div class='card mb-4 shadow-sm'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>{$evento['titulo']}</h5>";
        echo "<p class='card-text'>". substr($evento['descripcion'], 0, 100) . "...</p>";
        echo "<p><strong>Fecha:</strong> {$evento['fecha']}</p>";
        echo "<p><strong>Ubicación:</strong> {$evento['ubicacion']}</p>";
        echo "<a href='evento_detalle.php?id={$evento['id']}' class='btn btn-primary'>Ver detalles</a>";
        echo "</div></div></div>";
    }
    ?>
</div>

<?php
include 'includes/footer.php';
?>
