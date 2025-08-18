<?php
require_once("../../libreria/modelo.php");
$con = conexion();

$id_factura = intval($_POST['id_factura']);
$id_prod = intval($_POST['id_prod']);
$cantidad = intval($_POST['cantidad']);

// Consultar el producto y verificar stock
$res = $con->query("SELECT cantidad, precio FROM productos WHERE id_prod = $id_prod");
if ($res->num_rows == 0) {
    die("Producto no encontrado");
}

$producto = $res->fetch_assoc();

if ($producto['cantidad'] < $cantidad) {
    die("No hay suficiente inventario para este producto");
}

// Calcular subtotal
$subtotal = $producto['precio'] * $cantidad;

$con->begin_transaction();

try {
    // Insertar detalle de factura
    $stmt = $con->prepare("INSERT INTO detalle_factura (id_factura, id_prod, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiidd", $id_factura, $id_prod, $cantidad, $producto['precio'], $subtotal);
    $stmt->execute();

    // Actualizar total de la factura
    $con->query("UPDATE facturas SET total = total + $subtotal WHERE id_factura = $id_factura");

    // Reducir inventario
    $stmt2 = $con->prepare("UPDATE productos SET cantidad = cantidad - ? WHERE id_prod = ?");
    $stmt2->bind_param("ii", $cantidad, $id_prod);
    $stmt2->execute();

    $con->commit();
    header("Location: index.php?id_factura=$id_factura");
    exit;
} catch (Exception $e) {
    $con->rollback();
    die("Error al procesar el producto: " . $e->getMessage());
}
?>
