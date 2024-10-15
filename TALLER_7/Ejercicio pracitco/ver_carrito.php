<?php
include 'config_sesion.php';

// Lista de productos (simular desde la base de datos)
$productos = [
    1 => ['nombre' => 'Producto A', 'precio' => 10],
    2 => ['nombre' => 'Producto B', 'precio' => 15],
    3 => ['nombre' => 'Producto C', 'precio' => 20],
    4 => ['nombre' => 'Producto D', 'precio' => 25],
    5 => ['nombre' => 'Producto E', 'precio' => 30]
];

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Carrito de Compras</h1>

    <?php if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['carrito'] as $id_producto => $producto_carrito): ?>
                    <?php
                    $producto = $productos[$id_producto];
                    $subtotal = $producto_carrito['cantidad'] * $producto['precio'];
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($producto_carrito['cantidad']); ?></td>
                        <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                        <td><?php echo $subtotal; ?></td>
                        <td>
                            <form action="eliminar_del_carrito.php" method="post">
                                <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                <input type="submit" value="Eliminar">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>Total: $<?php echo $total; ?></p>
        <a href="checkout.php">Finalizar Compra</a>
    <?php else: ?>
        <p>El carrito está vacío.</p>
    <?php endif; ?>

    <a href="productos.php">Seguir comprando</a>
</body>
</html>
