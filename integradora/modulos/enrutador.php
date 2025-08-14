<?php
    class enrutador{
        public function cargarVista($vista){
            if (@$_SESSION['validada'] == 1){
                switch($vista){
                    case "crearInmuebles":
                        include_once('vistas/inmuebles/' . $vista .'.php');
                        break;
                    case "editarInmuebles":
                        include_once('vistas/inmuebles/'. $vista . '.php');
                        break;
                    case "consultarParametro";
                        include_once('vistas/inmuebles/'. $vista . '.php');
                        break;
                    case "eliminarInmuebles";
                        include_once('vistas/inmuebles/'. $vista . '.php');
                        break;
                    case "inicioInmuebles";
                        include_once('vistas/inmuebles/'. $vista . '.php');
                        break;
                    case "inicioInmueblesAdmin";
                        include_once('vistas/inmuebles/'. $vista . '.php');
                        break;
                    //usuarios
                    case "crearUsuario":
                        include_once('vistas/usuarios/' . $vista .'.php');
                        break;
                    case "editarUsuario":
                        include_once('vistas/usuarios/' . $vista .'.php');
                        break;
                    case "eliminarUsuario":
                        include_once('vistas/usuarios/' . $vista .'.php');
                        break;
                    case "consultaUsuario":
                        include_once('vistas/usuarios/' . $vista .'.php');
                        break;
                    case "inicioUsuario":
                        include_once('vistas/usuarios/' . $vista .'.php');
                        break;
                    case "inicioUsuarioAdmin":
                        include_once('vistas/usuarios/' . $vista .'.php');
                        break;
                    //com
                    case "eliminarComentario":
                        include_once('vistas/comentarios/' . $vista .'.php');
                        break;
                    case "consultarComentario":
                        include_once('vistas/comentarios/' . $vista .'.php');
                        break;
                    case "inicioComentario":
                        include_once('vistas/comentarios/' . $vista .'.php');
                        break;
                    case "cerrar":
                        session_destroy();

                         echo"
                            <script language='JavaScript'>
                            window.location.href='index.html';
                            </script>";
                        break;
                    default:
                        include_once('vistas/error.php');
                }
            }else{
                include_once('index.html');
            }
        }
        public function validarGet($variable){
            if(isset($variable)){
                return true;   
            } else{
                if (@$_SESSION['validada'] == 1 && @$_SESSION['bandera']==1)
                    include_once('vistas/inmuebles/inicioInmueblesAdmin.php');
                else if (@$_SESSION['validada'] == 1 && @$_SESSION['bandera']==2)
                    include_once('vistas/usuarios/inicioUsuario.php');
                 else if (@$_SESSION['validada'] == 1 && @$_SESSION['bandera']==3)
                    include_once('vistas/usuarios/inicioUsuario.php');
                else
                echo "
                <scriptnlanguage='JavaScript'>
                window.location.href='index.html';
                </script>";
            }
        }
    }
?>                    