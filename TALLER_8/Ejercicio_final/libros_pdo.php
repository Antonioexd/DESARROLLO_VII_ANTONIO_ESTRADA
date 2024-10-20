<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $isbn = $_POST['isbn'];
    $anio = $_POST['anio'];
    $cantidad = $_POST['cantidad'];

    $sql = "INSERT INTO libros (titulo, autor, isbn, anio, cantidad) VALUES (:titulo, :autor, :isbn, :anio, :cantidad)";
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':isbn', $isbn);
    $stmt->bindParam(':anio', $anio);
    $stmt->bindParam(':cantidad', $cantidad);
    
    if ($stmt->execute()) {
        echo "Libro añadido exitosamente";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
