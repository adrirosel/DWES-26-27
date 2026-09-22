<?php
$libro = 24.90;
const PORCENTAJE_DESCUENTO = 0.15;
const IVA = 0.04;

$precioDescontado = $libro * PORCENTAJE_DESCUENTO;
$libro -= $precioDescontado; 
$descuentoIva = $libro * IVA;
$libro -= $descuentoIva;

