
<?php
// Ejemplo básico de sort()
$numeros = [5, 2, 8, 1, 9];
echo "Array original: " . implode(", ", $numeros) . "</br>";
sort($numeros);
echo "Array ordenado: " . implode(", ", $numeros) . "</br>";

// Ordenar strings
$frutas = ["naranja", "manzana", "plátano", "uva"];
echo "</br>Frutas originales: " . implode(", ", $frutas) . "</br>";
sort($frutas);
echo "Frutas ordenadas: " . implode(", ", $frutas) . "</br>";

// Ejercicio: Ordenar calificaciones de estudiantes
$calificaciones = [
    "Juan" => 97,
    "María" => 82,
    "Carlos" => 71,
    "Ana" => 25
];
echo "</br>Calificaciones originales:</br>";
print_r($calificaciones);

asort($calificaciones);  // Ordena por valor manteniendo la asociación de índices
echo "Calificaciones ordenadas por nota:</br>";
print_r($calificaciones);

ksort($calificaciones);  // Ordena por clave (nombre del estudiante)
echo "Calificaciones ordenadas por nombre:</br>";
print_r($calificaciones);

// Bonus: Ordenar en orden descendente
$numeros = [5, 2, 8, 1, 9];
rsort($numeros);
echo "</br>Números en orden descendente: " . implode(", ", $numeros) . "</br>";

// Extra: Ordenar array multidimensional
$estudiantes = [
    ["nombre" => "Juan", "edad" => 20, "promedio" => 9.7],
    ["nombre" => "María", "edad" => 22, "promedio" => 8.2],
    ["nombre" => "Carlos", "edad" => 19, "promedio" => 7.1],
    ["nombre" => "Ana", "edad" => 21, "promedio" => 2.5]
];

// Ordenar por promedio
usort($estudiantes, function($a, $b) {
    return $b['promedio'] <=> $a['promedio'];
});

echo "</br>Estudiantes ordenados por promedio (descendente):</br>";
foreach ($estudiantes as $estudiante) {
    echo "{$estudiante['nombre']}: {$estudiante['promedio']}</br>";
}

// Desafío: Implementar ordenamiento personalizado
function ordenarPorLongitud($a, $b) {
    return strlen($b) - strlen($a);
}

$palabras = ["PHP", "JavaScript", "Python", "Java", "C++", "Ruby"];
usort($palabras, 'ordenarPorLongitud');
echo "</br>Palabras ordenadas por longitud (descendente):</br>";
print_r($palabras);

// Ejemplo adicional: Ordenar preservando claves
$datos = [
    "z" => "Último",
    "a" => "Primero",
    "m" => "Medio"
];

ksort($datos);  // Ordena por clave
echo "</br>Datos ordenados por clave:</br>";
print_r($datos);

arsort($datos);  // Ordena por valor en orden descendente
echo "Datos ordenados por valor (descendente):</br>";
print_r($datos);

$libros = [
    "El Señor de los Anillos" => 5,
    "Cien Años de Soledad" => 8,
    "1984" => 3,
    "Moby Dick" => 2,
    "La Odisea" => 10
];

echo "Inventario original:\n";
print_r($libros);

// Ordenar por valor (cantidad en stock) en orden ascendente
asort($libros);
echo "\nInventario ordenado por cantidad (ascendente) usando asort():\n";
print_r($libros);

// Ordenar por clave (título del libro) en orden ascendente
ksort($libros);
echo "\nInventario ordenado por título del libro (ascendente) usando ksort():\n";
print_r($libros);

// Ordenar por valor (cantidad en stock) en orden descendente
arsort($libros);
echo "\nInventario ordenado por cantidad (descendente) usando arsort():\n";
print_r($libros);

?>
      
