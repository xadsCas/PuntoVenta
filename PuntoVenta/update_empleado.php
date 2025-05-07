<?php
// Incluir el archivo de conexión a la base de datos
include "conexion.php";

// Leer los datos enviados en formato JSON
$data = json_decode(file_get_contents("php://input"));

if ($data && isset($data->id) && isset($data->nombre) && isset($data->puesto)) {
    $id = $data->id;
    $nombre = $data->nombre;
    $puestoId = $data->puesto;

    // Verificar si el puesto existe
    $sql_puesto = "SELECT Id_Puesto FROM Puesto WHERE Id_Puesto = ?";
    $stmt_puesto = $conn->prepare($sql_puesto);
    $stmt_puesto->bind_param("i", $puestoId);
    $stmt_puesto->execute();
    $res_puesto = $stmt_puesto->get_result();

    if ($row_puesto = $res_puesto->fetch_assoc()) {
        // Si el puesto existe, actualizamos el empleado
        $sql_update = "UPDATE Empleado SET Nombre = ?, Id_Puesto = ? WHERE Id_Empleado = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sii", $nombre, $puestoId, $id);

        if ($stmt_update->execute()) {
            echo json_encode(["success" => true, "message" => "Empleado actualizado correctamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar el empleado."]);
        }

        $stmt_update->close();
    } else {
        echo json_encode(["success" => false, "message" => "El puesto no existe."]);
    }

    $stmt_puesto->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos o mal formulados."]);
}
?>
