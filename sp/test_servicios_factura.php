<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');  

require_once("../funciones.php");
//LLAVES DE ACCESO AL WS
$sIde = "MinkaSw123*";
$sKey = "rrf656nb2396k6g6x44434h56jzx5g6";

//detalle de factura
$Objeto_detalle1 = new stdClass();
$Objeto_detalle1->codDetalle = 1;
$Objeto_detalle1->cantidad = 1;
$Objeto_detalle1->precioUnitario = "300";
$Objeto_detalle1->descuentoProducto = 0;
$Objeto_detalle1->detalle = "COMPRA DE NORMA 9001";  
// $arrayDetalle= array($Objeto_detalle1);

$Objeto_detalle2 = new stdClass();
$Objeto_detalle2->codDetalle = 2;
$Objeto_detalle2->cantidad = 1;
$Objeto_detalle2->precioUnitario = "400";
$Objeto_detalle2->descuentoProducto = 0;
$Objeto_detalle2->detalle = "COMPRA DE NORMA 9002";  
$arrayDetalle= array($Objeto_detalle1,$Objeto_detalle2);


$sucursal=0;
//$tipoTabla="1";
//$idRecibo="311129";
$fecha="2023-06-29";
$idPersona="16178";
//$idPlan="36";
//$cuota="12";
$monto_total="670";
$descuento=0;
$monto_final="670";
//$gestion="2022";
$id_usuario=11;
$usuario="GUILLERMO SUAREZ";
$nitCliente="4868422016";
$nombreFactura="MARCO ANTONIO LUNA";
//$NombreEstudiante="LUNA";
//$Concepto="Cuota 1";


$tipoPago="1";
$nroTarjeta=0;
$tipoDocumento="5";
$complementoDocumento="";
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, 
   "accion"=>"generarFacturaElectronica", //
   "cod_entidad"=>2, //ID de empresa, otorgado por minkasoftware
   "sucursal"=>$sucursal,   
   "idRecibo"=>0,
   "fecha"=>$fecha,
   "idPersona"=>$idPersona,//cod cliente
   "monto_total"=>$monto_total,
   "descuento"=>$descuento,
   "monto_final"=>$monto_final,
   "id_usuario"=>$id_usuario,//***
   "usuario"=>$usuario,//***
   "nitCliente"=>$nitCliente,
   "nombreFactura"=>$nombreFactura,   
   "tipoPago"=>$tipoPago,
   "nroTarjeta"=>$nroTarjeta,
   "tipoDocumento"=>$tipoDocumento,
   "complementoDocumento"=>$complementoDocumento,
   "correo"=>"bsullcamani@gmail.com",
   "items"=>$arrayDetalle
   // ,"NombreEstudiante"=>$NombreEstudiante,
   // "periodoFacturado"=>$periodoFacturado
);  
    
	$url="http://localhost:8080/minka_siat/wsminka/ws_generarFactura.php";
	$jsons=callService($parametros, $url);
	//print_r($jsons);
  
$obj=json_decode($jsons);//decodificando json
header('Content-type: application/json');  
print_r($jsons); 

?>
