<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Sol - Iniciar Sesión</title>
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
            max-width: 900px;
            min-height: 600px;
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

        .user-type-selector {
            display: flex;
            flex-direction: column;
            gap: 15px;
            z-index: 1;
            position: relative;
        }

        .user-type-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1em;
            backdrop-filter: blur(5px);
        }

        .user-type-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .user-type-btn.active {
            background: rgba(255, 255, 255, 0.9);
            color:rgb(27, 144, 56);
            border-color: white;
        }

        .right-panel {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form {
            display: none;
        }

        .login-form.active {
            display: block;
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
        }

        .form-subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 1em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-input:focus {
            outline: none;
            border-color:rgb(77, 126, 29);
            background: white;
            box-shadow: 0 0 0 3px rgba(14, 57, 11, 0.97);
        }

        .login-btn {
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

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgb(19, 141, 66);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color:rgb(28, 60, 10);
            text-decoration: none;
            font-size: 0.9em;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                max-width: 400px;
            }
            
            .left-panel {
                padding: 30px 20px;
            }
            
            .hotel-name {
                font-size: 2em;
            }
            
            .user-type-selector {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .user-type-btn {
                flex: 1;
                min-width: 80px;
                padding: 10px 15px;
                font-size: 0.9em;
            }
        }
    </style>
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
                <button class="user-type-btn" onclick="showLogin('usuario')">
                    Usuario
                </button>
                <button class="user-type-btn" onclick="showLogin('admin')">
                    Administrador
                </button>
            </div>
        </div>

        <div class="right-panel">
            <!-- Login Cliente -->
            <form class="login-form active" id="cliente-form">
                <h2 class="form-title">Bienvenido Cliente</h2>
                <p class="form-subtitle">Accede a tu cuenta para gestionar tus reservas</p>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" placeholder="cliente@ejemplo.com" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-input" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="login-btn">Iniciar Sesión</button>
            </form>

            <!-- Login Usuario -->
            <form class="login-form" id="usuario-form">
                <h2 class="form-title">Portal de Usuario</h2>
                <p class="form-subtitle">Acceso para personal del hotel</p>
                
                <div class="form-group">
                    <label class="form-label">ID de Usuario</label>
                    <input type="text" class="form-input" placeholder="ID de empleado" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-input" placeholder="••••••••" required>
                </div>
               
                <button type="submit" class="login-btn">Acceder al Sistema</button>
                
            </form>

            <!-- Login Administrador -->
            <form class="login-form" id="admin-form">
                <h2 class="form-title">Panel Administrativo</h2>
                <p class="form-subtitle">Acceso restringido, solo administradores</p>
                
                <div class="form-group">
                    <label class="form-label">Usuario Administrador</label>
                    <input type="text" class="form-input" placeholder="admin_usuario" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-input" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="login-btn" href="admin.php">Acceso Administrativo</button>
            </form>
        </div>
    </div>

    <script>
        // Funciones para cambiar entre tipos de login
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

        // Manejar envío de formularios
        document.querySelectorAll('.login-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formType = this.id.replace('-form', '');
                const inputs = this.querySelectorAll('.form-input');
                let credentials = {};
                
                inputs.forEach(input => {
                    if (input.value.trim() !== '') {
                        credentials[input.previousElementSibling.textContent] = input.value;
                    }
                });
                
                // Simulación de login
                const button = this.querySelector('.login-btn');
                const originalText = button.textContent;
                
                button.textContent = 'Verificando...';
                button.disabled = true;
                
                setTimeout(() => {
                    alert(`Login ${formType} simulado correctamente!\nCredenciales: ${JSON.stringify(credentials, null, 2)}`);
                    button.textContent = originalText;
                    button.disabled = false;
                }, 2000);
            });
        });

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
