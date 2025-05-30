<?php
class Plan {
    private $codigo;
    private $colCanales;
    private $importe;
    private $incluyeMG;    // Por defecto 100 MG

    public function __construct($codigo, $colCanales, $importe, $incluyeMG = true) {
        $this->codigo = $codigo;
        $this->colCanales = $colCanales;
        $this->importe = $importe;
        $this->incluyeMG = $incluyeMG;
    }

    // Getters y Setters
    public function getCodigo() {
        return $this->codigo;
    }
    public function getCanales() {
        return $this->colCanales;
    }
    public function getImporte() {
        return $this->importe;
    }
    public function getIncluyeMG() {
        return $this->incluyeMG;
    }
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
    public function setCanales($colCanales) {
        $this->colCanales = $colCanales;
    }
    public function setImporte($importe) {
        $this->importe = $importe;
    }
    public function setIncluyeMG($incluyeMG) {
        $this->incluyeMG = $incluyeMG;
    }
}
?>