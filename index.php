<?php 
include "libreria/modelo.php";
$modelo = new modelo();
$modelo->encabezado();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
</head>
<body class="bg-light">

    <div class="container text-center py-5">
        <h1 class="mb-4">Sistema de Facturación</h1>
        <p class="lead mb-5">Selecciona una sección para continuar:</p>

        <div class="d-grid gap-3 col-6 mx-auto">
            <a href="vistas/proveedor/index.php" class="btn btn-primary btn-lg">proveedor</a>
            <a href="vistas/productos/index.php" class="btn btn-success btn-lg">Productos</a>
            <a href="vistas/facturas/index.php" class="btn btn-warning btn-lg">Facturas</a>
            <a href="vistas/reportes/index.php" class="btn btn-dark btn-lg">Reporte Diario</a>
        </div>
    </div>

</body>
</html>