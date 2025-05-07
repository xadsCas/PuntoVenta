<?php
include "conexion.php";

// Consultar historial de compras
$sql = "SELECT 
            c.ID_Compra,
            c.Fecha,
            p.Nombre AS Proveedor,
            i.Nombre AS Producto,
            dc.Cantidad,
            dc.Precio_unitario,
            dc.Subtotal,
            c.Total
        FROM Compra c
        JOIN Proveedores p ON c.Id_proveedor = p.ID_Proveedor
        JOIN Detalle_Compra dc ON c.ID_Compra = dc.Id_compra
        JOIN Inventario i ON dc.Id_producto = i.id_producto
        ORDER BY c.Fecha DESC, c.ID_Compra DESC";

$result = $conn->query($sql);
$compras = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $compras[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }

        h1 {
            text-align: center;
        }

        #search-bar {
            margin: 20px auto;
            text-align: center;
        }

        #search-bar input {
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

<h1>Historial de Compras</h1>

<div id="search-bar">
    <input type="text" id="search" placeholder="Buscar por ID Compra...">
</div>

<div class="tabla-contenedor">
    <table id="tablaCompras">
        <thead>
            <tr>
                <th>ID Compra</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Total Compra</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $lastID = null;
            foreach ($compras as $row) {
                echo "<tr>";
                echo "<td>" . ($row['ID_Compra'] !== $lastID ? $row['ID_Compra'] : "") . "</td>";
                echo "<td>" . ($row['ID_Compra'] !== $lastID ? $row['Fecha'] : "") . "</td>";
                echo "<td>" . ($row['ID_Compra'] !== $lastID ? $row['Proveedor'] : "") . "</td>";
                echo "<td>{$row['Producto']}</td>";
                echo "<td>{$row['Cantidad']}</td>";
                echo "<td>$" . number_format($row['Precio_unitario'], 2) . "</td>";
                echo "<td>$" . number_format($row['Subtotal'], 2) . "</td>";
                echo "<td>" . ($row['ID_Compra'] !== $lastID ? "$" . number_format($row['Total'], 2) : "") . "</td>";
                echo "</tr>";

                $lastID = $row['ID_Compra'];
            }
            ?>
        </tbody>
    </table>
</div>

<a href="Inicio.html">
    <button id="btn-volver">Volver al inicio</button>
</a>

<script>
    // Buscador por ID Compra en tiempo real
    document.getElementById("search").addEventListener("keyup", function () {
        const filtro = this.value.toLowerCase();
        const filas = document.querySelectorAll("#tablaCompras tbody tr");

        filas.forEach(fila => {
            const idCompra = fila.cells[0].innerText.toLowerCase();
            if (idCompra.includes(filtro) || filtro === "") {
                fila.style.display = "";
            } else {
                fila.style.display = "none";
            }
        });
    });
</script>

</body>
</html>
