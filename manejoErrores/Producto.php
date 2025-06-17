<?php
class Producto {
    public $nombre;
    private $precio;
    protected $stock;
    public static $totalProductos = 0;

    public function __construct($nombre, $precio, $stock) {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock = $stock;
        self::$totalProductos++;
    }

    public function disminuirStock($cantidad) {
        if ($cantidad > $this->stock) {
            return false;
        }
        $this->stock -= $cantidad;
        return true;
    }
}
