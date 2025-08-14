<?php
$controlador = new controladorInmuebles();

if (isset($_GET['id_in'])) {
    $id_in = $_GET['id_in'];

    // Consultar imágenes asociadas
    include_once("clases/conexion.php");
    $con = new conexion();
    $res_img = $con->consultaRetorno("SELECT ruta_imagen FROM imagenes_inmueble WHERE id_in = '$id_in'");

    
    while ($img = mysqli_fetch_assoc($res_img)) {
        $ruta = $img['ruta_imagen'];
        if (file_exists($ruta)) {
            unlink($ruta);
        }
    }

    //  Eliminar registros de imágenes en la BD
    $con->consultaSimple("DELETE FROM imagenes_inmueble WHERE id_in = '$id_in'");

    //Eliminar inmueble
    $controlador->eliminar($id_in);

    if (isset($_SESSION['bandera'])) {
        if ($_SESSION['bandera'] == 1) {
            header("Location: index2.php?cargar=inicioInmueblesAdmin");
        } elseif ($_SESSION['bandera'] == 2) {
            header("Location: index3.php?cargar=inicioInmuebles");
        } else {
            header("Location: login.html");
        }
    } else {
        header("Location: login.html");
    }
    exit;
}
?>
