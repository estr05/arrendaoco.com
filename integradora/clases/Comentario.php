<?php
include_once('conexion.php');

class Comentario{
    private $id;
    private $comentario;
   

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
    public function listar() {
        $sql = "SELECT * FROM comentarios";
        $resultado = $this->con->consultaRetorno($sql);
        return $resultado;
    }
     public function filtrar($valor) {
        $sql = "SELECT * FROM comentarios where comentario like '$valor%'";
        $resultado = $this->con->consultaRetorno($sql);
        return $resultado;
    }
    public function crear(){
        $sql = "INSERT INTO comentarios(comentario)
            VALUES ('{$this->comentario}')";
        
        $this->con->consultaSimple($sql);
        return true;
    }
    public function eliminar() {
        $sql = "DELETE FROM comentarios WHERE id ='{$this->id}'";
        $this->con->consultaSimple($sql);
    }
    public function consultar() {

        $sql = "SELECT * FROM comentarios WHERE id ='{$this->id}'";
        $resultado = $this->con->consultaRetorno($sql);
        $row = mysqli_fetch_assoc($resultado);
        
    }
}
    
?>
