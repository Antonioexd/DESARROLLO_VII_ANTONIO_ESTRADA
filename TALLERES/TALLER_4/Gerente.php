<?php

require_once 'Empleado.php';
require_once 'Evaluable.php';

class Gerente extends Empleado implements Evaluable {
    private $departamento;
    private $bono;

    public function __construct($nombre, $idEmpleado, $salarioBase, $departamento) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->departamento = $departamento;
        $this->bono = 0;
    }

    // Getters y Setters del departamento y bono
    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function asignarBono($bono) {
        $this->bono = $bono;
    }

    public function getSalarioTotal() {
        return $this->salarioBase + $this->bono;
    }

    public function evaluarDesempenio() {
        // Lógica personalizada para evaluar el desempeño de un gerente
        return "El gerente " . $this->getNombre() . " ha sido evaluado con éxito. Bono asignado: $" . $this->bono;
    }
}
