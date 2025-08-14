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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    
    <!-- Bootstrap -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="formulario.css">
</head>
<body>
    <div class="form-container">
        <center><h1><b>Editar datos del usuario</b></h1></center>

        <form method="POST" class="styled-form" id="frmeditar_usuario">
            <label for="user">Usuario</label>
            <input type="text" name="user" id="user" value="<?php echo $row['user']; ?>" required>

            <label for="pass">Contraseña</label>
            <input type="text" name="pass" id="pass" value="<?php echo $row['pass']; ?>" required>

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $row['nombre']; ?>" required>

            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" id="direccion" value="<?php echo $row['direccion']; ?>">

            <label for="tel">Teléfono</label>
            <input type="number" name="tel" id="tel" value="<?php echo $row['tel']; ?>">

            <label for="correo">Correo</label>
            <input type="text" name="correo" id="correo" value="<?php echo $row['correo']; ?>">

            <div class="text-center mt-3">
                <button type="submit" name="registrar" class="btn btn-secondary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</body>
</html>
