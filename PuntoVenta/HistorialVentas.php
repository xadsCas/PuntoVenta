<?php
include "conexion.php";

$sql = "
    SELECT 
        v.Folio, 
        v.Fecha, 
        p.Nombre AS Producto, 
        dv.Cantidad, 
        dv.Precio_unitario, 
        dv.Subtotal, 
        v.Total
    FROM Venta v
    JOIN Detalle_Venta dv ON v.Folio = dv.Folio_venta
    JOIN Inventario p ON dv.Id_producto = p.id_producto
    ORDER BY v.Fecha DESC, v.Folio DESC
";

$result = $conn->query($sql);
$ventas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ventas[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }

        h1 {
            text-align: center;
        }

        #buscador {
            margin: 20px auto;
            text-align: center;
        }

        #buscador input {
            width: 300px;
            padding: 8px;
            font-size: 16px;
        }

        .tabla-contenedor {
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #ccc;
            background-color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        #btn-volver {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 12px 20px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        #btn-volver:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>

<h1>Historial de Ventas</h1>

<div id="buscador">
    <input type="text" id="filtroFolio" placeholder="Buscar por folio...">
</div>

<div class="tabla-contenedor">
    <table id="tablaVentas">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Total Venta</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $lastFolio = null;
            foreach ($ventas as $row) {
                echo "<tr>";
                echo "<td>" . ($row['Folio'] !== $lastFolio ? $row['Folio'] : "") . "</td>";
                echo "<td>" . ($row['Folio'] !== $lastFolio ? $row['Fecha'] : "") . "</td>";
                echo "<td>{$row['Producto']}</td>";
                echo "<td>{$row['Cantidad']}</td>";
                echo "<td>$" . number_format($row['Precio_unitario'], 2) . "</td>";
                echo "<td>$" . number_format($row['Subtotal'], 2) . "</td>";
                echo "<td>" . ($row['Folio'] !== $lastFolio ? "$" . number_format($row['Total'], 2) : "") . "</td>";
                echo "</tr>";

                $lastFolio = $row['Folio'];
            }
            ?>
        </tbody>
    </table>
</div>

<a href="inicio.html">
    <button id="btn-volver">Volver al inicio</button>
</a>

<script>
    // Buscador por folio en tiempo real
    document.getElementById("filtroFolio").addEventListener("keyup", function () {
        const filtro = this.value.toLowerCase();
        const filas = document.querySelectorAll("#tablaVentas tbody tr");

        filas.forEach(fila => {
            const folio = fila.cells[0].innerText.toLowerCase();
            if (folio.includes(filtro) || filtro === "") {
                fila.style.display = "";
            } else {
                fila.style.display = "none";
            }
        });
    });
</script>

</body>
</html>
