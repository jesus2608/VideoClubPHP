<?php
namespace DWES\ProyectoVideoclub;

use ClienteNoEncontradoException;
use SoporteNoEncontrado;

include "autoload.php";

class VideoClub{
    public function __construct(
        private string $nombre,
        private array $productos=[],
        private int $numProductos=0,
        private array $socios=[],
        private int $numSocios=0,
        private int $numProductosAlquilados=0,
        private int $numTotalAlquileres=0
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
  
 public function getNumProductosAlquilados(): int {
    return $this->numProductosAlquilados;
}

public function getNumTotalAlquileres(): int {
    return $this->numTotalAlquileres;
}

public function alquilarSocioProducto(int $numeroCliente, int $numeroSoporte) {
    $encontrado = false;
    $encontrado1 = false;
    $soporte = null;

    // Buscar el producto por su número
    for ($i = 0; $i < count($this->productos); $i++) {
        if ($this->productos[$i]->getNumero() == $numeroSoporte) {
            $soporte = $this->productos[$i];
            $encontrado = true;
            break;
        }
    }

    // Buscar el socio por su número
    for ($i = 0; $i < count($this->socios); $i++) {
        if ($this->socios[$i]->getNumero() == $numeroCliente) {
            if ($encontrado) {
                $this->socios[$i]->alquilar($soporte);
                $this->numProductosAlquilados++;
                $this->numTotalAlquileres++;
            }
            $encontrado1 = true;
            break;
        }
    }

    // Manejo de excepciones si no se encuentra el soporte o el cliente
    try {
        if (!$encontrado) throw new SoporteNoEncontrado("El soporte no se encontró.");
        if (!$encontrado1) throw new ClienteNoEncontradoException("El cliente no se encontró.");
    } catch (SoporteNoEncontrado $e) {
        $e->error();
    } catch (ClienteNoEncontradoException $e) {
        $e->error();
    }

    return $this;
}

public function alquilarSocioProductos(int $numSocio, array $numerosProductos) {
    $alquilado = false;

    // Verificar si alguno de los productos ya está alquilado
    for ($i = 0; $i < count($numerosProductos); $i++) {
        if ($numerosProductos[$i]->alquilado) {
            $alquilado = true;
            break;
        }
    }

    // Si ninguno está alquilado, proceder a alquilar todos
    if (!$alquilado) {
        for ($i = 0; $i < count($numerosProductos); $i++) {
            $this->alquilarSocioProducto($numSocio, $numerosProductos[$i]->getNumero());
            $this->numTotalAlquileres--;
        }
        $this->numTotalAlquileres++;
    } else {
        echo "Alguna de esas películas ya están alquiladas. Por favor, selecciona otra.";
    }
}

public function devolverSocioProducto(int $numSocio, int $numeroProducto) {
    $soporte = null;

    // Buscar el producto por su número
    for ($i = 0; $i < count($this->productos); $i++) {
        if ($this->productos[$i]->getNumero() == $numeroProducto) {
            $soporte = $this->productos[$i];
            break;
        }
    }

    // Verificar si el producto estaba alquilado
    if ($soporte && $soporte->alquilado) {
        echo "Gracias por devolver este soporte.";
        $soporte->alquilado = false;
        $this->numTotalAlquileres--;
        $this->numProductosAlquilados--;
    }
}

public function devolverSocioProductos(int $numSocio, array $numerosProductos) {
    $alquilado = false;

    // Verificar si alguno de los productos no está alquilado
    for ($i = 0; $i < count($numerosProductos); $i++) {
        if (!$numerosProductos[$i]->alquilado) {
            $alquilado = true;
            break;
        }
    }

    // Si todos estaban alquilados proceder a devolverlos
    if (!$alquilado) {
        for ($i = 0; $i < count($numerosProductos); $i++) {
            $this->devolverSocioProducto($numSocio, $numerosProductos[$i]->getNumero());
            $this->numTotalAlquileres++;
        }
        $this->numTotalAlquileres--;
    } else {
        echo "Alguna de esas películas no están alquiladas. Ha ocurrido un error.";
    }
}
}

?>