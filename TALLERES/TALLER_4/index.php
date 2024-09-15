<?php

require_once 'Gerente.php';
require_once 'Desarrollador.php';
require_once 'Empresa.php';

// Creación de la empresa
$empresa = new Empresa();

// Creación de empleados
$gerente = new Gerente("Alice", 1, 5000, "Tecnología");
$gerente->asignarBono(1000);

$desarrollador = new Desarrollador("Bob", 2, 4000, "PHP", "Senior");

// Agregar empleados a la empresa
$empresa->agregarEmpleado($gerente);
$empresa->agregarEmpleado($desarrollador);

// Listar empleados
echo "<h2>Lista de empleados:</h2>";
$empresa->listarEmpleados();

// Calcular nómina total
echo "<h2>Nómina total:</h2>";
echo "Nómina total: $" . $empresa->calcularNominaTotal() . "<br>";

// Evaluar desempeño de empleados
echo "<h2>Evaluación de desempeño:</h2>";
$empresa->evaluarEmpleados();
