<?php
require_once "config_pdo.php";

// Función para registrar errores en un archivo de log
function registrar_error($mensaje) {
    $archivo_log = 'error_log.txt';
    $mensaje = date('Y-m-d H:i:s') . " - " . $mensaje . "\n";
    file_put_contents($archivo_log, $mensaje, FILE_APPEND);
}

try {
    // 1. Mostrar todos los usuarios junto con el número de publicaciones que han hecho
    $sql = "SELECT u.id, u.nombre, COUNT(p.id) as num_publicaciones 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            GROUP BY u.id";

    $stmt = $pdo->query($sql);
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
    }

    echo "<h3>Usuarios y número de publicaciones:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Usuario: " . $row['nombre'] . ", Publicaciones: " . $row['num_publicaciones'] . "<br>";
    }

    // 2. Listar todas las publicaciones con el nombre del autor
    $sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
            FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha_publicacion DESC";

    $stmt = $pdo->query($sql);
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
    }

    echo "<h3>Publicaciones con nombre del autor:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }

    // 3. Encontrar el usuario con más publicaciones
    $sql = "SELECT u.nombre, COUNT(p.id) as num_publicaciones 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            GROUP BY u.id 
            ORDER BY num_publicaciones DESC 
            LIMIT 1";

    $stmt = $pdo->query($sql);
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<h3>Usuario con más publicaciones:</h3>";
    echo "Nombre: " . $row['nombre'] . ", Número de publicaciones: " . $row['num_publicaciones'];

    // 4. Mostrar las últimas 5 publicaciones con el nombre del autor
    $sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
            FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha_publicacion DESC 
            LIMIT 5";

    $stmt = $pdo->query($sql);
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
    }

    echo "<h3>Últimas 5 publicaciones:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }

    // 5. Listar los usuarios que no han realizado ninguna publicación
    $sql = "SELECT u.nombre 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            WHERE p.id IS NULL";

    $stmt = $pdo->query($sql);
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
    }

    echo "<h3>Usuarios sin publicaciones:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Usuario: " . $row['nombre'] . "<br>";
    }

    // 6. Calcular el promedio de publicaciones por usuario
    $sql = "SELECT AVG(num_publicaciones) as promedio 
            FROM (SELECT COUNT(p.id) as num_publicaciones 
                  FROM usuarios u 
                  LEFT JOIN publicaciones p ON u.id = p.usuario_id 
                  GROUP BY u.id) as subquery";

    $stmt = $pdo->query($sql);
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<h3>Promedio de publicaciones por usuario: " . $row['promedio'] . "</h3>";

    // 7. Encontrar la publicación más reciente de cada usuario
    $sql = "SELECT u.nombre, p.titulo, p.fecha_publicacion 
            FROM usuarios u 
            INNER JOIN publicaciones p ON u.id = p.usuario_id 
            WHERE p.fecha_publicacion = (SELECT MAX(p2.fecha_publicacion) 
                                         FROM publicaciones p2 
                                         WHERE p2.usuario_id = u.id)";

    $stmt = $pdo->query($sql);
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
    }

    echo "<h3>Publicación más reciente de cada usuario:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Usuario: " . $row['nombre'] . ", Título: " . $row['titulo'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }

} catch (Exception $e) {
    echo "Se produjo un error: " . $e->getMessage();
    registrar_error($e->getMessage());  // Registrar el error en un archivo de log
}

$pdo = null;
?>
