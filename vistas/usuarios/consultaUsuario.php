<form method="POST" action="">
    <label>Nombre del usuario</label>><input type="search" name="buscar">
</form>
<table class='table table-striped'>
    <thead>
        <th class='success'>Id</th>
        <th class='success'>Usuario</th>
        <th class='success'>Contraseña</th>
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
                <td><a href=?cargar=editar&id=<?php echo $row['id_user']; ?>>Editar</a></td>
                <td><a onClick='confirmar(<?php echo $row['id_user']; ?>)'>Eliminar<</a></td>
                
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script src="js/jquery.js"></script>
 <script language = "javascript">
            function confirmar(id_user){
                confirmar= confirm("Realmente deseas eliminar el registro?");
                if(confirmar)
            {
             window.location.href='?cargar=elimnar&id='+id_user; 
             alert('Registro eliminado...');
            }
            else {
                document.location="index.php";
            }
            }
</script>

