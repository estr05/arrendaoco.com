<?php
$nombre_in = $_POST['nombre_in'];
$precio = $_POST['precio'];
$descripcion = $_POST['descripcion'];
$estatus = $_POST['estatus'];
$categoria = $_POST['categoria'];
$contacto = $_POST['contacto'];
$ubicacion = $_POST['ubicacion'];

// Conexión a la base de datos
$con = new mysqli("localhost", "root", "", "arrendaoco");

// Verificar la conexión
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

// Insertar datos
$sql = "INSERT INTO inmuebles(nombre_in, precio, descripcion, estatus, categoria, contacto, ubicacion) 
         VALUES ('$nombre_in', '$precio', '$descripcion', '$estatus', '$categoria', '$contacto', '$ubicacion')";

// Ejecutar la consulta y verificar si fue exitosa
if ($con->query($sql) === TRUE) {
    echo "
    <script>
        alert('Inmueble registrado correctamente');
        window.location.href='index3.php'; // Make sure index3.php exists or change it to the correct redirect
    </script>";
} else {
    echo "Error al registrar el inmueble: " . $con->error;
}

// Cerrar la conexión
$con->close();

?>
