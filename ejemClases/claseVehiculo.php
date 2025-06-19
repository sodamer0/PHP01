<?php

abstract class Vehiculo{

    protected $modelo;

    protected $num_ruedas;

    protected $velocidadMax;

    protected $parado;

    protected $velocidad;


    public function __construct(string $modelo, float $velocidad=0)
    {
        $this->modelo = $modelo;

        $this->velocidad = $velocidad;

        $this->parado = $this->saberSiParado($velocidad);


    }


    private function saberSiParado(float $velocidad): bool
    {
        return $velocidad === 0.0;
    }

    abstract public function acelerar();

 
}





?>