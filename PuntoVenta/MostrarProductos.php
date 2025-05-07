<?php
include "conexion.php";
$sql = "SELECT * FROM Inventario";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        #table-container {
            margin-top: 20px;
            overflow-x: auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: white;
            border-radius: 8px;
            max-height: 400px;
            overflow-y: auto;
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
            transition: background-color 0.3s ease;
        }

        #btn-volver:hover {
            background-color: #1976D2;
        }

        #search-bar {
            margin-bottom: 20px;
            text-align: center;
        }

        #search-bar input[type="text"] {
            padding: 8px;
            width: 200px;
            font-size: 16px;
            margin-right: 10px;
        }

        #search-bar button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #search-bar button:hover {
            background-color: #45a049;
        }

        #update-product {
            margin-top: 20px;
            text-align: center;
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

        #update-form input[type="text"],
        #update-form input[type="number"] {
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

<h1>Inventario de Productos</h1>

<div id="search-bar">
    <input type="text" id="search" placeholder="Buscar por ID o nombre" oninput="filterTable()">
    <button type="button" onclick="filterTable()">Buscar</button>
</div>

<div id="table-container">
    <table>
        <tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio Venta</th>
            <th>Precio Compra</th>
            <th>Categoría</th>
            <th>Stock Actual</th>
            <th>ID Proveedor</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row["id_producto"]}</td>
                        <td>{$row["Nombre"]}</td>
                        <td>{$row["Descripcion"]}</td>
                        <td>{$row["Precio_venta"]}</td>
                        <td>{$row["Precio_compra"]}</td>
                        <td>{$row["Categoria"]}</td>
                        <td>{$row["Stock_actual"]}</td>
                        <td>{$row["Id_proveedor"]}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No hay productos registrados en el inventario.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>

<div id="update-product">
    <button onclick="toggleUpdateForm()">Actualizar Producto</button>
</div>

<div id="update-form">
    <h3>Actualizar Producto</h3>
    <label for="update-id">ID Producto:</label>
    <input type="text" id="update-id" placeholder="Introduce el ID del producto" oninput="debouncedLoadProductDetails()">

    <label for="update-name">Nombre:</label>
    <input type="text" id="update-name" placeholder="Nombre del producto">

    <label for="update-description">Descripción:</label>
    <input type="text" id="update-description" placeholder="Descripción del producto">

    <label for="update-price-sale">Precio Venta:</label>
    <input type="number" id="update-price-sale" placeholder="Precio de venta">

    <label for="update-price-buy">Precio Compra:</label>
    <input type="number" id="update-price-buy" placeholder="Precio de compra">

    <label for="update-category">Categoría:</label>
    <input type="text" id="update-category" placeholder="Categoría">

    <label for="update-stock">Stock Actual:</label>
    <input type="number" id="update-stock" placeholder="Stock actual">

    <button id="submit-update" onclick="submitUpdate()">Actualizar Producto</button>
</div>

<a href="inicio.html"><button id="btn-volver">Volver al inicio</button></a>

<script>
function toggleUpdateForm() {
    const form = document.getElementById("update-form");
    form.style.display = form.style.display === "none" || form.style.display === "" ? "block" : "none";
}

function filterTable() {
    const input = document.getElementById("search").value.toLowerCase();
    const rows = document.querySelectorAll("table tr");

    rows.forEach((row, index) => {
        if (index === 0) return;
        const cells = row.getElementsByTagName("td");
        const matches = Array.from(cells).some(cell =>
            cell.textContent.toLowerCase().includes(input)
        );
        row.style.display = matches ? "" : "none";
    });
}

let debounceTimer;

function debouncedLoadProductDetails() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(loadProductDetails, 500); // espera 500ms tras escribir
}

function loadProductDetails() {
    const id = document.getElementById("update-id").value.trim();
    if (id === "") return;

    fetch("get_product_details.php?id=" + id)
        .then(response => response.json())
        .then(data => {
            if (data && data.id_producto) {
                document.getElementById("update-name").value = data.Nombre;
                document.getElementById("update-description").value = data.Descripcion;
                document.getElementById("update-price-sale").value = data.Precio_venta;
                document.getElementById("update-price-buy").value = data.Precio_compra;
                document.getElementById("update-category").value = data.Categoria;
                document.getElementById("update-stock").value = data.Stock_actual;
            } else {
                console.log("Producto no encontrado");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
}

function submitUpdate() {
    const data = {
        id: document.getElementById("update-id").value,
        name: document.getElementById("update-name").value,
        description: document.getElementById("update-description").value,
        priceSale: parseFloat(document.getElementById("update-price-sale").value),
        priceBuy: parseFloat(document.getElementById("update-price-buy").value),
        category: document.getElementById("update-category").value,
        stock: parseInt(document.getElementById("update-stock").value)
    };

    fetch("update_product.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        if (result.success) location.reload();
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Error al actualizar el producto.");
    });
}
</script>

</body>
</html>
