<?php
require_once "config_pdo.php";

// ID del usuario que se va a eliminar
$id = 1; // El ID del usuario que se va a eliminar

try {
    // Consulta de eliminación
    $sql = "DELETE FROM usuarios WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    
    // Asignar valor al parámetro ID
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    echo "Registro eliminado exitosamente.";
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}

// Cerrar la conexión
$pdo = null;
?>
