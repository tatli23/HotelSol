<?php 
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST['numero'];
    $precio_noche = $_POST['precio_noche'];
    $tipo = $_POST['tipo'];
    $dias = intval($_POST['dias']);
    $fecha_inicio = date('Y-m-d');
    $fecha_fin = date('Y-m-d', strtotime("+$dias days"));
    $estado = 'ocupada';

    $nombre_huesped = $_POST['nombre_huesped'];

    try {
        // Buscar la habitación
        $stmtHab = $pdo->prepare("SELECT * FROM habitacion WHERE numero = :numero AND tipo = :tipo");
        $stmtHab->execute([':numero' => $numero, ':tipo' => $tipo]);
        $habitacion = $stmtHab->fetch(PDO::FETCH_ASSOC);

        if (!$habitacion) {
            throw new Exception("La habitación no fue encontrada.");
        }

        $id_habitacion = $habitacion['id_habitacion'];

        // Verificar disponibilidad en esas fechas
        $stmtValida = $pdo->prepare("
            SELECT * FROM reserva
            WHERE id_habitacion = :id_habitacion
              AND estado = 'activa'
              AND (
                (fecha_inicio <= :fecha_fin AND fecha_fin >= :fecha_inicio)
              )
        ");
        $stmtValida->execute([
            ':id_habitacion' => $id_habitacion,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin' => $fecha_fin
        ]);

        if ($stmtValida->fetch()) {
            throw new Exception("La habitación no está disponible en las fechas seleccionadas.");
        }

        $pdo->beginTransaction();

        // Buscar o insertar cliente por nombre
        $stmtCliente = $pdo->prepare("SELECT id_cliente FROM cliente WHERE nombre = :nombre");
        $stmtCliente->execute([':nombre' => $nombre_huesped]);
        $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            $stmtInsert = $pdo->prepare("INSERT INTO cliente (nombre, fecha_registro) VALUES (:nombre, :fecha)");
            $stmtInsert->execute([
                ':nombre' => $nombre_huesped,
                ':fecha' => $fecha_inicio
            ]);
            $id_cliente = $pdo->lastInsertId();
        } else {
            $id_cliente = $cliente['id_cliente'];
        }

        // Insertar reserva
        $stmtReserva = $pdo->prepare("INSERT INTO reserva (id_cliente, id_habitacion, fecha_inicio, fecha_fin, estado) VALUES (:id_cliente, :id_habitacion, :fecha_inicio, :fecha_fin, 'activa')");
        $stmtReserva->execute([
            ':id_cliente' => $id_cliente,
            ':id_habitacion' => $id_habitacion,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin' => $fecha_fin
        ]);
        $id_reserva = $pdo->lastInsertId();

        // Actualizar habitación
        $stmtUpdate = $pdo->prepare("UPDATE habitacion SET estado = :estado, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, id_reserva = :id_reserva WHERE id_habitacion = :id_habitacion");
        $stmtUpdate->execute([
            ':estado' => $estado,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin' => $fecha_fin,
            ':id_reserva' => $id_reserva,
            ':id_habitacion' => $id_habitacion
        ]);

        $pdo->commit();

        echo "<div style='color:green;'>✅ Reserva realizada y habitación actualizada correctamente.</div>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<div style='color:red;'>❌ Error: " . $e->getMessage() . "</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Hotel el Sol</title>
  <link rel="stylesheet" href="reghab.css">
</head>
<body class="index">
  <header>
    <h1>Hotel el Sol</h1>
  </header>

  <section>
    <div>
      <h2 class="menu"><strong>Registro de Habitaciones</strong></h2>
    </div>
  </section>

  <form class="Reg-habitacion" method="POST">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
      <div>
        <div class="form-group">
          <label>Tipo de Habitación:</label>
          <select name="tipo" id="tipoHabitacion" onchange="updateAvailableRooms(); calculateTotal();">
            <option value="">Seleccione tipo</option>
            <option value="sencilla">Sencilla - $500/noche</option>
            <option value="doble">Doble - $1,000/noche</option>
            <option value="suite">Suite - $1,500/noche</option>
          </select>
        </div>
        <div class="form-group">
          <label>Número de Habitación:</label>
          <select name="numero" id="numeroHabitacion">
            <option value="">Seleccione habitación</option>
          </select>
        </div>
        <div class="form-group">
          <label>Nombre del Huésped:</label>
          <input type="text" name="nombre_huesped" id="nombreHuesped" required>
        </div>
        
      </div>
      <div>
        <div class="form-group">
          <label>Número de Adultos:</label>
          <input type="number" name="num_adultos" id="numAdultos" min="1" value="1" onchange="calculateTotal();">
        </div>
        <div class="form-group">
          <label>Número de Niños:</label>
          <input type="number" name="num_ninos" id="numNinos" min="0" value="0">
        </div>
        <div class="form-group">
          <label>Días de Alojamiento:</label>
          <input type="number" name="dias" id="diasAlojamiento" min="1" value="1" onchange="calculateTotal();">
        </div>
        <div class="form-group">
          <label>Total a Pagar (con IVA 16%):</label>
          <input type="text" id="totalPagar" readonly style="background: #f0f0f0;">
        </div>
        <input type="hidden" name="precio_noche" id="precio_noche">
      </div>
    </div>
    <div class="navigation">
      <button type="submit" class="btn">Registrar Habitación</button>
      <button class="btn btn-secondary" type="button" onclick="window.location.href='administrador.php'">Regresar</button>
    </div>
  </form>

  <script>
    const rooms = {
      sencilla: Array.from({ length: 10 }, (_, i) => ({ number: i + 1, status: 'libre' })),
      doble: Array.from({ length: 10 }, (_, i) => ({ number: i + 10, status: 'libre' })),
      suite: Array.from({ length: 10 }, (_, i) => ({ number: i + 20, status: 'libre' })),
    };

    function updateAvailableRooms() {
      const type = document.getElementById('tipoHabitacion').value;
      const select = document.getElementById('numeroHabitacion');
      select.innerHTML = '<option value="">Seleccione habitación</option>';

      if (type && rooms[type]) {
        rooms[type].forEach(room => {
          if (room.status === 'libre') {
            select.innerHTML += `<option value="${room.number}">${room.number}</option>`;
          }
        });
      }
    }

    function calculateTotal() {
      const type = document.getElementById('tipoHabitacion').value;
      const days = parseInt(document.getElementById('diasAlojamiento').value) || 0;
      const adults = parseInt(document.getElementById('numAdultos').value) || 0;
      let basePrice = 0;

      switch(type) {
        case 'sencilla': basePrice = 500; break;
        case 'doble': basePrice = 1000; break;
        case 'suite': basePrice = 1500; break;
      }

      document.getElementById('precio_noche').value = basePrice;

      let extraAdults = 0;
      if (type === 'doble' && adults > 2) extraAdults = adults - 2;
      if (type === 'suite' && adults > 2) extraAdults = adults - 2;

      const extraCost = extraAdults * (basePrice / 2);
      const subtotal = (basePrice + extraCost) * days;
      const total = subtotal * 1.16;

      document.getElementById('totalPagar').value = `$${total.toFixed(2)}`;
    }
  </script>
</body>
</html>
