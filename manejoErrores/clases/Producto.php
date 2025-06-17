<?php
// Definir excepciones personalizadas
class PrecioInvalidoException extends Exception {}
class StockInsuficienteException extends Exception {}
class NombreDemasiadoLargoException extends Exception {}

class Producto {
    public $nombre;
    private $precio;
    protected $stock;
    public static $totalProductos = 0;

    public function __construct($nombre, $precio, $stock) {
        // Validaciones
        if (!is_string($nombre) || empty($nombre)) {
            throw new InvalidArgumentException("El nombre debe ser un string no vacío");
        }
        if (strlen($nombre) > 50) {
            throw new NombreDemasiadoLargoException("El nombre no puede exceder 50 caracteres");
        }
        if (!is_numeric($precio) || $precio < 0) {
            throw new PrecioInvalidoException("El precio debe ser un número no negativo");
        }
        if (!is_int($stock) || $stock < 0) {
            throw new InvalidArgumentException("El stock debe ser un entero no negativo");
        }

        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock = $stock;
        self::$totalProductos++;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getStock() {
        return $this->stock;
    }

    public function disminuirStock($cantidad) {
        if (!is_int($cantidad) || $cantidad <= 0) {
            throw new InvalidArgumentException("La cantidad debe ser un entero positivo");
        }
        if ($cantidad > $this->stock) {
            throw new StockInsuficienteException("Stock insuficiente: solo hay {$this->stock} unidades");
        }
        $this->stock -= $cantidad;
    }

    public function calcularDescuento($porcentaje) {
        if ($porcentaje === '' || !is_numeric($porcentaje)) {
            trigger_error("El porcentaje debe ser numérico y no vacío", E_USER_WARNING);
            return 0;
        }
        return $this->precio * ($porcentaje / 100);
    }

    public static function getTotalProductos() {
        return self::$totalProductos;
    }
}