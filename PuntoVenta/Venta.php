<?php
include "conexion.php";

// Obtener productos
$sql_productos = "SELECT Id_producto, Nombre, Precio_venta, Stock_actual, Descripcion FROM Inventario WHERE Stock_actual > 0";
$result_productos = $conn->query($sql_productos);
$productos_js = [];
while ($row = $result_productos->fetch_assoc()) {
    $productos_js[$row["Id_producto"]] = $row;
}

// Obtener empleados
$sql_empleados = "SELECT id_empleado, nombre FROM Empleado";
$result_empleados = $conn->query($sql_empleados);
$empleados_js = [];
while ($row = $result_empleados->fetch_assoc()) {
    $empleados_js[$row["id_empleado"]] = $row["nombre"];
}

// Recolectar folio de venta
$folio_generado = $_GET["folio_generado"] ?? null;
$mensaje = $_GET["mensaje"] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_empleado = $_POST["id_empleado"];
    $total = $_POST["total"];
    $tipo_pago = $_POST["tipo_pago"];
    $cambio = $_POST["cambio"] ?? 0;

    $sql_get_caja = "SELECT dinero_actual FROM Caja WHERE id = 1";
    $result_caja = $conn->query($sql_get_caja);

    if ($result_caja->num_rows > 0) {
        $row_caja = $result_caja->fetch_assoc();
        $dinero_actual = $row_caja["dinero_actual"];

        $productos_validos = array_filter($_POST["productos"], function ($producto) {
            return isset($producto["cantidad"]) && $producto["cantidad"] > 0;
        });

        if (!empty($productos_validos)) {
            $sql_venta = "INSERT INTO Venta (Id_Empleado, Total, Tipo_pago, Cambio) VALUES ('$id_empleado', '$total', '$tipo_pago', '$cambio')";
            if ($conn->query($sql_venta) === TRUE) {
                $folio_venta = $conn->insert_id;

                foreach ($productos_validos as $producto) {
                    $id_producto = $producto["id_producto"];
                    $cantidad = $producto["cantidad"];
                    $precio_unitario = $producto["precio_unitario"];
                    $subtotal = $cantidad * $precio_unitario;

                    $sql_detalle = "INSERT INTO Detalle_Venta (Folio_venta, Id_producto, Cantidad, Precio_unitario, Subtotal)
                                    VALUES ('$folio_venta', '$id_producto', '$cantidad', '$precio_unitario', '$subtotal')";
                    $conn->query($sql_detalle);

                    $sql_update_stock = "UPDATE Inventario SET Stock_actual = Stock_actual - $cantidad WHERE Id_producto = '$id_producto'";
                    $conn->query($sql_update_stock);
                }

                $nuevo_dinero = $dinero_actual + $total;
                $sql_update_caja = "UPDATE Caja SET dinero_actual = '$nuevo_dinero' WHERE id = 1";
                $conn->query($sql_update_caja);

                header("Location: Venta.php?folio_generado=$folio_venta&mensaje=Venta+registrada+correctamente");
                exit;
            } else {
                $mensaje = "❌ Error al registrar la venta: " . $conn->error;
            }
        } else {
            $mensaje = "⚠️ No se registraron productos porque la cantidad es cero.";
        }
    } else {
        $mensaje = "⚠️ No se encontró la caja con ID 1.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venta</title>
    <style>
        .producto-row { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
    </style>
</head>
<body>
<h1>Registrar Venta</h1>

<?php if ($mensaje): ?>
    <p><strong><?php echo htmlspecialchars($mensaje); ?></strong></p>
<?php endif; ?>

<form method="POST" action="Venta.php">
    <label for="id_empleado">ID Empleado:</label>
    <input type="number" name="id_empleado" id="id_empleado" required>
    <span id="nombre_empleado" style="font-weight: bold; margin-left: 10px;"></span>
    <br><br>

    <label for="id_producto_input">Ingresar ID de Producto:</label>
    <input type="number" id="id_producto_input">
    <button type="button" onclick="agregarProducto()">Agregar Producto</button>
    <button type="button" onclick="limpiarLista()">🗑️ Limpiar Lista</button>

    <div id="preview_producto" style="margin-top: 10px; font-weight: bold;"></div>

    <table id="tabla_productos">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody id="lista_productos"></tbody>
    </table>

    <label for="total">Total:</label>
    <input type="text" name="total" id="total" readonly><br><br>

    <label for="tipo_pago">Tipo de pago:</label>
    <select name="tipo_pago" id="tipo_pago" onchange="actualizarMetodoPago()">
        <option>Seleccion el metodo de pago: </option>
        <option value="efectivo">Efectivo</option>
        <option value="tarjeta">Tarjeta</option>
    </select><br><br>

    <div id="pago_efectivo_section" style="display: none;">
        <label for="pago_con">Pago con:</label>
        <input type="number" step="0.01" id="pago_con" oninput="calcularCambio()">
        <br>
        <label>Cambio:</label>
        <span id="cambio">0.00</span>
    </div>

    <input type="hidden" name="cambio" id="cambio_hidden">

    <br><br>
    <button type="submit">Registrar Venta</button>
</form>

<?php if ($folio_generado): ?>
    <form action="ticket_venta.php" method="GET" target="_blank">
        <input type="hidden" name="folio" value="<?php echo $folio_generado; ?>"><br><br>
        <button type="submit">Imprimir Ticket</button>
    </form>

    <form action="facturar.php" method="POST" target="_blank">
        <input type="hidden" name="folio" value="<?php echo $folio_generado; ?>"><br><br>
        <label for="id_cliente">ID Cliente:</label>
        <input type="number" name="id_cliente" required>
        <button type="submit">💼¿ Generar Factura</button>
    </form>
<?php endif; ?>

<br><br>
<a href="Inicio.html"><button>Volver al inicio</button></a>

<script>
const productos = <?php echo json_encode($productos_js, JSON_UNESCAPED_UNICODE); ?>;
const empleados = <?php echo json_encode($empleados_js, JSON_UNESCAPED_UNICODE); ?>;

const lista = document.getElementById("lista_productos");
const totalInput = document.getElementById("total");
const nombreEmpleado = document.getElementById("nombre_empleado");

document.getElementById("id_empleado").addEventListener("input", function () {
    const id = this.value;
    nombreEmpleado.textContent = empleados[id] || "Empleado no encontrado";
});

document.getElementById("id_producto_input").addEventListener("input", function () {
    const id = this.value;
    const previewDiv = document.getElementById("preview_producto");

    if (productos[id]) {
        const prod = productos[id];
        previewDiv.innerHTML = `
            Producto: <strong>${prod.Nombre}</strong><br>
            Descripción: ${prod.Descripcion}<br>
            Precio: $${parseFloat(prod.Precio_venta).toFixed(2)}<br>
            Stock disponible: ${prod.Stock_actual}
        `;
    } else {
        previewDiv.innerHTML = "❌ Producto no encontrado o sin stock.";
    }
});

function agregarProducto() {
    const inputProducto = document.getElementById("id_producto_input");
    const id = inputProducto.value;

    if (!productos[id]) {
        alert("Producto no encontrado o sin stock.");
        return;
    }

    if (document.getElementById("producto_" + id)) {
        alert("Este producto ya fue agregado.");
        return;
    }

    const prod = productos[id];
    const tr = document.createElement("tr");
    tr.id = "producto_" + id;
    tr.innerHTML = `
        <td><strong>${prod.Nombre}</strong></td>
        <td>${prod.Descripcion}</td>
        <td>$${parseFloat(prod.Precio_venta).toFixed(2)}</td>
        <td>
            <input type="number" name="productos[${id}][cantidad]" value="1" min="1" onchange="actualizarTotal()">
            <input type="hidden" name="productos[${id}][id_producto]" value="${id}">
            <input type="hidden" name="productos[${id}][precio_unitario]" value="${prod.Precio_venta}">
        </td>
        <td>$<span class="subtotal" id="subtotal_${id}">${parseFloat(prod.Precio_venta).toFixed(2)}</span></td>
        <td><button type="button" onclick="eliminarProducto('${id}')">❌</button></td>
    `;
    lista.appendChild(tr);
    actualizarTotal();
    inputProducto.value = "";
    inputProducto.focus();
    document.getElementById("preview_producto").innerHTML = "";
}

function eliminarProducto(id) {
    const fila = document.getElementById("producto_" + id);
    if (fila) {
        fila.remove();
        actualizarTotal();
    }
}

function actualizarTotal() {
    let total = 0;
    document.querySelectorAll("#lista_productos tr").forEach(div => {
        const input = div.querySelector("input[type='number']");
        const cantidad = parseInt(input.value) || 0;
        const precio = parseFloat(div.querySelector("input[name$='[precio_unitario]']").value);
        const id = div.id.replace("producto_", "");
        const subtotal = cantidad * precio;
        document.getElementById("subtotal_" + id).textContent = subtotal.toFixed(2);
        total += subtotal;
    });
    totalInput.value = total.toFixed(2);
    calcularCambio();
}

function limpiarLista() {
    lista.innerHTML = "";
    actualizarTotal();
    document.getElementById("preview_producto").innerHTML = "";
}

function actualizarMetodoPago() {
    const tipoPago = document.getElementById("tipo_pago").value;
    const seccionEfectivo = document.getElementById("pago_efectivo_section");

    if (tipoPago === "efectivo") {
        seccionEfectivo.style.display = "block";
    } else {
        seccionEfectivo.style.display = "none";
        document.getElementById("cambio").textContent = "0.00";
        document.getElementById("cambio_hidden").value = "0.00";
    }
}

function calcularCambio() {
    const total = parseFloat(totalInput.value) || 0;
    const pagoCon = parseFloat(document.getElementById("pago_con").value) || 0;
    const cambio = pagoCon - total;
    const cambioFinal = cambio >= 0 ? cambio.toFixed(2) : "0.00";
    document.getElementById("cambio").textContent = cambioFinal;
    document.getElementById("cambio_hidden").value = cambioFinal;
}

// 🚫 Validación al enviar formulario
document.querySelector("form").addEventListener("submit", function (e) {
    const tipoPago = document.getElementById("tipo_pago").value;
    const total = parseFloat(totalInput.value) || 0;

    if (tipoPago === "efectivo") {
        const pagoCon = parseFloat(document.getElementById("pago_con").value) || 0;

        if (pagoCon < total) {
            e.preventDefault();
            alert("⚠️ El monto recibido en efectivo no es suficiente para cubrir el total de la venta.");
            document.getElementById("pago_con").focus();
            return false;
        }
    }
});
</script>

</body>
</html>
