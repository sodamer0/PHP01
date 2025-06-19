<?php

require 'claseVehiculo.php';

class Moto extends Vehiculo{

    private $cilindrada;

    private $precio;


    public function __construct(string $modelo,float $velocidad, int $cilindrada, float $precio)
    {
        parent::__construct($modelo,$velocidad);

        $this->cilindrada = $cilindrada;

        $this->precio = $precio;
    }


    public function acelerar()
    {
        if (!$this->parado && $this->velocidad > 0) {
            echo "\n" . $this->modelo . " está acelerando con una velocidad de " . $this->velocidad . " Km/h.\n";
        } else {
            echo "\n" . $this->modelo . " no puede acelerar porque está parada.\n";
        }
    }

    /**
     * Get the value of modelo
     */ 
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set the value of modelo
     *
     * @return  self
     */ 
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get the value of parado
     */ 
    public function getParado()
    {
        return $this->parado;
    }

    /**
     * Set the value of parado
     *
     * @return  self
     */ 
    public function setParado($parado)
    {
        $this->parado = $parado;

        return $this;
    }

    /**
     * Get the value of cilindrada
     */ 
    public function getCilindrada()
    {
        return $this->cilindrada;
    }

    /**
     * Set the value of cilindrada
     *
     * @return  self
     */ 
    public function setCilindrada($cilindrada)
    {
        $this->cilindrada = $cilindrada;

        return $this;
    }

    /**
     * Get the value of precio
     */ 
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */ 
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    public function obtenerDatos(){


    return "\nModelo: ". $this->modelo . "\n¿Está parada?: ".($this->parado ? 'Sí' : 'No') . "\nTiene una velocidad de: ". $this->velocidad ."Km/h.\n"."Tiene una cilindrada de: ". $this->getCilindrada()."Cc.\n". "Tiene un precio de: ". number_format($this->getPrecio(), 2 ,',','.')."€\n";
    }
}

$moto1 = new Moto("Vespa",20.50,500,3150.65);

$moto2 = new Moto("Kawasaki",80.0,550,5550);

$moto3 = new Moto("Hamaha",0,700,12345.80);

echo $moto1->obtenerDatos();

echo $moto2->obtenerDatos();

echo $moto3->obtenerDatos();

?>