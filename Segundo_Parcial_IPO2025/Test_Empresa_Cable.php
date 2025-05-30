<?php
include_once 'Canal.php';
include_once 'Plan.php';
include_once 'Cliente.php';
include_once 'Contrato.php';
include_once 'ContratoWeb.php';
include_once 'EmpresaCable.php';


$objEmpresa = new EmpresaCable();


$objCanal1 = new Canal("deportivo", 1500, true);    // tipo, importe, esHD
$objCanal2 = new Canal("películas", 2000, true);
$objCanal3 = new Canal("noticias", 1000, false);


$colCanalesPlan1 = [$objCanal1, $objCanal2];
$objPlan1 = new Plan("111", $colCanalesPlan1, 3000, true);  


$colCanalesPlan2 = [$objCanal2, $objCanal3];
$objPlan2 = new Plan("222", $colCanalesPlan2, 2500, false);


$objCliente = new Cliente("DNI", "12345678", "Juan", "Pérez", "Av. Principal 123");

/*Creamos las instancias de Contratos*/

$objContrato1 = new Contrato("2024-03-15", "2024-04-15", $objPlan1, $objCliente);


$objContrato2 = new ContratoWeb("2024-03-15", "2024-04-15", $objPlan2, $objCliente);
$objContrato3 = new ContratoWeb("2024-03-15", "2024-04-15", $objPlan1, $objCliente, 15); // con 15% de descuento


echo "Importe Contrato Empresa: $" . $objContrato1->calcularImporte() . "\n";
echo "Importe Contrato Web 1: $" . $objContrato2->calcularImporte() . "\n";
echo "Importe Contrato Web 2: $" . $objContrato3->calcularImporte() . "\n";

// a. Incorporamos los planes a la empresa
$objEmpresa->incorporarPlan($objPlan1);
$objEmpresa->incorporarPlan($objPlan2);

// b. Incorporamos contrato normal (en empresa) 
$fechaHoy = date('Y-m-d');
$fechaVencimiento = date('Y-m-d', strtotime('+30 days'));
$objEmpresa->incorporarContrato($objPlan1, $objCliente, $fechaHoy, $fechaVencimiento, false);

// c. Incorporamos contrato web
$objEmpresa->incorporarContrato($objPlan1, $objCliente, $fechaHoy, $fechaVencimiento, true);

// d. Pagamos un contrato realizado en empresa
echo "Pago de contrato en empresa: $" . $objEmpresa->pagarContrato($objContrato1->getCodigo()) . "\n";

// e. Pagamos un contrato realizado vía web
echo "Pago de contrato web: $" . $objEmpresa->pagarContrato($objContrato2->getCodigo()) . "\n";

// f. Obtenemos promedio de importes para el plan 111
echo "Promedio de importes para plan 111: $" . $objEmpresa->retornarPromImporteContratos("111") . "\n";

?>