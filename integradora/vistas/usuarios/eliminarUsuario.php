<?php
    $controlador = new controladorUsuario();
    if (isset($_GET['id_user'])) {
        $row = $controlador->consultar($_GET['id_user']);
    } else {
        echo "
        <script language='Javascript'>
        alert('Registro modificado');
        window.location.href='?cargar=inicioUsuario';
        </script>";
    }
    $controlador->eliminar($_GET['id_user']);
    echo "
    <script language='Javascript'>
    alert('Registro eliminado');
    window.location.href='?cargar=inicioUsuario';
    </script>";

?>