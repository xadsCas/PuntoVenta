<?php
include "conexion.php";

$mensaje = "";

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $NombreProducto = $_POST["nombre_producto"];
    $Descripcion = $_POST["descripcion"];
    $PrecioVenta = floatval($_POST["precio_venta"]);
    $PrecioCompra = floatval($_POST["precio_compra"]);
    $Categoria = $_POST["categoria"];
    $StockActual = intval($_POST["stock_actual"]);
    $StockMinimo = intval($_POST["stock_minimo"]);
    $IdProveedor = intval($_POST["id_proveedor"]);

    // Validación básica
    if ($PrecioCompra > $PrecioVenta) {
        header("Location: Inventario.php?mensaje=❌+El+precio+de+compra+no+puede+ser+mayor+que+el+de+venta.");
        exit;
    }

    $sql = "INSERT INTO Inventario (Nombre, Descripcion, Precio_venta, Precio_compra, Categoria, Stock_actual, Stock_minimo, Id_proveedor)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddssii", $NombreProducto, $Descripcion, $PrecioVenta, $PrecioCompra, $Categoria, $StockActual, $StockMinimo, $IdProveedor);

    if ($stmt->execute()) {
        header("Location: Inventario.php?mensaje=✅+Producto+registrado+correctamente.");
    } else {
        $error = $conn->error;
        header("Location: Inventario.php?mensaje=❌+Error+al+registrar:+$error");
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Mensaje de éxito o error si lo hay
$mensaje = $_GET['mensaje'] ?? "";

// Obtener proveedores para el select
include "conexion.php"; // reconectar si ya se cerró antes
$sql_proveedores = "SELECT ID_Proveedor, Nombre FROM Proveedores";
$result_proveedores = $conn->query($sql_proveedores);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <style>
        body {
            font-family: Arial;
            max-width: 600px;
            margin: 40px auto;
        }
        label, input, select {
            display: block;
            width: 100%;
            margin-bottom: 12px;
        }
        button {
            padding: 10px 16px;
        }
        .mensaje {
            font-weight: bold;
            margin: 15px 0;
        }
        .mensaje.error {
            color: red;
        }
        .mensaje.exito {
            color: green;
        }
    </style>
</head>
<body>

<h2>Formulario para agregar producto al inventario</h2>

<?php if (!empty($mensaje)): ?>
    <p class="mensaje <?php echo str_starts_with($mensaje, "❌") ? 'error' : 'exito'; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
    </p>
<?php endif; ?>

<form method="POST" action="Inventario.php">
    <label for="nombre_producto">Nombre del Producto:</label>
    <input type="text" id="nombre_producto" name="nombre_producto" required>

    <label for="descripcion">Descripción:</label>
    <input type="text" id="descripcion" name="descripcion" required>

    <label for="precio_venta">Precio de Venta:</label>
    <input type="number" step="0.01" id="precio_venta" name="precio_venta" required>

    <label for="precio_compra">Precio de Compra:</label>
    <input type="number" step="0.01" id="precio_compra" name="precio_compra" required>

    <label for="categoria">Categoría:</label>
    <input type="text" id="categoria" name="categoria">

    <label for="stock_actual">Stock Actual:</label>
    <input type="number" id="stock_actual" name="stock_actual" required>

    <label for="stock_minimo">Stock Mínimo:</label>
    <input type="number" id="stock_minimo" name="stock_minimo" required>

    <label for="id_proveedor">Proveedor:</label>
    <select id="id_proveedor" name="id_proveedor" required>
        <option value="">-- Selecciona un proveedor --</option>
        <?php if ($result_proveedores->num_rows > 0): ?>
            <?php while($row = $result_proveedores->fetch_assoc()): ?>
                <option value="<?php echo $row['ID_Proveedor']; ?>">
                    <?php echo htmlspecialchars($row['Nombre']); ?>
                </option>
            <?php endwhile; ?>
        <?php else: ?>
            <option value="">No hay proveedores disponibles</option>
        <?php endif; ?>
    </select>

    <button type="submit">Guardar Producto</button>
</form>

<br><br>
<a href="inicio.html"><button type="button">Volver al inicio</button></a>

</body>
</html>
