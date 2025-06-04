<?php
include 'db_connection.php';
session_start();

// Inicializa el mensaje de error
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_usuario = trim($_POST['nombre_usuario'] ?? '');
    $input_password = trim($_POST['password'] ?? '');

    // Validación básica
    if (empty($input_usuario) || empty($input_password)) {
        $error = 'Usuario y contraseña son requeridos';
    } else {
        try{
        // Consulta el usuario y contraseña (hash)
        $stmt = $pdo->prepare("SELECT id_usuario, nombre_usuario, password FROM usuario WHERE nombre_usuario = ? LIMIT 1");
        $stmt->execute([$input_usuario]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

       if ($result && $input_password === $result['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $result['id_usuario'];
            $_SESSION['admin_username'] = $result['usuario'];

            header('Location: recepcionista.php');
            exit();
        } else {
            $error = 'Credenciales incorrectas. Intenta de nuevo.';
        }
        } catch (PDOException $e) {
            $error = 'Error en el sistema. Por favor intente más tarde.';
            // Registrar el error en un log
            error_log('Error en login administrador: ' . $e->getMessage());
        }
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
                <button class="user-type-btn active" onclick="showLogin('cliente')">
                    Cliente
                </button>
                <button class="user-type-btn" onclick="showLogin('recepcionista')">
                    Recepcionista
                </button>
                <button  class="user-type-btn" onclick="window.location.href='sesadmin.php'">
                    Administrador
                </button>
            </div>
        </div>

        <div class="right-panel">
            <?php if (!empty($error)) : ?>
                <div style="background-color: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Login Cliente -->
            <form class="login-form active" id="cliente-form" method="post" action="login.php">
                <input type="hidden" name="tipo_usuario" value="cliente">
                <h2 class="form-title">Bienvenido Cliente</h2>
                <p class="form-subtitle">Accede a tu cuenta para gestionar tus reservas</p>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" name="email" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-input" name="password" required>
                </div>
                
                <button type="submit" class="login-btn">Iniciar Sesión</button>
            </form>

            <!-- Login Recepcionista -->
            <form class="login-form" id="recepcionista-form" method="post" action="sesresep.php">
                <input type="hidden" name="tipo_usuario" value="recepcionista">
                <h2 class="form-title">Portal de Recepcionista</h2>
                <p class="form-subtitle">Acceso para personal del hotel</p>
                
                <div class="form-group">
                    <label class="form-label">ID de Recepcionista</label>
                    <input type="text" class="form-input" name="nombre_usuario" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-input" name="password" required>
                </div>
               
                <button type="submit" class="login-btn">Acceder al Sistema</button>
            </form>

            <!-- Login Administrador -->
            <form class="login-form" id="admin-form" method="post" action="sesadmin.php">
                <input type="hidden" name="tipo_usuario" value="admin">
                <h2 class="form-title">Panel Administrativo</h2>
                <p class="form-subtitle">Acceso restringido, solo administradores</p>
                
                <div class="form-group">
                    <label class="form-label">Usuario Administrador</label>
                    <input type="text" class="form-input" name="usuario_admin" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-input" name="password" required>
                </div>
                
                <button type="submit" class="login-btn">Acceso Administrativo</button>
            </form>
        </div>
    </div>

    <script>
        function showLogin(type) {
            // Remover clase active de todos los botones
            document.querySelectorAll('.user-type-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Remover clase active de todos los formularios
            document.querySelectorAll('.login-form').forEach(form => {
                form.classList.remove('active');
            });
            
            // Activar el botón seleccionado
            event.target.classList.add('active');
            
            // Mostrar el formulario correspondiente
            document.getElementById(type + '-form').classList.add('active');
        }

        // Efectos de hover para los inputs
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>