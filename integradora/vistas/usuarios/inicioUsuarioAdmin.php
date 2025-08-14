
<?php
    $usuario = new Usuario(); // Instancia de tu clase Usuario

    $buscar = '';
    $resultado = null;
    if (isset($_POST['buscar'])) {
        $buscar = $_POST['buscar']; 
        $resultado = $usuario->filtrar($buscar); 
    } else {
        $resultado = $usuario->listar();
    }
?>
<center><h1><b>Usuarios registrados</b></h1></center>

<form method="POST" action="">
    <label>Nombre del usuario</label>
    <input class="form-control container d-flex justify-content-center" type="search" name="buscar" value="<?php echo $buscar ?>" >
</form>
<div class="container d-flex justify-content-center">
<table class="table table-bordered">
    
    <thead>
        <th class='success'>Id</th>
        <th class='success'>Usuario</th>
        <th class='success'>Password</th>
        <th class='success'>Nombre</th>
        <th class='success'>Direccion</th>
        <th class='success'>Telefono</th>
        <th class='success'>Correo</th>
        <th class='success'>Rol</th>
        <th class='success'>Editar</th>
        <th class='success'>Eliminar</th>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultado)):?>
            <tr>
                <td><?php echo $row['id_user']; ?></td>
                <td><?php echo $row['user']; ?></td>
                <td><?php echo $row['pass']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['direccion']; ?></td>
                <td><?php echo $row['tel']; ?></td>
                <td><?php echo $row['correo']; ?></td>
                <td><?php echo $row['bandera']; ?></td>
                <td><a href="?cargar=editarUsuario&id_user=<?php echo $row['id_user']; ?>"><i class="btn btn-warning btn-sm">Editar</i></a></td>
                <td><a onClick='confirmar(<?php echo $row['id_user']; ?>)'><center><i class="btn btn-danger btn-sm" style="cursor:pointer;">Eliminar</i></center></a></td>
                
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
 
 <script language = "javascript">
            function confirmar(id_user){
    var MyId = id_user;
    swal({
        title: "¿Estas seguro de eliminar el registro",
        text: "Ya no podras recuperarlo",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, borrar",
        closeOnconfirm: false
    },
    function(){
        window.location.href='?cargar=eliminarUsuario&id_user='+MyId;  
    });
}
</script>
