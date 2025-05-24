<?php
// Procesar el formulario solo si se envió por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = "localhost";
    $usuario = "root";
    $contrasena = ""; 
    $basedatos = "hotel";

    $conn = new mysqli($host, $usuario, $contrasena, $basedatos);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $habitacion = isset($_POST['habitacion']) ? $_POST['habitacion'] : '';
    $personas = isset($_POST['personas']) ? intval($_POST['personas']) : 0;
    $noches = isset($_POST['noches']) ? intval($_POST['noches']) : 0;
    $servicios = isset($_POST['servicios']) ? $_POST['servicios'] : '';

    if (is_array($servicios)) {
        $servicios = implode(", ", $servicios);
    }

    if (empty($habitacion) || $personas <= 0 || $noches <= 0) {
        echo "<script>alert('Datos incompletos o inválidos.');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO reservas (habitacion, personas, noches, servicios) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siis", $habitacion, $personas, $noches, $servicios);

        if ($stmt->execute()) {
            $reserva_id = $conn->insert_id;
            // Mostramos el mensaje de éxito con emojis y botones
            $mensaje_exito = '
            <div id="mensaje-exito" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(152, 114, 145, 0.8); z-index: 1000; display: flex; justify-content: center; align-items: center;">
                <div style="background: white; padding: 30px; border-radius: 10px; text-align: center; max-width: 500px; width: 90%;">
                    <h2 style="color: #17582bd3; margin-bottom: 20px;">¡Listo!</h2>
                    <p style="font-size: 18px; margin-bottom: 30px;">✅ Has hecho tu reserva exitosamente</p>
                    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px;">
                        <a href="ver_ticket.php" style="background: #17582bd3; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                            🖨️ Imprimir Ticket
                        </a>
                        <a href="inicio.php" style="background: #FF7F50; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-size: 16px; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                            🏠 Volver a Inicio
                        </a>
                    </div>
                </div>
            </div>
            <script>
                // Ocultar el formulario después de enviarlo
                document.querySelector(".formulario-reserva").style.display = "none";
            </script>
            ';
            echo $mensaje_exito;
        } else {
            echo "<script>alert('Error al realizar la reserva: " . addslashes($stmt->error) . "');</script>";
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Sol</title>
  <link rel="stylesheet" href="estiloosInd.css">
</head>
<body class= 'index'>

  <header>
    <h1>Hotel el Sol</h1>
  </header>

  <nav>
    <a href="index.php">Inicio</a>
    <a href="Reserva.php">Reservar</a>
    <a href="habitaciones">Iniciar Sesion</a>
    <!--<a href="contacto">Contacto</a>-->
  </nav>

  <section class='hero'>
    <div >
      <h2>Bienvenido al Hotel el Sol</h2>
      <p><strong>Tu refugio perfecto bajo el sol</strong></p>
    </div>
  </section>
</body>
</html>