<?php
include "conexion.php";

// Obtener datos JSON del cuerpo de la petición
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $id = $data['id'];
    $name = $data['name'];
    $description = $data['description'];
    $priceSale = $data['priceSale'];
    $priceBuy = $data['priceBuy'];
    $category = $data['category'];
    $stock = $data['stock'];

    $sql = "UPDATE Inventario 
            SET Nombre = ?, Descripcion = ?, Precio_venta = ?, Precio_compra = ?, Categoria = ?, Stock_actual = ?
            WHERE id_producto = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddsii", $name, $description, $priceSale, $priceBuy, $category, $stock, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Producto actualizado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar el producto."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos no válidos."]);
}

$conn->close();
?>

