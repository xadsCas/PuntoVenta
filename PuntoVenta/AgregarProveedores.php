<?php
include "conexion.php";

$mensaje = $_GET['mensaje'] ?? "";

// Procesamiento al enviar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Nombre = trim($_POST["nombre"]);
    $Rfc = trim($_POST["rfc"]);
    $direccion = trim($_POST["direccion"]);
    $correo = trim($_POST["email"]);
    $telefono = trim($_POST["telefono"]);

    // Validaciones del servidor
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: AgregarProveedores.php?mensaje=❌+Correo+electrónico+inválido.");
        exit;
    }

    if (!preg_match('/^\d{7,}$/', $telefono)) {
        header("Location: AgregarProveedores.php?mensaje=❌+Teléfono+inválido+(mínimo+7+dígitos+numéricos).");
        exit;
    }

    // Verificar RFC duplicado
    $check_sql = "SELECT COUNT(*) as total FROM proveedores WHERE Rfc = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $Rfc);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $existe = $check_result->fetch_assoc()['total'] > 0;
    $check_stmt->close();

    if ($existe) {
        header("Location: AgregarProveedores.php?mensaje=⚠️+El+RFC+ya+está+registrado.");
        exit;
    }

    // Insertar proveedor
    $sql = "INSERT INTO proveedores (Rfc, Nombre, Domicilio, Correo, Telefono) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $Rfc, $Nombre, $direccion, $correo, $telefono);

    if ($stmt->execute()) {
        header("Location: AgregarProveedores.php?mensaje=✅+Proveedor+registrado+correctamente.");
    } else {
        $error = $conn->error;
        header("Location: AgregarProveedores.php?mensaje=❌+Error:+$error");
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Proveedor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 40px auto;
        }
        label, input {
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

<h2>Registrar Nuevo Proveedor</h2>

<?php if ($mensaje !== ""): ?>
    <p class="mensaje <?php echo (str_starts_with($mensaje, "❌") || str_starts_with($mensaje, "⚠️")) ? 'error' : ''; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
    </p>
<?php endif; ?>

<form method="POST" action="AgregarProveedores.php">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="rfc">RFC:</label>
    <input type="text" id="rfc" name="rfc" required>

    <label for="direccion">Dirección:</label>
    <input type="text" id="direccion" name="direccion" required>

    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" required>

    <label for="telefono">Teléfono:</label>
    <input type="tel" id="telefono" name="telefono" required>

    <button type="submit">Guardar</button>
</form>

<br>
<a href="inicio.html"><button type="button">Volver al inicio</button></a>

</body>
</html>
