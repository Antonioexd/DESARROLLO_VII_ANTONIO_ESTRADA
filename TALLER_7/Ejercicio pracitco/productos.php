<?php
include 'config_sesion.php';

// Lista de productos
$productos = [
    1 => ['nombre' => 'Producto A', 'precio' => 10],
    2 => ['nombre' => 'Producto B', 'precio' => 15],
    3 => ['nombre' => 'Producto C', 'precio' => 20],
    4 => ['nombre' => 'Producto D', 'precio' => 25],
    5 => ['nombre' => 'Producto E', 'precio' => 30]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>
<body>
    <h1>Lista de Productos</h1>
    <ul>
        <?php foreach ($productos as $id => $producto): ?>
            <li>
                <?php echo htmlspecialchars($producto['nombre']); ?> - $<?php echo htmlspecialchars($producto['precio']); ?>
                <form action="agregar_al_carrito.php" method="post">
                    <input type="hidden" name="id_producto" value="<?php echo $id; ?>">
                    <input type="submit" value="Añadir al carrito">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="ver_carrito.php">Ver Carrito</a>
</body>
</html>
