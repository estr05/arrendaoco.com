<?php
include_once("clases/conexion.php");
include_once("clases/Inmueble.php");

$inmuebles = new Inmuebles();
$con = new conexion();

$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

// validar permisos
if (!isset($_SESSION['bandera']) || $_SESSION['bandera'] !== '1') {
    echo "<p>No tienes permisos para ver esta pagina.</p>";
    exit;
}

/* ---------------- Paginacion ---------------- */
$limit = 6;
$page  = isset($_GET['page']) && ctype_digit($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

/* Filtro opcional */
$where = "";
if ($buscar !== '') {
    $b = addslashes($buscar);
    $where = "WHERE i.nombre_in LIKE '%$b%'";
}

/* Total de registros */
$sqlCount = "
  SELECT COUNT(*) AS total
  FROM usuarios AS u
  INNER JOIN inmuebles AS i ON u.id_user = i.propietario
  $where
";
$resC = $con->consultaRetorno($sqlCount);
$fC = mysqli_fetch_assoc($resC);
$totalRows = (int)($fC['total'] ?? 0);
$totalPages = max(1, (int)ceil($totalRows / $limit));

/* Normalizar pagina */
if ($page > $totalPages) { $page = $totalPages; }
$offset = ($page - 1) * $limit;

/* Consulta paginada */
$sql = "
  SELECT i.id_in, u.nombre, i.nombre_in, i.precio, i.descripcion, i.estatus,
         i.categoria, i.contacto, i.ubicacion
  FROM usuarios AS u
  INNER JOIN inmuebles AS i ON u.id_user = i.propietario
  $where
  ORDER BY i.id_in DESC
  LIMIT $limit OFFSET $offset
";
$resultado = $con->consultaRetorno($sql);

/* Base URL conservando parametros excepto page */
$qs = $_GET;
unset($qs['page']);
$base = $_SERVER['PHP_SELF'] . (count($qs) ? '?' . http_build_query($qs) . '&' : '?');

/* Prev/Next y rango */
$prev = $page - 1;
$next = $page + 1;
$start = max(1, $page - 2);
$end   = min($totalPages, $page + 2);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">

  <!-- Bootstrap CSS (asegura que ya lo tienes en tu layout global) -->
  <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
  <!-- Bootstrap Icons si usas el icono de lupa -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    /* Estilo buscador (como solicitaste) */
    .btn-buscador {
      background-color: #bcbabaff;
      border: none;
      color: white;
    }
    .btn-buscador:hover {
      background-color: #d9d9d9;
      color: black;
    }

    /* Paginacion: numeros gris, anterior/siguiente blancos */
    .pagination .page-link {
      border: none;
    }
    /* Numeros */
    .pagination .page-item:not(.prev-btn):not(.next-btn) .page-link {
      background-color: #bcbabaff;
      color: white;
    }
    .pagination .page-item:not(.prev-btn):not(.next-btn) .page-link:hover {
      background-color: #d9d9d9;
      color: black;
    }
    .pagination .page-item.active .page-link {
      background-color: #a5a3a3ff;
      color: white;
    }
    /* Anterior y Siguiente */
    .pagination .prev-btn .page-link,
    .pagination .next-btn .page-link {
      background-color: white;
      color: black;
    }
    .pagination .prev-btn .page-link:hover,
    .pagination .next-btn .page-link:hover {
      background-color: #f0f0f0;
      color: black;
    }
    /* Deshabilitados */
    .pagination .page-item.disabled .page-link {
      background-color: #e0e0e0;
      color: #999;
    }
  </style>
</head>
<body>

<center><h1><b>Inmuebles registrados</b></h1></center>
<br>

<!-- Buscador -->
<div class="container mb-4">
  <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . (isset($_GET['cargar']) ? '?cargar=' . urlencode($_GET['cargar']) : '')); ?>" class="d-flex justify-content-center">
    <div class="input-group" style="max-width:600px;">
      <input class="form-control" type="search" name="buscar" placeholder="Buscar por nombre..." value="<?php echo htmlspecialchars($buscar, ENT_QUOTES, 'UTF-8'); ?>">
      <button class="btn btn-buscador" type="submit">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </form>
</div>

<div class="container d-flex justify-content-center">
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>Imagen</th>
          <th>Propietario</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Descripcion</th>
          <th>Estatus</th>
          <th>Categoria</th>
          <th>Contacto</th>
          <th>Ubicacion</th>
          <th>Acciones</th>
          <th>Ver Detalle</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($totalRows === 0): ?>
          <tr><td colspan="11" class="text-center">No hay resultados.</td></tr>
        <?php else: ?>
          <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
              <td>
                <?php
                  $id_in = (int)$row['id_in'];
                  $sql_img = "SELECT ruta_imagen FROM imagenes_inmueble WHERE id_in = '$id_in' LIMIT 1";
                  $res_img = $con->consultaRetorno($sql_img);
                  if ($img = mysqli_fetch_assoc($res_img)) {
                      echo "<img src='".htmlspecialchars($img['ruta_imagen'], ENT_QUOTES, 'UTF-8')."' width='80' style='border:1px solid #ccc;'>";
                  } else {
                      echo "Sin imagen";
                  }
                ?>
              </td>
              <td><?php echo htmlspecialchars($row['nombre']); ?></td>
              <td><?php echo htmlspecialchars($row['nombre_in']); ?></td>
              <td>$<?php echo number_format((float)$row['precio'], 2); ?></td>
              <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
              <td><?php echo htmlspecialchars($row['estatus']); ?></td>
              <td><?php echo htmlspecialchars($row['categoria']); ?></td>
              <td><?php echo htmlspecialchars($row['contacto']); ?></td>
              <td><?php echo htmlspecialchars($row['ubicacion']); ?></td>
              <td>
                <a href="?cargar=editarInmuebles&id_in=<?php echo (int)$row['id_in']; ?>" class="btn btn-warning btn-sm m-1">Editar</a>
                <a onClick='confirmar(<?php echo (int)$row['id_in']; ?>)' class="btn btn-danger btn-sm m-1">Eliminar</a>
              </td>
              <td>
                <a href="detalleInmueble.php?id_in=<?php echo (int)$row['id_in']; ?>" class="btn btn-info btn-sm">Ver</a>
              </td>
            </tr>
          <?php } ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php if ($totalPages > 1): ?>
<nav aria-label="Paginacion" class="mt-3">
  <ul class="pagination justify-content-center">
    <li class="page-item prev-btn <?php echo $page <= 1 ? 'disabled' : ''; ?>">
      <a class="page-link" href="<?php echo $page <= 1 ? '#' : $base.'page='.$prev; ?>">Anterior</a>
    </li>

    <?php if ($start > 1): ?>
      <li class="page-item"><a class="page-link" href="<?php echo $base.'page=1'; ?>">1</a></li>
      <?php if ($start > 2): ?><li class="page-item disabled"><span class="page-link">...</span></li><?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
      <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
        <a class="page-link" href="<?php echo $base.'page='.$i; ?>"><?php echo $i; ?></a>
      </li>
    <?php endfor; ?>

    <?php if ($end < $totalPages): ?>
      <?php if ($end < $totalPages - 1): ?><li class="page-item disabled"><span class="page-link">...</span></li><?php endif; ?>
      <li class="page-item"><a class="page-link" href="<?php echo $base.'page='.$totalPages; ?>"><?php echo $totalPages; ?></a></li>
    <?php endif; ?>

    <li class="page-item next-btn <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
      <a class="page-link" href="<?php echo $page >= $totalPages ? '#' : $base.'page='.$next; ?>">Siguiente</a>
    </li>
  </ul>
</nav>
<?php endif; ?>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
function confirmar(id_in){
  var MyId = id_in;
  swal({
      title: "Estas seguro de eliminar el registro",
      text: "Ya no podras recuperarlo",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si, borrar",
      closeOnconfirm: false
  }, function(){
      window.location.href='?cargar=eliminarInmuebles&id_in='+MyId;
  });
}
</script>

<!-- Bootstrap JS (si no lo tienes ya en tu layout) -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
