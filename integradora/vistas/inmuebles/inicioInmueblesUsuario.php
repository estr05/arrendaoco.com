<?php
include_once("clases/conexion.php");
include_once("clases/Inmueble.php");

$inmuebles = new Inmuebles();
$con = new conexion(); // La conexión se establece en el constructor

// Verificar que el usuario sea arrendador (rol 2)
if ($_SESSION['bandera'] == '2') {
    $id_arrendador = $_SESSION['id_user'];
    $resultado = $inmuebles->listarPorPropietario($id_arrendador);
} else {
    echo "<p>No tienes permisos para ver esta página.</p>";
    exit;
}

// Consulta de inmuebles usando la clase conexion
$res_inmuebles = $con->consultaRetorno("SELECT * FROM inmuebles");
?>

<h1><b>Listado de Inmuebles</b></h1>
<div class="container">
    <div class="row">
        <?php while($inmueble = mysqli_fetch_assoc($res_inmuebles)): ?>
            <div class="col-md-4 mb-4">
                <div class="card">

                    <?php
                    // Usar id_in (correcto según tu BD)
                    $id_inmueble = $inmueble['id_in'];

                    // Obtener imágenes del inmueble
                    $res_img = $con->consultaRetorno("SELECT ruta_imagen FROM imagenes_inmueble WHERE id_in='$id_inmueble'");
                    $imagenes = mysqli_fetch_all($res_img, MYSQLI_ASSOC);
                    ?>

                    <!-- Carrusel de imágenes -->
                    <?php if(!empty($imagenes)): ?>
                        <div id="carousel-<?php echo $id_inmueble; ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach($imagenes as $index => $img): ?>
                                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                        <img src="<?php echo $img['ruta_imagen']; ?>" class="d-block w-100" alt="Imagen inmueble">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $id_inmueble; ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $id_inmueble; ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    <?php else: ?>
                        <img src="assets/img/no-image.jpg" class="card-img-top" alt="Sin imagen">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title"><?php echo $inmueble['nombre_in']; ?></h5>
                        <p class="card-text"><?php echo $inmueble['descripcion']; ?></p>
                        <p><b>Precio:</b> $<?php echo number_format($inmueble['precio'], 2); ?></p>
                        <p><b>Estatus:</b> <?php echo $inmueble['estatus']; ?></p>
                        <p><b>Categoría:</b> <?php echo $inmueble['categoria']; ?></p>
                        <p><b>Ubicación:</b> <?php echo $inmueble['ubicacion']; ?></p>
                    </div>

                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
