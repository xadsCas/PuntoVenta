<?php
include "conexion.php";

$sql = "SELECT V.*, E.Nombre AS nombre_empleado 
        FROM Venta V 
        LEFT JOIN Empleado E ON V.Id_Empleado = E.Id_Empleado
        ORDER BY Fecha DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Facturas</title>
    <style>
        .scroll {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        #buscador {
            margin-bottom: 10px;
            padding: 5px;
        }
    </style>
</head>
<body>

<h2>📄 Historial de Facturas</h2>

<input type="text" id="buscador" placeholder="Buscar por ID de Factura...">

<div class="scroll">
    <table id="tabla">
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>Empleado</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['Folio'] ?></td>
                <td><?= $row['Fecha'] ?></td>
                <td><?= $row['nombre_empleado'] ?? 'Desconocido' ?></td>
                <td>$<?= number_format($row['Total'], 2) ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<br><a href="Inicio.html"><button>Volver al inicio</button></a>

<script>
document.getElementById('buscador').addEventListener('input', function () {
    const filtro = this.value.toLowerCase();
    const filas = document.querySelectorAll('#tabla tbody tr');

    filas.forEach(fila => {
        const id = fila.cells[0].textContent.toLowerCase();
        fila.style.display = id.includes(filtro) ? '' : 'none';
    });
});
</script>

</body>
</html>
