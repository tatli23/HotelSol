<?php
include 'db_connection.php';
session_start();

// Obtener habitaciones con reservas finalizadas (completadas)
$stmt = $pdo->prepare("
    SELECT h.numero AS habitacion_numero, h.tipo, r.fecha_inicio, r.fecha_fin, 
           c.nombre, c.apellidos, f.monto_total
    FROM habitacion h
    JOIN reserva r ON h.id_habitacion = r.id_habitacion
    JOIN cliente c ON r.id_cliente = c.id_cliente
    JOIN factura f ON f.id_reserva = r.id_reserva
    WHERE r.estado = 'completada' AND r.fecha_fin = CURDATE()
    ORDER BY h.numero
");
$stmt->execute();
$facturas_recientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Sol</title>
  <link rel="stylesheet" href="estfactura.css">

</head>

<body class="index">

    <header>
     <h1>Hotel el Sol</h1>
    </header>

    <section>
    <div>
      <h2 class="menu"><strong>Generar Factura </strong></h2>
    </div>
  </section>

<div class="module-screen" id="factura">
            <h2 style="margin-bottom: 2rem; color: #4a5568;">Generar Factura</h2>
            <div class="form-group">
                <label>Seleccionar Habitación (Check-out reciente):</label>
                <select id="facturaHabitacion" onchange="generateInvoice()">
                    <option value="">Seleccione habitación</option>
                </select>
            </div>
            <div id="invoiceContent" class="invoice-content" style="display: none;"></div>
            <div class="navigation">
                <button class="btn" onclick="downloadInvoice()">Descargar Factura (.txt)</button>
                <button class="btn btn-secondary"  onclick="window.location.href='administrador.php'">Regresar</button>
            </div>
        </div>  

        <script>
    const invoiceHistory = <?php echo json_encode(array_map(function ($row) {
      return [
        'room' => $row['habitacion_numero'],
        'roomType' => $row['tipo'],
        'checkIn' => date('d/m/Y', strtotime($row['fecha_inicio'])),
        'checkOut' => date('d/m/Y', strtotime($row['fecha_fin'])),
        'days' => (new DateTime($row['fecha_inicio']))->diff(new DateTime($row['fecha_fin']))->days + 1,
        'total' => number_format($row['monto_total'], 2, '.', ''),
        'guest' => [
          'name' => trim($row['nombre'] . ' ' . $row['apellidos']),
          'rfc' => $row['rfc'] ?? 'N/A'
        ]
      ];
    }, $facturas_recientes)); ?>;

    function loadInvoiceOptions() {
      const select = document.getElementById('facturaHabitacion');
      select.innerHTML = '<option value="">Seleccione habitación</option>';

      invoiceHistory.forEach((invoice, index) => {
        select.innerHTML += `<option value="${index}">Habitación ${invoice.room} - ${invoice.guest.name}</option>`;
      });
    }

    function generateInvoice() {
      const index = document.getElementById('facturaHabitacion').value;
      const contentDiv = document.getElementById('invoiceContent');

      if (index !== '') {
        const invoice = invoiceHistory[index];
        const subtotal = (invoice.total / 1.16).toFixed(2);
        const iva = (invoice.total - subtotal).toFixed(2);

        const invoiceText = `
========================================
         HOTEL "EL SOL"
    FACTURA ELECTRÓNICA
========================================

Fecha de Emisión: ${new Date().toLocaleDateString()}
Número de Factura: FAC-${String(Date.now()).slice(-6)}

DATOS DEL HUÉSPED:
Nombre: ${invoice.guest.name}
RFC: ${invoice.guest.rfc}

DETALLES DE LA ESTANCIA:
Habitación: ${invoice.room} (${invoice.roomType.toUpperCase()})
Fecha de Entrada: ${invoice.checkIn}
Fecha de Salida: ${invoice.checkOut}
Días de Alojamiento: ${invoice.days}

DESGLOSE DE COSTOS:
Subtotal: ${subtotal}
IVA (16%): ${iva}
TOTAL: ${invoice.total}

========================================
Gracias por su preferencia
Hotel "El Sol"
========================================
        `;

        contentDiv.textContent = invoiceText;
        contentDiv.style.display = 'block';
      } else {
        contentDiv.style.display = 'none';
      }
    }

    function downloadInvoice() {
      const content = document.getElementById('invoiceContent').textContent;
      const blob = new Blob([content], { type: 'text/plain' });
      const link = document.createElement('a');
      link.href = URL.createObjectURL(blob);
      link.download = 'factura.txt';
      link.click();
    }

    document.addEventListener('DOMContentLoaded', loadInvoiceOptions);
  </script>
 <footer>
    <p>&copy; <?php echo date("Y"); ?> Hotel Sol. Todos los derechos reservados.</p>
  </footer>

        
</body>
</html>