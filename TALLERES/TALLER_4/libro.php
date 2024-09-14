<?php 
class Libro{
    public $titulo;
    public $autor;
    public $anioPublicacion;

    public function __construct ($titulo, $autor, $anioPublicacion){
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->anioPublicacion = $anioPublicacion;
    }

    public function obtenerInformacion(){
        return "'{$this->titulo}' por {$this->autor}, publicado en {$this->anioPublicacion}";
    }
}

$milibro = new Libro ("Cien años de soledad","Gabriel Gracia Marquez", 1967);
echo $milibro->obtenerInformacion();

?>