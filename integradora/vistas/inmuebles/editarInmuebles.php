<?php
include_once("clases/conexion.php");
include_once("clases/Inmueble.php");



$con = new conexion();
$inmueble = new Inmuebles();

$id_in = isset($_GET['id_in']) ? intval($_GET['id_in']) : 0;
if ($id_in <= 0) {
    echo "<p>Inmueble no válido.</p>";
    exit;
}

$sql_inmueble = "SELECT * FROM inmuebles WHERE id_in = $id_in";
$res_inmueble = $con->consultaRetorno($sql_inmueble);
$datos = mysqli_fetch_assoc($res_inmueble);

if (!$datos) {
    echo "<p>No se encontró el inmueble.</p>";
    exit;
}

if (isset($_POST['actualizar'])) {
    $nombre_in = trim($_POST['nombre_in']);
    $precio = floatval($_POST['precio']);
    $descripcion = trim($_POST['descripcion']);
    $estatus = $_POST['estatus'];
    $categoria = $_POST['categoria'];
    $contacto = trim($_POST['contacto']);
    $ubicacion = trim($_POST['ubicacion']);

    $sql_update = "UPDATE inmuebles 
                   SET nombre_in='$nombre_in', precio='$precio', descripcion='$descripcion', 
                       estatus='$estatus', categoria='$categoria', contacto='$contacto', ubicacion='$ubicacion' 
                   WHERE id_in = $id_in";
    $con->consultaSimple($sql_update);

    if (!empty($_FILES['imagenes']['name'][0])) {
        $rutaCarpeta = "uploads/inmuebles/";
        if (!is_dir($rutaCarpeta)) {
            mkdir($rutaCarpeta, 0777, true);
        }

        foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
            $nombreOriginal = basename($_FILES['imagenes']['name'][$key]);
            $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

            $permitidas = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($extension, $permitidas)) continue;
            if ($_FILES['imagenes']['size'][$key] > 5 * 1024 * 1024) continue;

            $nombreArchivo = uniqid() . "_" . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $nombreOriginal);
            $rutaDestino = $rutaCarpeta . $nombreArchivo;

            if (move_uploaded_file($tmp_name, $rutaDestino)) {
                $inmueble->guardarImagen($id_in, $rutaDestino);
            }
        }
    }

    if (isset($_SESSION['bandera'])) {
        if ($_SESSION['bandera'] == 1) {
            header("Location: index2.php");
        } elseif ($_SESSION['bandera'] == 2) {
            header("Location: index3.php");
        } else {
            header("Location: login.html");
        }
    } else {
        header("Location: login.html");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Inmueble</title>          
    <link rel="stylesheet" href="formulario.css">
</head>
<body>
    <div class="form-container">
        <h1>Editar Inmueble</h1>
        <form method="POST" enctype="multipart/form-data" class="styled-form">
            <label>Nombre del Inmueble</label>
            <input type="text" name="nombre_in" value="<?= htmlspecialchars($datos['nombre_in']); ?>" required>

            <label>Precio</label>
            <input type="number" step="0.01" name="precio" value="<?= $datos['precio']; ?>" required>

            <label>Descripción</label>
            <textarea name="descripcion" required><?= htmlspecialchars($datos['descripcion']); ?></textarea>

            <label>Estatus</label>
            <select name="estatus" required>
                <option value="Disponible" <?= $datos['estatus'] == 'Disponible' ? 'selected' : ''; ?>>Disponible</option>
                <option value="Ocupado" <?= $datos['estatus'] == 'Ocupado' ? 'selected' : ''; ?>>Ocupado</option>
            </select>

            <label>Categoría</label>
            <select name="categoria" required>
                <option value="Cuarto" <?= $datos['categoria'] == 'Cuarto' ? 'selected' : ''; ?>>Cuarto</option>
                <option value="Casa" <?= $datos['categoria'] == 'Casa' ? 'selected' : ''; ?>>Casa</option>
                <option value="Departamento" <?= $datos['categoria'] == 'Departamento' ? 'selected' : ''; ?>>Departamento</option>
            </select>

            <label>Contacto</label>
            <input type="text" name="contacto" value="<?= htmlspecialchars($datos['contacto']); ?>" required>

            <label>Ubicación</label>
            <input type="text" name="ubicacion" value="<?= htmlspecialchars($datos['ubicacion']); ?>" required>

            <label>Imágenes adicionales</label>
            <input type="file" name="imagenes[]" multiple accept="image/*">
            <small>Formatos permitidos: JPG, PNG, WEBP. Máx 5MB por imagen.</small>

            <button type="submit" name="actualizar">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
