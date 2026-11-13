<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/src/archivos.php';

$errores = [];
$mensaje = null;
$guardado = null;
$anterior = null;
$esSustitucion = array_key_exists('anterior', $_GET);

if ($esSustitucion) {
    $anterior = resolverCartel($_GET['anterior'] ?? null);
    if (empty($anterior)) {
        http_response_code(404);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (postExcesivo()) {
        $errores['general'] = 'El envío completo supera el límite de PHP.';
    } else {
        $subida = inspeccionarImagen($_FILES, !$esSustitucion);

        if (!empty($subida['error'])) {
            $errores['imagen'] = $subida['error'];
        } elseif (empty($subida['archivo']) && $esSustitucion) {
            $mensaje = 'No se ha cambiado el cartel.';
            $guardado = $anterior['nombre'];
        } elseif (!empty($subida['archivo'])) {
            try {
                $archivo = $subida['archivo'];
                $destino = prepararDestino(
                    $archivo['extension'],
                    $esSustitucion ? $anterior['nombre'] : null
                );

                if (!move_uploaded_file($archivo['tmp_name'], $destino['ruta'])) {
                    $errores['imagen'] = 'No se ha podido guardar la imagen.';
                } elseif ($esSustitucion) {
                    if (retirarArchivo($anterior['nombre'])) {
                        $mensaje = 'El cartel se ha sustituido correctamente.';
                        $guardado = $destino['nombre'];
                        $anterior = resolverCartel($destino['nombre']);
                    } else {
                        if (!retirarArchivo($destino['nombre'])) {
                            error_log('No se pudo retirar el cartel nuevo tras fallar la sustitución: ' . $destino['nombre']);
                        }
                        $errores['general'] = 'No se ha podido completar la sustitución. Se conserva el cartel anterior.';
                    }
                } else {
                    $mensaje = 'El cartel se ha guardado correctamente.';
                    $guardado = $destino['nombre'];
                }
            } catch (RuntimeException $error) {
                $errores['imagen'] = $error->getMessage();
            }
        }
    }
}

require dirname(__DIR__) . '/vistas/subir.php';
