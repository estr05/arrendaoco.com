<?php
require_once '../clases/login.php';
$con = new mysqli("localhost","root","","arrendaoco");
$usuario = $_POST['usuario'];
$pass = $_POST ['pass'];

$usuario = mysqli_real_escape_string($con, $usuario);
$pass = mysqli_real_escape_string($con, $pass);

$login = new Login($usuario, $pass);

$login->validar();
if($_SESSION['validada'] == 1 && $_SESSION['bandera']==1)
header("location: ../index2.php"); //Admin

else if($_SESSION['validada'] == 1 && $_SESSION['bandera']==2)
header("location: ../index3.php"); //Propietario

else if ($_SESSION['validada'] == 1 && $_SESSION['bandera'] == 3)
    header("location: ../index1.php"); //Inquilino

else
header("location: ../login.html");
?>