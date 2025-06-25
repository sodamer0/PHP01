<?php

class PrecioInvalidoException extends Exception{} //Excepción personalizada para precios inválidos

class StockInsuficienteException extends Exception{} //Excepción personalizada para stock insuficiente

class Producto {
    public $id;
    public $nombre;
    private $precio;
    protected $stock;


    public function __construct($id, $nombre, $precio, $stock = 0) {

        if (!is_string($nombre) || empty($nombre)) { //Validación do 'nombre' ten que ser un string ou non baleiro.
            throw new InvalidArgumentException("El nombre debe ser un texto no vacío");
        }
        if (!is_numeric($precio) || $precio < 0) { //Validación do 'precio' ten que ser un número non negativo.
            throw new PrecioInvalidoException("El precio debe ser un número no negativo");
        }
        if (!is_int($stock) || $stock < 0) { //Validación do 'stock' ten que ser un número enteiro non negativo.
            throw new StockInsuficienteException("El stock debe ser un entero no negativo");
        }

        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }


    public function toArray() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'stock' => $this->stock
        ];
    }

}


