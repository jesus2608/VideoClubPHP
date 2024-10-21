<?php
namespace DWES\ProyectoVideoclub;
include "autoload.php";

class CintaVideo extends Soporte{
    public function __construct(
        string $titulo,
        int $numero,
        float $precio,
        private int $duracion
    )
    {
        parent::__construct($titulo,$numero,$precio);
    }
    public function muestraResumen():string
    {
    $palabra= "<br> Pelicula en VHS"; 
    $palabra.=parent::muestraResumen();
    $palabra.="<br> Duracion : ".$this->duracion." minutos";
    return $palabra;
    }

}


?>