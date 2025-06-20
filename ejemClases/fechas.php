<?php

$fecha = new DateTime("now",new DateTimeZone('Europe/Madrid'));



$fechaEspecifica = new DateTime('2025-06-13 18:07:00');

echo $fecha->format("d/m/Y H:i:s");

$fecha->setTimezone(new DateTimeZone('America/Los_Angeles'));

echo "\n" . $fecha->format("d/m/Y H:i:s");

echo "\n" . $fechaEspecifica->format("d/m/Y H:i:s");

$fecha->setTimezone(new DateTimeZone('Europe/Moscow'));

echo "\n" . $fecha->format('Y-m-d H:i:s');

$fecha1=new DateTime('2025-06-20');

$fecha2=new DateTime('1970-01-01');

$intervalo = $fecha1->diff($fecha2);

echo "\n" . $intervalo->y.' años';

?>