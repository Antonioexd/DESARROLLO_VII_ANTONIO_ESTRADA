<?php
require_once "config_pdo.php";

// Función para mostrar productos con bajo stock
function mostrarProductosBajoStock($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM vista_productos_bajo_stock");
        echo "<h3>Productos con bajo stock:</h3>";
        echo "<table border='1'><tr><th>ID</th><th>Nombre</th><th>Stock</th><th>Total Ventas</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>{$row['id']}</td><td>{$row['nombre']}</td><td>{$row['stock']}</td><td>{$row['total_ventas']}</td></tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Función para mostrar historial completo de clientes
function mostrarHistorialClientes($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM vista_historial_clientes");
        echo "<h3>Historial completo de cada cliente:</h3>";
        echo "<table border='1'><tr><th>ID Cliente</th><th>Nombre Cliente</th><th>Producto</th><th>Total</th><th>Fecha</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>{$row['cliente_id']}</td><td>{$row['cliente_nombre']}</td><td>{$row['producto_nombre']}</td><td>{$row['total']}</td><td>{$row['fecha']}</td></tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Función para mostrar métricas de rendimiento por categoría
function mostrarMetricasCategoria($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM vista_metricas_categoria");
        echo "<h3>Métricas de rendimiento por categoría:</h3>";
        echo "<table border='1'><tr><th>ID Categoría</th><th>Nombre Categoría</th><th>Ventas Totales</th><th>Cantidad Productos</th><th>Producto Más Vendido</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>{$row['categoria_id']}</td><td>{$row['categoria_nombre']}</td><td>{$row['ventas_totales']}</td><td>{$row['cantidad_productos']}</td><td>{$row['producto_mas_vendido']}</td></tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Función para mostrar tendencias de ventas por mes
function mostrarTendenciasVentas($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM vista_tendencias_ventas");
        echo "<h3>Tendencias de ventas por mes:</h3>";
        echo "<table border='1'><tr><th>Mes</th><th>Ventas Totales</th><th>Ventas Mes Anterior</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>{$row['mes']}</td><td>{$row['ventas_totales']}</td><td>{$row['ventas_mes_anterior']}</td></tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Mostrar los resultados
mostrarProductosBajoStock($pdo);
mostrarHistorialClientes($pdo);
mostrarMetricasCategoria($pdo);
mostrarTendenciasVentas($pdo);

$pdo = null;
?>
