<?php

class Matematica{

    const PI=3.1416;


    public function getPi(){

        return self::PI;

    }
}


echo "\n" . Matematica::PI ."\n";

$math = new Matematica();

echo "\n" . $math->getPi() . "\n";


?>