
<?php
// Definir variables
$nombre_completo = "Antonio Estrada Mendoza";
$edad = 20; // edad real
$correo = "antonio.estrada1@utp.ac.pa"; // tu correo real
$telefono = "6525-6504"; // tu número real

// Definir constante
define("OCUPACION", "Estudiante");

// Mostrar la información usando diferentes métodos de impresión
echo "Nombre Completo: " . $nombre_completo . "<br>"; // Concatenación con punto
print "Edad: $edad<br>"; // Interpolación directa
printf("Correo: %s<br>", $correo); // printf con formato
echo "Teléfono: {$telefono}<br>"; // Interpolación con llaves
echo "Ocupación: " . OCUPACION . "<br>"; // Concatenación con constante

// Mostrar el tipo y valor de cada variable
echo "<br>Información de las variables y constante:<br>";
var_dump($nombre_completo);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($correo);
echo "<br>";
var_dump($telefono);
echo "<br>";
var_dump(OCUPACION);
?>


                    

                    

                    
