<?php
require_once "config_pdo.php";

try {
    // Iniciar la transacción
    $pdo->beginTransaction();

    // Insertar un nuevo usuario
    $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nombre' => 'Nuevo Usuario', ':email' => 'nuevo@example.com']);
    $usuario_id = $pdo->lastInsertId();  // Obtener el ID del usuario insertado

    // Insertar una publicación para ese usuario
    $sql = "INSERT INTO publicaciones (usuario_id, titulo, contenido) VALUES (:usuario_id, :titulo, :contenido)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':titulo' => 'Nueva Publicación',
        ':contenido' => 'Contenido de la nueva publicación'
    ]);

    // Si ambas consultas fueron exitosas, confirmar la transacción
    $pdo->commit();
    echo "Transacción completada con éxito.";
} catch (Exception $e) {
    // En caso de error, revertir la transacción
    $pdo->rollBack();
    echo "Error en la transacción: " . $e->getMessage();
}
?>
