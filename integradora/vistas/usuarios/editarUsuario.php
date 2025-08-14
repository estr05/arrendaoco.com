<?php
if (!isset($_SESSION['bandera'])) {
    header("Location: login.html");
    exit;
}

$controlador = new controladorUsuario();

if (isset($_GET['id_user'])) {
    $row = $controlador->consultar($_GET['id_user']);
} else {
    header('location: index.php');
    exit;
}

if (isset($_POST['registrar'])) {
    $r = $controlador->editar(
        $_GET['id_user'],
        $_POST['user'],
        $_POST['pass'],
        $_POST['nombre'],
        $_POST['direccion'],
        $_POST['tel'],
        $_POST['correo']
    );

    if ($r) {
        echo "
            <script>
                alert('Usuario actualizado correctamente');
                window.location.href='" . 
                    ($_SESSION['bandera'] == 1 ? "?cargar=inicioUsuarioAdmin" : "?cargar=inicioUsuario") .
                "';
            </script>";
    }
}
?>

<center><h1><b>Editar datos del usuario</b></h1></center>
<section>
    <div class="container">
        <div>
            <div class="col-md-10 col-md-offset-2">
                <div class="panel panel-primary">
                    <table width="100%">
                        <form action="" method="post" id="frmeditar_usuario">
                            <tr class="espacio">
                                <td align="right"><label for="user">Usuario:</label></td>
                                <td><input type="text" class="form-control" name="user" id="user" value="<?php echo $row['user']; ?>"></td>
                            </tr>
                            <tr class="espacio">
                                <td align="right"><label for="pass">Contraseña:</label></td>
                                <td><input type="text" class="form-control" name="pass" id="pass" required value="<?php echo $row['pass']; ?>"></td>
                            </tr>
                            <tr class="espacio">
                                <td align="right"><label for="nombre">Nombre:</label></td>
                                <td><input type="text" class="form-control" name="nombre" id="nombre" required value="<?php echo $row['nombre']; ?>"></td>
                            </tr>
                            <tr class="espacio">
                                <td align="right"><label for="direccion">Dirección:</label></td>
                                <td><input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $row['direccion']; ?>"></td>
                            </tr>
                            <tr class="espacio">
                                <td align="right"><label for="tel">Teléfono:</label></td>
                                <td><input type="number" class="form-control" name="tel" id="tel" value="<?php echo $row['tel']; ?>"></td>
                            </tr>
                            <tr class="espacio">
                                <td align="right"><label for="correo">Correo:</label></td>
                                <td><input type="text" class="form-control" name="correo" id="correo" value="<?php echo $row['correo']; ?>"></td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input type="submit" name="registrar" class="btn btn-secondary" value="Registrar" title="Registrar">
                                </td>
                            </tr>
                        </form>
                    </table>
                    <!-- termina la tabla -->
                </div>
            </div>
        </div>
    </div>
</section>
