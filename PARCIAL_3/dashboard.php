<?php 
session_start();
if (isset($_SESSION['tareas'])){
    $_SESSION['tareas'] = [];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $titulo = $_POST['titulo'];
    $fecha_limite = $_POST['fecha_limite'];

if (!empty($titulo) && !empty($fecha_limite) && strtotime($fecha_limite) > time()){
    $_SESSION['tareas'][] = ['titulo' => $titulo, 'fecha_limite' => $fecha_limite];
}else {
    $error = "Todos los campos son obligatorios y la fecha debe ser futura.";
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Lista de Tareas de <?php echo $_SESSION['usuario']; ?></h2>
    <ul>
        <?php foreach ($_SESSION['tareas'] as $tarea): ?>
            <li><?php echo $tarea['titulo'] . " - " . $tarea['fecha_limite']; ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Agregar Tarea</h3>
    <form method="post" action="">
        Título: <input type="text" name="titulo" required><br>
        Fecha Límite: <input type="date" name="fecha_limite" required><br>
        <input type="submit" value="Agregar Tarea">
    </form>

    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

    <p><a href="logout.php">Cerrar Sesión</a></p>
</body>
</html>
