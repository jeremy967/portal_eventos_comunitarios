<?php
include 'includes/db.php';

// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión solo si no ha sido iniciada
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para obtener el usuario por correo electrónico
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch();

    // Verificar si el correo existe
    if ($usuario) {
        // Verificar si la contraseña es correcta
        if (password_verify($password, $usuario['password'])) {
            // Almacenar el ID y el nombre del usuario en la sesión
            $_SESSION['usuario'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

            // Redirigir al inicio o a otra página
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['error'] = "Contraseña incorrecta.";
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Correo electrónico no encontrado.";
        header('Location: login.php');
        exit();
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container">
    <h2>Iniciar Sesión</h2>

    <!-- Mostrar mensajes de error, si los hay -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); // Limpiar el mensaje después de mostrarlo ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
