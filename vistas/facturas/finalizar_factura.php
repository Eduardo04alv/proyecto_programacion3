<?php
require_once("../../libreria/modelo.php");
$m = new modelo();
$m->encabezado();

$con = conexion();

// Obtener id_factura por GET
$id_factura = isset($_GET['id_factura']) ? intval($_GET['id_factura']) : 0;
if ($id_factura <= 0) {
    echo "<div class='alert alert-danger'>Factura no válida</div>";
    exit;
}

// Marcar factura como finalizada
$con->query("UPDATE facturas SET estado='finalizada' WHERE id_factura=$id_factura");

// Consultar cabecera de la factura
$res_factura = $con->query("SELECT * FROM facturas WHERE id_factura=$id_factura");
$factura = $res_factura->fetch_assoc();

// Consultar detalle de productos
$res_detalle = $con->query("
    SELECT df.cantidad, df.precio_unitario, df.subtotal, p.nombre 
    FROM detalle_factura df
    JOIN productos p ON df.id_prod = p.id_prod
    WHERE df.id_factura = $id_factura
");
?>

<div class="card shadow p-4">
    <h4 class="mb-3">Ticket de Venta</h4>
    
    <p><strong>Factura #:</strong> <?= $id_factura ?></p>
    <p><strong>Fecha:</strong> <?= $factura['fecha'] ?></p>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Producto</th>
                <th class="text-center">Cantidad</th>
                <th class="text-end">Precio Unit.</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $res_detalle->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td class="text-center"><?= $fila['cantidad'] ?></td>
                    <td class="text-end"><?= number_format($fila['precio_unitario'],2) ?></td>
                    <td class="text-end"><?= number_format($fila['subtotal'],2) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="text-end">
        <h4>Total: <span class="text-success">$<?= number_format($factura['total'],2) ?></span></h4>
    </div>

    <!-- Botones -->
    <div class="d-flex justify-content-between mt-4">
        <button onclick="window.print()" class="btn btn-info btn-lg">
            <i class="bi bi-printer-fill"></i> Imprimir
        </button>
        <a href="index.php" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Nueva Factura
        </a>
    </div>
</div>

</div> <!-- cierre container -->
</body>
</html>
