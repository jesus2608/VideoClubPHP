<?php
namespace DWES\ProyectoVideoclub;

include "autoload.php";

class Dvd extends Soporte{
    public function __construct(
        string $titulo,
        int $numero,
        float $precio,
        public string $idiomas,
        private string $formaPantalla
    )
    {
     parent::__construct($titulo,$numero,$precio);   
    }

    public function muestraResumen(): string
    {
        $palabra=parent::muestraResumen();
        $palabra.= "<br> Idiomas: ".$this->idiomas."<br> Formato Pantalla:".$this->formaPantalla;
        return $palabra;
    }
}

?>