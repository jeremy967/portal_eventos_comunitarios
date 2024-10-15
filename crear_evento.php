<?php
session_start();
include 'includes/db.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header('Location: no_access.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $ubicacion = $_POST['ubicacion'];
    $categoria = $_POST['categoria'];
    $cupo = $_POST['cupo'];

    // Insertar el evento en la base de datos
    $sql = "INSERT INTO eventos (titulo, descripcion, fecha, ubicacion, categoria, cupo, admin_id) 
            VALUES (:titulo, :descripcion, :fecha, :ubicacion, :categoria, :cupo, :admin_id)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'titulo' => $titulo,
        'descripcion' => $descripcion,
        'fecha' => $fecha,
        'ubicacion' => $ubicacion,
        'categoria' => $categoria,
        'cupo' => $cupo,
        'admin_id' => $_SESSION['usuario'] // El ID del administrador que creó el evento
    ]);

    echo "Evento creado exitosamente.";
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <h2>Crear Evento</h2>
    <form method="POST" action="crear_evento.php">
        <div class="form-group mb-3">
            <label for="titulo">Título del Evento</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        <div class="form-group mb-3">
            <label for="ubicacion">Ubicación</label>
            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
        </div>
        <div class="form-group mb-3">
            <label for="categoria">Categoría</label>
            <input type="text" class="form-control" id="categoria" name="categoria" required>
        </div>
        <div class="form-group mb-3">
            <label for="cupo">Cupo máximo de asistentes</label>
            <input type="number" class="form-control" id="cupo" name="cupo" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Evento</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
