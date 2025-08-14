<?php
  $controlador = new controladorUsuario();
  if(isset($_POST['registrar'])){
        $r=$controlador->crear($_POST['user'],$_POST['pass'],$_POST['nombre'],$_POST['direccion'],$_POST['tel'],$_POST['correo'],$_POST['bandera']);
        echo $r;
if($r){
            echo "
                <script>
                    alert('Usuario creado correctamente');
                    if(confirm('¿Desea crear otro usuario?')) {
                        window.location.href='?cargar=crearUsuario';
                    } else {";
            
            if (isset($_SESSION['bandera']) && $_SESSION['bandera'] == 1) {
                echo "window.location.href='?cargar=inicioUsuarioAdmin';";
            } else {
                echo "window.location.href='?cargar=inicioUsuario';";
            }

            echo "}
                </script>";
        }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de usuarios</title>
  <link rel="stylesheet" href="formulario.css">
</head>
<body>
  
<section>
  <div class="form-container">
<center><h1>Registro de usuarios</h1></center>

      <div class="container">
        <div>
          <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-primary">
                    <table width="100%">
                    <form action="" method="post" id="frmusuario" enctype="multipart/form-data" class="styled-form">
                    <tr class="espacio">
                    <td align="right"><label for="user">Usuario</label></td><td><input type="text" class="form-control" name="user" id="user"
                    placeholder="Ingresa un usuario" autofocus required> <span id="resultado"></span></td>
                    </tr>
                    <tr class="espacio">
                    <td align="right"> <label for="pass">Contraseña:</label></td><td><input type="password" class="form-control" name="pass" id="pass"
                    placeholder="Ingresa una contraseña"required></td>
                    </tr >
                    <td class="espacio" align="right"> <label for="nombre">Nombre:</label></td><td><input type="text" class="form-control" name="nombre"
                    id="nombre" placeholder="Ingresa un nombre" required></td>
                    </tr>
                    <tr class="espacio">
                    <td align="right"> <label for="direccion">Direccion:</label></td><td><input type="text" class="form-control" name="direccion"
                    id="direccion"></td>
                    </tr>
                    <tr class="espacio">
                    <td align="right"> <label for="tel">Telefono:</label></td><td><input type="number" class="form-control" name="tel"
                    id="tel" placeholder="Ingresa un telefono"required></td>
                    </tr>
                     <tr class="espacio">
                    <td align="right"> <label for="correo">Correo:</label></td><td><input type="text" class="form-control" name="correo"
                    id="correo" placeholder="Ingresa un correo"required></td>
                    </tr>

                    <tr class="espacio">
                    <td align="right"><label for="bandera">Rol:</label></td><td><select class="form-control" name="bandera" id="bandera">
                        <option value="2">Propietario</option>
                        <option value="3">Inquilino</option>
                    </select>
                    </td>
                    </tr>

                <td align="center" colspan="2"><input type="submit" name="registrar" class="btn btn-secondary justify-content-center" value="Registrar" title="Registrar"/></td>
                    </tr>
                    </form>
                    </table>
                    <!--TERMINA LA TABLA-->
                    </div>
                    </div>
      </div>
      </div>
</section>
</body>
</html>
<script>
  //funcion para validar nombre de usuario existente
$(document).ready(function(){
  var consulta ="";
  //hacemos focus
  $("#user").focus();
  //comprobamos si se pulsa la tecla
  $("#user").keyup(function(e){
//obtenemos texto introducido en el campo
if(consulta != $("#user").val()){
  $("#resultado").empty();
}
consulta = $("#user").val();
//hace la busqueda
$("#resultado").delay(1300).queue(function(n){
  //$("#resultado").html('<img src="ajax-loader.gif" />');
            $.ajax({
            type: "POST",
            url: "vistas/usuarios/comprobar.php",
            data: "b=" +consulta,
            dataType: "html",
            error: function(){
      //alert("error peticion ajax");
            },
            success: function(data){
            $("#resultado").html(data);
            n();
          }
        });
      });
    });
  });
</script>