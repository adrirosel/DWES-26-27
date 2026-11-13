<?php

declare(strict_types=1);

const MIME_CARTELES = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
];

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function directorioCarteles(): string
{
    return dirname(__DIR__) . '/storage/carteles';
}

function patronNombre(): string
{
    return '/\A[a-f0-9]{32}\.(jpg|png|webp)\z/';
}

function nombreValido(mixed $nombre): bool
{
    return is_string($nombre) && preg_match(patronNombre(), $nombre) === 1;
}

function postExcesivo(): bool
{
    return (float) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 8 * 1024 * 1024;
}

function recibirImagen(array $archivos, bool $obligatoria): array
{
    if (!array_key_exists('imagen', $archivos)) {
        return [
            'archivo' => null,
            'error' => $obligatoria ? 'Selecciona una imagen.' : null,
        ];
    }

    $a = $archivos['imagen'];
    if (!is_array($a)
        || !isset($a['error'], $a['size'], $a['tmp_name'])
        || !is_int($a['error'])
        || !is_int($a['size'])
        || !is_string($a['tmp_name'])) {
        return ['archivo' => null, 'error' => 'La entrada de la imagen no es válida.'];
    }

    if ($a['error'] === UPLOAD_ERR_NO_FILE) {
        return [
            'archivo' => null,
            'error' => $obligatoria ? 'Selecciona una imagen.' : null,
        ];
    }

    if ($a['error'] !== UPLOAD_ERR_OK) {
        $mensaje = match ($a['error']) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'La imagen supera el límite de recepción.',
            UPLOAD_ERR_PARTIAL => 'La imagen ha llegado incompleta.',
            UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE => 'No se ha podido recibir la imagen.',
            UPLOAD_ERR_EXTENSION => 'Una extensión de PHP ha detenido la subida.',
            default => 'Error de recepción de la imagen.',
        };
        return ['archivo' => null, 'error' => $mensaje];
    }

    return ['archivo' => $a, 'error' => null];
}

function inspeccionarImagen(array $archivos, bool $obligatoria): array
{
    $r = recibirImagen($archivos, $obligatoria);
    if (!empty($r['error']) || empty($r['archivo'])) {
        return $r;
    }

    $a = $r['archivo'];
    $maxSize = 2 * 1024 * 1024;
    if ($a['size'] < 1 || $a['size'] > $maxSize) {
        return ['archivo' => null, 'error' => 'El tamaño del archivo no es correcto. Entre 1 byte y 2 MiB.'];
    }
    if (!is_file($a['tmp_name']) || !is_readable($a['tmp_name'])) {
        return ['archivo' => null, 'error' => 'El archivo no se ha cargado bien / no es legible.'];
    }

    $detector = new finfo(FILEINFO_MIME_TYPE);
    $mime = $detector->file($a['tmp_name']);
    if (empty($mime) || !array_key_exists($mime, MIME_CARTELES)) {
        return ['archivo' => null, 'error' => 'El tipo de archivo / extensión no es válido.'];
    }

    $a['extension'] = MIME_CARTELES[$mime];
    return ['archivo' => $a, 'error' => null];
}

function prepararDestino(string $extension, ?string $evitar = null): array
{
    if (!in_array($extension, array_values(MIME_CARTELES), true)) {
        throw new RuntimeException('La extensión de la imagen no es válida.');
    }

    $directorio = directorioCarteles();
    if (!is_dir($directorio) || !is_writable($directorio)) {
        throw new RuntimeException('El almacenamiento de carteles no está disponible.');
    }

    for ($intento = 0; $intento < 5; $intento++) {
        try {
            $nombre = bin2hex(random_bytes(16)) . '.' . $extension;
        } catch (Throwable $error) {
            throw new RuntimeException('No se ha podido preparar el nombre del archivo.', 0, $error);
        }

        if (!empty($evitar) && $nombre === $evitar) {
            continue;
        }

        $ruta = $directorio . '/' . $nombre;
        if (file_exists($ruta) || is_link($ruta)) {
            continue;
        }

        return ['nombre' => $nombre, 'ruta' => $ruta];
    }

    throw new RuntimeException('El nombre ya está ocupado. Vuelve a enviar.');
}

function resolverCartel(mixed $nombre): ?array
{
    if (!nombreValido($nombre)) {
        return null;
    }

    $ruta = directorioCarteles() . '/' . $nombre;
    if (!is_file($ruta) || is_link($ruta) || !is_readable($ruta)) {
        return null;
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($ruta);
    if (empty($mime)
        || !isset(MIME_CARTELES[$mime])
        || pathinfo($nombre, PATHINFO_EXTENSION) !== MIME_CARTELES[$mime]) {
        return null;
    }

    return ['nombre' => $nombre, 'ruta' => $ruta, 'mime' => $mime];
}

function listarCarteles(): array
{
    $directorio = directorioCarteles();
    $rutas = glob($directorio . '/*');
    if (empty($rutas)) {
        return [];
    }

    $nombres = [];
    foreach ($rutas as $ruta) {
        $nombre = basename($ruta);
        if (!empty(resolverCartel($nombre))) {
            $nombres[] = $nombre;
        }
    }

    sort($nombres);
    return $nombres;
}

function retirarArchivo(string $nombre): bool
{
    if (!nombreValido($nombre)) {
        return false;
    }

    $ruta = directorioCarteles() . '/' . $nombre;
    if (!is_file($ruta) || is_link($ruta)) {
        return false;
    }

    return unlink($ruta);
}
