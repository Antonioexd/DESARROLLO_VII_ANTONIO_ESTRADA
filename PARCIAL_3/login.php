<?php 
session_start(); //Iniciar Sesion

//validar las credenciales

$usuarios = [
    'usuario1' => 'contrasena1',
    'usuario2' =>'contrasena2'
];

if (isset($_SESSION['REWQUEST_METHOD'])  === 'POST'){
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
}

if (!empty($usuario) && !empty($contrasena)) {
    $_SESSION['usuarios'][] = ['usuario' => $usuario, 'contrasena' => $contrasena];
}else {
    $error = "Credenciales incorrectas o espacios vacios.";
}

if (isset($usuarios['usuario']) && $usuarios['usuario'] === $contrasena){
    $_SESSION['usuario'] = $usuario;
    $_SESSION['contrasena'] = $contrasena;
    $_SESSION['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'];
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
</head>
<body>
    <h2>Iniciar sesion</h2>
    <form method="post" action="">
        Usuario = <input type="text" name="usuario" required><br>
        contraseña = <input type="password" name="contraseña" required><br>
        <input type="submit" value="Iniciar Sesion" >
             
    </form>
</body>
</html>