<?php
include 'config_sesion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_producto'])) {
    $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);

    if ($id_producto !== false) {
        // Verificar si ya existe el carrito
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Añadir el producto al carrito o incrementar la cantidad
        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto]['cantidad']++;
        } else {
            $_SESSION['carrito'][$id_producto] = ['cantidad' => 1];
        }

        header("Location: ver_carrito.php");
        exit();
    } else {
        echo "Producto inválido.";
    }
}
?>
