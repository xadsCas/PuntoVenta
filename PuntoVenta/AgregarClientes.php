<?php
include "conexion.php";

// Variable para mostrar mensajes
$mensaje = "";

// Verifica si se envió el formulario antes de procesar los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Nombre = $_POST["nombre"];
    $Rfc = $_POST["rfc"];
    $direccion = $_POST["direccion"];
    $correo = $_POST["email"];
    $telefono = $_POST["telefono"];

    // Verificar si el RFC ya existe en la base de datos
    $sql_check = "SELECT COUNT(*) FROM clientes WHERE Rfc = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("s", $Rfc);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Si el RFC ya existe, mostrar mensaje de error
        $mensaje = "❌ El RFC ya está registrado.";
    } else {
        // Si el RFC no existe, proceder con la inserción
        $sql = "INSERT INTO clientes (Rfc, Nombre, Direccion, Correo, Telefono) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $Rfc, $Nombre, $direccion, $correo, $telefono);

        if ($stmt->execute()) {
            $mensaje = "✅ Cliente registrado correctamente.";
        } else {
            $mensaje = "❌ Error al registrar: " . $conn->error;
        }

        $stmt->close();
    }

    // Cerrar conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 500px;
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        .mensaje {
            margin: 10px 0;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }
        .mensaje.error {
            color: red;
            background-color: #f8d7da;
        }
        .mensaje.success {
            color: green;
            background-color: #d4edda;
        }
        label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }
        input, button, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .btn-back {
            background-color: #007BFF;
            color: white;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registrar Nuevo Cliente</h2>

    <!-- Mostrar mensaje después de enviar el formulario -->
    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?php echo (strpos($mensaje, '❌') !== false) ? 'error' : 'success'; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="rfc">RFC:</label>
        <input type="text" id="rfc" name="rfc" required><br><br>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required><br><br>

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required><br><br>

        <button type="submit">Guardar</button>
    </form>

    <br>
    <a href="Inicio.html"><button type="button" class="btn-back">Volver al inicio</button></a>
</div>

</body>
</html>
