<?php
include "conexion.php";

$sql = "SELECT CC.*, E.Nombre AS nombre_empleado
        FROM corte_caja CC
        LEFT JOIN Empleado E ON CC.Id_Empleado = E.Id_Empleado
        ORDER BY Fecha DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Cortes</title>
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

<h2>📚 Historial de Cortes de Caja</h2>

<input type="text" id="buscador" placeholder="Buscar por ID de Corte...">

<div class="scroll">
    <table id="tabla">
        <thead>
            <tr>
                <th>ID Corte</th>
                <th>Fecha</th>
                <th>Empleado</th>
                <th>Total Sistema</th>
                <th>Total Efectivo</th>
                <th>Diferencia</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['Id_Corte'] ?></td>
                <td><?= $row['Fecha'] ?></td>
                <td><?= $row['nombre_empleado'] ?? 'Desconocido' ?></td>
                <td>$<?= number_format($row['Total_sistema'], 2) ?></td>
                <td>$<?= number_format($row['Total_efectivo'], 2) ?></td>
                <td style="color:<?= $row['Diferencia'] == 0 ? 'green' : 'red' ?>">
                    $<?= number_format($row['Diferencia'], 2) ?>
                </td>
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
