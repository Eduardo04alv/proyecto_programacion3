<?php  
include('../../libreria/modelo.php');
$modelo = new modelo();
$modelo->encabezado(); 
$conn = conexion();


$sql_proveedores = "SELECT id_prov, nombre, apellido FROM proveedor";
$resultado_proveedores = $conn->query($sql_proveedores);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card mx-auto shadow" style="max-width: 500px;">
        <div class="card-header bg-primary text-white text-center">
            <h4>Agregar Nuevo Producto</h4>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">nombre:</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="precio_prod" class="form-label">precio:</label>
                    <input type="number" class="form-control" name="precio_prod" id="precio_prod" required>
                </div>
               <div class="mb-3">
                   <label for="id_prove" class="form-label">Proveedor:</label>
                   <select class="form-select" name="id_prove" id="id_prove" required>
                      <option value="" disabled selected>Seleccione un proveedor</option>
                        <?php while ($row = $resultado_proveedores->fetch_assoc()): ?>
                        <option value="<?= $row['id_prov'] ?>">
                        <?= $row['nombre'] . ' ' . $row['apellido'] ?>
                     </option>
                      <?php endwhile; ?>
                   </select>
                </div>
                
                <div class="mb-3">
                    <label for="inventario_prod" class="form-label">inventario prod:</label>
                    <input type="number" class="form-control" name="inventario_prod" id="inventario_prod" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <?php 
    if (
        isset($_POST['nombre']) &&
        isset($_POST['precio_prod']) &&
        isset($_POST['inventario_prod'])&&
        isset($_POST['id_prove']) 
    ) {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $precio_prod = $conn->real_escape_string($_POST['precio_prod']);
        $inventario_prod = $conn->real_escape_string($_POST['inventario_prod']);
        $id_prove = $conn->real_escape_string($_POST['id_prove']);

        $sql = "INSERT INTO productos(nombre,  cantidad, precio, id_prov) 
                VALUES ('$nombre',  '$inventario_prod', $precio_prod, $id_prove)";

        if ($conn->query($sql) === true) {
            echo "<div class='alert alert-success text-center mt-4'>¡Cliente guardado correctamente!</div>";
        } else {
            echo "<div class='alert alert-danger text-center mt-4'>Error al guardar: " . $conn->error . "</div>";
        }
        echo "<script>
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 1500);
                  </script>";
    }
    ?>
</div>

</body>
</html>
