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
    <title>Productos</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Listado de productos</h2>
        <a href="add.php" class="btn btn-primary">Agregar productos</a>
    </div>

    <table class="table table-hover table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Inventario</th>    
                <th>Proveedor</th>    
                <th>Acciones</th>       
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
            // INNER JOIN con la tabla proveedor
            $respuesta = $conn->query("
                SELECT p.id_prod, p.nombre AS nombre_prod, p.precio, p.cantidad, pr.nombre AS nombre_prov
                FROM productos p
                INNER JOIN proveedor pr ON p.id_prov = pr.id_prov
            ");

            if ($respuesta->num_rows > 0) {
                while($data = $respuesta->fetch_object()){
                    echo "<tr>";
                    echo "<td>{$data->id_prod}</td>";
                    echo "<td>{$data->nombre_prod}</td>";
                    echo "<td>{$data->precio}</td>";
                    echo "<td>{$data->cantidad}</td>";
                    echo "<td>{$data->nombre_prov}</td>";
                    echo "<td>
                            <a href='editar.php?id={$data->id_prod}' class='btn btn-sm btn-warning me-1'>Editar</a>
                            <a href='eliminar.php?id={$data->id_prod}' class='btn btn-sm btn-danger'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay productos registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

