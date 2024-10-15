<?php
include 'config_sesion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_producto'])) {
    $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);

    if ($id_producto !== false && isset($_SESSION['carrito'][$id_producto])) {
        unset($_SESSION['carrito'][$id_producto]);
    }

    header("Location: ver_carrito.php");
    exit();
}
?>
