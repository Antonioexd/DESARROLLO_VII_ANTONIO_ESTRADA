
<?php
// Ejemplo de uso de str_replace()
$frase = "El gato negro saltó sobre el perro negro";
$fraseModificada = str_replace("negro", "blanco", $frase);

echo "Frase original: $frase</br>";
echo "Frase modificada: $fraseModificada</br>";

// Ejercicio: Crea una variable con una frase que contenga al menos tres veces la palabra "PHP"
// y usa str_replace() para cambiar "PHP" por "JavaScript"
$miFrase = "En la clase de hoy de desarrollo VII vimos funciones predefinidas de PHP, Estoy muy contento de a ver hecho mi HOLA MUNDO en PHP, espero poder terminar este taller que estoy haciendo en PHP a tiempo xddd"; // Reemplaza esto con tu frase
$miFraseModificada = str_replace("PHP", "JavaScript", $miFrase);

echo "</br>Mi frase original: $miFrase</br>";
echo "Mi frase modificada: $miFraseModificada</br>";

// Bonus: Usa str_replace() para reemplazar múltiples palabras a la vez
$texto = "Le arregle la laptop a mi mama para poderme llevar mi mouse a la ciudad. Lo utilizare con la laptop.";
$buscar = ["laptop", "mouse"];
$reemplazar = ["Peras", "uvas"];
$textoModificado = str_replace($buscar, $reemplazar, $texto);

echo "</br>Texto original: $texto</br>";
echo "Texto modificado: $textoModificado</br>";
?>