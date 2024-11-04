<?php
require_once "config_pdo.php";

function obtenerEstadisticasTabla($pdo, $tabla) {
    try {
        $sql = "SHOW TABLE STATUS LIKE :tabla";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':tabla' => $tabla]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

function obtenerEstadisticasIndices($pdo, $tabla) {
    try {
        $sql = "SHOW INDEX FROM " . $tabla;
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

function mostrarVariablesRendimiento($pdo) {
    try {
        $variables = [
            'innodb_buffer_pool_size',
            'key_buffer_size',
            'max_connections',
            'query_cache_size',
            'tmp_table_size',
            'max_heap_table_size'
        ];
        
        $sql = "SHOW VARIABLES WHERE Variable_name IN ('" . implode("','", $variables) . "')";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

function monitorearConsulta($pdo, $consultaSQL) {
    $inicio = microtime(true);
    $stmt = $pdo->prepare($consultaSQL);
    $stmt->execute();
    $fin = microtime(true);

    $tiempoEjecucion = $fin - $inicio;
    
    // Insertar el resultado en la tabla de monitoreo
    $sqlMonitoreo = "INSERT INTO monitoreo_consultas (consulta, tiempo_ejecucion) VALUES (:consulta, :tiempo)";
    $stmtMonitoreo = $pdo->prepare($sqlMonitoreo);
    $stmtMonitoreo->execute([
        ':consulta' => $consultaSQL,
        ':tiempo' => $tiempoEjecucion
    ]);

    echo "Consulta ejecutada en: " . number_format($tiempoEjecucion, 4) . " segundos<br>";
}

// Mostrar estadísticas
$tablas = ['productos', 'ventas', 'detalles_venta', 'clientes'];

echo "<h2>Estadísticas de Tablas</h2>";
foreach ($tablas as $tabla) {
    echo "<h3>Tabla: $tabla</h3>";
    print_r(obtenerEstadisticasTabla($pdo, $tabla));
    
    echo "<h4>Índices:</h4>";
    print_r(obtenerEstadisticasIndices($pdo, $tabla));
}

echo "<h2>Variables de Rendimiento</h2>";
print_r(mostrarVariablesRendimiento($pdo));

$pdo = null;
?>