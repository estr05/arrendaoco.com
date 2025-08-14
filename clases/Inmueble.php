<?php
include_once('conexion.php');

class Inmuebles {
    private $id_in;
    private $propietario;
    private $nombre_in;
    private $precio;
    private $descripcion;
    private $estatus;
    private $categoria;
    private $contacto;
    private $ubicacion;

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

    // Lista solo los inmuebles del usuario logueado
    public function listar(){
        $opcion = $_SESSION['id_user'];
        $sql = "SELECT i.id_in, u.nombre, i.nombre_in, i.precio, i.descripcion, i.estatus,
                       i.categoria, i.contacto, i.ubicacion
                FROM usuarios AS u
                INNER JOIN inmuebles AS i ON u.id_user = i.propietario
                WHERE propietario='{$opcion}'";
        return $this->con->consultaRetorno($sql);
    }

    // Lista solo inmuebles de un propietario específico
    public function listarPorPropietario($id_propietario) {
        $sql = "SELECT i.id_in, u.nombre, i.nombre_in, i.precio, i.descripcion, i.estatus,
                       i.categoria, i.contacto, i.ubicacion
                FROM usuarios AS u
                INNER JOIN inmuebles AS i ON u.id_user = i.propietario
                WHERE i.propietario = '{$id_propietario}'";
        return $this->con->consultaRetorno($sql);
    }

    // Lista todos los inmuebles (para admin)
    public function listarTodos() {
        $sql = "SELECT i.id_in, u.nombre, i.nombre_in, i.precio, i.descripcion, i.estatus,
                       i.categoria, i.contacto, i.ubicacion
                FROM usuarios AS u
                INNER JOIN inmuebles AS i ON u.id_user = i.propietario";
        return $this->con->consultaRetorno($sql);
    }

    // Crea un inmueble y guarda múltiples imágenes
    public function crear(){
        $sql = "INSERT INTO inmuebles (propietario, nombre_in, precio, descripcion, estatus, categoria, contacto, ubicacion)
                VALUES ('{$this->propietario}', '{$this->nombre_in}', '{$this->precio}', '{$this->descripcion}',
                        '{$this->estatus}', '{$this->categoria}', '{$this->contacto}', '{$this->ubicacion}')";
        $this->con->consultaSimple($sql);

        // Obtener último ID insertado
        $id_in = $this->con->ultimoId();

        // Guardar imágenes si se enviaron
        if (!empty($_FILES['imagenes']['name'][0])) {
            $rutaCarpeta = "uploads/inmuebles/";
            if (!is_dir($rutaCarpeta)) {
                mkdir($rutaCarpeta, 0777, true);
            }

            foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
                $nombreArchivo = uniqid() . "_" . basename($_FILES['imagenes']['name'][$key]);
                $rutaDestino = $rutaCarpeta . $nombreArchivo;

                if (move_uploaded_file($tmp_name, $rutaDestino)) {
                    $this->guardarImagen($id_in, $rutaDestino);
                }
            }
        }

        return true;
    }

    // Guarda una imagen asociada a un inmueble
    public function guardarImagen($id_in, $ruta_imagen) {
        $sql = "INSERT INTO imagenes_inmueble (id_in, ruta_imagen) VALUES ('{$id_in}', '{$ruta_imagen}')";
        $this->con->consultaSimple($sql);
    }

    public function eliminar() {
        $sql = "DELETE FROM inmuebles WHERE id_in ='{$this->id_in}'";
        $this->con->consultaSimple($sql);
    }

    public function consultar() {
        $sql = "SELECT * FROM inmuebles WHERE id_in ='{$this->id_in}'";
        $resultado = $this->con->consultaRetorno($sql);
        $row = mysqli_fetch_assoc($resultado);

        $this->id_in = $row['id_in'];
        $this->nombre_in = $row['nombre_in'];
        $this->precio = $row['precio'];
        $this->descripcion = $row['descripcion'];
        $this->estatus = $row['estatus'];
        $this->categoria = $row['categoria'];
        $this->contacto = $row['contacto'];
        $this->ubicacion = $row['ubicacion'];
    }
}
?>
