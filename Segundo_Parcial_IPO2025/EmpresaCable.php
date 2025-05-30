<?php 
class EmpresaCable {
   
    private $colPlanes;       
    private $colCanales;      
    private $colClientes;     
    private $colContratos;    
    
    /**
     * Constructor de la clase EmpresaCable
     */
    public function __construct() {
      
        $this->colPlanes = [];
        $this->colCanales = [];
        $this->colClientes = [];
        $this->colContratos = [];
    }

    // Getters y Setters
    public function getColPlanes() {
        return $this->colPlanes;
    }

    public function getColCanales() {
        return $this->colCanales;
    }

    public function getColClientes() {
        return $this->colClientes;
    }

    public function getColContratos() {
        return $this->colContratos;
    }

    public function setColPlanes($colPlanes) {
        $this->colPlanes = $colPlanes;
    }

    public function setColCanales($colCanales) {
        $this->colCanales = $colCanales;
    }

    public function setColClientes($colClientes) {
        $this->colClientes = $colClientes;
    }

    public function setColContratos($colContratos) {
        $this->colContratos = $colContratos;
    }


/** Incorpora un nuevo plan si no existe uno igual
     * @param Plan $objPlan
     * @return boolean
     */
        public function incorporarPlan($objPlan) {
        $colPlanes = $this->getColPlanes();
        $planExiste = false;
        $i = 0;
        

        while($i < count($colPlanes) && !$planExiste) {
            $planActual = $colPlanes[$i];
            
          
            $canalesIguales = $planActual->getCanales() == $objPlan->getCanales();
            $mgIguales = $planActual->getMegasIncluidos() == $objPlan->getMegasIncluidos();
            
            if($canalesIguales && $mgIguales) {
                $planExiste = true;
            }
            $i++;
        }
        
      
        if(!$planExiste) {
            $colPlanes[] = $objPlan;
            $this->setColPlanes($colPlanes);
        }
        
        return !$planExiste;
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
     * Incorpora un nuevo contrato
     * @param Plan $objPlan
     * @param Cliente $objCliente
     * @param string $fechaInicio
     * @param string $fechaVencimiento
     * @param boolean $esWeb
     * @return boolean
     */


    public function incorporarContrato($objPlan, $objCliente, $fechaInicio, $fechaVencimiento, $esWeb) {
        
        $tipoDoc = $objCliente->getTipoDoc();
        $numeroDoc = $objCliente->getNumeroDoc();
        $contratoExistente = $this->buscarContrato($tipoDoc, $numeroDoc);
        
       
        if($contratoExistente !== null && 
           $contratoExistente->getEstado() !== "finalizado") {
            $contratoExistente->setEstado("finalizado");
        }
        
      
        if($esWeb) {
            $nuevoContrato = new ContratoWeb($fechaInicio, $fechaVencimiento, $objPlan, $objCliente);
        } else {
            $nuevoContrato = new Contrato($fechaInicio, $fechaVencimiento, $objPlan, $objCliente);
        }
        
        
        $colContratos = $this->getColContratos();
        $colContratos[] = $nuevoContrato;
        $this->setColContratos($colContratos);
        
        return true;
    }

    /**
     * Calcula el promedio de importes de contratos de un plan específico
     * @param string $codigoPlan
     * @return float
     */
    public function retornarPromImporteContratos($codigoPlan) {
        
        $colContratos = $this->getColContratos();
        $sumaImportes = 0;
        $cantidadContratos = 0;
        
       
        foreach($colContratos as $contrato) {
            $objPlan = $contrato->getObjPlan();
            
            if($objPlan->getCodigo() == $codigoPlan) {
                $sumaImportes += $contrato->getImporte();
                $cantidadContratos++;
            }
        }
        
       
        $promedio = ($cantidadContratos > 0) ? $sumaImportes / $cantidadContratos : 0;
        
        return $promedio;
    }
    /**
     * Procesa el pago de un contrato y actualiza su estado
     * @param string $codigoContrato
     * @return float
     */
    public function pagarContrato($codigoContrato) {
        $colContratos = $this->getColContratos();
        $importeAPagar = 0;
        $i = 0;
        $encontrado = false;
        
        
        while($i < count($colContratos) && !$encontrado) {
            $contrato = $colContratos[$i];
            
            if($contrato->getCodigo() == $codigoContrato) {
                $encontrado = true;
                $estado = $contrato->getEstado();
                $importeBase = $contrato->getImporte();
                
                
                switch($estado) {
                    case "al día":
                        $importeAPagar = $importeBase;
                        $contrato->setSeRenueva(true);
                        break;
                        
                    case "moroso":
                        $diasMora = $contrato->diasContratoVencido($contrato);
                        $multa = $importeBase * 0.10 * $diasMora;
                        $importeAPagar = $importeBase + $multa;
                        $contrato->setEstado("al día");
                        $contrato->setSeRenueva(true);
                        break;
                    case "suspendido":
                        $diasMora = $contrato->diasContratoVencido($contrato);
                        $multa = $importeBase * 0.10 * $diasMora;
                        $importeAPagar = $importeBase + $multa;
                        $contrato->setSeRenueva(false);
                        break;
                        
                    case "finalizado":
                        $importeAPagar = 0;
                        break;
                }
            }
            $i++;
        }
        
        return $importeAPagar;
    }
}
