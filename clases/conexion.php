<?php
// conexion.php

// Incluir la configuración desde config.php
include('config.php'); // Esto incluye las configuraciones de la base de datos

class conexion {
    private $host = DB_HOST;     // Usamos la constante definida en config.php
    private $usuario = DB_USER; // Usamos la constante definida en config.php
    private $clave = DB_PASS;   // Usamos la constante definida en config.php
    private $bd = DB_NAME;      // Usamos la constante definida en config.php
    private $conexion;

    public function __construct() {
        // Crear la conexión usando las configuraciones de config.php
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

    public function ultimoId() {
        return $this->conexion->insert_id;
    }
}
?>
