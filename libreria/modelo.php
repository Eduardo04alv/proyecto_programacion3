<?php  
class modelo {
    public function encabezado() {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        </head>
        <body>
            <div class="container mt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="../../index.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-house-door-fill"></i>
                    </a>
                    <h2 class="text-center flex-grow-1">veterinaria la selva</h2>
                  
                    <div style="width: 56px;"></div>
                </div>
        <?php
    }
}
function conexion(){
    $con = new mysqli("localhost","root","","veterinaria_la_selva");
    if($con->connect_error){
        echo"error en la conexion con la base de datos";
    }
    return $con;
}
?>