Este es un sistema de gestion de estudiantes,sus materias y calificaciones, y realizar operaciones como reportes, busquedas y graduacion

Funcionalidades:

1.Agregar estudiantes: Crea estudiantes con `id`, `nombre`, `edad`, `carrera` y añade materias con sus calificaciones.
   $estudiante = new Estudiante(1, "Ana Pérez", 21, "Ingeniería");
   $estudiante->agregarMateria("Matemáticas", 85);
   $sistema->agregarEstudiante($estudiante);
   ```

2.Listar estudiantes: Lista todos los estudiantes del sistema.

   $sistema->listarEstudiantes();
   

3. Buscar estudiantes: Busca estudiantes por nombre o carrera (insensible a mayúsculas/minúsculas).
   $sistema->buscarEstudiantes("Juan");
   

4. Promedio general: Calcula el promedio general de todos los estudiantes.
   
   $sistema->calcularPromedioGeneral();
   

5. Mejor estudiante: Obtiene el estudiante con el mejor promedio.
   
   $sistema->obtenerMejorEstudiante();
   

6. Reporte de rendimiento: Genera un informe de rendimiento por materia (promedio, calificación más alta/baja).
   
   $sistema->generarReporteRendimiento();


7. Graduar estudiante: Gradúa a un estudiante, eliminándolo del sistema.
   
   $sistema->graduarEstudiante(1);
   

8. Ranking: Genera un ranking de estudiantes basado en sus promedios.
   
   $sistema->generarRanking();
   

9. Estadísticas por carrera: Muestra estadísticas de cada carrera, incluyendo el promedio general y mejor estudiante.
   
   $sistema->generarEstadisticasPorCarrera();
   
