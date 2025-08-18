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
    <title>Proveedores</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Listado de Proveedores</h2>
        <a href="add.php" class="btn btn-primary">Agregar Cliente</a>
    </div>

    <table class="table table-hover table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Telefono</th>   
                <th>Acciones</th>       
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
            $respuesta = $conn->query("SELECT * FROM proveedor");
            if ($respuesta->num_rows > 0) {
                while($data = $respuesta->fetch_object()){
                    echo "<tr>"; 
                    echo "<td>{$data->id_prov}</td>";
                    echo "<td>{$data->nombre}</td>";
                    echo "<td>{$data->apellido}</td>";
                    echo "<td>{$data->telefono}</td>";
                    echo "<td>
                            <a href='editar.php?id={$data->id_prov}' class='btn btn-sm btn-warning me-1'>Editar</a>
                            <a href='eliminar.php?id={$data->id_prov}' class='btn btn-sm btn-danger'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay clientes registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>