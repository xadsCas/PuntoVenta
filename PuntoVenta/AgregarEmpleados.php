<?php
include "conexion.php";

$mensaje = $_GET['mensaje'] ?? "";

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $id_puesto = intval($_POST['Id_Puesto']);

    // Validación
    if (empty($nombre)) {
        header("Location: AgregarEmpleados.php?mensaje=❌+El+nombre+no+puede+estar+vacío.");
        exit;
    }

    if ($id_puesto <= 0) {
        header("Location: AgregarEmpleados.php?mensaje=❌+Selecciona+un+puesto+válido.");
        exit;
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO empleado (Nombre, Id_Puesto) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nombre, $id_puesto);

    if ($stmt->execute()) {
        header("Location: AgregarEmpleados.php?mensaje=✅+Empleado+guardado+correctamente.");
    } else {
        $error = $conn->error;
        header("Location: AgregarEmpleados.php?mensaje=❌+Error+al+guardar:+$error");
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Obtener lista de puestos
$sql_puestos = "SELECT Id_Puesto, Nombre FROM puesto";
$result_puestos = $conn->query($sql_puestos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Empleado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 40px auto;
        }
        label, select, input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        button {
            padding: 8px 16px;
        }
        .mensaje {
            margin: 10px 0;
            font-weight: bold;
            color: green;
        }
        .mensaje.error {
            color: red;
        }
    </style>
</head>
<body>

<h2>Agregar Empleado</h2>

<?php if (!empty($mensaje)): ?>
    <p class="mensaje <?php echo (str_starts_with($mensaje, "❌")) ? 'error' : ''; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
    </p>
<?php endif; ?>

<form method="POST" action="AgregarEmpleados.php">
    <label for="nombre">Nombre del empleado:</label>
    <input type="text" name="nombre" id="nombre" required>

    <label for="puesto">Puesto:</label>
    <select name="Id_Puesto" id="puesto" required>
        <option value="">-- Selecciona un puesto --</option>
        <?php while ($row = $result_puestos->fetch_assoc()): ?>
            <option value="<?php echo $row['Id_Puesto']; ?>">
                <?php echo htmlspecialchars($row['Nombre']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Guardar Empleado</button>
</form>

<br>
<a href="Inicio.html"><button type="button">Ir a Inicio</button></a>

</body>
</html>
