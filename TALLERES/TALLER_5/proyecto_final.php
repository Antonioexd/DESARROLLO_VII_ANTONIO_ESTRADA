<?php

// Clase Estudiante
class Estudiante {
    private int $id;
    private string $nombre;
    private int $edad;
    private string $carrera;
    private array $materias;

    public function __construct(int $id, string $nombre, int $edad, string $carrera) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = [];
    }

    // Método para agregar una materia y su calificación
    public function agregarMateria(string $materia, float $calificacion): void {
        $this->materias[$materia] = $calificacion;
    }

    // Método para obtener el promedio de calificaciones
    public function obtenerPromedio(): float {
        if (count($this->materias) === 0) {
            return 0.0;
        }
        return array_sum($this->materias) / count($this->materias);
    }

    // Método para obtener detalles del estudiante
    public function obtenerDetalles(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => $this->materias,
            'promedio' => $this->obtenerPromedio()
        ];
    }

    // Método __toString para facilitar la impresión de información
    public function __toString(): string {
        return "ID: {$this->id}, Nombre: {$this->nombre}, Carrera: {$this->carrera}, Promedio: {$this->obtenerPromedio()}";
    }
}

// Clase SistemaGestionEstudiantes
class SistemaGestionEstudiantes {
    private array $estudiantes;
    private array $graduados;

    public function __construct() {
        $this->estudiantes = [];
        $this->graduados = [];
    }

    // Método para agregar un estudiante
    public function agregarEstudiante(Estudiante $estudiante): void {
        $this->estudiantes[$estudiante->obtenerDetalles()['id']] = $estudiante;
    }

    // Método para obtener un estudiante por ID
    public function obtenerEstudiante(int $id): ?Estudiante {
        return $this->estudiantes[$id] ?? null;
    }

    // Método para listar todos los estudiantes
    public function listarEstudiantes(): array {
        return array_map(fn($estudiante) => $estudiante->obtenerDetalles(), $this->estudiantes);
    }

    // Método para calcular el promedio general de todos los estudiantes
    public function calcularPromedioGeneral(): float {
        if (count($this->estudiantes) === 0) {
            return 0.0;
        }
        $promedios = array_map(fn($estudiante) => $estudiante->obtenerPromedio(), $this->estudiantes);
        return array_sum($promedios) / count($promedios);
    }

    // Método para obtener estudiantes por carrera
    public function obtenerEstudiantesPorCarrera(string $carrera): array {
        return array_filter($this->estudiantes, fn($estudiante) => $estudiante->obtenerDetalles()['carrera'] === $carrera);
    }

    // Método para obtener el mejor estudiante (con el promedio más alto)
    public function obtenerMejorEstudiante(): ?Estudiante {
        return array_reduce($this->estudiantes, function($mejor, $actual) {
            return $actual->obtenerPromedio() > ($mejor ? $mejor->obtenerPromedio() : 0) ? $actual : $mejor;
        });
    }

    // Método para generar reporte de rendimiento (promedio, calificación más alta y baja por materia)
    public function generarReporteRendimiento(): array {
        $reporte = [];
        foreach ($this->estudiantes as $estudiante) {
            foreach ($estudiante->obtenerDetalles()['materias'] as $materia => $calificacion) {
                if (!isset($reporte[$materia])) {
                    $reporte[$materia] = ['total' => 0, 'count' => 0, 'max' => $calificacion, 'min' => $calificacion];
                }
                $reporte[$materia]['total'] += $calificacion;
                $reporte[$materia]['count']++;
                $reporte[$materia]['max'] = max($reporte[$materia]['max'], $calificacion);
                $reporte[$materia]['min'] = min($reporte[$materia]['min'], $calificacion);
            }
        }
        // Calcular el promedio por materia
        foreach ($reporte as $materia => &$datos) {
            $datos['promedio'] = $datos['total'] / $datos['count'];
        }
        return $reporte;
    }

    // Método para graduar a un estudiante por ID
    public function graduarEstudiante(int $id): bool {
        if (isset($this->estudiantes[$id])) {
            $this->graduados[$id] = $this->estudiantes[$id];
            unset($this->estudiantes[$id]);
            return true;
        }
        return false;
    }

    // Método para generar el ranking de los estudiantes por promedio
    public function generarRanking(): array {
        usort($this->estudiantes, fn($a, $b) => $b->obtenerPromedio() <=> $a->obtenerPromedio());
        return $this->listarEstudiantes();
    }

    // Método para buscar estudiantes por nombre o carrera (insensible a mayúsculas/minúsculas)
    public function buscarEstudiantes(string $termino): array {
        $termino = strtolower($termino);
        return array_filter($this->estudiantes, function($estudiante) use ($termino) {
            $detalles = $estudiante->obtenerDetalles();
            return strpos(strtolower($detalles['nombre']), $termino) !== false ||
                   strpos(strtolower($detalles['carrera']), $termino) !== false;
        });
    }

    // Método para generar estadísticas por carrera
    public function generarEstadisticasPorCarrera(): array {
        $estadisticas = [];
        foreach ($this->estudiantes as $estudiante) {
            $detalles = $estudiante->obtenerDetalles();
            $carrera = $detalles['carrera'];
            if (!isset($estadisticas[$carrera])) {
                $estadisticas[$carrera] = ['num_estudiantes' => 0, 'total_promedio' => 0, 'mejor_promedio' => 0, 'mejor_estudiante' => null];
            }
            $estadisticas[$carrera]['num_estudiantes']++;
            $estadisticas[$carrera]['total_promedio'] += $estudiante->obtenerPromedio();
            if ($estudiante->obtenerPromedio() > $estadisticas[$carrera]['mejor_promedio']) {
                $estadisticas[$carrera]['mejor_promedio'] = $estudiante->obtenerPromedio();
                $estadisticas[$carrera]['mejor_estudiante'] = $estudiante;
            }
        }
        // Calcular el promedio por carrera
        foreach ($estadisticas as $carrera => &$datos) {
            $datos['promedio_carrera'] = $datos['total_promedio'] / $datos['num_estudiantes'];
        }
        return $estadisticas;
    }
}

// Instancia del sistema de gestión de estudiantes
$sistema = new SistemaGestionEstudiantes();

// Creación de estudiantes
$estudiantes = [
    new Estudiante(1, "Ana Pérez", 21, "Ingeniería"),
    new Estudiante(2, "Juan López", 22, "Medicina"),
    new Estudiante(3, "Carlos Martínez", 20, "Derecho"),
    // Crea más estudiantes...
];

// Agregar materias y calificaciones
$estudiantes[0]->agregarMateria("Matemáticas", 85);
$estudiantes[0]->agregarMateria("Física", 90);
$estudiantes[1]->agregarMateria("Biología", 92);
$estudiantes[1]->agregarMateria("Química", 88);
$estudiantes[2]->agregarMateria("Derecho Penal", 77);
$estudiantes[2]->agregarMateria("Derecho Civil", 83);

// Agregar estudiantes al sistema
foreach ($estudiantes as $estudiante) {
    $sistema->agregarEstudiante($estudiante);
}

// Mostrar todos los estudiantes
print_r($sistema->listarEstudiantes());

// Obtener el mejor estudiante
echo "Mejor estudiante: " . $sistema->obtenerMejorEstudiante() . "\n";

// Graduar a un estudiante
$sistema->graduarEstudiante(1);

// Generar reporte de rendimiento
print_r($sistema->generarReporteRendimiento());

// Buscar estudiantes por nombre
print_r($sistema->buscarEstudiantes("Juan"));

// Generar ranking de estudiantes
print_r($sistema->generarRanking());

?>