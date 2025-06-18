<?php

abstract class Vehiculo{

    protected $modelo;

    protected $num_ruedas;

    protected $velocidadMax;

    protected $parado;

    protected $velocidad;


    public function __construct(string $modelo, bool $parado, float $velocidad)
    {
        $this->modelo = $modelo;

        $this->parado = true;

        $this->velocidad = $velocidad;
    }


    abstract public function acelerar();

 
}





?>