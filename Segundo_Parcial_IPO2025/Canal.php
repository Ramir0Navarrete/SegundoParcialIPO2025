<?php
class Canal {
    private $tipo;          
    private $importe;
    private $esHD;         

    public function __construct($tipo, $importe, $esHD) {
        $this->tipo = $tipo;
        $this->importe = $importe;
        $this->esHD = $esHD;
    }

    // Getters y Setters
    public function getTipo() {
        return $this->tipo;
    }
    public function getImporte() {
        return $this->importe;
    }
    public function getEsHD() {
        return $this->esHD;
    }
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
    public function setImporte($importe) {
        $this->importe = $importe;
    }
    public function setEsHD($esHD) {
        $this->esHD = $esHD;
    }
}
?>