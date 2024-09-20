<?php
// 1. Crear un arreglo multidimensional de ventas por región y producto
$ventas = [
    "Norte" => [
        "Producto A" => [100, 120, 140, 110, 130],
        "Producto B" => [85, 95, 105, 90, 100],
        "Producto C" => [60, 55, 65, 70, 75]
    ],
    "Sur" => [
        "Producto A" => [80, 90, 100, 85, 95],
        "Producto B" => [120, 110, 115, 125, 130],
        "Producto C" => [70, 75, 80, 65, 60]
    ],
    "Este" => [
        "Producto A" => [110, 115, 120, 105, 125],
        "Producto B" => [95, 100, 90, 105, 110],
        "Producto C" => [50, 60, 55, 65, 70]
    ],
    "Oeste" => [
        "Producto A" => [90, 85, 95, 100, 105],
        "Producto B" => [105, 110, 100, 115, 120],
        "Producto C" => [80, 85, 75, 70, 90]
    ]
];

// 2. Función para calcular el promedio de ventas
function promedioVentas($ventas) {
    return array_sum($ventas) / count($ventas);
}

// 3. Calcular y mostrar el promedio de ventas por región y producto
echo "Promedio de ventas por región y producto:\n";
foreach ($ventas as $region => $productos) {
    echo "$region:\n";
    foreach ($productos as $producto => $ventasProducto) {
        $promedio = promedioVentas($ventasProducto);
        echo "  $producto: " . number_format($promedio, 2) . "\n";
    }
    echo "\n";
}

// 4. Función para encontrar el producto más vendido en una región
function productoMasVendido($productos) {
    $maxVentas = 0;
    $productoTop = '';
    foreach ($productos as $producto => $ventas) {
        $totalVentas = array_sum($ventas);
        if ($totalVentas > $maxVentas) {
            $maxVentas = $totalVentas;
            $productoTop = $producto;
        }
    }
    return [$productoTop, $maxVentas];
}

// 5. Encontrar y mostrar el producto más vendido por región
echo "Producto más vendido por región:\n";
foreach ($ventas as $region => $productos) {
    [$productoTop, $ventasTop] = productoMasVendido($productos);
    echo "$region: $productoTop (Total: $ventasTop)\n";
}

// 6. Calcular las ventas totales por producto
$ventasTotalesPorProducto = [];
foreach ($ventas as $region => $productos) {
    foreach ($productos as $producto => $ventasProducto) {
        if (!isset($ventasTotalesPorProducto[$producto])) {
            $ventasTotalesPorProducto[$producto] = 0;
        }
        $ventasTotalesPorProducto[$producto] += array_sum($ventasProducto);
    }
}

echo "\nVentas totales por producto:\n";
arsort($ventasTotalesPorProducto);
foreach ($ventasTotalesPorProducto as $producto => $total) {
    echo "$producto: $total\n";
}

// 7. Encontrar la región con mayores ventas totales
$ventasTotalesPorRegion = array_map(function($productos) {
    return array_sum(array_map('array_sum', $productos));
}, $ventas);

$regionTopVentas = array_keys($ventasTotalesPorRegion, max($ventasTotalesPorRegion))[0];
echo "\nRegión con mayores ventas totales: $regionTopVentas\n";

// TAREA: Implementa una función que analice el crecimiento de ventas
// Calcula y muestra el porcentaje de crecimiento de ventas del primer al último mes
// para cada producto en cada región. Identifica el producto y la región con mayor crecimiento.
// Tu código aquí

function calcularCrecimiento($ventasPrimerMes, $ventasUltimoMes) {
    if ($ventasPrimerMes == 0) return 0; // Evitar divisiones por cero
    return (($ventasUltimoMes - $ventasPrimerMes) / $ventasPrimerMes) * 100;
}

// Función para analizar el crecimiento de ventas por región y producto
function analizarCrecimientoVentas($ventas) {
    $mayorCrecimiento = -INF;
    $productoMayorCrecimiento = '';
    $regionMayorCrecimiento = '';

    echo "Crecimiento de ventas por región y producto:\n";
    foreach ($ventas as $region => $productos) {
        echo "$region:\n";
        foreach ($productos as $producto => $ventasProducto) {
            $primerMes = $ventasProducto[0];  // Ventas del primer mes
            $ultimoMes = $ventasProducto[count($ventasProducto) - 1];  // Ventas del último mes

            // Calcular el porcentaje de crecimiento
            $crecimiento = calcularCrecimiento($primerMes, $ultimoMes);
            echo "  $producto: " . number_format($crecimiento, 2) . "% de crecimiento\n";

            // Identificar el mayor crecimiento
            if ($crecimiento > $mayorCrecimiento) {
                $mayorCrecimiento = $crecimiento;
                $productoMayorCrecimiento = $producto;
                $regionMayorCrecimiento = $region;
            }
        }
        echo "\n";
    }

    // Mostrar el producto y la región con mayor crecimiento
    echo "Producto y región con mayor crecimiento:\n";
    echo "$productoMayorCrecimiento en la región $regionMayorCrecimiento con un crecimiento de " . number_format($mayorCrecimiento, 2) . "%\n";
}

// Llamar a la función para analizar el crecimiento de ventas
analizarCrecimientoVentas($ventas);


?>