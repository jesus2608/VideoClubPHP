<?php
class Cliente{
public function __construct(
    public string $nombre,
    private int $numero,
    private int $maxAlquilerConcurrente=3,
    private array $soportesAlquilados=[],
    private int $numSoportesAlquilados=0,
    
)
{}

public function getNumero():int{
    return $this->numero;
}
public function setNumero(int $numero){
    $this->numero=$numero;
}
public function getNumSoportesAlquilados():int{
    return $this->numSoportesAlquilados;
}
public function muestraResumen(){
    return $this->nombre." Numero de soportes alquilados ". count($this->soportesAlquilados);
}
public function tieneAlquilado(Soporte $s):bool{
    for ($i=0; $i <$this->numSoportesAlquilados ; $i++) { 
        if($this->soportesAlquilados[$i]->titulo==$s->titulo) return true;
    }
    return false;
}
public function alquilar(Soporte $s):bool{
    if($this->tieneAlquilado($s)){
        echo "<br>El cliente ya tiene alquilado el soporte ".$s->titulo."<br>";
        return false;
    }elseif($this->getNumSoportesAlquilados()>=$this->maxAlquilerConcurrente){
        echo "<br>Este cliente tiene ".$this->maxAlquilerConcurrente." elementos alquilados. No puede alquilar mas en este videoclub hasta que no devuelvas algo <br>";
        return false;
    }else{
        $this->numSoportesAlquilados++;
        array_push($this->soportesAlquilados,$s);
        echo "<br>Alquilado soporte a ".$this->nombre."<br>".$s->muestraResumen();
        return true;
    }
}
public function devolver(int $numeroSoporte):bool{
    if($this->numSoportesAlquilados==0){
    echo "<br>Este cliente no tiene soportes alquilados";
    return true;
    }else{
    for ($i=0; $i <$this->numSoportesAlquilados ; $i++) { 
        if($this->soportesAlquilados[$i]->getNumero()==$numeroSoporte){
            $this->numSoportesAlquilados--;
            echo "Soporte devuelto<br>";
            array_splice($this->soportesAlquilados, $i, 1);
            return true;
        
    }
  
}
echo "<br>No se ha podido encontrar el soporte en los alquileres de este cliente";
return false;
    }
}

public function listaAlquileres():void{
    if($this->numSoportesAlquilados==0)
    echo "Este cliente no tiene soportes alquilados";
    else{
        echo "El cliente tiene ".$this->numSoportesAlquilados." soportes alquilados";
        for ($i=0; $i <$this->numSoportesAlquilados ; $i++) { 
            echo $this->soportesAlquilados[$i]->muestraResumen();
        }
    }
}


}

?>