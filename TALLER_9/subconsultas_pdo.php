<?php
require_once "config_pdo.php";

try {
    // 1. Productos que nunca se han vendido
    $sql = "SELECT p.nombre 
            FROM productos p 
            LEFT JOIN ventas v ON p.id = v.producto_id 
            WHERE v.producto_id IS NULL";
    $stmt = $pdo->query($sql);
    
    echo "<h3>Productos que nunca se han vendido:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Producto: {$row['nombre']}<br>";
    }

    // 2. Categorías con número de productos y valor total del inventario
    $sql = "SELECT c.nombre as categoria, COUNT(p.id) as total_productos, SUM(p.precio) as valor_inventario 
            FROM categorias c 
            JOIN productos p ON c.id = p.categoria_id 
            GROUP BY c.id";
    $stmt = $pdo->query($sql);
    
    echo "<h3>Categorías con número de productos y valor total del inventario:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Categoría: {$row['categoria']}, Total productos: {$row['total_productos']}, Valor inventario: ${$row['valor_inventario']}<br>";
    }

    // 3. Clientes que han comprado todos los productos de una categoría específica
    $categoria_especifica_id = 1; // Reemplaza con el ID de la categoría específica
    $sql = "SELECT c.nombre 
            FROM clientes c 
            JOIN ventas v ON c.id = v.cliente_id 
            WHERE v.producto_id IN (
                SELECT p.id 
                FROM productos p 
                WHERE p.categoria_id = :categoria_especifica_id
            ) 
            GROUP BY c.id 
            HAVING COUNT(DISTINCT v.producto_id) = (
                SELECT COUNT(*) 
                FROM productos p 
                WHERE p.categoria_id = :categoria_especifica_id
            )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':categoria_especifica_id' => $categoria_especifica_id]);
    
    echo "<h3>Clientes que han comprado todos los productos de una categoría específica:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Cliente: {$row['nombre']}<br>";
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
    $stmt = $pdo->query($sql);
    
    echo "<h3>Porcentaje de ventas de cada producto respecto al total de ventas:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Producto: {$row['nombre']}, Ventas: ${$row['ventas_producto']}, Porcentaje: {$row['porcentaje_ventas']}%<br>";
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>
