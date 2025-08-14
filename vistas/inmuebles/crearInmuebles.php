<?php
  $controlador = new controladorInmuebles();
  if(isset($_POST['registrar'])){
        // Aquí enviamos también las imágenes al controlador
        $r = $controlador->crear(
            $_POST['propietario'],
            $_POST['nombre_in'],
            $_POST['precio'],
            $_POST['descripcion'],
            $_POST['estatus'],
            $_POST['categoria'],
            $_POST['contacto'],
            $_POST['ubicacion'],
            $_FILES['imagenes'] // nuevo parámetro
        );
        echo $r;
        if($r){
    echo "<script>
        if(confirm('¿Desea realizar un nuevo registro?')){
            window.location.href='?cargar=crearInmuebles';
        } else {";
    
    if (isset($_SESSION['bandera']) && $_SESSION['bandera'] == 1) {
        echo "window.location.href='?cargar=inicioInmueblesAdmin';"; // Admin
    } elseif (isset($_SESSION['bandera']) && $_SESSION['bandera'] == 2) {
        echo "window.location.href='?cargar=inicioInmuebles';"; // Propietario
    } else {
        echo "window.location.href='login.html';";
    }

    echo "}
    </script>";
}

  }
?>
<?php
$servidor = "localhost";
$usuario = "root";
$pass = "";
$db = "arrendaoco";
$conexion = mysqli_connect($servidor,$usuario,$pass,$db);
$opcion = $_SESSION['id_user'];
$cad1 = "SELECT id_user,nombre FROM usuarios WHERE id_user='{$opcion}'";
$eje1 = mysqli_query($conexion,$cad1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de inmuebles</title>
     <link rel="stylesheet" href="formulario.css">
</head>
<body>
<section>
      <div class="form-container">
        <center><h1>Registro de Inmuebles</h1></center>
        <div>
          <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-primary">
                    <table width="100%">
                    <form action="" method="post" id="frminmuebles" enctype="multipart/form-data" class="styled-form"> 

                       <tr class="espacio"> 
                        <td align="right">Propietario:</td>
                        <td>
                            <select class="form-control" name="propietario" id="propietario" >
                            <?php while($row=mysqli_fetch_assoc($eje1)){ ?>
                                <option value="<?php echo $row['id_user']; ?>"><?php echo $row['nombre']; ?></option>
                            <?php } ?>
                            </select>
                        </td>
                       </tr>

                       <tr class="espacio"> 
                        <td align="right">Nombre:</td>
                        <td><input type="text" name="nombre_in" class="form-control" placeholder="Ingresa nombre del inmueble" pattern="[a-zA-Z]\u00C0-\u017F){2,254}" title="No se aceptan números"
                    autofocus required></td>
                       </tr>

                       <tr class="espacio"> 
                        <td align="right">Precio:</td>
                        <td><input  type="num" id="precio" name="precio"  class="form-control"   step="0.01" placeholder="Ingresa el precio del inmueble"required></td>
                       </tr>

                       <tr class="espacio"> 
                        <td align="right">Descripción:</td>
                        <td><textarea name="descripcion" class="form-control" placeholder="Ingresa descripcion del inmueble" required></textarea></td>
                       </tr>

                       <tr class="espacio"> 
                        <td align="right">Estatus:</td>
                        <td>
                            <select name="estatus" class="form-control" required>
                                <option value ="Disponible">Disponible</option>
                                <option value="Ocupado">Ocupado</option>
                            </select>
                        </td>
                       </tr>

                    <tr class="espacio">
                    <td align="right"><label for="categoria">Categoria:</label></td><td><select class="form-control" name="categoria" id="categoria">
                        <option value="Casa">Casa</option>
                        <option value="Cuarto">Cuarto</option>
                        <option value="Departamento">Departamento</option>
                    </select>
                    </td>
                    </tr>

                       <tr class="espacio"> 
                        <td align="right">Contacto:</td>
                        <td><input type="text" name="contacto" class="form-control" placeholder="Numero de telefono o Email" required></td>
                       </tr>

                       <tr class="espacio"> 
                        <td align="right">Ubicación:</td>
                        <td><input type="text" name="ubicacion" class="form-control" placeholder="Agrega una ubicación" required></td>
                       </tr>

                       <!-- Nuevo campo para subir múltiples imágenes -->
                       <tr class="espacio">
                            <td align="right">Imágenes:</td>
                            <td>
                                <input type="file" name="imagenes[]" id="imagenes" class="form-control" multiple accept="image/*" required>
                                <small>Puedes seleccionar 4 o más imágenes.</small>
                            </td>
                       </tr>

                       <tr>
                            <td colspan="2" class="text-center">
                                <button type="submit" name="registrar" class="btn btn-secondary justify-content-center">Registrar Inmueble</button>
                            </td>
                       </tr>

                    </form>
                    </table>
            </div>
          </div>
        </div>
      </div>
</section>
</body>
</html>
