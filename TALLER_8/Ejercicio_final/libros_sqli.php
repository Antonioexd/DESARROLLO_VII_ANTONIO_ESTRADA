<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $isbn = $_POST['isbn'];
    $anio = $_POST['anio'];
    $cantidad = $_POST['cantidad'];

    $stmt = $conn->prepare("INSERT INTO libros (titulo, autor, isbn, anio, cantidad) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $titulo, $autor, $isbn, $anio, $cantidad);

    if ($stmt->execute()) {
        echo "Libro añadido exitosamente";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
