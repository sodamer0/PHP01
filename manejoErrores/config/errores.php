<?php
// Habilitar reporte de errores para pruebas
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'C:\xampp\php\logs\php_error.log');

// Generar un warning intencionalmente (solo para prueba)
//trigger_error("Esto es un error de prueba", E_USER_WARNING);

// Manejador global de excepciones no capturadas
function manejarExcepcion($ex) {
    error_log("Excepción no capturada: " . $ex->getMessage() . " en " . $ex->getFile() . ":" . $ex->getLine());
    echo "<p class='error'>Error inesperado: Por favor, contacta al administrador.</p>";
}
set_exception_handler('manejarExcepcion');

// Manejador de errores para warnings
set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) {
        echo "<p class='warning'>Advertencia: $message en $file, línea $line</p>";
    }
});