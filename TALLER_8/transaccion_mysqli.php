<?php
require_once "config_mysqli.php";

// Iniciar la transacción
mysqli_begin_transaction($conn);

try {
    // Insertar un nuevo usuario
    $sql = "INSERT INTO usuarios (nombre, email) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $nombre, $email);
    $nombre = "Nuevo Usuario";
    $email = "nuevo@example.com";
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error al insertar usuario: " . mysqli_error($conn));
    }
    $usuario_id = mysqli_insert_id($conn);  // Obtener el ID del usuario insertado

    // Insertar una publicación para ese usuario
    $sql = "INSERT INTO publicaciones (usuario_id, titulo, contenido) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iss", $usuario_id, $titulo, $contenido);
    $titulo = "Nueva Publicación";
    $contenido = "Contenido de la nueva publicación";
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error al insertar publicación: " . mysqli_error($conn));
    }

    // Si ambas consultas fueron exitosas, confirmar la transacción
    mysqli_commit($conn);
    echo "Transacción completada con éxito.";
} catch (Exception $e) {
    // En caso de error, revertir la transacción
    mysqli_rollback($conn);
    echo "Error en la transacción: " . $e->getMessage();
}

// Cerrar la conexión
mysqli_close($conn);
?>
