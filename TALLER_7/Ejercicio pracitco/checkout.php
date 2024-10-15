<?php
include 'config_sesion.php';

// Verificar si hay productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "No hay productos en el carrito.";
    exit();
}

// Procesar la compra (aquí podrías conectar con un sistema de pago)

// Simular un nombre de usuario
$usuario = 'Cliente';

// Guardar el nombre del usuario en una cookie por 24 horas
setcookie('nombre_usuario', $usuario, time() + 86400, '/', '', true, true);  // Secure y HttpOnly

// Limpiar el carrito
$_SESSION['carrito'] = [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra Finalizada</title>
</head>
<body>
    <h1>Compra Finalizada</h1>
    <p>Gracias por tu compra, <?php echo htmlspecialchars($usuario); ?>.</p>
    <a href="productos.php">Volver a la tienda</a>
</body>
</html>
