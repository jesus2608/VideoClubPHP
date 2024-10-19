<?php
include_once "Dvd.php";
include_once "Juego.php";
include_once "Cliente.php";
include_once "CintaVideo.php";
include_once "Soporte.php";


class VideoClub{
    public function __construct(
        private string $nombre,
        private array $productos=[],
        private int $numProductos=0,
        private array $socios=[],
        private int $numSocios=0
    )
    {}

    private function incluirProducto(Soporte $producto):void{
    array_push($this->productos,$producto);
    echo "Incluido soporte ".$this->numProductos."<br>";
    }

    public function incluirCintaVideo(string $titulo, float $precio, int $minutos){
        $cinta= new CintaVideo($titulo, $this->numProductos++,$precio, $minutos);
        $this->incluirProducto($cinta);
    }

    public function incluirDvd(string $titulo, float $precio, string $idiomas, string $pantalla){
        $dvd = new Dvd($titulo, $this->numProductos++, $precio, $idiomas, $pantalla);
        $this->incluirProducto($dvd);
    }

    public function incluirJuego(string $titulo, float $precio, string $consola, int $minJ, int $maxJ){
        $juego = new Juego($titulo, $this->numProductos++, $precio, $consola, $minJ, $maxJ);
        $this-> incluirProducto($juego);
        
    }

    public function incluirSocio(string $nombre, int $maxAlquileresConcurrentes= 3 ){
        $socio = new Cliente($nombre, $this->numSocios++, $maxAlquileresConcurrentes);
        array_push($this->socios, $socio);
        echo "<br>Incluido socio ".$this->numSocios;
    }

    public function listarProductos(){
        echo "Listado para los ".$this->numProductos." productos disponibles";
       for ($i=0; $i <count($this->productos) ; $i++) { 
        echo $this->productos[$i]->muestraResumen();
       } 
    }
    public function listarSocios(){
        echo "<br>Listado de los ".$this->numSocios." socios del videoclub"."<br>";
        for ($i=0; $i <count($this->socios) ; $i++) { 
         echo "<b> Cliente ". $i." </b>".$this->socios[$i]->muestraResumen()."<br>";
        } 
    }
    public function alquilarSocioProducto(int $numeroCliente, int $numeroSoporte){
        for ($i=0; $i < count($this->productos); $i++) { 
            if($this->productos[$i]->getNumero()==$numeroSoporte){
            $soporte=$this->productos[$i];
            }
        }
        for ($i=0; $i <count($this->socios) ; $i++) { 
            if($this->socios[$i]->getNumero()==$numeroCliente){
                $this->socios[$i]->alquilar($soporte);
            }
        }
      
    }

}


?>