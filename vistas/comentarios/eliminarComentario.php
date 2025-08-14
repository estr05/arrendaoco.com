 <?php
    $controlador = new controladorComentario();
    if (isset($_GET['id'])) {
        $row = $controlador->consultar($_GET['id']);
    } else {
        echo "
        <script language='Javascript'>
        alert('Registro modificado');
        window.location.href='?cargar=inicioComentario';
        </script>";
    }
    $controlador->eliminar($_GET['id']);
    echo "
    <script language='Javascript'>
    alert('Registro eliminado');
    window.location.href='?cargar=inicioComentario';
    </script>";

?>