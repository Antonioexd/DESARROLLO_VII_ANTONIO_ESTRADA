<?php
require_once "config_pdo.php";

// Función para registrar una venta
function registrarVenta($pdo, $cliente_id, $producto_id, $cantidad) {
    try {
        $stmt = $pdo->prepare("CALL sp_registrar_venta(:cliente_id, :producto_id, :cantidad, @venta_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();
        
        // Obtener el ID de la venta
        $result = $pdo->query("SELECT @venta_id as venta_id")->fetch(PDO::FETCH_ASSOC);
        
        echo "Venta registrada con éxito. ID de venta: " . $result['venta_id'];
    } catch (PDOException $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($pdo, $cliente_id) {
    try {
        $stmt = $pdo->prepare("CALL sp_estadisticas_cliente(:cliente_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $estadisticas = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function procesarDevolucion($pdo, $venta_id, $producto_id, $cantidad) {
    try {
        $stmt = $pdo->prepare("CALL sp_procesar_devolucion(:venta_id, :producto_id, :cantidad)");
        $stmt->bindParam(':venta_id', $venta_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();
        
        echo "Devolución procesada con éxito.";
    } catch (PDOException $e) {
        echo "Error al procesar la devolución: " . $e->getMessage();
    }
}

function calcularAplicarDescuento($pdo, $cliente_id, $producto_id, $cantidad) {
    try {
        $stmt = $pdo->prepare("CALL sp_calcular_aplicar_descuento(:cliente_id, :producto_id, :cantidad, @total)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();
        
        // Get total after discount
        $result = $pdo->query("SELECT @total as total")->fetch(PDO::FETCH_ASSOC);
        
        echo "Descuento aplicado con éxito. Total: $" . $result['total'];
    } catch (PDOException $e) {
        echo "Error al calcular/aplicar el descuento: " . $e->getMessage();
    }
}

function reporteBajoStock($pdo) {
    try {
        $stmt = $pdo->prepare("CALL sp_reporte_bajo_stock()");
        $stmt->execute();
        
        echo "<h3>Reporte de Productos con Bajo Stock</h3>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Producto ID: " . $row['producto_id'] . "<br>";
            echo "Nombre: " . $row['nombre'] . "<br>";
            echo "Cantidad: " . $row['cantidad'] . "<br>";
            echo "Sugerencia: " . $row['sugerencia_reorden'] . "<br><br>";
        }
    } catch (PDOException $e) {
        echo "Error al generar el reporte de bajo stock: " . $e->getMessage();
    }
}


// Ejemplos de uso
registrarVenta($pdo, 1, 1, 2);
obtenerEstadisticasCliente($pdo, 1);

$pdo = null;
?>