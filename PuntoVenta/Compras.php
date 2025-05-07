<?php
include "conexion.php";

// Obtener proveedores
$sql_proveedores = "SELECT ID_Proveedor, Nombre FROM Proveedores";
$proveedores = $conn->query($sql_proveedores)->fetch_all(MYSQLI_ASSOC);

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $IdProveedor = $_POST['id_proveedor'];
    $Total = floatval($_POST['total']);

    if ($Total <= 0) {
        echo "<script>alert('❌ El total no puede ser menor o igual a 0.');</script>";
    } else {
        $sql_compra = "INSERT INTO Compra (Id_proveedor, Total, Estado) VALUES (?, ?, 'Pendiente')";
        $stmt = $conn->prepare($sql_compra);
        $stmt->bind_param("id", $IdProveedor, $Total);
        if ($stmt->execute()) {
            $IdCompra = $conn->insert_id;

            foreach ($_POST['productos'] as $producto) {
                $IdProducto = $producto['id_producto'];
                $Cantidad = floatval($producto['cantidad']);
                $PrecioUnitario = floatval($producto['precio_unitario']);
                $Subtotal = $Cantidad * $PrecioUnitario;

                if ($Cantidad > 0) {
                    $sql_detalle = "INSERT INTO Detalle_Compra (Id_compra, Id_producto, Cantidad, Precio_unitario, Subtotal)
                                    VALUES (?, ?, ?, ?, ?)";
                    $stmt_detalle = $conn->prepare($sql_detalle);
                    $stmt_detalle->bind_param("iiidd", $IdCompra, $IdProducto, $Cantidad, $PrecioUnitario, $Subtotal);
                    $stmt_detalle->execute();

                    $sql_stock = "UPDATE Inventario SET Stock_actual = Stock_actual + ? WHERE id_producto = ?";
                    $stmt_stock = $conn->prepare($sql_stock);
                    $stmt_stock->bind_param("di", $Cantidad, $IdProducto);
                    $stmt_stock->execute();
                }
            }

            $sql_caja = "UPDATE Caja SET dinero_actual = dinero_actual - ? WHERE Id = 1";
            $stmt_caja = $conn->prepare($sql_caja);
            $stmt_caja->bind_param("d", $Total);
            $stmt_caja->execute();

            // ✅ Redirigir para evitar reenvío de formulario
            header("Location: Compras.php?exito=1");
            exit;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Compra</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        #tabla-productos { max-height: 400px; overflow-y: auto; border: 1px solid #ccc; }
        table { width: 100%; border-collapse: collapse; }
        thead { position: sticky; top: 0; background-color: #f8f8f8; }
        th, td { padding: 8px; border-bottom: 1px solid #ddd; text-align: center; }
        #buscador { margin-bottom: 10px; padding: 6px; width: 300px; }
        #total { font-weight: bold; font-size: 1.2em; background: #e0ffe0; padding: 5px; }
        .fila-producto input[type="number"] { width: 70px; }
        .boton-volver {
            padding: 10px 20px;
            background-color: #444;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2>Registrar Compra</h2>

<form method="POST" action="">
    <label for="id_proveedor">Proveedor:</label>
    <select name="id_proveedor" id="id_proveedor" required>
        <option value="">Seleccione un proveedor</option>
        <?php foreach ($proveedores as $prov): ?>
            <option value="<?= $prov['ID_Proveedor'] ?>"><?= $prov['Nombre'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="text" id="buscador" placeholder="Buscar producto por nombre o ID..." disabled>

    <div id="tabla-productos">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody id="cuerpo-tabla">
                <!-- Productos cargados dinámicamente -->
            </tbody>
        </table>
    </div>

    <br>
    <label for="total">Total:</label>
    <input type="number" id="total" name="total" readonly><br><br>

    <button type="submit">Registrar Compra</button>
</form>

<br><br>
<a href="Inicio.html" class="boton-volver">⬅ Volver al inicio</a>

<script>
document.getElementById('id_proveedor').addEventListener('change', function () {
    const idProveedor = this.value;
    const cuerpoTabla = document.getElementById('cuerpo-tabla');
    const buscador = document.getElementById('buscador');
    cuerpoTabla.innerHTML = '';
    buscador.value = '';
    buscador.disabled = !idProveedor;

    if (idProveedor) {
        fetch('getProductosPorProveedor.php?proveedor_id=' + idProveedor)
            .then(response => response.json())
            .then(data => {
                data.forEach(producto => {
                    const fila = document.createElement('tr');
                    fila.classList.add('fila-producto');
                    fila.innerHTML = `
                        <td>${producto.id_producto}</td>
                        <td>${producto.Nombre}</td>
                        <td>$${parseFloat(producto.Precio_compra).toFixed(2)}</td>
                        <td>
                            <input type="number" name="productos[${producto.id_producto}][cantidad]" min="0" placeholder="0" onchange="updateTotal()">
                            <input type="hidden" name="productos[${producto.id_producto}][id_producto]" value="${producto.id_producto}">
                            <input type="hidden" name="productos[${producto.id_producto}][precio_unitario]" value="${producto.Precio_compra}">
                        </td>
                    `;
                    cuerpoTabla.appendChild(fila);
                });
            });
    }
});

function updateTotal() {
    let total = 0;
    document.querySelectorAll('input[name$="[cantidad]"]').forEach(input => {
        const cantidad = parseFloat(input.value) || 0;
        const precio = parseFloat(input.parentElement.querySelector('input[name$="[precio_unitario]"]').value) || 0;
        total += cantidad * precio;
    });
    document.getElementById('total').value = total.toFixed(2);
}

document.getElementById('buscador').addEventListener('input', function () {
    const texto = this.value.toLowerCase();
    document.querySelectorAll('.fila-producto').forEach(fila => {
        const contenido = fila.textContent.toLowerCase();
        fila.style.display = contenido.includes(texto) ? '' : 'none';
    });
});
</script>

</body>
</html>
