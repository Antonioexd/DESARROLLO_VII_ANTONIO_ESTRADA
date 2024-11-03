<?php
require_once "config_mysqli.php";

// 1. Productos que nunca se han vendido
$sql = "SELECT p.nombre 
        FROM productos p 
        LEFT JOIN ventas v ON p.id = v.producto_id 
        WHERE v.producto_id IS NULL";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Productos que nunca se han vendido:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: {$row['nombre']}<br>";
    }
    mysqli_free_result($result);
}

// 2. Categorías con número de productos y valor total del inventario
$sql = "SELECT c.nombre as categoria, COUNT(p.id) as total_productos, SUM(p.precio) as valor_inventario 
        FROM categorias c 
        JOIN productos p ON c.id = p.categoria_id 
        GROUP BY c.id";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Categorías con número de productos y valor total del inventario:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Categoría: {$row['categoria']}, Total productos: {$row['total_productos']}, Valor inventario: ${$row['valor_inventario']}<br>";
    }
    mysqli_free_result($result);
}

// 3. Clientes que han comprado todos los productos de una categoría específica
$categoria_especifica_id = 1; // Reemplaza con el ID de la categoría específica
$sql = "SELECT c.nombre 
        FROM clientes c 
        JOIN ventas v ON c.id = v.cliente_id 
        WHERE v.producto_id IN (
            SELECT p.id 
            FROM productos p 
            WHERE p.categoria_id = $categoria_especifica_id
        ) 
        GROUP BY c.id 
        HAVING COUNT(DISTINCT v.producto_id) = (
            SELECT COUNT(*) 
            FROM productos p 
            WHERE p.categoria_id = $categoria_especifica_id
        )";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Clientes que han comprado todos los productos de una categoría específica:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Cliente: {$row['nombre']}<br>";
    }
    mysqli_free_result($result);
}

// 4. Porcentaje de ventas de cada producto respecto al total de ventas
$sql = "SELECT p.nombre, 
        (SELECT SUM(v.total) 
         FROM ventas v 
         WHERE v.producto_id = p.id) as ventas_producto,
        (SELECT SUM(v.total) 
         FROM ventas v) as total_ventas,
        (100 * (SELECT SUM(v.total) 
         FROM ventas v 
         WHERE v.producto_id = p.id) / 
        (SELECT SUM(v.total) 
         FROM ventas v)) as porcentaje_ventas
        FROM productos p";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Porcentaje de ventas de cada producto respecto al total de ventas:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: {$row['nombre']}, Ventas: ${$row['ventas_producto']}, Porcentaje: {$row['porcentaje_ventas']}%<br>";
    }
    mysqli_free_result($result);
}

mysqli_close($conn);
?>
