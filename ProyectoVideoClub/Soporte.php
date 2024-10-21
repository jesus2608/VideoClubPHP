<?php
namespace DWES\ProyectoVideoclub;

include "autoload.php";
abstract class Soporte implements Resumible{
    const iva = 0.21;

    public function __construct(
        public string $titulo,
        protected int $numero,
        private float $precio,
        public bool $alquilado=false
    )
    {
    }
    public function getPrecio(){ return $this->precio;}
    public function getPrecioConIva(){ return ($this->precio)+($this->precio*self::iva);}
    public function getNumero(){ return $this->numero;}
    public function muestraResumen():string {
        $palabra = "<br>".$this->titulo."<br>".$this->precio." € (IVA no incluido)";

        return $palabra;
    }


}

?>