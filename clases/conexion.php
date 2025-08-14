<?php
class conexion {
    private $host = "localhost";
    private $usuario = "root";
    private $clave = "";
    private $bd = "arrendaoco"; // <-- CAMBIA esto por el nombre real de tu base
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->clave, $this->bd);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function getConexion() {
        return $this->conexion;
    }


    public function consultaRetorno($sql) {
        return $this->conexion->query($sql);
    }

    public function consultaSimple($sql) {
        $this->conexion->query($sql);
    }
   
    public function ultimoId()
{
    return $this->conexion->insert_id;
}
}
?>
