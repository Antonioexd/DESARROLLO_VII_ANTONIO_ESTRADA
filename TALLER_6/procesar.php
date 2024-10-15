<?php
// Iniciar variables para errores y datos
$errores = [];
$datos = [];

// Sanitización y validación de los campos existentes
// ...

// Sanitización de la fecha de nacimiento
if (isset($_POST['fecha_nacimiento'])) {
    $fecha_nacimiento = filter_input(INPUT_POST, 'fecha_nacimiento', FILTER_SANITIZE_STRING);
    
    // Validar que la fecha sea válida
    if (!$fecha_nacimiento || !DateTime::createFromFormat('Y-m-d', $fecha_nacimiento)) {
        $errores[] = "La fecha de nacimiento no es válida.";
    } else {
        // Calcular la edad
        $fecha_actual = new DateTime();
        $fecha_nac = new DateTime($fecha_nacimiento);
        $edad = $fecha_actual->diff($fecha_nac)->y;
        $datos['edad'] = $edad;
        $datos['fecha_nacimiento'] = $fecha_nacimiento;
    }
}

// Validación y procesamiento de la foto de perfil con nombre único
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
    $nombre_archivo = $_FILES['foto_perfil']['name'];
    $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
    $nombre_unico = uniqid('foto_') . '.' . $extension;
    
    $ruta_destino = 'uploads/' . $nombre_unico;
    
    if (!move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $ruta_destino)) {
        $errores[] = "Error al subir la foto de perfil.";
    } else {
        $datos['foto_perfil'] = $ruta_destino;
    }
} else {
    $errores[] = "No se ha subido una foto de perfil.";
}

// Mostrar resultados o errores
if (empty($errores)) {
    // Mostrar datos recibidos, incluyendo la edad calculada
    echo "<h2>Datos Recibidos:</h2>";
    echo "<table border='1'>";
    foreach ($datos as $campo => $valor) {
        echo "<tr>";
        echo "<th>" . ucfirst($campo) . "</th>";
        echo "<td>$valor</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    // Mostrar errores y devolver los datos anteriores en el formulario
    echo "<h2>Errores:</h2>";
    echo "<ul>";
    foreach ($errores as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
    
    // Devolver los datos ingresados al formulario en caso de error
    echo "<form action='procesar.php' method='post' enctype='multipart/form-data'>";
    echo "<input type='date' name='fecha_nacimiento' value='" . htmlspecialchars($fecha_nacimiento) . "'>";
    // Otros campos con datos ingresados...
    echo "<input type='submit' value='Enviar'>";
    echo "</form>";

    if (empty($errores)) {
        // Guardar datos en un archivo JSON
        $archivo_json = 'registros.json';
        
        if (file_exists($archivo_json)) {
            $registros = json_decode(file_get_contents($archivo_json), true);
        } else {
            $registros = [];
        }
        
        $registros[] = $datos;
        
        file_put_contents($archivo_json, json_encode($registros, JSON_PRETTY_PRINT));
        
        echo "<p>Datos guardados exitosamente.</p>";
    }
    
}

// Enlace para volver al formulario
echo "<br><a href='formulario.html'>← Volver al formulario</a>";
?>
