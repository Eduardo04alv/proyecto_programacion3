<?php  
include('../../libreria/modelo.php');
$modelo = new modelo();
$modelo->encabezado(); 
$conn = conexion();
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
            <h4>Agregar Nuevo Proveedor</h4>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">nombre_prove:</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">apellido_prove:</label>
                    <input type="text" class="form-control" name="apellido" id="apellido" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">telefono_prove:</label>
                    <input type="text" class="form-control" name="telefono" id="telefono" required>
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
        isset($_POST['apellido']) &&
        isset($_POST['telefono'])
    ) {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $apellido_prove = $conn->real_escape_string($_POST['apellido']);
        $telefono_prove = $conn->real_escape_string($_POST['telefono']);

        $sql = "INSERT INTO proveedor (nombre, apellido, telefono) 
                VALUES ('$nombre', '$apellido_prove', '$telefono_prove')";

        if ($conn->query($sql) === true) {
            echo "<div class='alert alert-success text-center mt-4'>Proveedor guardado correctamente!</div>";
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
