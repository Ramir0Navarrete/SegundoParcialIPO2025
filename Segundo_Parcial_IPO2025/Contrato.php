<?php 
class Contrato {

private $codigo;      

private $fechaInicio;

private $fechaVencimiento;

private $objPlan;        

private $estado;        

private $costo;

private $seRenueva;       

private $objCliente;     

public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $objCliente) {
        $this->codigo = uniqid(); // Genera un código único para el contrato//
        $this->fechaInicio = $fechaInicio;
        $this->fechaVencimiento = $fechaVencimiento;
        $this->objPlan = $objPlan;
        $this->objCliente = $objCliente;
        $this->estado = "al día";
        $this->seRenueva = true;
        $this->costo = 0;
    }

    // Getters

     public function getCodigo() {
        return $this->codigo;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function getFechaVencimiento() {
        return $this->fechaVencimiento;
    }

    public function getObjPlan() {
        return $this->objPlan;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCosto() {
        return $this->costo;
    }
    public function getSeRenueva() {
        return $this->seRenueva;
    }

    public function getObjCliente() {
        return $this->objCliente;
    }

    // Setters

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    public function setFechaVencimiento($fechaVencimiento) {
        $this->fechaVencimiento = $fechaVencimiento;
    }

    public function setObjPlan($objPlan) {
        $this->objPlan = $objPlan;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
    public function setCosto($costo) {
        $this->costo = $costo;
    }

    public function setSeRenueva($seRenueva) {
        $this->seRenueva = $seRenueva;
    }

    public function setObjCliente($objCliente) {
        $this->objCliente = $objCliente;
    }



    /**
     * Actualiza el estado del contrato según los días de vencimiento
     */
    public function actualizarEstadoContrato() {
       
        $diasVencidos = $this->diasContratoVencido($this);
        
        if ($diasVencidos > 0) {
            if ($diasVencidos > 10) {
                $this->estado = "suspendido";
            } else {
                $this->estado = "moroso";
            }
        } else {
            $this->estado = "al día";
        }
    }


     /**  Calcula el importe final del contrato
     *  @return float
     */
    public function calcularImporte() {
        
        $objPlan = $this->getObjPlan();
        
       
        $importeTotal = $objPlan->getImporte();
        
        
        $coleccionCanales = $objPlan->getCanales();
        
      
        foreach($coleccionCanales as $objCanal) {
            $importeTotal += $objCanal->getImporte();
        }

       
        $this->setCosto($importeTotal);
        
        return $importeTotal;
    }
}
