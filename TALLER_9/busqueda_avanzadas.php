<?php
function busquedaAvanzada($pdo, array $criterios) {
    $qb = new QueryBuilder($pdo);
    $qb->table('productos p')
       ->select('p.*', 'c.nombre as categoria')
       ->join('categorias c', 'p.categoria_id', '=', 'c.id');

    // Aplicar filtros dinámicamente
    if (isset($criterios['nombre'])) {
        $qb->where('p.nombre', 'LIKE', '%' . $criterios['nombre'] . '%');
    }

    if (isset($criterios['precio_min'])) {
        $qb->where('p.precio', '>=', $criterios['precio_min']);
    }

    if (isset($criterios['precio_max'])) {
        $qb->where('p.precio', '<=', $criterios['precio_max']);
    }

    if (isset($criterios['categorias']) && is_array($criterios['categorias'])) {
        $qb->whereIn('c.id', $criterios['categorias']);
    }

    if (isset($criterios['ordenar_por'])) {
        $qb->orderBy($criterios['ordenar_por'], $criterios['orden'] ?? 'ASC');
    }

    if (isset($criterios['limite'])) {
        $qb->limit($criterios['limite'], $criterios['offset'] ?? 0);
    }

    return $qb->execute();
}

function buscarVentas($pdo, array $criterios) {
    $qb = new QueryBuilder($pdo);
    $qb->table('ventas v')
       ->select('v.*', 'c.nombre as cliente', 'p.nombre as producto')
       ->join('clientes c', 'v.cliente_id', '=', 'c.id')
       ->join('productos p', 'v.producto_id', '=', 'p.id');
       
    if (isset($criterios['fecha_inicio'])) {
        $qb->where('v.fecha', '>=', $criterios['fecha_inicio']);
    }
    if (isset($criterios['fecha_fin'])) {
        $qb->where('v.fecha', '<=', $criterios['fecha_fin']);
    }
    if (isset($criterios['cliente_id'])) {
        $qb->where('v.cliente_id', '=', $criterios['cliente_id']);
    }
    if (isset($criterios['producto_id'])) {
        $qb->where('v.producto_id', '=', $criterios['producto_id']);
    }
    if (isset($criterios['monto_min'])) {
        $qb->where('v.monto', '>=', $criterios['monto_min']);
    }
    if (isset($criterios['monto_max'])) {
        $qb->where('v.monto', '<=', $criterios['monto_max']);
    }

    return $qb->execute();
}

function actualizacionMasivaProductos($pdo, array $data, array $criterios) {
    $ub = new UpdateBuilder($pdo);
    $ub->table('productos')->set($data);

    if (isset($criterios['categoria_id'])) {
        $ub->where('categoria_id', '=', $criterios['categoria_id']);
    }
    if (isset($criterios['precio_min'])) {
        $ub->where('precio', '>=', $criterios['precio_min']);
    }
    if (isset($criterios['precio_max'])) {
        $ub->where('precio', '<=', $criterios['precio_max']);
    }

    return $ub->execute();
}


// Ejemplo de uso
$criterios = [
    'nombre' => 'laptop',
    'precio_min' => 500,
    'precio_max' => 2000,
    'categorias' => [1, 2],
    'ordenar_por' => 'p.precio',
    'orden' => 'DESC',
    'limite' => 10
];

$resultados = busquedaAvanzada($pdo, $criterios);
?>