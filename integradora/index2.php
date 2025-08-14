<?php
session_start();
include_once('modulos/enrutador.php');
include_once('modulos/controlador.php');
if($_SESSION['validada'] == 1){
}else
header("location: index.html");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">  
  <title>Arrendamientos Ocosingo</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Cardo:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="icon" href="favicon.ico" type="image/x-icon">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
   <link rel="stylesheet" href="assets/css/sweetalert.css">
    <script src="assets/js/jquery.min.js"></script>
   <link rel="stylesheet" href="navbar.css">
       <link rel="stylesheet" href="../../formulario.css">

</head>

<body>
  
  <header id="header" class="navbar">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

  <a href="index.html" class="brand-logo"><img src="img/logo.png" alt="imagenlogo" class="logo">ArrendaOco</a>
      <div>
        <span> <?php if (@$_SESSION['validada'] == 1) {
          echo "<span><label align=right>". $_SESSION['nombre']."</label></span>";}?></span>  
      </div>
            <nav id="navmenu" class="navmenu">
        <ul>
           <li class="dropdown"><span>Inmuebles</span>
            <ul>
              <li><a href="?cargar=crearInmuebles">Registrar</a></li>
              <li><a href="?cargar=inicioInmueblesAdmin ">Consultar</a></li>
              <li><a onclick="window.open('reportes/rep/reporte_inmueble.php')" style="cursor:pointer;">Reporte</a></li>
            </ul>
          </li>
          <li class="dropdown"><span>Usuarios</span><br>
            <ul>
              <li><a href="?cargar=crearUsuario">Registrar</a></li>
              <li><a href="?cargar=inicioUsuario">Consultar</a></li>
              <li><a onclick="window.open('reportes/rep/reporte_usuario.php')" style="cursor:pointer;">Reporte</a></li>
               </ul>
              </li>

              <li class="dropdown"><span>Comentarios</span><br>
            <ul>
              <li><a href="?cargar=inicioComentario">Consultar</a></li>
              <li><a onclick="window.open('reportes/rep/reporte_comentarios.php')" style="cursor:pointer;">Reporte</a></li>
               </ul>
              </li>
          <li ><a href="?cargar=cerrar"><span>Cerrar sesion</span></a></li>
        </ul>
      </nav>
    </div>
  </header>
  <main class="main">
              <section>
                <?php
                require_once 'modulos/controlador.php';
                require_once 'modulos/enrutador.php';
                      $enrutador = new enrutador();
                      if($enrutador->validarGET(@$_GET['cargar'])){
                          $enrutador->cargarVista(@$_GET['cargar']);
                      }
                ?>

              </section>
  </main>


  <!-- Scroll Top -->

  <!-- Preloader -->
  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/jquery.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>