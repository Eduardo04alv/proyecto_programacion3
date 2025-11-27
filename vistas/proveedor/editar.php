<?php  
include('../../libreria/modelo.php');
$modelo = new modelo();
$modelo->encabezado(); 
$conn = conexion();



$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$proveedoree = null;

if ($id > 0) {
    $sql = "SELECT * FROM proveedor WHERE id_prov = $id";
    $resultado = $conn->query($sql);
    if ($resultado && $resultado->num_rows > 0) {
        $proveedoree = $resultado->fetch_object();
    } else {
        echo "<div class='alert alert-danger text-center'>❌ proveedor no encontrado.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-warning text-center'>⚠️ ID no válido.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar proveedor</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow mx-auto" style="max-width: 500px;">
        <div class="card-header bg-warning text-white text-center">
            <h4>Editar proveedor</h4>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($proveedoree->nombre) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input type="text" name="apellido" value="<?= htmlspecialchars($proveedoree->apellido) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono:</label>
                    <input type="text" name="telefono" value="<?= htmlspecialchars($proveedoree->telefono) ?>" class="form-control" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary" name="guardar">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $telefono = $conn->real_escape_string($_POST['telefono']);

    $sql = "UPDATE proveedor SET 
                nombre='$nombre',
                apellido='$apellido',
                telefono='$telefono'
            WHERE id_prov=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success text-center mt-4'>
                Cambios guardados correctamente. Redirigiendo...
              </div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 2000);
              </script>";
    } else {
        echo "<div class='alert alert-danger text-center mt-4'>
                 Error al guardar: " . $conn->error . "
              </div>";
    }
}
?>

</body>
</html>
