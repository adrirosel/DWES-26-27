<?php

declare(strict_types=1);

function limpiarEspacios(string $texto): string
{
    // TODO 1: limpiar extremos y agrupar espacios consecutivos.
    return preg_replace('/\s+/', ' ', trim($texto));
}

function normalizarBusqueda(string $texto): string
{
    // REVISAR: ¿funciona con CÁMARA y ÓRBITA?
    return mb_strtolower(limpiarEspacios($texto), 'UTF-8');
}

function obtenerCategorias(array $equipos): array
{
    // TODO 2: extraer categorías sin duplicados en orden de aparición.
    return array_values(array_unique(array_column($equipos, 'categoria')));
}

function categoriaValida(string $categoria, array $categorias): bool
{
    return $categoria === '' ||  array_search($categoria, $categorias, true) !== false;
}

function unidadesPrestadas(array $prestamos, int $equipoId): int
{
    // TODO 5: sumar unidades de préstamos activos de este equipo.
    $filtro = array_filter($prestamos, 
                fn(array $a): bool => $a['equipoId'] === $equipoId && $a['estado'] === 'activo');
    
    $unidadesPrestadas = array_reduce($filtro, 
                        fn(int $carry, array $item): int => $carry + $item['unidades'], 0);
    return $filtro === [] ? 0 : $unidadesPrestadas;
}

// Función facilitada: añade los cálculos a una copia de cada equipo.
function prepararEquipos(array $equipos, array $prestamos): array
{
    return array_map(
        function (array $equipo) use ($prestamos): array {
            $equipo['prestadas'] = unidadesPrestadas($prestamos, $equipo['id']);
            $equipo['disponibles'] = $equipo['unidades'] - $equipo['prestadas'];

            return $equipo;
        },
        $equipos
    );
}

function filtrarEquipos(
    array $equipos,
    string $texto,
    string $categoria,
    bool $soloDisponibles
): array
{
    // TODO 3: filtrar por nombre, categoría y unidades disponibles.
    return array_filter(
        $equipos, 
        fn(array $e): bool => 
        str_contains(normalizarBusqueda($e['nombre']), normalizarBusqueda($texto)) &&
        ($categoria === '' || normalizarBusqueda($e['categoria']) === normalizarBusqueda($categoria)) &&
        (!$soloDisponibles || $e['disponibles'] > 0)
    );
}

function ordenarEquipos(array $equipos, string $orden): array
{
    // TODO 4: ordenar una copia según el criterio y desempatar por id.
    $copia = $equipos;
    usort($copia, 
    fn(array $a, array $b): int=>
        $orden === 'disponibles' 
        ? [$a[$orden], $a['id']] <=> [$b[$orden], $b['id']] 
        : [normalizarBusqueda($a[$orden]), $a['id']] <=> [normalizarBusqueda($b[$orden]), $b['id']]);
    return $copia;
}



function resumirEquipos(array $equipos): array
{
    return [
        'cantidad' => count($equipos),
        'unidades' => array_reduce($equipos, fn(int $carry, array $item): int => $carry + $item['unidades'], 0), // REVISAR: cuenta equipos, no unidades
        'prestadas' => array_reduce(
            $equipos,
            fn(int $s, array $a): int => $s + $a['prestadas'],
            0
        ),
        'disponibles' => array_reduce($equipos, fn(int $carry, array $item): int=> $carry + $item['disponibles'], 0), // TODO 6: sumar unidades disponibles
        'hayAgotados' => array_any($equipos, fn(array $e): bool => $e['disponibles'] === 0), // TODO 7: comprobar si algún equipo está agotado
        'todosDisponibles' => array_all($equipos, fn(array $e): bool => $e['disponibles'] > 0), // TODO 8: comprobar si todos tienen disponibilidad
    ];
}

// Función facilitada: permite pasar una función como dato.
function transformarNombres(array $nombres, callable $callback): array
{
    return array_map($callback, $nombres);
}

function generarEtiquetas(array $equipos, string $prefijo = 'Equipo: '): array
{
    // TODO 9: extraer nombres y usar una closure que capture el prefijo.
    $nombres = array_column($equipos, 'nombre');
    $nombresTransformados = transformarNombres($nombres, 
                                               function(string $n) use ($prefijo){
                                                    return $prefijo . normalizarBusqueda($n);
                                               } );
    return $nombresTransformados;
}

// Función facilitada. La entrada web valida el id antes de llamar.
function normalizarId(int|string $id): int
{
    return (int) $id;
}

function buscarPorId(array $equipos, int|string $id): ?array
{
    // TODO 10: buscar por id en todos los equipos; id no es índice.
    $equipoEncontrado = array_find($equipos, fn(array $e): bool => $e['id'] === normalizarId($id));
    return $equipoEncontrado['id'] === normalizarId($id) ? $equipoEncontrado : null;
}

function responsableVisible(?string $responsable): string
{
    // TODO 11: resolver el caso de responsable null.

    return (!is_string($responsable)) ? 'Responsable pendiente' : $responsable;
}

function inicioNombre(string $nombre): string
{
    return mb_substr(limpiarEspacios($nombre), 0, 3, 'UTF-8');
}

function codigoValido(string $codigo): bool
{
    return preg_match('/^AV-\d{4}-\d{4}$/', $codigo) === 1;
}
