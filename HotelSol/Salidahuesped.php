<?php
include 'db_connection.php';
session_start();

// Procesar la salida si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['procesar_salida'])) {
    $habitacion_numero = $_POST['habitacion_salida'] ?? '';
    $llaves_entregadas = isset($_POST['llaves_entregadas']) ? 1 : 0;

    if (empty($habitacion_numero)) {
        $error_message = "Seleccione una habitación";
    } elseif (!$llaves_entregadas) {
        $error_message = "Debe confirmar que el huésped entregó las llaves";
    } else {
        $stmt = $pdo->prepare("
            SELECT h.numero, h.tipo, h.precio_noche, h.fecha_inicio,
                   c.nombre, c.apellidos, r.id_reserva, r.id_cliente
            FROM habitacion h
            JOIN reserva r ON h.id_reserva = r.id_reserva
            JOIN cliente c ON r.id_cliente = c.id_cliente
            WHERE h.numero = ? AND h.estado = 'ocupada'
        ");
        $stmt->execute([$habitacion_numero]);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($datos) {
            try {
                $pdo->beginTransaction();

                $fecha_inicio = new DateTime($datos['fecha_inicio']);
                $fecha_fin = new DateTime();
                $dias = $fecha_inicio->diff($fecha_fin)->days + 1;
                $subtotal = $datos['precio_noche'] * $dias;
                $iva = $subtotal * 0.16;
                $total = $subtotal + $iva;

                // Actualizar reserva
                $pdo->prepare("
                    UPDATE reserva 
                    SET fecha_fin = CURDATE(), estado = 'completada' 
                    WHERE id_reserva = ?
                ")->execute([$datos['id_reserva']]);

                // Liberar habitación
                $pdo->prepare("
                    UPDATE habitacion 
                    SET estado = 'Libre', id_reserva = NULL, fecha_inicio = NULL, fecha_fin = NULL 
                    WHERE numero = ?
                ")->execute([$habitacion_numero]);

                // Insertar factura
                $pdo->prepare("
                    INSERT INTO factura (id_cliente, id_reserva, fecha_emision, monto_total) 
                    VALUES (?, ?, CURDATE(), ?)
                ")->execute([
                    $datos['id_cliente'],
                    $datos['id_reserva'],
                    $total
                ]);

                $pdo->commit();
                $success_message = "Salida procesada exitosamente. Factura generada por $" . number_format($total, 2);
            } catch (Exception $e) {
                $pdo->rollBack();
                $error_message = "Error al procesar la salida: " . $e->getMessage();
            }
        } else {
            $error_message = "No se encontró una reserva activa para esta habitación";
        }
    }
}


// Obtener habitaciones ocupadas con reservas activas
$stmt = $pdo->prepare("
    SELECT h.numero, h.tipo, h.precio_noche, h.fecha_inicio,
           c.nombre, c.apellidos, r.id_reserva
    FROM habitacion h
    JOIN reserva r ON h.id_reserva = r.id_reserva
    JOIN cliente c ON r.id_cliente = c.id_cliente
    WHERE h.estado = 'ocupada' 
    ORDER BY h.numero
");
$stmt->execute();
$habitaciones_ocupadas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// AJAX para obtener datos del huésped
if (isset($_GET['get_guest_info']) && isset($_GET['habitacion'])) {
    $habitacion_numero = $_GET['habitacion'];
    
    $stmt = $pdo->prepare("
        SELECT h.*, c.nombre, c.apellidos, h.fecha_inicio
        FROM habitacion h
        JOIN reserva r ON h.id_reserva = r.id_reserva
        JOIN cliente c ON r.id_cliente = c.id_cliente
        WHERE h.numero = ? AND h.estado = 'ocupada' 
    ");
    $stmt->execute([$habitacion_numero]);
    $info = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($info) {
        $fecha_inicio = new DateTime($info['fecha_inicio']);
        $fecha_actual = new DateTime();
        $dias = $fecha_inicio->diff($fecha_actual)->days + 1;
        $subtotal = $info['precio_noche'] * $dias;
        $total = $subtotal * 1.16;

        $nombre_completo = trim($info['nombre'] . ' ' . $info['apellidos']);

        $response = [
            'nombre' => $nombre_completo,
            'dias' => $dias,
            'fecha_entrada' => $fecha_inicio->format('d/m/Y'),
            'total' => number_format($total, 2),
            'subtotal' => number_format($subtotal, 2),
            'precio_noche' => number_format($info['precio_noche'], 2)
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Sol</title>
  <link rel="stylesheet" href="salidhues.css">

</head>

<body class="index">

    <header>
     <h1>Hotel el Sol</h1>
    </header>

    <section>
    <div>
      <h2 class="menu"><strong>Salida de Huéspedes </strong></h2>
    </div>
  </section>

 <div class="module-screen" id="salidaHuespedes">
        <form method="POST" action="">
            <!-- Mostrar mensajes -->
            <?php if (isset($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            
            <?php if (isset($success_message)): ?>
                <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>

            <div class="form-group">
                <label for="habitacion_salida">Número de Habitación:</label>
                <select id="habitacion_salida" name="habitacion_salida" onchange="loadGuestInfo()" required>
                    <option value="">Seleccione habitación ocupada</option>
                    <?php foreach ($habitaciones_ocupadas as $habitacion): ?>
                        <option value="<?php echo $habitacion['numero']; ?>">
                            Habitación <?php echo $habitacion['numero']; ?> (<?php echo ucfirst($habitacion['tipo']); ?>) - 
                            <?php echo htmlspecialchars(trim($habitacion['nombre'] . ' ' . $habitacion['apellidos'])); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="guestInfo" class="guest-info">
                <h4>📋 Información del Huésped:</h4>
                <div class="guest-details">
                    <p><strong> Nombre:</strong> <span id="guestName"></span></p>
                    <p><strong> Días de alojamiento:</strong> <span id="guestDays"></span></p>
                    <p><strong> Fecha de entrada:</strong> <span id="checkInDate"></span></p>
                    <p><strong> Precio por noche:</strong> $<span id="pricePerNight"></span></p>
                </div>
                
                <div class="total-breakdown">
                    <p><strong>Subtotal:</strong> $<span id="subtotal"></span></p>
                    <p><strong>IVA (16%):</strong> $<span id="iva"></span></p>
                    <p style="font-size: 1.2em; color: #28a745;"><strong>💵 Total a pagar:</strong> $<span id="totalPaid"></span></p>
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="llaves_entregadas" name="llaves_entregadas" required>
                    <label for="llaves_entregadas"> El huésped entregó las llaves</label>
                </div>
            </div>

            <div class="navigation">
                <button type="submit" name="procesar_salida" class="btn btn-primary"> Procesar Salida</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='administrador.php'"> Regresar</button>
            </div>
        </form>
        </div>
       <script>
        function loadGuestInfo() {
            const habitacionSelect = document.getElementById('habitacion_salida');
            const guestInfo = document.getElementById('guestInfo');
            const habitacionNumero = habitacionSelect.value;
            
            if (habitacionNumero) {
                // Hacer petición AJAX para obtener información del huésped
                fetch(`?get_guest_info=1&habitacion=${habitacionNumero}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('guestName').textContent = data.nombre;
                        document.getElementById('guestDays').textContent = data.dias + (data.dias === 1 ? ' día' : ' días');
                        document.getElementById('checkInDate').textContent = data.fecha_entrada;
                        document.getElementById('pricePerNight').textContent = data.precio_noche;
                        document.getElementById('subtotal').textContent = data.subtotal;
                        
                        // Calcular IVA
                        const subtotalNum = parseFloat(data.subtotal.replace(',', ''));
                        const ivaAmount = subtotalNum * 0.16;
                        document.getElementById('iva').textContent = ivaAmount.toFixed(2);
                        
                        document.getElementById('totalPaid').textContent = data.total;
                        
                        guestInfo.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        guestInfo.style.display = 'none';
                        alert('Error al cargar la información del huésped');
                    });
            } else {
                guestInfo.style.display = 'none';
            }
        }

        // Limpiar formulario después de envío exitoso
        <?php if (isset($success_message)): ?>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('habitacion_salida').value = '';
                document.getElementById('guestInfo').style.display = 'none';
                document.getElementById('llaves_entregadas').checked = false;
                
                // Recargar la página después de 3 segundos para actualizar la lista
                setTimeout(function() {
                    window.location.reload();
                }, 3000);
            });
        <?php endif; ?>

        // Validación adicional en el cliente
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const habitacion = document.getElementById('habitacion_salida').value;
                const llaves = document.getElementById('llaves_entregadas').checked;
                
                if (!habitacion) {
                    e.preventDefault();
                    alert('Por favor seleccione una habitación');
                    return;
                }
                
                if (!llaves) {
                    e.preventDefault();
                    alert('Debe confirmar que el huésped entregó las llaves');
                    return;
                }
                
                // Confirmación final
                const confirmacion = confirm('¿Está seguro de procesar la salida de esta habitación?');
                if (!confirmacion) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>