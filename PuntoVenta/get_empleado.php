<?php
include "conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT e.Id_Empleado, e.Nombre, p.Nombre AS Puesto
            FROM Empleado e
            INNER JOIN Puesto p ON e.Id_Puesto = p.Id_Puesto
            WHERE e.Id_Empleado = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Empleado no encontrado."]);
    }

    $stmt->close();
    $conn->close();
}
?>
