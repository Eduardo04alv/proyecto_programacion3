<?php
require_once("../../libreria/modelo.php");
$modelo = new modelo();
$modelo->encabezado();
$con = conexion();

// Consultar totales de ventas agrupados por fecha
$res = $con->query("
    SELECT DATE(fecha) AS dia, SUM(total) AS total_ventas
    FROM facturas
    GROUP BY DATE(fecha)
    ORDER BY DATE(fecha) ASC
");

$fechas = [];
$totales = [];

while($row = $res->fetch_assoc()) {
    $fechas[] = $row['dia'];
    $totales[] = $row['total_ventas'];
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Reporte de Ventas</h2>

    <!-- Gráfico de ganancias -->
    <canvas id="graficoVentas" width="800" height="400"></canvas>

    <!-- Tabla de ventas -->
    <table class="table table-bordered table-hover mt-4">
        <thead class="table-dark">
            <tr>
                <th>Fecha</th>
                <th>Total Ventas</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i=0; $i<count($fechas); $i++): ?>
                <tr>
                    <td><?= $fechas[$i] ?></td>
                    <td>$<?= number_format($totales[$i], 2) ?></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoVentas').getContext('2d');
const grafico = new Chart(ctx, {
    type: 'bar', // Puedes cambiar a 'line' si prefieres línea
    data: {
        labels: <?= json_encode($fechas) ?>,
        datasets: [{
            label: 'Ganancias por día',
            data: <?= json_encode($totales) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
