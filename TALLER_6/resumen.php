<?php
$archivo_json = 'registros.json';

if (file_exists($archivo_json)) {
    $registros = json_decode(file_get_contents($archivo_json), true);

    if (!empty($registros)) {
        echo "<h2>Resumen de Registros</h2>";
        echo "<table border='1' style='border-collapse: collapse; width: 50%; text-align: left;'>";
        echo "<thead><tr><th>Campo</th><th>Valor</th></tr></thead>";
        echo "<tbody>";

        foreach ($registros as $registro) {
            foreach ($registro as $campo => $valor) {
                echo "<tr>";
                echo "<th style='text-transform: capitalize;'>" . htmlspecialchars($campo) . "</th>";
                echo "<td>" . htmlspecialchars($valor) . "</td>";
                echo "</tr>";
            }
            echo "<tr><td colspan='2'><hr></td></tr>";  // Separador entre registros
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No hay registros almacenados.</p>";
    }
} else {
    echo "<p>No hay registros almacenados.</p>";
}
?>
