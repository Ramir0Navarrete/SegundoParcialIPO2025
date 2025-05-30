<?php 
class Cliente {
    private $tipoDoc;
    private $numeroDoc;
    private $nombre;
    private $apellido;
    private $direccion;

    public function __construct($tipoDoc, $numeroDoc, $nombre, $apellido, $direccion) {
        $this->tipoDoc = $tipoDoc;
        $this->numeroDoc = $numeroDoc;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->direccion = $direccion;
    }

    // Getters y Setters
    public function getTipoDoc() {
        return $this->tipoDoc;
    }
    public function getNumeroDoc() {
        return $this->numeroDoc;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getApellido() {
        return $this->apellido;
    }
    public function getDireccion() {
        return $this->direccion;
    }
    public function setTipoDoc($tipoDoc) {
        $this->tipoDoc = $tipoDoc;
    }
    public function setNumeroDoc($numeroDoc) {
        $this->numeroDoc = $numeroDoc;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
}
?>