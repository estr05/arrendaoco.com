<?php
include_once('conexion.php');

class Usuario{
    private $id_user;
    private $user;
    private $pass;
    private $nombre;
    private $direccion;
    private $tel;
    private $correo;
    private $bandera;
   

    private $con;

    public function __construct(){
        $this->con = new conexion();
    }
    public function set($atributo, $contenido) {
        $this->$atributo = $contenido;
    }
    public function get($atributo) {
        return $this->$atributo;
    }
    
    // ------
    public function listar() {
        // Verifica si la sesión está iniciada y si la bandera del usuario está disponible
        if (isset($_SESSION['bandera'])) {
            $bandera_usuario = $_SESSION['bandera'];

            if ($bandera_usuario == 1) { // Si es administrador (bandera = 1)
                $sql = "SELECT * FROM usuarios"; // Mostrar todos los usuarios
            } else { // Si es propietario o usuario normal (bandera = 2 o cualquier otro valor)
                if (isset($_SESSION['id_user'])) {
                    $id_usuario_logueado = $_SESSION['id_user'];
                    $sql = "SELECT * FROM usuarios WHERE id_user = '{$id_usuario_logueado}'"; // Mostrar solo su propio usuario
                } else {
                    // Si no hay id_user en sesión para un no-admin, no hay datos que mostrar
                    return false; 
                }
            }
            $resultado = $this->con->consultaRetorno($sql);
            return $resultado;
        } else {
            // Si no hay bandera en la sesión (ej. no logueado), no hay datos que mostrar
            return false; 
        }
    }
    // --- FIN MODIFICACIÓN ---

     public function filtrar($valor) {
        // Este método sigue funcionando como antes, para filtrar por nombre
        $sql = "SELECT * FROM usuarios where nombre like '$valor%'";
        $resultado = $this->con->consultaRetorno($sql);
        return $resultado;
    }
    public function crear(){
        $sql = "INSERT INTO usuarios(user,pass,nombre,direccion,tel,correo,bandera)
            VALUES ('{$this->user}','{$this->pass}','{$this->nombre}','{$this->direccion}','{$this->tel}',
            '{$this->correo}','2')"; // El valor '2' para 'bandera' parece ser fijo aquí.
        
        $this->con->consultaSimple($sql);
        return true;
    }
    public function eliminar() {
        $sql = "DELETE FROM usuarios WHERE id_user ='{$this->id_user}'";
        $resultado = $this->con->consultaSimple($sql);
    }
    public function consultar() {

        $sql = "SELECT * FROM usuarios WHERE id_user ='{$this->id_user}'";
        $resultado = $this->con->consultaRetorno($sql);
        $row = mysqli_fetch_assoc($resultado);
        
        //set

        $this->id_user = $row['id_user'];
        $this->user = $row['user'];
        $this->pass = $row['pass'];
        $this->nombre = $row['nombre'];
        $this->direccion = $row['direccion'];
        $this->tel = $row['tel'];
        $this->correo = $row['correo'];
        $this->bandera = $row['bandera'];
            return $row;
    }
    public function editar() {
        $sql = "UPDATE usuarios SET user = '{$this->user}', pass = '{$this->pass}', nombre = '{$this->nombre}',
                direccion = '{$this->direccion}', tel = '{$this->tel}', correo = '{$this->correo}'
                WHERE id_user = '{$this->id_user}'";
        
        $this->con->consultaSimple($sql);
        return true;
    }
}
?>