<?php

class CupoSuperadoException extends Exception{
    public function __construct($msj, $codigo = 0, Exception $previa = null) {
       
        parent::__construct($msj, $codigo, $previa);
    }
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    public function error(){
        echo "<br>Has superado el cupo maximo de soportes devuelve algo";
    }
}

?>