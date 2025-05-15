<?php
include "conexion.php";
date_default_timezone_set('America/Mexico_City');

// Calcular totales por tipo de pago
$sql_ventas_efectivo = "SELECT SUM(Total) AS total_efectivo FROM Venta WHERE DATE(Fecha) = CURDATE() AND Tipo_Pago = 'e'";
$sql_ventas_tarjeta = "SELECT SUM(Total) AS total_tarjeta FROM Venta WHERE DATE(Fecha) = CURDATE() AND Tipo_Pago = 't'";

$total_efectivo_sistema = $conn->query($sql_ventas_efectivo)->fetch_assoc()['total_efectivo'] ?? 0;
$total_tarjeta = $conn->query($sql_ventas_tarjeta)->fetch_assoc()['total_tarjeta'] ?? 0;

// Totales generales
$sql_ventas = "SELECT SUM(Total) AS total_ventas FROM Venta WHERE DATE(Fecha) = CURDATE()";
$sql_compras = "SELECT SUM(Total) AS total_compras FROM Compra WHERE DATE(Fecha) = CURDATE()";

$total_ventas = $conn->query($sql_ventas)->fetch_assoc()['total_ventas'] ?? 0;
$total_compras = $conn->query($sql_compras)->fetch_assoc()['total_compras'] ?? 0;

$total_sistema = $total_ventas - $total_compras;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_empleado = $_POST['id_empleado'];
    $efectivo_contado = $_POST['total_efectivo'];
    $diferencia = $efectivo_contado - $total_efectivo_sistema;

    $sql = "INSERT INTO corte_caja (Id_Empleado, Total_sistema, Total_efectivo, Diferencia)
            VALUES ('$id_empleado', '$total_sistema', '$efectivo_contado', '$diferencia')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('✅ Corte de caja registrado.'); window.location='realizar_corte.php';</script>";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar Corte de Caja</title>
</head>
<body>

<h2>📤 Realizar Corte de Caja</h2>

<p>Total ventas: $<?= number_format($total_ventas, 2) ?></p>
<p>↳ En efectivo: $<?= number_format($total_efectivo_sistema, 2) ?></p>
<p>↳ Con tarjeta: $<?= number_format($total_tarjeta, 2) ?></p>
<p>Total compras: $<?= number_format($total_compras, 2) ?></p>
<p><strong>Total sistema (esperado):</strong> $<?= number_format($total_sistema, 2) ?></p>

<form method="POST">
    <label for="id_empleado">ID del Empleado:</label>
    <input type="number" name="id_empleado" required><br><br>

    <label for="total_efectivo">Efectivo contado:</label>
    <input type="number" name="total_efectivo" step="0.01" required><br><br>

    <button type="submit">Registrar Corte</button>
</form>

<br><a href="Inicio.html"><button>Volver al inicio</button></a>

</body>
</html>
