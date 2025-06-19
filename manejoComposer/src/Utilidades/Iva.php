<?php
namespace App\Utilidades;

class Iva {
    public static function calcular($base, $porcentaje = 21) {
        return $base * $porcentaje / 100;
    }
}