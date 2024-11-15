<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=biblioteca_personal', 'root', ''); // Ajusta el usuario y contraseña si es necesario
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
