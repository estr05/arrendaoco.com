<?php
session_start();
include_once("clases/conexion.php");

if (!isset($_GET['id_in'])) {
    echo "<p>ID de inmueble no especificado.</p>";
    exit;
}

$id_in = intval($_GET['id_in']);
$con = new conexion();

// Obtener datos del inmueble
$sql = "SELECT * FROM inmuebles WHERE id_in = $id_in";
$res = $con->consultaRetorno($sql);
$inmueble = mysqli_fetch_assoc($res);

if (!$inmueble) {
    echo "<p>Inmueble no encontrado.</p>";
    exit;
}

// Obtener imágenes del inmueble
$sql_img = "SELECT ruta_imagen FROM imagenes_inmueble WHERE id_in = $id_in";
$res_img = $con->consultaRetorno($sql_img);
$imagenes = mysqli_fetch_all($res_img, MYSQLI_ASSOC);

// Procesar comentario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario'])) {
    $comentario = trim($_POST['comentario']);
    $id_user = $_SESSION['id_user'];

    if (!empty($comentario)) {
        $comentario_seguro = $con->getConexion()->real_escape_string($comentario);
        $comentario_sql = "INSERT INTO comentarios (id_inmueble, id_usuario, comentario) 
                           VALUES ($id_in, $id_user, '$comentario_seguro')";
        $con->consultaSimple($comentario_sql);
    }
}

// Obtener comentarios con JOIN a la tabla usuarios
$comentarios_sql = "SELECT u.nombre, c.comentario, c.fecha 
                    FROM comentarios c
                    JOIN usuarios u ON c.id_usuario = u.id_user
                    WHERE c.id_inmueble = $id_in 
                    ORDER BY c.fecha DESC";
$comentarios_res = $con->consultaRetorno($comentarios_sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle del Inmueble</title>
  <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
  <style>
.carousel-item img {
    height: 500px;
    object-fit: cover;
    width: 100%;
}
</style>
<div class="container mt-4">
  <div class="row align-items-start">
    <div class="col-md-6 mb-4">
      <?php if (!empty($imagenes)): ?>
        <div id="carousel-<?php echo $id_in; ?>" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php foreach($imagenes as $index => $img): ?>
              <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                <img src="<?php echo $img['ruta_imagen']; ?>" class="d-block w-100" alt="Imagen inmueble">
              </div>
            <?php endforeach; ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $id_in; ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $id_in; ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      <?php else: ?>
        <img src="assets/img/no-image.jpg" class="img-fluid" alt="Sin imagen">
      <?php endif; ?>
    </div>
    <div class="col-md-6 text-start">
      <h2><?php echo $inmueble['nombre_in']; ?></h2>
      <p><strong>Precio:</strong> $<?php echo number_format($inmueble['precio'], 2); ?></p>
      <p><strong>Descripción:</strong> <?php echo $inmueble['descripcion']; ?></p>
      <p><strong>Estatus:</strong> <?php echo $inmueble['estatus']; ?></p>
      <p><strong>Categoría:</strong> <?php echo $inmueble['categoria']; ?></p>
      <p><strong>Ubicación:</strong> <?php echo $inmueble['ubicacion']; ?></p>
      <p><strong>Contacto:</strong> <?php echo $inmueble['contacto']; ?></p>
    </div>
  </div>

  <?php

$boton_volver = '';

if (isset($_SESSION['bandera'])) {
    switch ($_SESSION['bandera']) {
        case '1': // Administrador
            $boton_volver = '<a href="index2.php" class="btn btn-outline-dark mt-3">Volver al inicio</a>';
            break;
        case '2': // Arrendador
            $boton_volver = '<a href="index3.php" class="btn btn-outline-dark mt-3">Volver al inicio</a>';
            break;
        case '3': // Usuario
            $boton_volver = '<a href="index1.php" class="btn btn-outline-dark mt-3">Volver al inicio</a>';
            break;
        default:
            $boton_volver = '<a href="index1.php" class="btn btn-outline-dark mt-3">Inicio</a>';
    }
} else {
    $boton_volver = '<a href="index1.php" class="btn btn-secondary mt-3">Inicio</a>';
}

echo $boton_volver;
?>
  <hr>

  <div class="row">
  <!-- Columna izquierda: Formulario para comentar -->
  <div class="col-md-6">
    <h4>Comentarios</h4>
    <form method="post" class="mb-3">
      <div class="mb-3">
        <textarea name="comentario" class="form-control" placeholder="Escribe tu comentario..." required></textarea>
      </div>
      <button type="submit" class="btn btn-outline-success">Enviar comentario</button>
    </form>
  </div>

<div class="col-md-6">
  <h4>Comentarios publicados</h4>
  <div class="border rounded p-2 bg-light" style="max-height: 400px; overflow-y: auto;">
    <?php if (mysqli_num_rows($comentarios_res) > 0): ?>
      <?php while($comentario = mysqli_fetch_assoc($comentarios_res)): ?>
        <div class="mb-2 border-bottom pb-2">
          <p><strong><?php echo htmlspecialchars($comentario['nombre']); ?></strong> <em>(<?php echo $comentario['fecha']; ?>)</em></p>
          <p><?php echo htmlspecialchars($comentario['comentario']); ?></p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-muted">Aún no hay comentarios publicados para este inmueble.</p>
    <?php endif; ?>
  </div>
</div>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>