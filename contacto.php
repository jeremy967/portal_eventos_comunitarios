<?php
include 'includes/db.php';
include 'includes/header.php';

// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión solo si no ha sido iniciada
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Insertar el mensaje en la base de datos
    $sql = "INSERT INTO contactos (nombre, email, mensaje) VALUES (:nombre, :email, :mensaje)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'nombre' => $nombre,
        'email' => $email,
        'mensaje' => $mensaje
    ]);

    echo "Gracias por contactarnos. Nos pondremos en contacto contigo pronto.";
}
?>

<div class="container">
    <h2>Contáctanos</h2>

    <!-- Formulario de contacto -->
    <form method="POST" action="contacto.php">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="mensaje">Mensaje:</label>
            <textarea name="mensaje" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
