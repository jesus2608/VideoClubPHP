<?php
namespace DWES\ProyectoVideoclub;
include "autoload.php";

class Juego extends Soporte{
    public function __construct(
        string $titulo,
        int $numero,
        float $precio,
        public string $consola,
        private int $minNumJugadores,
        private int $maxNumJugadores

    )
    {
      parent::__construct($titulo,$numero,$precio);  
    }

    public function muestraJugadoresPosibles():string{
        if($this->maxNumJugadores>1)
        return "En este juego pueden jugar un minimo de ".$this->minNumJugadores." jugadores y un maximo de ".$this->maxNumJugadores;
        else return "Para un jugador";
    }
    public function muestraResumen(): string
    {
        $palabra= "<br>Juego para ".$this->consola."";
        $palabra.= parent::muestraResumen();
        $palabra.= "<br>".$this->muestraJugadoresPosibles();
        return $palabra;

    }
}

?>