<?php
include "conexion.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total_efectivo = floatval($_POST["total_efectivo"]);
    $idempleado = intval($_POST["idempleado"]);
    $observaciones = $_POST["observaciones"];
    $fecha = date("Y-m-d H:i:s");

    // Obtener dinero registrado en caja
    $sql_caja = "SELECT Dinero_Actual FROM Caja WHERE Id = 1";
    $result = $conn->query($sql_caja);
    $dinero_registrado = 0;

    if ($row = $result->fetch_assoc()) {
        $dinero_registrado = floatval($row["Dinero_Actual"]);
    }

    // Calcular diferencia
    $diferencia = $total_efectivo - $dinero_registrado;

    // Insertar arqueo
    $sql = "INSERT INTO arqueo (idempleado, fecha, total_efectivo, diferencia, observaciones)
            VALUES ('$idempleado', '$fecha', '$total_efectivo', '$diferencia', '$observaciones')";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "✅ Arqueo registrado correctamente.";
    } else {
        $mensaje = "❌ Error al registrar el arqueo: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Arqueo de Caja</title>
</head>
<body>
    <h2>Arqueo de Caja</h2>

    <?php if ($mensaje): ?>
        <p><?= $mensaje ?></p>
    <?php endif; ?>

    <form method="POST">
        ID del Empleado: <input type="number" name="idempleado" required><br><br>
        Dinero contado en caja: <input type="number" step="0.01" name="total_efectivo" required><br><br>
        Observaciones:<br>
        <textarea name="observaciones" rows="4" cols="40"></textarea><br><br>
        <button type="submit">Registrar Arqueo</button>
    </form>

    <br><br>
    <a href="Inicio.html"><button>Volver al inicio</button></a>
</body>
</html>
