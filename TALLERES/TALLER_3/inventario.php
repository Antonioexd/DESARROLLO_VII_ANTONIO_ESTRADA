<?php

// Ruta del archivo JSON
$archivoInventario = 'inventario.json';

// Función para leer el inventario desde el archivo JSON y convertirlo en un array de productos
function leerInventario($archivo) {
    if (!file_exists($archivo)) {
        die("Error: El archivo $archivo no existe.");
    }
    $contenido = file_get_contents($archivo);
    return json_decode($contenido, true);
}

// Función para ordenar el inventario alfabéticamente por nombre del producto
function ordenarInventarioPorNombre(&$inventario) {
    usort($inventario, function($a, $b) {
        return strcmp($a['nombre'], $b['nombre']);
    });
}

// Función para mostrar un resumen del inventario ordenado (nombre, precio, cantidad)
function mostrarResumenInventario($inventario) {
    echo "Resumen del Inventario:\n";
    foreach ($inventario as $producto) {
        echo "- {$producto['nombre']}: Precio: \${$producto['precio']}, Cantidad: {$producto['cantidad']}\n";
    }
}

// Función para calcular el valor total del inventario
function calcularValorTotal($inventario) {
    return array_sum(array_map(function($producto) {
        return $producto['precio'] * $producto['cantidad'];
    }, $inventario));
}

// Función para generar un informe de productos con stock bajo (menos de 5 unidades)
function generarInformeStockBajo($inventario, $umbral = 5) {
    $productosBajoStock = array_filter($inventario, function($producto) use ($umbral) {
        return $producto['cantidad'] < $umbral;
    });

    if (count($productosBajoStock) > 0) {
        echo "Informe de Productos con Stock Bajo (menos de $umbral unidades):\n";
        foreach ($productosBajoStock as $producto) {
            echo "- {$producto['nombre']}: Cantidad: {$producto['cantidad']}\n";
        }
    } else {
        echo "No hay productos con stock bajo.\n";
    }
}

// Leer el inventario desde el archivo JSON
$inventario = leerInventario($archivoInventario);

// Ordenar el inventario alfabéticamente por nombre del producto
ordenarInventarioPorNombre($inventario);

// Mostrar el resumen del inventario
mostrarResumenInventario($inventario);

// Calcular y mostrar el valor total del inventario
$valorTotal = calcularValorTotal($inventario);
echo "\nValor total del inventario: \$$valorTotal\n";

// Generar un informe de productos con stock bajo
generarInformeStockBajo($inventario);

?>
