<?php
require_once 'conexion.php';

class Login{
    public function __construct($user,$pass)
    {
        
        $this->user = $user;
        $this->pass = $pass;

    }
    
    public function validar(){
        $con = new Conexion();
        $sql = "select id_user,nombre,bandera,user from usuarios where pass ='$this->pass' and user='$this->user'";
        $res = $con->consultaRetorno($sql);

        while ($fila = mysqli_fetch_assoc($res)){
            @session_start();
            $_SESSION['nombre'] = $fila['nombre'];
              $_SESSION['bandera'] = $fila['bandera'];
          $_SESSION['user'] = $fila['user'];
          $_SESSION['id_user'] = $fila['id_user'];
            $_SESSION['validada'] = 1;
        }
    }
        
    }
?>