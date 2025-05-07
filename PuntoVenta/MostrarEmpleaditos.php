<?php
// Incluir el archivo de conexión a la base de datos
include "conexion.php";

// Consulta con JOIN para obtener el nombre del puesto desde la tabla puesto
$sql = "SELECT e.Id_Empleado, e.Nombre, p.Nombre AS Puesto
        FROM Empleado e
        INNER JOIN Puesto p ON e.Id_Puesto = p.Id_Puesto";

$result = $conn->query($sql);

// Obtener los puestos disponibles
$puestos_sql = "SELECT * FROM Puesto";
$puestos_result = $conn->query($puestos_sql);

// Verificar si hay resultados
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Empleados</title>
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

        #update-form select {
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

<h1>Listado de Empleados</h1>

<div id="search-bar">
    <input type="text" id="search" placeholder="Buscar por ID de Empleado" oninput="filterTable()">
</div>

<div id="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Puesto</th>
            <th>Acciones</th> <!-- Añadimos una columna para acciones -->
        </tr>

        <?php
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["Id_Empleado"] . "</td>
                        <td>" . $row["Nombre"] . "</td>
                        <td>" . $row["Puesto"] . "</td>
                        <td><button onclick='loadEmployeeData(" . $row["Id_Empleado"] . ")'>Editar</button></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay empleados registrados.</td></tr>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </table>
</div>

<a href="inicio.html"><button id="btn-volver">Volver al inicio</button></a>

<!-- Botón para abrir el formulario de actualización -->
<button id="btn-update">Actualizar Datos</button>

<!-- Formulario de actualización -->
<div id="update-form">
    <h3>Actualizar Empleado</h3>
    <label for="update-id">ID Empleado:</label>
    <input type="text" id="update-id" placeholder="Introduce el ID del empleado" disabled>

    <label for="update-name">Nombre:</label>
    <input type="text" id="update-name" placeholder="Nombre del empleado">

    <label for="update-puesto">Puesto:</label>
    <select id="update-puesto">
        <?php
        // Mostrar los puestos disponibles
        while ($puesto = $puestos_result->fetch_assoc()) {
            echo "<option value='" . $puesto["Id_Puesto"] . "'>" . $puesto["Nombre"] . "</option>";
        }
        ?>
    </select>

    <button id="submit-update" onclick="submitUpdate()">Actualizar Empleado</button>
</div>

<script>
// Función para filtrar la tabla por ID de empleado
function filterTable() {
    const search = document.getElementById("search").value.toLowerCase();
    const rows = document.querySelectorAll("table tr");

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        if (cells.length > 0) {
            const idEmpleado = cells[0].textContent.toLowerCase();
            row.style.display = idEmpleado.includes(search) ? "" : "none";
        }
    });
}

// Mostrar el formulario de actualización
document.getElementById("btn-update").addEventListener("click", function() {
    const updateForm = document.getElementById("update-form");
    updateForm.style.display = "block";
});

// Cargar los datos del empleado en el formulario de actualización
function loadEmployeeData(id) {
    // Aquí puedes hacer una consulta para obtener los datos del empleado con el id, por ahora simulamos:
    const updateForm = document.getElementById("update-form");
    const updateId = document.getElementById("update-id");
    const updateName = document.getElementById("update-name");
    const updatePuesto = document.getElementById("update-puesto");

    // Simulando datos de ejemplo
    updateId.value = id;
    updateName.value = "Empleado " + id; // Aquí debes poner el nombre real
    updatePuesto.value = "1"; // Aquí debes poner el puesto real

    updateForm.style.display = "block";
}

// Función para enviar la actualización
function submitUpdate() {
    const id = document.getElementById("update-id").value;
    const name = document.getElementById("update-name").value;
    const puesto = document.getElementById("update-puesto").value;

    const data = {
        id: id,
        nombre: name,
        puesto: puesto
    };

    fetch("update_empleado.php", {
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
        alert("Error al actualizar el empleado.");
    });
}
</script>

</body>
</html>
