<?php

date_default_timezone_set('Europe/Madrid');

$hoy = new DateTimeImmutable();

$devolucion = $hoy->modify('+15 days');

echo 'Fecha actual: ' . $hoy->format('d/m/Y H:i') . '<br>';
echo 'Fecha devolucion: ' . $devolucion->format('d/m/Y H:i');