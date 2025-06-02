<?php
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recolectar datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $tipo_habitacion = $_POST['tipo_habitacion'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];
    $fecha_registro = date('Y-m-d');

    try {
        $pdo->beginTransaction();

        // Buscar habitación libre
        $sql_habitacion = "SELECT id_habitacion FROM habitacion 
                           WHERE tipo = ? AND estado = 'Libre' LIMIT 1";
        $stmt_hab = $pdo->prepare($sql_habitacion);
        $stmt_hab->execute([$tipo_habitacion]);
        $habitacion = $stmt_hab->fetch(PDO::FETCH_ASSOC);

        if (!$habitacion) {
            throw new Exception("No hay habitaciones disponibles del tipo seleccionado.");
        }

        $id_habitacion = $habitacion['id_habitacion'];

        // Insertar cliente
        $sql_cliente = "INSERT INTO cliente (nombre, apellidos, email, num_telefono, fecha_registro) 
                        VALUES (?, ?, ?, ?, ?)";
        $stmt_cliente = $pdo->prepare($sql_cliente);
        $stmt_cliente->execute([$nombre, $apellido, $email, $telefono, $fecha_registro]);
        $id_cliente = $pdo->lastInsertId();

        // Insertar reserva
        $sql_reserva = "INSERT INTO reserva (id_cliente, id_habitacion, fecha_inicio, fecha_fin, estado)
                        VALUES (?, ?, ?, ?, 'confirmada')";
        $stmt_reserva = $pdo->prepare($sql_reserva);
        $stmt_reserva->execute([$id_cliente, $id_habitacion, $fecha_entrada, $fecha_salida]);
        $id_reserva = $pdo->lastInsertId();

        // Actualizar habitación
        $sql_actualiza = "UPDATE habitacion 
                          SET estado = 'ocupada', 
                              fecha_inicio = ?, 
                              fecha_fin = ?, 
                              id_reserva = ? 
                          WHERE id_habitacion = ?";
        $stmt_actualiza = $pdo->prepare($sql_actualiza);
        $stmt_actualiza->execute([$fecha_entrada, $fecha_salida, $id_reserva, $id_habitacion]);

        $pdo->commit();

        echo "<script>alert('✅ Reserva realizada con éxito.'); window.location.href = 'consulta_reservas.php';</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('❌ Error al realizar la reserva: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>




<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Sol</title>
  <link rel="stylesheet" href="reser.css">
</head>
<body class= 'index'>

  <header>
    <h1>Hotel el Sol</h1>
  </header>

    <nav>
   <!-- <a href="index.php">Inicio</a>-->
  </nav>

  <section class='hero'>
    <div >
      <h2>Bienvenido al Hotel el Sol</h2>
      <p><strong>Has tu reserva para disfrutar de nuesros servicios </p>
    </div>
  </section>

  
<body>
    <div class="container">
        <div class="header">
            <h1>Hotel El Sol</h1>
            <p>Sistema de Reservaciones en Línea</p>
        </div>
        
        <div class="form-container">
            <?php if (isset($mensaje_exito)): ?>
                <div class="alert success">
                    <?= $mensaje_exito ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert error">
                    ❌ <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">Nombre </label>
                        <input type="text" id="nombre" name="nombre" required 
                               value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido </label>
                        <input type="text" id="apellido" name="apellido" required 
                               value="<?= isset($_POST['apellido']) ? htmlspecialchars($_POST['apellido']) : '' ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email </label>
                        <input type="email" id="email" name="email" required 
                               value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono </label>
                        <input type="tel" id="telefono" name="telefono" required 
                               value="<?= isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : '' ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="fecha_entrada">Fecha de Entrada </label>
                        <input type="date" id="fecha_entrada" name="fecha_entrada" required 
                               min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                               value="<?= isset($_POST['fecha_entrada']) ? $_POST['fecha_entrada'] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="fecha_salida">Fecha de Salida </label>
                        <input type="date" id="fecha_salida" name="fecha_salida" required 
                               min="<?= date('Y-m-d', strtotime('+2 days')) ?>"
                               value="<?= isset($_POST['fecha_salida']) ? $_POST['fecha_salida'] : '' ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tipo_habitacion">Tipo de Habitación </label>
                        <select id="tipo_habitacion" name="tipo_habitacion" required>
    <option value="">Selecciona una habitación</option>
    <option value="sencilla" <?= (isset($_POST['tipo_habitacion']) && $_POST['tipo_habitacion'] == 'sencilla') ? 'selected' : '' ?>>
        Sencilla - $500/noche
    </option>
    <option value="doble" <?= (isset($_POST['tipo_habitacion']) && $_POST['tipo_habitacion'] == 'doble') ? 'selected' : '' ?>>
        Doble - $800/noche
    </option>
    <option value="suite" <?= (isset($_POST['tipo_habitacion']) && $_POST['tipo_habitacion'] == 'suite') ? 'selected' : '' ?>>
        Suite - $1500/noche
    </option>
</select>

                    </div>
                    <div class="form-group">
                        <label for="num_huespedes">Número de Huéspedes</label>
                         <input type="number" name="num_adultos" id="numAdultos" min="1" value="1" onchange="calculateTotal();">
                    </div>
                </div>
                
                
                <button type="submit" class="btn">
                     Confirmar Reservación
                </button>
                <button type="button" class="btn " onclick="window.location.href='index.php'"> Regresar</button>
            </form>
        </div>
    </div>

    <script>
        // Actualizar fecha mínima de salida cuando cambia la fecha de entrada
        document.getElementById('fecha_registro').addEventListener('change', function() {
            const fechaEregistro = new Date(this.value);
            fechaEntrada.setDate(fecharegistro.getDate() + 1);
            document.getElementById('fecha_salida').min = fecharegistro.toISOString().split('T')[0];

    function calculateTotal() {
      const adults = parseInt(document.getElementById('numAdultos').value) || 0;
      let basePrice = 0;
    }

        });
    </script>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> Hotel Sol. Todos los derechos reservados.</p>
  </footer>

</body>
</html>