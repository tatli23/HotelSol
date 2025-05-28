<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Sol - Registro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg,rgb(129, 200, 82) 0%,rgb(75, 162, 123) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            min-height: 650px;
            display: flex;
            position: relative;
        }

        .left-panel {
            flex: 1;
            background: linear-gradient(45deg,rgb(37, 73, 9),rgb(18, 77, 7));
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            animation: float 20s infinite linear;
            opacity: 0.3;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(-100px) rotate(360deg); }
        }

        .hotel-name {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 10px;
            z-index: 1;
            position: relative;
        }

        .hotel-tagline {
            font-size: 1.1em;
            opacity: 0.9;
            margin-bottom: 30px;
            z-index: 1;
            position: relative;
        }

        .welcome-text {
            font-size: 1.2em;
            margin-bottom: 20px;
            z-index: 1;
            position: relative;
            line-height: 1.4;
        }

        .login-link {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1em;
            backdrop-filter: blur(5px);
            text-decoration: none;
            display: inline-block;
            z-index: 1;
            position: relative;
        }

        .login-link:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .right-panel {
            flex: 1.2;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-height: 650px;
            overflow-y: auto;
        }

        .register-form {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-title {
            font-size: 2em;
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
            text-align: center;
        }

        .form-subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 1em;
            text-align: center;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            flex: 1;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: rgb(77, 126, 29);
            background: white;
            box-shadow: 0 0 0 3px rgba(14, 57, 11, 0.1);
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .form-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: rgb(77, 126, 29);
        }

        .form-checkbox label {
            color: #555;
            font-size: 0.9em;
            line-height: 1.4;
        }

        .form-checkbox a {
            color: rgb(28, 60, 10);
            text-decoration: none;
        }

        .form-checkbox a:hover {
            text-decoration: underline;
        }

        .register-btn {
            width: 100%;
            background: linear-gradient(45deg,rgb(24, 122, 26),rgb(22, 126, 27));
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(19, 141, 66, 0.3);
        }

        .register-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .login-redirect {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .login-redirect a {
            color: rgb(28, 60, 10);
            text-decoration: none;
            font-weight: 600;
        }

        .login-redirect a:hover {
            text-decoration: underline;
        }

        .password-strength {
            margin-top: 5px;
            font-size: 0.8em;
        }

        .strength-weak { color: #dc3545; }
        .strength-medium { color: #ffc107; }
        .strength-strong { color: #28a745; }

        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
        }

        .error-message {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                max-width: 400px;
                min-height: auto;
            }
            
            .left-panel {
                padding: 30px 20px;
            }
            
            .hotel-name {
                font-size: 2em;
            }
            
            .right-panel {
                max-height: none;
                overflow-y: visible;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
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
            </div>
            
            <a href="#" class="login-link" onclick="redirectToLogin()">
                ¿Ya tienes cuenta? Iniciar Sesión
            </a>
        </div>

        <div class="right-panel">
            <div class="success-message" id="success-message">
                ¡Registro exitoso! Te hemos enviado un email de confirmación.
            </div>
            
            <div class="error-message" id="error-message">
                Error en el registro. Por favor verifica los datos ingresados.
            </div>

            <form class="register-form" id="register-form">
                <h2 class="form-title">Crear Cuenta</h2>
                <p class="form-subtitle">Completa tus datos para comenzar a disfrutar nuestros servicios</p>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-input" name="nombre" placeholder="Tu nombre" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Apellidos *</label>
                        <input type="text" class="form-input" name="apellidos" placeholder="Tus apellidos" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-input" name="email" placeholder="cliente@ejemplo.com" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Teléfono *</label>
                        <input type="tel" class="form-input" name="telefono" placeholder="+52 123 456 7890" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-input" name="fecha_nacimiento">
                    </div>
                </div>
            
                
                <div class="form-group">
                    <label class="form-label">Contraseña *</label>
                    <input type="password" class="form-input" name="password" placeholder="Mínimo 8 caracteres" required minlength="8">
                    <div class="password-strength" id="password-strength"></div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Confirmar Contraseña *</label>
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
                
                <div class="login.phpt">
                    ¿Ya tienes una cuenta? <a href="#" onclick="redirectToLogin()">Iniciar sesión aquí</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Validación en tiempo real de contraseña
        const passwordInput = document.querySelector('input[name="password"]');
        const confirmPasswordInput = document.querySelector('input[name="confirm_password"]');
        const strengthIndicator = document.getElementById('password-strength');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            strengthIndicator.textContent = strength.text;
            strengthIndicator.className = `password-strength ${strength.class}`;
        });

        function checkPasswordStrength(password) {
            if (password.length < 6) {
                return { text: 'Contraseña muy débil', class: 'strength-weak' };
            }
            
            let score = 0;
            if (password.length >= 8) score++;
            if (/[a-z]/.test(password)) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;
            
            if (score < 3) {
                return { text: 'Contraseña débil', class: 'strength-weak' };
            } else if (score < 4) {
                return { text: 'Contraseña media', class: 'strength-medium' };
            } else {
                return { text: 'Contraseña fuerte', class: 'strength-strong' };
            }
        }

        // Validación de confirmación de contraseña
        confirmPasswordInput.addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                this.setCustomValidity('Las contraseñas no coinciden');
            } else {
                this.setCustomValidity('');
            }
        });

        // Manejar envío del formulario
        document.getElementById('register-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Validar que las contraseñas coincidan
            if (data.password !== data.confirm_password) {
                showError('Las contraseñas no coinciden');
                return;
            }
            
            // Validar términos y condiciones
            if (!data.terms) {
                showError('Debes aceptar los términos y condiciones');
                return;
            }
            
            // Simular registro
            const submitBtn = document.querySelector('.register-btn');
            const originalText = submitBtn.textContent;
            
            submitBtn.textContent = 'Creando cuenta...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                // Simular éxito
                showSuccess();
                this.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                
                console.log('Datos del registro:', data);
            }, 2000);
        });

        function showSuccess() {
            const successMsg = document.getElementById('success-message');
            const errorMsg = document.getElementById('error-message');
            
            errorMsg.style.display = 'none';
            successMsg.style.display = 'block';
            
            setTimeout(() => {
                successMsg.style.display = 'none';
            }, 5000);
        }

        function showError(message) {
            const errorMsg = document.getElementById('error-message');
            const successMsg = document.getElementById('success-message');
            
            errorMsg.textContent = message;
            successMsg.style.display = 'none';
            errorMsg.style.display = 'block';
            
            setTimeout(() => {
                errorMsg.style.display = 'none';
            }, 5000);
        }

        function redirectToLogin() {
            alert('Redirigiendo a la página de login...\n(Aquí pondrías: window.location.href = "login.html")');
        }

        function showTerms() {
            alert('Aquí se mostrarían los términos y condiciones del Hotel Sol');
        }

        function showPrivacy() {
            alert('Aquí se mostraría la política de privacidad del Hotel Sol');
        }

        // Efectos de hover para los inputs
        document.querySelectorAll('.form-input, .form-select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
                this.parentElement.style.transition = 'transform 0.3s ease';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Formatear teléfono automáticamente
        document.querySelector('input[name="telefono"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 10) {
                value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})/, '+$1 $2 $3 $4');
            }
            e.target.value = value;
        });
    </script>
</body>
</html>
