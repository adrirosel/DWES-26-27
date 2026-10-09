<?php
require __DIR__ . '/../src/multa.php';
$dias = (int) ($_GET['dias'] ?? 10);
$tarifa = 0.50;
$total = calcularMulta($dias, $tarifa);
echo 'Multa: '
    . number_format($total, 2, ',', '') . ' €';
