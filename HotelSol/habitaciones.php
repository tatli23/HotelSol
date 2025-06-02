<?php
include 'db_connection.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Sol</title>
  <link rel="stylesheet" href="conshabitaciones.css">
</head>

<body class="index">

<header>
  <h1>Hotel el Sol</h1>
</header>

<section>
  <div>
    <h2 class="menu"><strong>Consulta de Habitaciones </strong></h2>
  </div>
</section>

<div class="habitaciones-grid">
  <?php
  try {
      $conn = $pdo; // conexión establecida desde db_connection.php

      // Consulta completa incluyendo huésped si está disponible
      $stmt = $conn->query("SELECT numero, tipo, precio_noche AS precio, estado FROM habitacion ORDER BY numero ASC");
      $habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (empty($habitaciones)) {
          echo "<p>No se encontraron habitaciones en la base de datos.</p>";
      } else {
          foreach ($habitaciones as $row) {
              $numero = htmlspecialchars($row['numero']);
              $tipo = htmlspecialchars($row['tipo']);
              $precio = htmlspecialchars($row['precio']);
              $estado = htmlspecialchars($row['estado']);


              // Determinar clase CSS
              $estado_normalizado = strtolower(trim($estado));
              $colorClase = ($estado_normalizado === 'ocupada' || $estado_normalizado === 'ocupado') ? 'ocupada' : 'libre';

              echo "
              <div class='habitacion-card $colorClase'>
                  <h3>Habitación $numero</h3>
                  <p><strong>Tipo:</strong> $tipo</p>
                  <p><strong>Precio:</strong> \$$precio/noche</p>
                  <p><strong>Estado:</strong> <span class='estado'>$estado</span></p>";

              if ($colorClase === 'ocupada' && !empty($huesped)) {
                  echo "<p><strong>Huésped:</strong> $huesped</p>";
              }

              echo "</div>";
          }
      }

  } catch (PDOException $e) {
      echo "<p>Error al obtener las habitaciones: " . htmlspecialchars($e->getMessage()) . "</p>";
  }
  ?>
</div>

<!-- Sección de estadísticas -->
<div class="estadisticas">
  <?php
  try {
      // Estadísticas por estado
      $stmt_stats = $conn->query("
          SELECT estado, COUNT(*) as cantidad 
          FROM habitacion 
          GROUP BY estado
      ");
      $stats = $stmt_stats->fetchAll(PDO::FETCH_ASSOC);

      echo "<h3>Estadísticas de Habitaciones:</h3>";
      foreach ($stats as $stat) {
          $estado = htmlspecialchars($stat['estado']);
          $cantidad = htmlspecialchars($stat['cantidad']);
          echo "<p><strong>$estado:</strong> $cantidad habitaciones</p>";
      }

      // Total
      $stmt_total = $conn->query("SELECT COUNT(*) as total FROM habitacion");
      $total = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];
      echo "<p><strong>Total:</strong> $total habitaciones</p>";

  } catch (PDOException $e) {
      echo "<p>Error al obtener estadísticas: " . htmlspecialchars($e->getMessage()) . "</p>";
  }
  ?>
</div>

<div class="navigation">
  <button class="btn btn-secondary" onclick="window.location.href='administrador.php'">Regresar</button>
</div>

<footer>
  <p>&copy; <?php echo date("Y"); ?> Hotel Sol. Todos los derechos reservados.</p>
</footer>

</body>
</html>
