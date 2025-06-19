<?php

require __DIR__ . '/vendor/autoload.php';

use App\Utilidades\Iva;

$base = 100;
$iva = Iva::calcular($base);

echo "\nEl IVA de $base € es $iva €\n";