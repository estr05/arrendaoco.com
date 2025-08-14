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

  <!-- Main CSS File -->
  <link rel="stylesheet" href="assets/css/sweetalert.css">
  <script src="assets/js/jquery.min.js"></script>
  <link rel="stylesheet" href="./estilos.css">
  <link rel="stylesheet" href="navbar.css">
  <link rel="stylesheet" href="Cormorant.css">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
<?php
session_start();
include_once("clases/conexion.php");
$con = new conexion();

$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

$categoria = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';/*esta linea captura el valor del parametro(si existe) */

/*codigo sql para filtrar inmuebles disponibles*/
$sql = "SELECT i.id_in, u.nombre, i.nombre_in, i.precio, i.descripcion, i.estatus, 
               i.categoria, i.contacto, i.ubicacion
        FROM usuarios AS u
        INNER JOIN inmuebles AS i ON u.id_user = i.propietario
        WHERE i.estatus = 'Disponible'";

if ($buscar !== '') {
    $sql .= " AND i.nombre_in LIKE '%" . addslashes($buscar) . "%'";
}
/*aqui se añade un filtro (este depende del valor del parametro osea Casa,Cuarto,Departamento)*/ 
if ($categoria !== '') {
    $sql .= " AND i.categoria = '" . addslashes($categoria) . "'";/*addslashes para prevenir inyecciones sql*/
}
$res_inmuebles = $con->consultaRetorno($sql);

include_once("clases/Inmueble.php");
$con = new conexion();

if (!isset($_SESSION['bandera']) || $_SESSION['bandera'] != '3') {
    echo "<p>No tienes permisos para ver esta página.</p>";
    exit;
}
?>
<style>
.carousel-item img {
    height: 250px;
    object-fit: cover;
    width: 100%;
}
</style>

<nav class="navbar">
  <div class="navbar-container">
    <a href="index.html" class="brand-logo"><img src="img/logo.png" alt="imagenlogo" class="logo">ArrendaOco</a>
    <button class="menu-toggle" aria-label="Toggle navigation">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <div class="navbar-links" id="navbarNavAltMarkup">
      <a class="nav-item active" aria-current="page" href="index.html">Inicio</a>
      <a class="nav-item" href="nosotros.html">Nosotros</a>
    </div>
  </div>
</nav>

<header class="bg-light py-5 text-center">
  <h1 class="titulo">Bienvenidos</h1>
  <p class="subtitulo">¡Encuentra tu nuevo hogar: renta la propiedad ideal!</p>
</header>

<br><br>
<center><h1><b>Inmuebles Disponibles</b></h1><br>

<div class="d-flex justify-content-center gap-3 my-3">
    <a href="index1.php" class="btn btn-success px-4  <?php if(!isset($categoria) || $categoria == '') echo 'active'; ?>">Todos</a>
  <a href="index1.php?categoria=Casa" class="btn btn-success px-4 <?php if(isset($categoria) && $categoria == 'Casa') echo 'active'; ?>">Casas</a>
  <a href="index1.php?categoria=Departamento" class="btn btn-success px-4 <?php if(isset($categoria) && $categoria == 'Departamento') echo 'active'; ?>">Departamentos</a>
  <a href="index1.php?categoria=Cuarto" class="btn btn-success px-4 <?php if(isset($categoria) && $categoria == 'Cuarto') echo 'active'; ?>">Cuartos</a>
</div>

<div class="container mb-5">
  <form method="GET" action="index1.php" class="d-flex justify-content-center">
    <div class="input-group w-50">
      <input class="form-control" type="search" name="buscar" placeholder="Buscar por nombre..." value="<?php echo htmlspecialchars($buscar); ?>">
      <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
    </div>
  </form>
</div>

<?php if (mysqli_num_rows($res_inmuebles) > 0): ?><!--Verifica si hay resultados de inmuebles en la busqueda si no encuentra manda un mensaje-->
<div class="container">
  <div class="row">
    <?php while($inmueble = mysqli_fetch_assoc($res_inmuebles)): ?><!--este ciclo devuelve fila por fila de la tabla hasta tener todos los registros-->
    <div class="col-md-4 mb-4">
      <div class="card">
        <?php
        $id_inmueble = $inmueble['id_in'];/*obtenemos el id del inmueble*/
        $res_img = $con->consultaRetorno("SELECT ruta_imagen FROM imagenes_inmueble WHERE id_in='$id_inmueble'");/*consultar imagenes del inmueble*/
        $imagenes = mysqli_fetch_all($res_img, MYSQLI_ASSOC);/*devuelve arreglo de rutas de imagenes del inmueble*/
        ?>
        <?php if(!empty($imagenes)): ?><!--Verificar que no este vacio-->


        <div id="carousel-<?php echo $id_inmueble; ?>" class="carousel slide" data-bs-ride="carousel"><!--se crea el carrusel-->
          <div class="carousel-inner">
            <?php foreach($imagenes as $index => $img): ?><!--recoje el arreglo de imagenes y genera dinamicamente  el slide-->
            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>"><!--esta linea sirve para que el carrusel sepa que imagen va a mostrar primero (con el active)-->
              <img src="<?php echo $img['ruta_imagen']; ?>" alt="Imagen inmueble"><!--asigna la ruta de la imagen antes obtenida-->
            </div>
            <?php endforeach; ?><!--termina el ciclo foreach-->
          </div>

          <!--botones de izquierda y derecha en el carrucel-->
          <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $id_inmueble; ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $id_inmueble; ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button> 
        </div>


        <?php else: ?>
        <img src="assets/img/no-image.jpg" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Sin imagen"><!--muestra una imagen alternativa por si no tiene imagenes el inmueble-->
        <?php endif; ?>


        <div class="card shadow-sm h-100 border-0">
          <h5 class="card-title"><?php echo $inmueble['nombre_in']; ?></h5>
          <p class="card-text"><?php echo $inmueble['descripcion']; ?></p>
          <p><b>Precio:</b> $<?php echo number_format($inmueble['precio'], 2); ?></p>
          <p><b>Estatus:</b> <?php echo $inmueble['estatus']; ?></p>
          <p><b>Categoría:</b> <?php echo $inmueble['categoria']; ?></p>
          <p><b>Ubicación:</b> <?php echo $inmueble['ubicacion']; ?></p>
          <a href="detalleInmueble.php?id_in=<?php echo $inmueble['id_in']; ?>" class="btn btn-outline-secondary w-100 mt-2">Ver Detalles</a>
        </div>


      </div>
    </div>
    <?php endwhile; ?>

  </div>
</div>
    <footer style="background-color: #203c31;" class="text-light pt-0 pb-0">
    <div class="container text-center text-md-start">
        <div class="row text-center text-md-start g-3">
            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto">
                <h6 class="text-uppercase mb-2 fw-bold">ArrendaOco</h6>
                <p class="small">
Nuestro portal te permite explorar una amplia selección de casas, departamentos y cuartos. Con filtros avanzados y descripciones detalladas, encontrar tu próximo hogar es más fácil que nunca.</p>
            </div>
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto">
                <h6 class="text-uppercase mb-2 fw-bold">Enlaces Rápidos</h6>
                <p class="small">
                    <a href="#" class="text-light text-decoration-none">Servicios</a>
                </p>
                <p class="small">
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=digitalcodefive@gmail.com" target="_blank" class="text-light text-decoration-none">Contacto</a>
                </p>
            </div>
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto">
                <h6 class="text-uppercase mb-2 fw-bold">Redes Sociales</h6>
                <a href="https://www.instagram.com/aoco.05" target="_blank" class="bi bi-instagram text-light"></a> 
          </div>
              <div class="col-md-4 col-lg-3 col-xl-3 mx-auto">
                <h6 class="text-uppercase mb-2 fw-bold">Contacto</h6>
                <p class="small">
                    <i class="fas fa-home me-2"></i> Ocosingo, Chiapas, México
                </p>
                <p class="small">
                    <i class="fas fa-envelope me-2"></i> arrendaoco@gmail.com
                </p>
                <p class="small">
                    <i class="fas fa-phone me-2"></i>+52 9191234567
                </p>
            </div>
        </div>
        <hr class="my-3">
        <div class="row align-items-center">
            <div class="col-md-7 col-lg-8">
                <p class="small m-0">
                    © 2025 Todos los derechos reservados por:
                    <a href="#" class="text-light text-decoration-none"><strong class="small">ArrendaOco</strong></a>
                </p>
            </div>
        </div>
    </div>
</footer>
<?php else: ?>
<div class="text-center mb-5">
  <h4>No se encontraron inmuebles disponibles.</h4>
</div>
<?php endif; ?>


<!-- JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>