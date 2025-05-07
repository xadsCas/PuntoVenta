<?php
include "conexion.php";

if (isset($_GET['proveedor_id'])) {
    $proveedor_id = $_GET['proveedor_id'];

    // Consultar los productos disponibles del proveedor seleccionado
    $sql = "SELECT id_producto, Nombre, Precio_compra, Precio_venta FROM Inventario WHERE Id_Proveedor = '$proveedor_id'";
    $result = $conn->query($sql);

    $productos = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
    }

    // Retornar los productos en formato JSON
    echo json_encode($productos);
}

$conn->close();
?>
