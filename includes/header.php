<?php
// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión solo si no ha sido iniciada
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Eventos Comunitarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <!-- Archivo CSS personalizado -->
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Eventos Comunitarios</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="eventos.php">Eventos</a></li>
                <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>

                <!-- Mostrar opciones de administrador si el usuario ha iniciado sesión como administrador -->
                <?php if (isset($_SESSION['usuario'])): ?>
                    <!-- Si el usuario es administrador, mostrar las opciones de gestión -->
                    <?php if ($_SESSION['tipo_usuario'] == 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="gestionar_usuarios.php">Gestionar Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="gestionar_eventos.php">Gestionar Eventos</a></li>
                        <li class="nav-item"><a class="nav-link" href="ver_contacto.php">Ver Contacto</a></li>
                    <?php endif; ?>

                    <!-- Mostrar el nombre del usuario y el botón "Cerrar Sesión" -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Bienvenido, <?php echo $_SESSION['nombre']; ?> <!-- Aquí se muestra el nombre -->
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <!-- Si el usuario NO ha iniciado sesión, mostrar "Iniciar Sesión" y "Registrarse" -->
                    <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">

