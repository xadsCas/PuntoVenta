<?php
// Incluir el archivo de conexión a la base de datos
include "conexion.php";

// Obtener los datos de la solicitud JSON
$data = json_decode(file_get_contents('php://input'), true);

// Obtener los datos del proveedor
$id = $data['id'];
$nombre = $data['nombre'];
$rfc = $data['rfc'];
$domicilio = $data['domicilio'];
$telefono = $data['telefono'];
$correo = $data['correo'];

// Realizar la consulta para actualizar los datos
$sql = "UPDATE proveedores 
        SET Nombre = ?, RFC = ?, Domicilio = ?, Telefono = ?, Correo = ? 
        WHERE ID_Proveedor = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $nombre, $rfc, $domicilio, $telefono, $correo, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Proveedor actualizado con éxito."]);
} else {
    echo json_encode(["success" => false, "message" => "Error al actualizar el proveedor."]);
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
