<?php
// Incluir el archivo de conexión a la base de datos
include "conexion.php";

// Realizar la consulta para obtener todos los clientes
$sql = "SELECT * FROM Clientes";
$result = $conn->query($sql);

// Verificar si hay resultados
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
            margin: 0;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        #search-bar {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 8px;
            width: 300px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        #table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            font-size: 16px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9f7e9;
        }

        .btn-volver {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #2196F3;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-volver:hover {
            background-color: #1976D2;
        }

        #update-form {
            display: none;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 300px;
            margin: 20px auto;
        }

        #update-form input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        #update-form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        #update-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h1>Listado de Clientes</h1>

<div id="search-bar">
    <input type="text" id="search" placeholder="Buscar por ID de Cliente" oninput="filterTable()">
</div>

<div id="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>RFC</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Acciones</th> <!-- Columna para editar -->
        </tr>

        <?php
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["ID_cliente"] . "</td>
                        <td>" . $row["Rfc"] . "</td>
                        <td>" . $row["Nombre"] . "</td>
                        <td>" . $row["Direccion"] . "</td>
                        <td>" . $row["Telefono"] . "</td>
                        <td>" . $row["Correo"] . "</td>
                        <td><button onclick='loadClienteData(" . $row["ID_cliente"] . ")'>Editar</button></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No hay clientes registrados.</td></tr>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </table>
</div>

<a href="inicio.html"><button class="btn-volver">Volver al inicio</button></a>

<!-- Formulario de actualización -->
<div id="update-form">
    <h3>Actualizar Cliente</h3>
    <label for="update-id">ID Cliente:</label>
    <input type="text" id="update-id" placeholder="Introduce el ID del cliente" disabled>

    <label for="update-rfc">RFC:</label>
    <input type="text" id="update-rfc" placeholder="RFC del cliente">

    <label for="update-name">Nombre:</label>
    <input type="text" id="update-name" placeholder="Nombre del cliente">

    <label for="update-direccion">Dirección:</label>
    <input type="text" id="update-direccion" placeholder="Dirección del cliente">

    <label for="update-telefono">Teléfono:</label>
    <input type="text" id="update-telefono" placeholder="Teléfono del cliente">

    <label for="update-correo">Correo:</label>
    <input type="text" id="update-correo" placeholder="Correo del cliente">

    <button id="submit-update" onclick="submitUpdate()">Actualizar Cliente</button>
</div>

<script>
// Función para filtrar la tabla por ID de cliente
function filterTable() {
    const search = document.getElementById("search").value.toLowerCase();
    const rows = document.querySelectorAll("table tr");

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        if (cells.length > 0) {
            const idCliente = cells[0].textContent.toLowerCase();
            row.style.display = idCliente.includes(search) ? "" : "none";
        }
    });
}

// Cargar los datos del cliente en el formulario de actualización
function loadClienteData(id) {
    // Aquí puedes hacer una consulta para obtener los datos del cliente con el id
    const updateForm = document.getElementById("update-form");
    const updateId = document.getElementById("update-id");
    const updateRFC = document.getElementById("update-rfc");
    const updateName = document.getElementById("update-name");
    const updateDireccion = document.getElementById("update-direccion");
    const updateTelefono = document.getElementById("update-telefono");
    const updateCorreo = document.getElementById("update-correo");

    // Simulando datos de ejemplo (deberías usar una consulta para obtener los datos reales)
    updateId.value = id;
    updateRFC.value = "RFC" + id; // Aquí debes poner el RFC real
    updateName.value = "Cliente " + id; // Aquí debes poner el nombre real
    updateDireccion.value = "Dirección " + id; // Aquí debes poner la dirección real
    updateTelefono.value = "Telefono " + id; // Aquí debes poner el teléfono real
    updateCorreo.value = "Correo " + id; // Aquí debes poner el correo real

    updateForm.style.display = "block";
}

// Función para enviar la actualización
function submitUpdate() {
    const id = document.getElementById("update-id").value;
    const rfc = document.getElementById("update-rfc").value;
    const name = document.getElementById("update-name").value;
    const direccion = document.getElementById("update-direccion").value;
    const telefono = document.getElementById("update-telefono").value;
    const correo = document.getElementById("update-correo").value;

    const data = {
        id: id,
        rfc: rfc,
        nombre: name,
        direccion: direccion,
        telefono: telefono,
        correo: correo
    };

    fetch("update_cliente.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        if (result.success) {
            document.getElementById("update-form").style.display = "none";
            location.reload(); // Recargar la página para reflejar los cambios
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Error al actualizar el cliente.");
    });
}
</script>

</body>
</html>
