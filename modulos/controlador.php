<?php
    include ('clases/Inmueble.php');
    include ('clases/Usuario.php');
    include ('clases/Comentario.php');
    //Clase para productos
    class controladorInmuebles{
        //atributos
        private $inmuebles;
        public function __construct() {
            $this->inmuebles = new Inmuebles();
    }
    public function index () {
        $resultado = $this->inmuebles->listar();
        return $resultado;
    }
    public function crear ($propietario,$nombre_in, $precio, $descripcion, $estatus, $categoria, $contacto, $ubicacion) {
        $this->inmuebles->set("propietario", $propietario);
        $this->inmuebles->set("nombre_in", $nombre_in);
        $this->inmuebles->set("precio", $precio);
        $this->inmuebles->set("descripcion", $descripcion);
        $this->inmuebles->set("estatus", $estatus);
        $this->inmuebles->set("categoria", $categoria);
        $this->inmuebles->set("contacto", $contacto);
        $this->inmuebles->set("ubicacion", $ubicacion);

        $resultado = $this->inmuebles->crear();
        return $resultado;
    }
    public function eliminar($id_in){
        $this->inmuebles->set("id_in", $id_in);
        $this->inmuebles->eliminar();
    }
    public function consultar($id_in){
        $this->inmuebles->set("id_in", $id_in);
        $datos= $this->inmuebles->consultar();
        return $datos;
    }
    public function editar ($id_in,$nombre_in, $precio, $descripcion, $estatus, $categoria, $contacto, $ubicacion) {

         $this->inmuebles->set("id_in", $id_in);
        $this->inmuebles->set("nombre_in", $nombre_in);
        $this->inmuebles->set("precio", $precio);
        $this->inmuebles->set("descripcion", $descripcion);
        $this->inmuebles->set("estatus", $estatus);
        $this->inmuebles->set("categoria", $categoria);
        $this->inmuebles->set("contacto", $contacto);
        $this->inmuebles->set("ubicacion", $ubicacion);

        $resultado = $this->inmuebles->editar();
        return $resultado;
    }
    
    
}
//clase para USUARIOS

class controladorUsuario{
        //atributos
        private $usuario;
        public function __construct() {
            $this->usuario = new Usuario();
    }
    public function index () {
        $resultado = $this->usuario->listar();
        return $resultado;
    }
    public function crear ($user, $pass, $nombre, $direccion, $tel, $correo, $bandera) {
        $this->usuario->set("nombre", $nombre);
        $this->usuario->set("user", $user);
        $this->usuario->set("pass", $pass);
        $this->usuario->set("direccion", $direccion);
        $this->usuario->set("tel", $tel);
        $this->usuario->set("correo", $correo);
        $this->usuario->set("bandera", $bandera);

        $resultado = $this->usuario->crear();
        return $resultado;
    }
    public function eliminar($id_user){
        $this->usuario->set("id_user", $id_user);
        $this->usuario->eliminar();
    }
    public function consultar($id_user){
        $this->usuario->set("id_user", $id_user);
        $datos= $this->usuario->consultar();
        return $datos;
    }
    
   public function editar ($id_user,$user, $pass, $nombre, $direccion, $tel, $correo) {

         $this->usuario->set("id_user", $id_user);
        $this->usuario->set("user", $user);
        $this->usuario->set("pass", $pass);
        $this->usuario->set("nombre", $nombre);
        $this->usuario->set("direccion", $direccion);
        $this->usuario->set("tel", $tel);
        $this->usuario->set("correo", $correo);

        $resultado = $this->usuario->editar();
        return $resultado;
    }
}
    

//Comentarios

class controladorComentario{
        //atributos
        private $comentario;
        public function __construct() {
            $this->comentario = new Comentario();
    }
    public function index () {
        $resultado = $this->comentario->listar();
        return $resultado;
    }
    public function eliminar($id){
        
        $this->comentario->set("id", $id);
        $this->comentario->eliminar();
    }
    public function consultar($id){
        $this->comentario->set("id", $id);
        $datos= $this->comentario->consultar();
        return $datos;
    }
}


?>