<?php

declare(strict_types=1);
// Importar librerías
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';
// Poner la zona horaria
date_default_timezone_set('Europe/Madrid');

// 3.1. Leer parámetros
// Para qué está la función normalizarTexto() (Corregido)
$genero = normalizarTexto($_GET['genero']?? 'todos');
$plataforma = normalizarTexto($_GET['plataforma']?? 'todas');
$texto = normalizarTexto($_GET['q'] ?? '');
$orden = normalizarTexto($_GET['orden'] ?? 'titulo');
// 3.2. Normalizar y comprobar que los valores recibidos estén dentro de los esperados

// No se comprueba que $plataforma esté dentro de las definidas y lo mismo con orden. (Corregido)

if(!array_key_exists($plataforma, $plataformas)){
    $plataforma = 'todas';
}
// if(!in_array($orden, ['titulo', 'precio', 'puntuacion'])){
//     $orden = 'titulo';
// }

// 3.3. Filtros
$resultados = $videojuegos;

// Aplica sobre $resultados los filtros, la búsqueda y la ordenación solicitados.

// Perfecto!
if ($genero !== 'todos') {
    $resultados = filtrarPorGenero($resultados, $genero);
}
if ($plataforma !== 'todas') {
    $resultados = filtrarPorPlataforma($resultados, $plataforma);
}
if ($texto !== '') {
    $resultados = buscarPorTexto($resultados, $texto);
}
if ($orden !== null) {
    $resultados = ordenarVideojuegos($resultados, $orden);
}

// 3.5. Ordenar salida
// Ordena las dos colecciones anteriores manteniendo la relación entre claves y valores. (Corregido)

$resultados = ordenarVideojuegos($resultados, $orden);

$ventasOrdenadas = $ventasSemana;
$plataformasOrdenadas = $plataformas;

ksort($plataformasOrdenadas);
asort($ventasOrdenadas);

$timestampConsulta = time();
$fechaConsulta = date('d/m/Y H:i', $timestampConsulta);
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Catálogo de videojuegos</title>
</head>

<body>
    <h1>Catálogo de videojuegos</h1>

    <form method="get">
        <label>
            Género:
            <input type="text" name="genero" value="<?= htmlspecialchars($genero) ?>">
        </label>

        <label>
            Plataforma:
            <select name="plataforma">
                <option value="todas">Todas</option>
                <?php foreach ($plataformas as $codigo => $nombre): ?>
                    <option value="<?= htmlspecialchars($codigo) ?>">
                        <?= htmlspecialchars($nombre) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Buscar:
            <input type="text" name="q" value="<?= $texto ?>">
        </label>

        <label>
            Orden:
            <select name="orden">
                <option value="titulo">Título</option>
                <option value="precio">Precio</option>
                <option value="puntuacion">Puntuación</option>
            </select>
        </label>

        <button type="submit">Aplicar</button>
    </form>

    <p>Resultados: <?= htmlspecialchars((string)count($resultados)) ?></p>

    <ul>
        <?php foreach ($resultados as $videojuego): ?>
            <li>
                <!-- Cuidado con los enlaces -->
                <a href="videojuego.php?id=<?= $videojuego['id'] ?>">
                    <?= htmlspecialchars($videojuego['titulo']) ?>
                </a>
                · <?= htmlspecialchars($videojuego['plataforma']) ?>
                · <?= number_format($videojuego['precio'], 2, ',', '.') ?> €
                · <?= $videojuego['puntuacion'] ?>/10
            </li>
        <?php endforeach; ?>
    </ul>
    <h2>Plataformas por código</h2>
    <ul>
        <?php foreach ($plataformas as $codigo => $nombre): ?>
            <li><?= htmlspecialchars((string) $codigo) ?>: <?= htmlspecialchars((string) $nombre) ?></li>
        <?php endforeach; ?>
    </ul>
    <h2>Ventas de la semana</h2>
    <ul>
        <?php foreach ($ventasSemana as $codigo => $ventas): ?>
            <li><?= htmlspecialchars((string) $codigo) ?>: <?= $ventas ?></li>
        <?php endforeach; ?>

    </ul>

    <p>Consulta generada: <?= htmlspecialchars($fechaConsulta) ?></p>
</body>

</html>