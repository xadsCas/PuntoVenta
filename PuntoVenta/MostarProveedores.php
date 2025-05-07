<?php
// Incluir el archivo de conexión a la base de datos
include "conexion.php";

// Realizar la consulta para obtener todos los proveedores
$sql = "SELECT * FROM proveedores";
$result = $conn->query($sql);

// Verificar si hay resultados
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Proveedores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f0f2f5;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        #table-container {
            max-height: 400px;
            overflow-y: auto;
        }

        #search-bar {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="text"] {
            padding: 8px;
            width: 200px;
        }

        #btn-volver {
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
        }

        #btn-volver:hover {
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

        #update-form input[type="text"], #update-form input[type="number"] {
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

<h1>Listado de Proveedores</h1>

<div id="search-bar">
    <input type="text" id="search" placeholder="Buscar por ID de Proveedor" oninput="filterTable()">
</div>

<div id="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>RFC</th>
            <th>Domicilio</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Acciones</th> <!-- Columna para editar -->
        </tr>

        <?php
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["ID_Proveedor"] . "</td>
                        <td>" . $row["Nombre"] . "</td>
                        <td>" . $row["RFC"] . "</td>
                        <td>" . $row["Domicilio"] . "</td>
                        <td>" . $row["Telefono"] . "</td>
                        <td>" . $row["Correo"] . "</td>
                        <td><button onclick='loadProveedorData(" . $row["ID_Proveedor"] . ")'>Editar</button></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No hay proveedores registrados.</td></tr>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </table>
</div>

<a href="inicio.html"><button id="btn-volver">Volver al inicio</button></a>

<!-- Formulario de actualización -->
<div id="update-form">
    <h3>Actualizar Proveedor</h3>
    <label for="update-id">ID Proveedor:</label>
    <input type="text" id="update-id" placeholder="Introduce el ID del proveedor" disabled>

    <label for="update-name">Nombre:</label>
    <input type="text" id="update-name" placeholder="Nombre del proveedor">

    <label for="update-rfc">RFC:</label>
    <input type="text" id="update-rfc" placeholder="RFC del proveedor">

    <label for="update-domicilio">Domicilio:</label>
    <input type="text" id="update-domicilio" placeholder="Domicilio del proveedor">

    <label for="update-telefono">Teléfono:</label>
    <input type="text" id="update-telefono" placeholder="Teléfono del proveedor">

    <label for="update-correo">Correo:</label>
    <input type="text" id="update-correo" placeholder="Correo del proveedor">

    <button id="submit-update" onclick="submitUpdate()">Actualizar Proveedor</button>
</div>

<script>
// Función para filtrar la tabla por ID de proveedor
function filterTable() {
    const search = document.getElementById("search").value.toLowerCase();
    const rows = document.querySelectorAll("table tr");

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        if (cells.length > 0) {
            const idProveedor = cells[0].textContent.toLowerCase();
            row.style.display = idProveedor.includes(search) ? "" : "none";
        }
    });
}

// Cargar los datos del proveedor en el formulario de actualización
function loadProveedorData(id) {
    // Aquí puedes hacer una consulta para obtener los datos del proveedor con el id
    const updateForm = document.getElementById("update-form");
    const updateId = document.getElementById("update-id");
    const updateName = document.getElementById("update-name");
    const updateRFC = document.getElementById("update-rfc");
    const updateDomicilio = document.getElementById("update-domicilio");
    const updateTelefono = document.getElementById("update-telefono");
    const updateCorreo = document.getElementById("update-correo");

    // Simulando datos de ejemplo (deberías usar una consulta para obtener los datos reales)
    updateId.value = id;
    updateName.value = "Proveedor " + id; // Aquí debes poner el nombre real
    updateRFC.value = "RFC" + id; // Aquí debes poner el RFC real
    updateDomicilio.value = "Domicilio " + id; // Aquí debes poner el domicilio real
    updateTelefono.value = "Telefono " + id; // Aquí debes poner el teléfono real
    updateCorreo.value = "Correo " + id; // Aquí debes poner el correo real

    updateForm.style.display = "block";
}

// Función para enviar la actualización
function submitUpdate() {
    const id = document.getElementById("update-id").value;
    const name = document.getElementById("update-name").value;
    const rfc = document.getElementById("update-rfc").value;
    const domicilio = document.getElementById("update-domicilio").value;
    const telefono = document.getElementById("update-telefono").value;
    const correo = document.getElementById("update-correo").value;

    const data = {
        id: id,
        nombre: name,
        rfc: rfc,
        domicilio: domicilio,
        telefono: telefono,
        correo: correo
    };

    fetch("update_proveedor.php", {
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
        alert("Error al actualizar el proveedor.");
    });
}
</script>

</body>
</html>
