<?php
if (!isset($_SESSION['bandera'])) {
    header("Location: login.html");
    exit;
}

if ($_SESSION['bandera'] == 1) {
    header("Location: index2.php?cargar=inicioUsuarioAdmin");
    exit;
}
// Si bandera == 2, se queda en esta vista
?>
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
<link rel="stylesheet" href="usuario.css">
<h1 class="page-title">Perfil del Usuario</h1>

<div class="profiles-grid-wrapper">
    <?php
    if ($resultado && mysqli_num_rows($resultado) > 0):
        while ($row = mysqli_fetch_assoc($resultado)):
    ?>
        <div class="profile-card-container">
            <div class="profile-card">
                <div class="profile-header">
                    <h2>Detalles del perfil</h2>
                </div>

                <div class="user-info">
                    <h3><?php echo $row['nombre']; ?></h3>
                    <p><i class="bi bi-person"></i> Usuario: <?php echo $row['user']; ?></p>
                    <p><i class="bi bi-key"></i> Contraseña <?php echo $row['pass']; ?></p>
                    <p><i class="bi bi-house"></i> Dirección: <?php echo $row['direccion']; ?></p>
                    <p><i class="bi bi-telephone"></i> Teléfono: <?php echo $row['tel']; ?></p>
                    <p><i class="bi bi-envelope"></i> <a href="mailto:<?php echo $row['correo']; ?>"><?php echo $row['correo']; ?></a></p>
                </div>

                <div class="profile-actions">
                    <a href="?cargar=editarUsuario&id_user=<?php echo $row['id_user']; ?>" class="action-button edit-button">
                        <i class="bi bi-pencil-square "></i> Editar
                    </a>
                </div>
            </div>
        </div>
    <?php
        endwhile;
    else:
    ?>
        <p class="no-results">No se encontraron usuarios.</p>
    <?php endif; ?>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/sweetalert.min.js"></script>

<script language="javascript">
    function confirmar(id_user){
        var MyId = id_user;
        swal({
            title: "¿Estas seguro de eliminar el registro?",
            text: "¡Ya no podrás recuperarlo!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí, Eliminar",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                window.location.href='?cargar=eliminarUsuario&id_user=' + MyId;
            } else {
                swal("Cancelado", "Tu registro está a salvo :)", "error");
            }
        });
    }
</script>
