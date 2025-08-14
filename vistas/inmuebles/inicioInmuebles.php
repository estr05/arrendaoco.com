<?php
include_once("clases/conexion.php");
include_once("clases/Inmueble.php");

$inmuebles = new Inmuebles();
$con = new conexion();

// Verificar que el usuario sea arrendador (rol 2)
if ($_SESSION['bandera'] == '2') {
    $id_arrendador = $_SESSION['id_user'];
    $resultado = $inmuebles->listarPorPropietario($id_arrendador);
} else {
    echo "<p>No tienes permisos para ver esta página.</p>";
    exit;
}
?>
<center><h1><b>Inmuebles registrados</b></h1></center> <br>
<div class="container d-flex justify-content-center">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Propietario</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Estatus</th>
            <th>Categoría</th>
            <th>Contacto</th>
            <th>Ubicación</th>
            <th>Acciones</th>
            <th>Ver Detalle</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <!-- Imagen miniatura -->
                <td>
                    <?php
                    $id_in = $row['id_in'];
                    $sql_img = "SELECT ruta_imagen FROM imagenes_inmueble WHERE id_in = '$id_in' LIMIT 1";
                    $res_img = $con->consultaRetorno($sql_img);
                    if ($img = mysqli_fetch_assoc($res_img)) {
                        echo "<img src='{$img['ruta_imagen']}' width='80' style='border:1px solid #ccc;'>";
                    } else {
                        echo "Sin imagen";
                    }
                    ?>
                </td>

                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['nombre_in']; ?></td>
                <td>$<?php echo number_format($row['precio'], 2); ?></td><!--agregamos el signo de peso concatenado-->
                <td><?php echo $row['descripcion']; ?></td>
                <td><?php echo $row['estatus']; ?></td>
                <td><?php echo $row['categoria']; ?></td>
                <td><?php echo $row['contacto']; ?></td>
                <td><?php echo $row['ubicacion']; ?></td>

                <td>
                    <a href="?cargar=editarInmuebles&id_in=<?php echo $row['id_in']; ?>" class="btn btn-warning btn-sm m-1">Editar</a>
                    <a onClick='confirmar(<?php echo $row['id_in']; ?>)'class="btn btn-danger btn-sm m-1">Eliminar</a>
                </td>
    
                <td>
                    <a href="detalleInmueble.php?id_in=<?php echo $row['id_in']; ?>" class="btn btn-info btn-sm"   >
                        Ver
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
 <script language = "javascript">
            function confirmar(id_in){
    var MyId = id_in;
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
        window.location.href='?cargar=eliminarInmuebles&id_in='+MyId;  
    });
}
</script>