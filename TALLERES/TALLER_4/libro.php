<?php 

require_once 'Prestable.php';

class Libro implements Prestable {
    
    private $titulo;
    private $autor;
    private $anioPublicacion;
    private $disponible = true;

    // Constructor para inicializar los atributos del libro
    public function __construct($titulo, $autor, $anioPublicacion) {
        $this->setTitulo($titulo);
        $this->setAutor($autor);
        $this->setAnioPublicacion($anio);
    }

    // Métodos getter y setter para título
    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = trim($titulo); // Eliminamos espacios innecesarios
    }

    // Métodos getter y setter para autor
    public function getAutor() {
        return $this->autor;
    }

    public function setAutor($autor) {
        $this->autor = trim($autor); // Eliminamos espacios innecesarios
    }

    // Métodos getter y setter para año de publicación
    public function getAnioPublicacion() {
        return $this->anioPublicacion;
    }

    public function setAnioPublicacion($anio) {
        $this->anioPublicacion = intval($anio); // Convertimos a entero
    }

    // Método para obtener información del libro
    public function obtenerInformacion() {
        return "'{$this->getTitulo()}' por {$this->getAutor()}, publicado en {$this->getAnioPublicacion()}";
    }

    // Método para prestar el libro
    public function prestar() {
        if ($this->disponible) {
            $this->disponible = false;
            return true;
        }
        return false;
    }

    // Método para devolver el libro
    public function devolver() {
        $this->disponible = true;
    }

    // Método para comprobar si el libro está disponible
    public function estaDisponible() {
        return $this->disponible;
    }
}

// Ejemplo de uso

$miLibro = new Libro("El Quijote", "Miguel de Cervantes", 1605);
echo $miLibro->obtenerInformacion() . "\n";
echo "Título: " . $miLibro->getTitulo() . "\n";

// Crear un nuevo objeto Libro y trabajar con su disponibilidad
$libro = new Libro("Rayuela", "Julio Cortázar", 1963);
echo $libro->obtenerInformacion() . "\n";
echo "Disponible: " . ($libro->estaDisponible() ? "Sí" : "No") . "\n";
$libro->prestar();
echo "Disponible después de prestar: " . ($libro->estaDisponible() ? "Sí" : "No") . "\n";
$libro->devolver();
echo "Disponible después de devolver: " . ($libro->estaDisponible() ? "Sí" : "No") . "\n";

?>