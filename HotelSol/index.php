

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
    <a href="registro.php">Iniciar Sesion</a>
   
  </nav>

  <section class='hero'>
    <div >
      <h2>Bienvenido al Hotel el Sol</h2>
      <p><strong>Tu refugio perfecto bajo el sol</strong></p>
    </div>
  </section>
    
  <section>
    <div >
      <h2 class="serv"><strong>Servicios</strong></h2>
    </div>
  </section>

 <section class="sec1" >
    <img src="https://c.otcdn.com/imglib/hotelfotos/8/221/resort-grand-velas-riviera-maya-all-inclusive-playa-del-carmen-20240504150800647000.jpg"class="habitacion-img">
    <div>
      <h2>Habitaciones</h2>
      <p>Contamos con habitaciones individuales, dobles y suites con vista al mar. Todas incluyen aire acondicionado, WiFi y servicio a la habitación.</p>
    </div>
  </section>

  <section class="sec1">
    <img src="https://images.trvl-media.com/lodging/22000000/21190000/21182700/21182618/8ce62ce0.jpg?impolicy=resizecrop&rw=575&rh=575&ra=fill" class="alberca-img">
    <div>
      <h2>Alberca</h2>
      <p>Disfruta de nuestra alberca al aire libre con vista al mar, ideal para relajarte bajo el sol o refrescarte en cualquier momento del día. Contamos con área de camastros, bar junto a la alberca y servicio de snacks.</p>
    </div>
  </section>

  <section class="sec1">
    <img src="https://dea154aeb528bee620f5-799733fd03b9298a9f65fee6178f3d08.ssl.cf1.rackcdn.com/pix_1_0_0_55bb87d6df71a.jpg"class="restaurante-img">
    <div>
      <h2>Restaraunte </h2>
      <p>Nuestro restaurante ofrece una experiencia culinaria única con platillos locales e internacionales preparados con ingredientes frescos. Contamos con buffet diario para desayuno, comida y cena, además de servicio a la carta y opción de servicio a la habitación.</p>
    </div>
  </section>

  <section class="sec1">
    <img src="https://thearchitecturedesigns.com/wp-content/uploads/2020/08/spa-room-design-3.jpg"class="spa-img">
    <div>
      <h2>Spa</h2>
      <p>Relájate en nuestro spa con tratamientos diseñados para renovar cuerpo y mente. Ofrecemos masajes, faciales, aromaterapia y acceso a sauna y jacuzzi en un ambiente de total tranquilidad.</p>
    </div>
  </section>

  <section class="sec1">
    <img src="https://cdn.getyourguide.com/img/tour/5dd3230c0a1b5.jpeg/148.jpg"class="actividades-img">
    <div>
      <h2>Actividades</h2>
      <p>Contamos con un programa diario de actividades para todas las edades: yoga frente al mar, torneos deportivos, clases de cocina, caminatas guiadas y noches temáticas para que disfrutes cada momento.

</p>
    </div>
  </section>

<!--Apartado de servicios-->
  <section class="galeria-container">
    <h2><strong>Galeria</strong></h2>
    <div class="galeria-cards">
    <!--habitacones-->
    <div class="card">
      <img src="https://c.otcdn.com/imglib/hotelfotos/8/221/resort-grand-velas-riviera-maya-all-inclusive-playa-del-carmen-20240504150800647000.jpg"class="habitacion-img">
      <p>Habitaciones</p>
    </div>

    <!-- apartado de la alberca-->
    <div class="card">
      <img src="https://images.trvl-media.com/lodging/22000000/21190000/21182700/21182618/8ce62ce0.jpg?impolicy=resizecrop&rw=575&rh=575&ra=fill" alt="Alberca al aire libre">
      <p>Alberca al aire libre</p>
    </div>

    <!-- apartado para el burffet-->
    <div class="card">
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTOdurLyEGCnCpXx_nKW3TVaz1fuSzgWyel3Om80ospmlszoBydmV0rwLmYczTn_MpjIJk&usqp=CAU" alt="restaraute con buffet diario">
      <p>Restaurante con buffet diario</p>
    </div>

    <!--aparatado de spa-->
    <div class="card">
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTLxaGVi65Hhm0PcmN4as7gMR5vGRAlQ7I74Q&s" alt="Spa">
      <p>Spa</p>
    </div>
    
    <!--apartado de actividades recreativas-->
    <div class="card">
      <img src="https://cdn.getyourguide.com/img/tour/5dd3230c0a1b5.jpeg/148.jpg">
      <p>Excursiones y actividades recreativas</p>
    </div>
    </div>
  </section>


  <section class="sec3">
    <h2>Contacto</h2>
    <p>📍 Playa Dorada, México<br>
       📞 Teléfono: +52 123 456 7890<br>
       📧 Correo: contacto@hotelsol.mx
    </p>
  </section>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> Hotel Sol. Todos los derechos reservados.</p>
  </footer>

</body>
</html>
