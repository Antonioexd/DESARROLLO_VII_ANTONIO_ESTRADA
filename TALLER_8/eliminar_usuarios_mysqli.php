<?php
require_once "config_mysqli.php";

// ID del usuario que se va a eliminar
$id = 1; // El ID del usuario que se va a eliminar

// Consulta de eliminación
$sql = "DELETE FROM usuarios WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo "Registro eliminado exitosamente.";
} else {
    echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($conn);
}

// Cerrar la conexión
mysqli_close($conn);
?>
