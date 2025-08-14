<?php
include_once("clases/conexion.php");
session_start();

if ($_SESSION['bandera'] !== '1') {
    echo "<p>No tienes permiso para ver esta página.</p>";
    exit;
}

$con = new conexion();
$sql = "
    SELECT c.id, c.comentario, c.fecha, i.nombre_in, u.nombre AS nombre_usuario
    FROM comentarios c
    INNER JOIN inmuebles i ON c.id_inmueble = i.id_in
    INNER JOIN usuarios u ON c.id_usuario = u.id_user
    ORDER BY c.fecha DESC
";

$res = $con->consultaRetorno($sql);
?>

<h2 class="text-center mt-4 mb-4">Listado de Comentarios</h2>
<div class="container">
 <div class="container d-flex justify-content-center">
<table class="table table-bordered">
      <tr>
        <th>Usuario</th>
        <th>Inmueble</th>
        <th>Comentario</th>
        <th>Fecha</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      <?php while($comentario = mysqli_fetch_assoc($res)): ?>
        <tr>
          <td><?php echo htmlspecialchars($comentario['nombre_usuario']); ?></td>
          <td><?php echo htmlspecialchars($comentario['nombre_in']); ?></td>
          <td><?php echo htmlspecialchars($comentario['comentario']); ?></td>
          <td><?php echo $comentario['fecha']; ?></td>
          <td>
            <form action="eliminarComentario.php" method="post" onsubmit="return confirm('¿Eliminar este comentario?');">
              <input type="hidden" name="id" value="<?php echo $comentario['id']; ?>">
              <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</div>
