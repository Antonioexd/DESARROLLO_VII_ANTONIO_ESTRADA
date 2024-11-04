<?php
require 'database_connection.php';
require 'Paginator.php';

// Parámetros de paginación y caché
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = isset($_GET['perPage']) ? min(100, max(1, (int)$_GET['perPage'])) : 10;
$cacheFile = "cache/page_{$page}_perPage_{$perPage}.json";

// Obtener datos del caché si están disponibles
if (file_exists($cacheFile) && time() - filemtime($cacheFile) < 3600) {
    $data = json_decode(file_get_contents($cacheFile), true);
} else {
    $paginator = new Paginator($pdo, 'productos', $perPage);
    $paginator->setPage($page);
    $results = $paginator->getResults();
    $pageInfo = $paginator->getPageInfo();
    $data = ['results' => $results, 'pageInfo' => $pageInfo];
    file_put_contents($cacheFile, json_encode($data));
}

// Exportar a CSV si se solicita
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=\"productos.csv\"");

    $output = fopen("php://output", "w");
    fputcsv($output, array_keys($data['results'][0]));

    foreach ($data['results'] as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
}

// Retornar los resultados en JSON para la paginación infinita
header("Content-Type: application/json");
echo json_encode($data);
?>
