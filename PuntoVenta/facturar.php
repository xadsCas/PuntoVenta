<?php
include "conexion.php";
require('fpdf186/fpdf.php');

// Validar entrada
$folio_venta = $_POST['folio'] ?? '';
$id_cliente = $_POST['id_cliente'] ?? '';

if (empty($folio_venta) || empty($id_cliente)) {
    die("❌ Folio o cliente no proporcionado.");
}

// Obtener datos del cliente
$sql_cliente = "SELECT nombre, rfc FROM Clientes WHERE id_cliente = '$id_cliente'";
$result_cliente = $conn->query($sql_cliente);

if ($result_cliente->num_rows == 0) {
    die("❌ Cliente no encontrado.");
}

$cliente = $result_cliente->fetch_assoc();
$cliente_nombre = $cliente['nombre'];
$cliente_rfc = $cliente['rfc'];

// Obtener datos de la venta
$sql_venta = "SELECT v.total, v.fecha, e.nombre AS empleado_nombre
              FROM Venta v
              JOIN Empleado e ON v.id_empleado = e.id_empleado
              WHERE v.folio = '$folio_venta'";
$result_venta = $conn->query($sql_venta);

if ($result_venta->num_rows == 0) {
    die("❌ Venta no encontrada.");
}

$venta = $result_venta->fetch_assoc();
$total = $venta['total'];
$fecha_venta = $venta['fecha'];
$empleado_nombre = $venta['empleado_nombre'];

// Obtener detalles
$sql_detalles = "SELECT p.nombre, dv.cantidad, dv.precio_unitario, dv.subtotal
                 FROM Detalle_Venta dv
                 JOIN Inventario p ON dv.id_producto = p.id_producto
                 WHERE dv.folio_venta = '$folio_venta'";
$result_detalles = $conn->query($sql_detalles);

// Iniciar PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Encabezado
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'FACTURA DE VENTA', 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, 6, 'Fecha: ' . $fecha_venta, 0, 0);
$pdf->Cell(90, 6, 'Folio: ' . $folio_venta, 0, 1);
$pdf->Cell(100, 6, 'Empleado: ' . $empleado_nombre, 0, 1);

// Cliente
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 6, 'Datos del Cliente', 0, 1);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(100, 6, 'Nombre: ' . $cliente_nombre, 0, 1);
$pdf->Cell(100, 6, 'RFC: ' . $cliente_rfc, 0, 1);

// Tabla productos
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(80, 8, 'Producto', 1, 0, 'C');
$pdf->Cell(30, 8, 'Cantidad', 1, 0, 'C');
$pdf->Cell(40, 8, 'Precio Unitario', 1, 0, 'C');
$pdf->Cell(40, 8, 'Subtotal', 1, 1, 'C');

$pdf->SetFont('Arial', '', 11);
while ($detalle = $result_detalles->fetch_assoc()) {
    $pdf->Cell(80, 8, $detalle['nombre'], 1);
    $pdf->Cell(30, 8, $detalle['cantidad'], 1, 0, 'C');
    $pdf->Cell(40, 8, '$' . number_format($detalle['precio_unitario'], 2), 1, 0, 'R');
    $pdf->Cell(40, 8, '$' . number_format($detalle['subtotal'], 2), 1, 1, 'R');
}

// Total
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(150, 8, 'TOTAL:', 0, 0, 'R');
$pdf->Cell(40, 8, '$' . number_format($total, 2), 0, 1, 'R');

$pdf->Output();
$conn->close();
?>
