<?php

declare(strict_types=1);

function limpiarEspacios(string $texto): string
{
    // TODO 1: limpiar extremos y agrupar espacios consecutivos.
    return preg_replace('/\s+/', ' ', trim($texto));
}

function normalizarBusqueda(string $texto): string
{
    // REVISAR: ¿funciona con PÁDEL y ÓRBITA?
    return mb_strtolower(limpiarEspacios($texto), 'UTF-8');
}

function obtenerCategorias(array $actividades): array
{
    // TODO 2: extraer categorías sin duplicados en orden de aparición.
    return array_values(array_unique(array_column($actividades, 'categoria')));
}

function categoriaValida(string $categoria, array $categorias): bool
{
    return $categoria === '' || array_search($categoria, $categorias, true) !== false;
}

function plazasOcupadas(array $reservas, int $actividadId): int
{
    // TODO 5: sumar plazas de reservas confirmadas de esta actividad.
    $confirmadas = array_filter($reservas, 
    fn(array $a):bool =>
    $a['actividadId'] === $actividadId && $a['estado'] === 'confirmada');
    return array_reduce($confirmadas, 
            fn(int $carry, array $r): int=> $carry + $r['plazas'], 0);
}

// Función facilitada: añade los cálculos a una copia de cada actividad.
function prepararActividades(array $actividades, array $reservas): array
{
    return array_map(
        function (array $actividad) use ($reservas): array {
            $actividad['ocupadas'] = plazasOcupadas($reservas, $actividad['id']);
            $actividad['libres'] = $actividad['capacidad'] - $actividad['ocupadas'];

            return $actividad;
        },
        $actividades
    );
}

function filtrarActividades(
    array $actividades,
    string $texto,
    string $categoria,
    bool $soloConPlazas
): array
{
    // TODO 3: filtrar por nombre, categoría y plazas libres.
    return array_filter(
        $actividades, 
        fn(array $a): bool =>
        (str_contains(normalizarBusqueda($a['nombre']), normalizarBusqueda($texto))) &&

        ($categoria === '' ||
            normalizarBusqueda($a['categoria']) === normalizarBusqueda($categoria)) &&

        (!$soloConPlazas || $a['libres'] > 0)
    );
}

function ordenarActividades(array $actividades, string $orden): array
{
    // TODO 4: ordenar una copia según el criterio y desempatar por id.
    usort($actividades,
        fn(array $a, array $b):int =>
        $orden === 'libres' ? 
            (($a[$orden] <=> $b[$orden]) ?: $a['id'] <=> $b['id'])
            : ((normalizarBusqueda($a[$orden]) <=> normalizarBusqueda($b[$orden])) ?: $a['id'] <=> $b['id']),
    );
    return $actividades;
}

function resumirActividades(array $actividades): array
{
    return [
        'cantidad' => count($actividades),
        'capacidad' => array_reduce($actividades, fn(int $carry, array $a):int => $carry + $a['capacidad'], 0), // REVISAR: cuenta actividades, no plazas
        'ocupadas' => array_reduce(
            $actividades,
            fn(int $s, array $a): int => $s + $a['ocupadas'],
            0
        ),
        'libres' => array_reduce(
            $actividades,
            fn(int $s, array $a): int => $s + $a['libres'],
            0,),
         // TODO 6: sumar plazas libres
        'hayCompletas' => array_any($actividades, fn(array $a):bool => $a['libres'] === 0), // TODO 7: comprobar si alguna está completa
        'todasConPlazas' => array_all($actividades, fn(array $a):bool => $a['libres'] > 0), // TODO 8: comprobar si todas tienen plazas
    ];
}

// Función facilitada: permite pasar una función como dato.
function transformarNombres(array $nombres, callable $callback): array
{
    return array_map($callback, $nombres);
}

function generarEtiquetas(array $actividades, string $prefijo = 'Actividad: '): array
{
    $nombres = array_column($actividades, 'nombre');
    return transformarNombres($nombres, 
        function(string $nombre) use ($prefijo): string{
            return $prefijo . limpiarEspacios($nombre);
        });
    // TODO 9: extraer nombres y usar una closure que capture el prefijo.
}

// Función facilitada. La entrada web valida el id antes de llamar.
function normalizarId(int|string $id): int
{
    return (int) $id;
}

function buscarPorId(array $actividades, int|string $id): ?array
{
    // TODO 10: buscar por id en todas las actividades; id no es índice.

    return array_find($actividades, 
            fn(array $a): bool=> $a['id'] === normalizarId($id));
}

function monitorVisible(?string $monitor): string
{
    // return is_null($monitor) ? 'Monitor pendiente' : $monitor;
    return $monitor ?? 'Monitor pendiente';
}

function inicioNombre(string $nombre): string
{
    return mb_substr(limpiarEspacios($nombre), 0, 3, 'UTF-8');
}

function codigoValido(string $codigo): bool
{
    return preg_match('/^DEP-\d{4}-\d{4}$/', $codigo) === 1;
}
