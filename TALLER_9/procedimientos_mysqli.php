<?php
require_once "config_mysqli.php";

// Función para registrar una venta
function registrarVenta($conn, $cliente_id, $producto_id, $cantidad) {
    $query = "CALL sp_registrar_venta(?, ?, ?, @venta_id)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $cliente_id, $producto_id, $cantidad);
    
    try {
        mysqli_stmt_execute($stmt);
        
        // Obtener el ID de la venta
        $result = mysqli_query($conn, "SELECT @venta_id as venta_id");
        $row = mysqli_fetch_assoc($result);
        
        echo "Venta registrada con éxito. ID de venta: " . $row['venta_id'];
    } catch (Exception $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($conn, $cliente_id) {
    $query = "CALL sp_estadisticas_cliente(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $estadisticas = mysqli_fetch_assoc($result);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    }
    
    mysqli_stmt_close($stmt);
}

function procesarDevolucion($conn, $venta_id, $producto_id, $cantidad) {
    $query = "CALL sp_procesar_devolucion(?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $venta_id, $producto_id, $cantidad);
    
    try {
        mysqli_stmt_execute($stmt);
        echo "Devolución procesada con éxito.";
    } catch (Exception $e) {
        echo "Error al procesar la devolución: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

function calcularAplicarDescuento($conn, $cliente_id, $producto_id, $cantidad) {
    $query = "CALL sp_calcular_aplicar_descuento(?, ?, ?, @total)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $cliente_id, $producto_id, $cantidad);
    
    try {
        mysqli_stmt_execute($stmt);
        
        // Get total after discount
        $result = mysqli_query($conn, "SELECT @total as total");
        $row = mysqli_fetch_assoc($result);
        
        echo "Descuento aplicado con éxito. Total: $" . $row['total'];
    } catch (Exception $e) {
        echo "Error al calcular/aplicar el descuento: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

function reporteBajoStock($conn) {
    $query = "CALL sp_reporte_bajo_stock()";
    $stmt = mysqli_prepare($conn, $query);
    
    try {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        echo "<h3>Reporte de Productos con Bajo Stock</h3>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Producto ID: " . $row['producto_id'] . "<br>";
            echo "Nombre: " . $row['nombre'] . "<br>";
            echo "Cantidad: " . $row['cantidad'] . "<br>";
            echo "Sugerencia: " . $row['sugerencia_reorden'] . "<br><br>";
        }
    } catch (Exception $e) {
        echo "Error al generar el reporte de bajo stock: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

function calcularComisiones($conn) {
    $query = "CALL sp_calcular_comisiones()";
    $stmt = mysqli_prepare($conn, $query);
    
    try {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        echo "<h3>Reporte de Comisiones</h3>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Vendedor ID: " . $row['vendedor_id'] . "<br>";
            echo "Total Ventas: $" . $row['total_ventas'] . "<br>";
            echo "Total Productos: " . $row['total_productos'] . "<br>";
            echo "Comisión: " . $row['comision'] . "<br><br>";
        }
    } catch (Exception $e) {
        echo "Error al calcular las comisiones: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}


// Ejemplos de uso
registrarVenta($conn, 1, 1, 2);
obtenerEstadisticasCliente($conn, 1);

mysqli_close($conn);
?>