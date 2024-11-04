<?php

// Verificar nivel de membresía de un cliente
function verificarMembresia($pdo, $cliente_id) {
    $stmt = $pdo->prepare("SELECT nivel_membresia, total_compras FROM clientes WHERE id = ?");
    $stmt->execute([$cliente_id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($cliente) {
        echo "Nivel de Membresía: " . $cliente['nivel_membresia'] . "<br>";
        echo "Total de Compras: $" . $cliente['total_compras'] . "<br><br>";
    } else {
        echo "Cliente no encontrado.<br><br>";
    }
}

// Verificar estadísticas de ventas por categoría
function verificarEstadisticasVentas($pdo, $categoria_id) {
    $stmt = $pdo->prepare("SELECT total_ventas FROM estadisticas_ventas WHERE categoria_id = ?");
    $stmt->execute([$categoria_id]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado) {
        echo "Total de Ventas para la Categoría: $" . $resultado['total_ventas'] . "<br><br>";
    } else {
        echo "No se encontraron estadísticas para esta categoría.<br><br>";
    }
}

// Verificar alerta de stock crítico
function verificarAlertaStock($pdo, $producto_id) {
    $stmt = $pdo->prepare("SELECT stock_actual, fecha_alerta FROM alertas_stock WHERE producto_id = ? ORDER BY fecha_alerta DESC LIMIT 1");
    $stmt->execute([$producto_id]);
    $alerta = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($alerta) {
        echo "Alerta de Stock Crítico:<br>";
        echo "Stock Actual: " . $alerta['stock_actual'] . "<br>";
        echo "Fecha de Alerta: " . $alerta['fecha_alerta'] . "<br><br>";
    } else {
        echo "No se han generado alertas para este producto.<br><br>";
    }
}

// Verificar historial de cambios de estado del cliente
function verificarHistorialEstado($pdo, $cliente_id) {
    $stmt = $pdo->prepare("SELECT estado_anterior, estado_nuevo, fecha_cambio FROM historial_estado_clientes WHERE cliente_id = ? ORDER BY fecha_cambio DESC LIMIT 1");
    $stmt->execute([$cliente_id]);
    $historial = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($historial) {
        echo "Historial de Cambio de Estado:<br>";
        echo "Estado Anterior: " . $historial['estado_anterior'] . "<br>";
        echo "Estado Nuevo: " . $historial['estado_nuevo'] . "<br>";
        echo "Fecha de Cambio: " . $historial['fecha_cambio'] . "<br><br>";
    } else {
        echo "No se encontraron cambios de estado para este cliente.<br><br>";
    }
}

// Ejecución de verificaciones (reemplaza los IDs con los valores específicos para probar)
$cliente_id = 1;  // ID de un cliente existente
$categoria_id = 1; // ID de una categoría existente
$producto_id = 1;  // ID de un producto existente

// Llamadas a las funciones de verificación
echo "<h3>Verificación de Nivel de Membresía</h3>";
verificarMembresia($pdo, $cliente_id);

echo "<h3>Verificación de Estadísticas de Ventas por Categoría</h3>";
verificarEstadisticasVentas($pdo, $categoria_id);

echo "<h3>Verificación de Alerta de Stock Crítico</h3>";
verificarAlertaStock($pdo, $producto_id);

echo "<h3>Verificación de Historial de Cambios de Estado</h3>";
verificarHistorialEstado($pdo, $cliente_id);
?>
