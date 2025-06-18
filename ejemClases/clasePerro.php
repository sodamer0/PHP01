<?php

require 'claseAnimal.php';

class Perro extends Animal{
    
    private $raza;

    public function __construct(string $nombre, int $edad, string $raza){

        parent::__construct($nombre,$edad);

        $this->raza = $raza;

    }

    public function describir(){

        return parent::describir() . "| Raza: {$this->raza}.\n";
    }
    

}

$perro1 = new Perro("Bobby","3","labrador");

echo $perro1->describir();


?>