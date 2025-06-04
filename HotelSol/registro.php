<?php
include 'db_connection.php';
session_start();

$success = false;
$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = strtolower(trim($_POST['email']));
    $telefono = trim($_POST['telefono']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Debug: Verificar qué datos llegan
    $debug_info[] = "Datos recibidos: " . json_encode([
        'nombre' => $nombre,
        'apellidos' => $apellidos, 
        'email' => $email,
        'telefono' => $telefono,
        'fecha_nacimiento' => $fecha_nacimiento
    ]);

    // Validaciones
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($telefono) || empty($fecha_nacimiento) || empty($password) || empty($confirm_password)) {
        $error = "Por favor, completa todos los campos obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El formato del correo no es válido.";
    } elseif ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } elseif (strlen($password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres.";
    } else {
        try {
            // Debug: Verificar conexión a BD
            $debug_info[] = "Conexión a BD establecida correctamente";
            
            // Verificar que el correo o teléfono no estén registrados
            $query = "SELECT id_cliente FROM cliente WHERE email = ? OR num_telefono = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$email, $telefono]);

            $debug_info[] = "Query de verificación ejecutada. Filas encontradas: " . $stmt->rowCount();

            if ($stmt->rowCount() > 0) {
                $error = "Ya existe una cuenta registrada con este correo o teléfono.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Debug: Verificar hash de contraseña
                $debug_info[] = "Contraseña hasheada correctamente";
                
                $insert = "INSERT INTO cliente (nombre, apellidos, email, num_telefono, fecha_nacimiento, password) 
                           VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($insert);
                
                // Debug: Preparar statement
                $debug_info[] = "Statement preparado correctamente";
                
                $result = $stmt->execute([
                    $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $hashed_password
                ]);

                // Debug: Verificar resultado de ejecución
                $debug_info[] = "Resultado de execute(): " . ($result ? 'true' : 'false');
                $debug_info[] = "Filas afectadas: " . $stmt->rowCount();
                $debug_info[] = "Último ID insertado: " . $pdo->lastInsertId();

                if ($result && $stmt->rowCount() > 0) {
                    $success = true;
                    $debug_info[] = "¡Registro exitoso!";
                } else {
                    $error = "Error al registrar usuario. No se insertaron datos.";
                    $debug_info[] = "ERROR: No se insertaron filas en la base de datos";
                }
            }
        } catch (PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
            $debug_info[] = "ERROR PDO: " . $e->getMessage();
            $debug_info[] = "Código de error: " . $e->getCode();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Hotel Sol - Registro</title>
    <link rel="stylesheet" href="registro.css"/>
    <style>
        .debug-info {
            background: #f0f0f0;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
        }
        .debug-info h4 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .debug-item {
            margin: 5px 0;
            color: #666;
        }
    </style>
</head>

<body>


    <div class="container">
        <div class="left-panel">
            <h1 class="hotel-name">Hotel Sol</h1>
            <p class="hotel-tagline">Tu experiencia de lujo te espera</p>
            <div class="welcome-text">
                ¡Únete a nuestra familia de huéspedes distinguidos y disfruta de beneficios exclusivos!
            </div >
            <a href="login.php" class="login-link">¿Ya tienes cuenta? Iniciar Sesión</a>
            

        </div>

        <div class="right-panel">
            <form class="register-form" method="POST" id="register-form">
                <h2 class="form-title">Crear Cuenta</h2>
                <p class="form-subtitle">Completa tus datos para comenzar a disfrutar nuestros servicios</p>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-input" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Apellidos</label>
                        <input type="text" class="form-input" name="apellidos" value="<?= htmlspecialchars($_POST['apellidos'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" class="form-input" name="telefono" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-input" name="fecha_nacimiento" value="<?= htmlspecialchars($_POST['fecha_nacimiento'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-input" name="password" placeholder="Mínimo 8 caracteres" required minlength="8">
                    <div class="password-strength" id="password-strength"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-input" name="confirm_password" placeholder="Repite tu contraseña" required>
                </div>

                <div class="form-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        Acepto los <a href="#" onclick="showTerms()">términos y condiciones</a> 
                        y la <a href="#" onclick="showPrivacy()">política de privacidad</a> *
                    </label>
                </div>

                <button type="submit" class="register-btn">Crear Cuenta</button>
                <div class="login-link">
                    ¿Ya tienes una cuenta? <a href="login.php" onclick="redirectToLogin()">Iniciar sesión aquí</a>
                </div>
            </form>
        </div>
    </div>

<script>
    const passwordInput = document.querySelector('input[name="password"]');
    const confirmPasswordInput = document.querySelector('input[name="confirm_password"]');
    const strengthIndicator = document.getElementById('password-strength');

    passwordInput.addEventListener('input', function () {
        const strength = checkPasswordStrength(this.value);
        strengthIndicator.textContent = strength.text;
        strengthIndicator.className = `password-strength ${strength.class}`;
    });

    function checkPasswordStrength(password) {
        if (password.length < 6) return { text: 'Muy débil', class: 'strength-weak' };
        let score = 0;
        if (password.length >= 8) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/\d/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;

        if (score <= 2) return { text: 'Débil', class: 'strength-weak' };
        if (score <= 3) return { text: 'Media', class: 'strength-medium' };
        return { text: 'Fuerte', class: 'strength-strong' };
    }

    confirmPasswordInput.addEventListener('input', function () {
        this.setCustomValidity(this.value !== passwordInput.value ? 'Las contraseñas no coinciden' : '');
    });

    function redirectToLogin() {
        window.location.href = 'login.php';
    }

    function showTerms() {
        alert('Aquí se mostrarían los términos y condiciones del Hotel Sol');
    }

    function showPrivacy() {
        alert('Aquí se mostraría la política de privacidad del Hotel Sol');
    }

    document.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.style.transform = 'translateY(-2px)';
            input.parentElement.style.transition = 'transform 0.3s ease';
        });
        input.addEventListener('blur', () => {
            input.parentElement.style.transform = 'translateY(0)';
        });
    });

    document.querySelector('input[name="telefono"]').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 10) {
            value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})/, '+$1 $2 $3 $4');
        }
        e.target.value = value;
    });
</script>

</body>
</html>