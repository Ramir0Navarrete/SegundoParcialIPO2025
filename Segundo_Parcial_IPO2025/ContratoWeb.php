<?php 
class ContratoWeb extends Contrato {
    private $porcentajeDescuento;

    /**
     * Constructor
     */
    public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $objCliente, $porcentajeDescuento = 10) {
        parent::__construct($fechaInicio, $fechaVencimiento, $objPlan, $objCliente);
        $this->porcentajeDescuento = $porcentajeDescuento;
    }

    public function calcularImporte() {
        $importeBase = parent::calcularImporte();
        $descuento = $this->getPorcentajeDescuento();
        $importeFinal = $importeBase - ($importeBase * ($descuento/100));
        $this->setCosto($importeFinal);
        return $importeFinal;
    }
}
/**
     * Busca un contrato por tipo y número de documento del cliente
     * @param string $tipoDoc
     * @param string $numeroDoc
     * @return Contrato|null
     */

    public function buscarContrato($tipoDoc, $numeroDoc) {
       
        $colContratos = $this->getColContratos();
        $contratoEncontrado = null;
        $i = 0;
       
       
        while($i < count($colContratos) && $contratoEncontrado == null) {
            $contratoActual = $colContratos[$i];
            $objCliente = $contratoActual->getObjCliente();
           
           
            if($objCliente->getTipoDoc() == $tipoDoc &&
               $objCliente->getNumeroDoc() == $numeroDoc) {
                $contratoEncontrado = $contratoActual;
            }
            $i++;
        }
       
        return $contratoEncontrado;
    }


  
    /**
     * Método toString 
     */
    public function __toString() {
        $infoContrato = parent::__toString();
        return $infoContrato . "\nPorcentaje de descuento: " . $this->porcentajeDescuento . "%";
    }

