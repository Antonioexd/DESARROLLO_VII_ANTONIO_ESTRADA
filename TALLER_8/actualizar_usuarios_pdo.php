<?php
require_once "config_pdo.php";

// Parámetros del usuario que se va a actualizar
$id = 1; // El ID del usuario que se va a actualizar
$nuevo_nombre = "Carlos Gómez";
$nuevo_email = "carlos@example.com";

try {
    // Consulta de actualización
    $sql = "UPDATE usuarios SET nombre=:nombre, email=:email WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    
    // Asignar valores a los parámetros
    $stmt->bindParam(':nombre', $nuevo_nombre);
    $stmt->bindParam(':email', $nuevo_email);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    echo "Registro actualizado exitosamente.";
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}

// Cerrar la conexión
$pdo = null;
?>
