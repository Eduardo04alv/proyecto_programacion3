<?php  
include('../../libreria/modelo.php');
$modelo = new modelo();
$modelo->encabezado(); 
$conn = conexion();

// Obtener ID del producto
$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$producto = null;
$mensaje = '';

if ($id > 0) {
    $sql = "SELECT * FROM productos WHERE id_prod = $id";
    $resultado = $conn->query($sql);
    if ($resultado && $resultado->num_rows > 0) {
        $producto = $resultado->fetch_object();
    } else {
        echo "<div class='alert alert-danger text-center'>❌ Producto no encontrado.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-warning text-center'>⚠️ ID no válido.</div>";
    exit;
}

// Guardar cambios
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);
    $id_prov = intval($_POST['id_prov']);

    $sql = "UPDATE productos SET 
                nombre='$nombre',
                precio='$precio',
                cantidad='$cantidad',
                id_prov='$id_prov'
            WHERE id_prod=$id";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "<div class='alert alert-success text-center mt-3'>
                        ✅ Cambios guardados correctamente.
                     </div>";
                      echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 2000);
              </script>";
        // Actualizar el objeto $producto para reflejar cambios en el formulario
        $producto->nombre = $nombre;
        $producto->precio = $precio;
        $producto->cantidad = $cantidad;
        $producto->id_prov = $id_prov;
    } else {
        $mensaje = "<div class='alert alert-danger text-center mt-3'>
                        ❌ Error al guardar: " . $conn->error . "
                     </div>";
                      echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 2000);
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar producto</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow mx-auto" style="max-width: 500px;">
        <div class="card-header bg-warning text-white text-center">
            <h4>Editar Producto</h4>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($producto->nombre) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio:</label>
                    <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($producto->precio) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="cantidad" class="form-label">Inventario:</label>
                    <input type="number" name="cantidad" value="<?= htmlspecialchars($producto->cantidad) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_prov" class="form-label">Proveedor:</label>
                    <select name="id_prov" class="form-control" required>
                        <option value="" disabled>Selecciona un proveedor</option>
                        <?php
                        $proveedores = $conn->query("SELECT id_prov, nombre FROM proveedor ORDER BY nombre ASC");
                        while($prov = $proveedores->fetch_assoc()) {
                            $selected = ($prov['id_prov'] == $producto->id_prov) ? 'selected' : '';
                            echo "<option value='{$prov['id_prov']}' $selected>{$prov['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Mensaje de éxito/error -->
                <?= $mensaje ?>

                <div class="d-flex justify-content-between mt-3">
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary" name="guardar">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
