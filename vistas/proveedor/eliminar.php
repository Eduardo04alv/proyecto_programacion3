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
    <title>Eliminar proveedor</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-body text-center">

            <?php
            if (isset($_GET["id"])) {
                $id = intval($_GET["id"]);

                $sql = "DELETE FROM proveedor WHERE id_prov = $id";

                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success'>
                             Registro eliminado con éxito. Redirigiendo...
                          </div>";
                } else {
                    echo "<div class='alert alert-danger'>
                             Error al eliminar: " . $conn->error . "
                          </div>";
                }
            } else {
                echo "<div class='alert alert-warning'>
                        ⚠️ No se especificó un ID válido para eliminar.
                      </div>";
            }

            $conn->close();
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 1500);
                  </script>";
            ?>

        </div>
    </div>
</div>

</body>
</html>
