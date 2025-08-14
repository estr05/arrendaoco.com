<?php
include_once("clases/conexion.php");

// Validar que sea administrador
if ($_SESSION['bandera'] !== '1') {
    echo "<p>No tienes permiso para ver esta página.</p>";
    exit;
}

$con = new conexion();

// Obtener comentarios con datos del inmueble
$sql = "
    SELECT c.id, c.comentario, c.fecha, i.nombre_in, u.nombre AS nombre_usuario
    FROM comentarios c
    INNER JOIN inmuebles i ON c.id_inmueble = i.id_in
    INNER JOIN usuarios u ON c.id_usuario = u.id_user
    ORDER BY c.fecha DESC
";

$res = $con->consultaRetorno($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Comentarios de Inmuebles</title>
  <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">

</head>
<body>
<div class="container mt-4">
  <center><h1><b>Comentarios registrados</b></h1></center> <br>
  <div class="container d-flex justify-content-center">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>Usuario</th>
        <th>Inmueble</th>
        <th>Comentario</th>
        <th>Fecha</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($res)): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['nombre_usuario']); ?></td>
        <td><?php echo htmlspecialchars($row['nombre_in']); ?></td>
        <td><?php echo htmlspecialchars($row['comentario']); ?></td>
        <td><?php echo $row['fecha']; ?></td>
        <td>

            <a onClick='confirmar(<?php echo $row['id']; ?>)'class="btn btn-danger btn-sm">Eliminar</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</div>
</body>
</html>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
 <script language = "javascript">
            function confirmar(id){
    var MyId = id;
    alert(id);
    swal({
        title: "¿Estas seguro de eliminar el registro",
        text: "Ya no podras recuperarlo",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, borrar",
        closeOnconfirm: false
    },
    function(){
        window.location.href='?cargar=eliminarComentario&id='+MyId;  
    });
}
</script>
