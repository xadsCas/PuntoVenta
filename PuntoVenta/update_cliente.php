<?php
// Conexión a la base de datos
include "conexion.php";

// Obtener los datos enviados en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Extraer los valores del cliente
$id = $data['id'];
$rfc = $data['rfc'];
$nombre = $data['nombre'];
$direccion = $data['direccion'];
$telefono = $data['telefono'];
$correo = $data['correo'];

// Actualizar el cliente en la base de datos
$sql = "UPDATE Clientes SET Rfc = ?, Nombre = ?, Direccion = ?, Telefono = ?, Correo = ? WHERE ID_cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $rfc, $nombre, $direccion, $telefono, $correo, $id);

// Ejecutar la consulta y verificar si fue exitosa
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cliente actualizado correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el cliente.']);
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
