<?php
include "conexion.php";

// Consulta del historial de arqueos
$sql_historial = "SELECT A.id_arqueo, A.fecha, A.idempleado, A.total_efectivo, A.diferencia, A.observaciones,
                         E.Nombre AS nombre_empleado
                  FROM arqueo A
                  LEFT JOIN empleado E ON A.idempleado = E.Id_Empleado
                  ORDER BY A.fecha DESC";
$result_historial = $conn->query($sql_historial);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Arqueos</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .diferencia-ok {
            color: green;
            font-weight: bold;
        }

        .diferencia-error {
            color: red;
            font-weight: bold;
        }

        .scroll-container {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            margin-top: 10px;
        }

        #buscarInput {
            padding: 6px;
            margin-bottom: 10px;
            width: 250px;
        }

        button {
            padding: 8px 12px;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <h2>📋 Historial de Arqueos</h2>

    <input type="text" id="buscarInput" placeholder="Buscar por ID de Arqueo...">

    <div class="scroll-container">
        <table id="tablaArqueos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Empleado</th>
                    <th>Total Efectivo</th>
                    <th>Diferencia</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_historial->num_rows > 0): ?>
                    <?php while ($row = $result_historial->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_arqueo'] ?></td>
                            <td><?= $row['fecha'] ?></td>
                            <td><?= $row['nombre_empleado'] ?? 'Desconocido' ?> (ID: <?= $row['idempleado'] ?>)</td>
                            <td>$<?= number_format($row['total_efectivo'], 2) ?></td>
                            <td class="<?= $row['diferencia'] == 0 ? 'diferencia-ok' : 'diferencia-error' ?>">
                                $<?= number_format($row['diferencia'], 2) ?>
                            </td>
                            <td><?= nl2br(htmlspecialchars($row['observaciones'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6">No hay registros de arqueo disponibles.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <br><br>
    <a href="Inicio.html"><button>Volver al inicio</button></a>

    <script>
        document.getElementById('buscarInput').addEventListener('keyup', function () {
            const filter = this.value.trim();
            const rows = document.querySelectorAll('#tablaArqueos tbody tr');

            rows.forEach(row => {
                const id = row.cells[0].textContent.trim();
                if (id.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

</body>
</html>
