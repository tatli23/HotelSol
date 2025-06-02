<?php
include 'db_connection.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['nombre_usuario'] ?? '';
    $contraseña = $_POST['password'] ?? '';

    if (!empty($usuario) && !empty($contraseña)) {
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nombre_usuario = ?");
        $stmt->execute([$usuario]);
        $usuario_db = $stmt->fetch();

        if ($usuario_db && password_verify($contraseña, $usuario_db['password'])) {
            $_SESSION['user_id'] = $usuario_db['id_usuario'];
            $_SESSION['nombre_usuario'] = $usuario_db['nombre_usuario'];
            $_SESSION['rol'] = $usuario_db['rol'];

            // Redirigir según el rol
            switch ($usuario_db['rol']) {
                case 'cliente':
                    header("Location: Reserva.php");
                    break;
                case 'recepcionista':
                    header("Location: recepcionista.php");
                    break;
                case 'admin':
                    header("Location: administrador.php");
                    break;
                default:
                    header("Location: login.php");
            }
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Por favor, llena todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Sol - Iniciar Sesión</title>
    <link rel="stylesheet" href="estlogin.css">
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <h1 class="hotel-name">Hotel Sol</h1>
            <p class="hotel-tagline">Tu experiencia de lujo te espera</p>
            <div class="user-type-selector">
                <button class="user-type-btn active" onclick="showLogin('cliente')">Cliente</button>
                <button class="user-type-btn" onclick="showLogin('usuario')">Recepcionista</button>
                <button class="user-type-btn" onclick="showLogin('admin')">Administrador</button>
            </div>
        </div>

        <div class="right-panel">
            <?php if ($error): ?>
                <p style="color:red; text-align:center;"><?= $error ?></p>
            <?php endif; ?>

            <!-- Login Cliente -->
            <form class="login-form active" id="cliente-form" method="POST" action="login.php">
                <input type="hidden" name="rol" value="cliente">
                <h2 class="form-title">Bienvenido Cliente</h2>
                <p class="form-subtitle">Accede a tu cuenta para gestionar tus reservas</p>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" name="nombre_usuario" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                <button type="submit" class="login-btn">Iniciar Sesión</button>
            </form>

            <!-- Login Recepcionista -->
            <form class="login-form" id="usuario-form" method="POST" action="login.php">
                <input type="hidden" name="rol" value="recepcionista">
                <h2 class="form-title">Portal de Recepcionista</h2>
                <p class="form-subtitle">Acceso para personal del hotel</p>
                <div class="form-group">
                    <label class="form-label">ID de Recepcionista</label>
                    <input type="text" name="nombre_usuario" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                <button type="submit" class="login-btn">Acceder al Sistema</button>
            </form>

            <!-- Login Administrador -->
            <form class="login-form" id="admin-form" method="POST" action="login.php">
                <input type="hidden" name="rol" value="admin">
                <h2 class="form-title">Panel Administrativo</h2>
                <p class="form-subtitle">Acceso restringido, solo administradores</p>
                <div class="form-group">
                    <label class="form-label">Usuario Administrador</label>
                    <input type="text" name="nombre_usuario" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                <button type="submit" class="login-btn">Acceso Administrativo</button>
            </form>
        </div>
    </div>

    <script>
        function showLogin(type) {
            document.querySelectorAll('.user-type-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.login-form').forEach(form => form.classList.remove('active'));
            event.target.classList.add('active');
            document.getElementById(type + '-form').classList.add('active');
        }
    </script>
</body>
</html>
