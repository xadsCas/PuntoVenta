<?php
require 'fpdf186/fpdf.php';
include "conexion.php";

if (!isset($_GET['folio'])) {
    die("Folio de venta no proporcionado.");
}

$folio = intval($_GET['folio']);

// Obtener datos de la venta
$sql_venta = "SELECT v.Folio, v.Fecha, e.Nombre AS Empleado, v.Total
              FROM venta v
              INNER JOIN empleado e ON v.Id_Empleado = e.Id_Empleado
              WHERE v.Folio = $folio";
$result_venta = $conn->query($sql_venta);

if (!$result_venta || $result_venta->num_rows == 0) {
    die("Venta no encontrada o error en la consulta.");
}

$venta = $result_venta->fetch_assoc();

// Obtener detalles
$sql_detalle = "SELECT d.Id_producto, i.Nombre, d.Cantidad, d.Precio_unitario, d.Subtotal
                FROM detalle_venta d
                INNER JOIN inventario i ON d.Id_producto = i.id_producto
                WHERE d.Folio_venta = $folio";
$result_detalle = $conn->query($sql_detalle);

// Crear PDF
$pdf = new FPDF('P','mm',[80,297]); // tamaño ticket 80mm
$pdf->AddPage();
$pdf->SetMargins(4, 4, 4);
$pdf->SetFont('Courier', 'B', 14);
$pdf->Cell(0, 8, 'TIENDA ', 0, 1, 'C');

$pdf->SetFont('Courier', '', 10);

$pdf->Ln(1);
$pdf->Cell(0, 0, str_repeat('-', 32), 0, 1, 'C');
$pdf->Ln(2);

$pdf->Cell(0, 5, 'Folio: ' . $venta['Folio']);
$pdf->Ln(4);
$pdf->Cell(0, 5, 'Fecha: ' . $venta['Fecha']);
$pdf->Ln(4);

// CORREGIDO: se hace salto de línea tras imprimir el nombre del empleado
$pdf->MultiCell(0, 5, 'Empleado: ' . $venta['Empleado']);
$pdf->Ln(2); // un pequeño espacio extra antes de la tabla

$pdf->Cell(0, 0, str_repeat('-', 32), 0, 1, 'C');
$pdf->Ln(2);


// Encabezados de tabla
$pdf->SetFont('Courier', 'B', 10);
$pdf->Cell(30, 5, 'Producto', 0);
$pdf->Cell(10, 5, 'Cant', 0, 0, 'C');
$pdf->Cell(15, 5, 'Precio', 0, 0, 'R');
$pdf->Cell(20, 5, 'Importe', 0, 1, 'R');
$pdf->SetFont('Courier', '', 9);

// Productos
while ($row = $result_detalle->fetch_assoc()) {
    $nombre = substr($row['Nombre'], 0, 28);
    $pdf->Cell(30, 5, $nombre);
    $pdf->Cell(10, 5, $row['Cantidad'], 0, 0, 'C');
    $pdf->Cell(15, 5, '$' . number_format($row['Precio_unitario'], 2), 0, 0, 'R');
    $pdf->Cell(20, 5, '$' . number_format($row['Subtotal'], 2), 0, 1, 'R');
}
$pdf->Ln(1);
$pdf->Cell(0, 0, str_repeat('-', 32), 0, 1, 'C');
$pdf->Ln(3);

// Total
$pdf->SetFont('Courier', 'B', 12);
$pdf->Cell(0, 6, 'TOTAL: $' . number_format($venta['Total'], 2), 0, 1, 'R');
$pdf->Ln(3);
$pdf->SetFont('Courier', '', 10);
$pdf->Cell(0, 0, str_repeat('-', 32), 0, 1, 'C');
$pdf->Ln(4);

// Mensaje final
$pdf->SetFont('Courier', 'B', 11);
$pdf->Cell(0, 6, '¡Gracias por su compra!', 0, 1, 'C');
$pdf->Ln(2);
$pdf->SetFont('Courier', '', 9);
$pdf->Cell(0, 4, 'Conserve su ticket para cambios', 0, 1, 'C');
$pdf->Cell(0, 4, 'No se aceptan devoluciones.', 0, 1, 'C');

// Salida
$pdf->Output('I', 'ticket_' . $folio . '.pdf');
?>
