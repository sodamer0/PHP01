<?php

class Animal{

    protected $nombre;

    protected $edad;

    public function __construct($nombre, $edad)
    {
        
        $this->nombre = $nombre;
        $this->edad = $edad;
    }


    public function describir(){

        return "Nombre del animal: {$this->nombre} | Edad: {$this->edad} años";

    }


    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of edad
     */ 
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set the value of edad
     *
     * @return  self
     */ 
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }
}

$animal1 = new Animal("Copito","5");


?>