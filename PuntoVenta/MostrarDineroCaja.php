<?php
include "conexion.php";

// Obtener el dinero actual en caja
$sql_caja = "SELECT dinero_actual FROM Caja LIMIT 1";
$result = $conn->query($sql_caja);
$row = $result->fetch_assoc();
$dinero_actual = number_format($row['dinero_actual'], 2);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinero en Caja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        .container {
            background: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Dinero Actual en Caja</h1>
    <h2>$<?php echo $dinero_actual; ?></h2>
    <a href="inicio.html" class="btn">Volver al Inicio</a>
</div>

</body>
</html>
