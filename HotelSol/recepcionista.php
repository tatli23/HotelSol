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
  <link rel="stylesheet" href="menuadmiEst.css">

</head>

<body class= 'index'>

  <header>
    <h1>Hotel el Sol</h1>
  </header>

  <nav>
    <a href="index.php">Inicio</a>
  </nav>

  <section class='hero'>
    <div >
      <h2> Hotel El Sol</h2>
      <p><strong>Sistema de Gestión Hotel el Sol</strong></p>
    </div>
  </section>

  <section>
    <div>
      <h2 class="menu"><strong>Menu principal </strong></h2>
      <p>Bienvenido</p>
    </div>
  </section>

     <div class="container">
         <div class="main-menu" id="mainMenu">
            <div class="menu-grid">
                <a class="menu-item" href="Habitaciones.php">
                    <h3>🔍 Consulta de Habitaciones</h3>
                    <p>Ver disponibilidad de habitaciones</p>
                </a>
                <a class="menu-item" href="registrohabitaciones.php">
                    <h3>📝 Registro de Habitación</h3>
                    <p>Registrar nuevos huéspedes</p>
                </a>
                <a class="menu-item" href="salidhuesped.php">
                    <h3>🚪 Salida de Huéspedes</h3>
                    <p>Procesar check-out</p>
                </a>
                <a class="menu-item" href="factura.php">
                    <h3>🧾 Imprimir Factura</h3>
                    <p>Generar facturas</p>
                </a>
                <a class="menu-item" href="index.php">
                    <h3>🚪 Salir</h3>
                    <p>Cerrar sesión</p>
                </a>
            </div>
        </div>
     </div>

       <footer>
    <p>&copy; <?php echo date("Y"); ?> Hotel Sol. Todos los derechos reservados.</p>
  </footer>
</body>
</html>




