<?php
$user = $_POST['user'];
$pass = $_POST['pass'];
$nombre = $_POST['nombre'];
$direccion= $_POST['direccion'];
$tel= $_POST['tel'];
$correo= $_POST['correo'];
$bandera = $_POST['bandera'];


    $con = new mysqli("localhost", "root", "", "arrendaoco");
  mysqli_query($con, "INSERT INTO usuarios(user,pass,nombre,direccion,tel,correo,bandera) VALUES ('$user','$pass','$nombre','$direccion','$tel','$correo','$bandera')");
  
 echo "
<script>
    alert('Usuario registrado correctamente');
                window.location.href='index.html';
                
 </script>";

 ?>

 