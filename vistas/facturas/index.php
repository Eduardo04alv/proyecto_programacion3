<?php
require_once("../../libreria/modelo.php");
$m = new modelo();
$m->encabezado();

$con = conexion();

// Si no hay factura activa, crear una nueva
if (!isset($_GET['id_factura'])) {
    $con->query("INSERT INTO facturas (total) VALUES (0.00)");
    $id_factura = $con->insert_id;
    header("Location: index.php?id_factura=$id_factura");
    exit;
} else {
    $id_factura = intval($_GET['id_factura']);
}

// Consultar los productos de la factura actual
$sql = "SELECT df.id_detalle, p.nombre, df.cantidad, df.precio_unitario, df.subtotal
        FROM detalle_factura df
        JOIN productos p ON df.id_prod = p.id_prod
        WHERE df.id_factura = $id_factura";
$detalles = $con->query($sql);

// Total de la factura
$total = 0;
$res = $con->query("SELECT total FROM facturas WHERE id_factura = $id_factura");
if ($row = $res->fetch_assoc()) {
    $total = $row['total'];
}
?>

<div class="card shadow p-4">
    <h4 class="mb-3">Caja Registradora</h4>

    <!-- Buscar/agregar producto -->
    <form action="procesar_producto.php" method="post" class="row g-2 mb-4">
    <input type="hidden" name="id_factura" value="<?= $id_factura ?>">
    <div class="col-md-6">
        <select name="id_prod" class="form-control" required>
            <option value="" disabled selected>Selecciona un producto</option>
            <?php
            // Consultar todos los productos disponibles
            $productos = $con->query("SELECT id_prod, nombre, cantidad FROM productos WHERE cantidad > 0");
            if ($productos->num_rows > 0) {
                while($prod = $productos->fetch_assoc()) {
                    echo "<option value='{$prod['id_prod']}'>{$prod['nombre']} (Disponible: {$prod['cantidad']})</option>";
                }
            } else {
                echo "<option value='' disabled>No hay productos disponibles</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-md-3">
        <input type="number" name="cantidad" class="form-control" placeholder="Cantidad" value="1" min="1" required>
    </div>
    <div class="col-md-3 d-grid">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Agregar
        </button>
    </div>
</form>

    <!-- Tabla de detalle -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Producto</th>
                <th class="text-center">Cantidad</th>
                <th class="text-end">Precio Unit.</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($detalles->num_rows > 0): ?>
                <?php while ($fila = $detalles->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['nombre']) ?></td>
                        <td class="text-center"><?= $fila['cantidad'] ?></td>
                        <td class="text-end"><?= number_format($fila['precio_unitario'], 2) ?></td>
                        <td class="text-end"><?= number_format($fila['subtotal'], 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">No hay productos agregados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Total -->
    <div class="text-end">
        <h3>Total: <span class="text-success">$<?= number_format($total, 2) ?></span></h3>
    </div>

    <!-- Botones de acción -->
    <div class="d-flex justify-content-between mt-4">
        <a href="finalizar_factura.php?id_factura=<?= $id_factura ?>" class="btn btn-primary btn-lg">
            <i class="bi bi-check-circle"></i> Finalizar
        </a>
        <a href="cancelar_factura.php?id_factura=<?= $id_factura ?>" class="btn btn-danger btn-lg">
            <i class="bi bi-x-circle"></i> Cancelar
        </a>
    </div>
</div>

</div> <!-- cierre container del encabezado -->
</body>
</html>
