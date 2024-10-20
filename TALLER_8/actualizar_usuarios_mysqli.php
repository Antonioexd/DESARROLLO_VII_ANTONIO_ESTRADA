<?php
require_once "config_mysqli.php";

// Parámetros del usuario que se va a actualizar
$id = 1; // El ID del usuario que se va a actualizar
$nuevo_nombre = "Carlos Gómez";
$nuevo_email = "carlos@example.com";

// Consulta de actualización
$sql = "UPDATE usuarios SET nombre='$nuevo_nombre', email='$nuevo_email' WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo "Registro actualizado exitosamente.";
} else {
    echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($conn);
}

// Cerrar la conexión
mysqli_close($conn);
?>
