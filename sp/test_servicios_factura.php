<?php 
 error_reporting(E_ALL);
ini_set('display_errors', '1');  

$sucursal="0";
$tipoTabla="3";
$idRecibo="28622";
$fecha="2022-08-31";
$idPersona="28626";
// $monto="550";
$gestion="2022";
$usuario="Alison Ala";
$nitCliente="4868422";
$nombreFactura="LUNA";
$NombreEstudiante="MARCO ANTONIO LUNA GONZALES";
$Concepto="INFORMATICA 111";
$tipoPago="1";
$nroTarjeta=0;
$tipoDocumento="1";
$complementoDocumento="";
$monto_total=550;
$descuento=0;
$monto_final=$monto_total-$descuento;
$id_usuario=1000;
$periodoFacturado="JUNIO - 2022";


require_once("../funciones.php");
//LLAVES DE ACCESO AL WS
$sIde = "MinkaSw123*";
$sKey = "rrf656nb2396k6g6x44434h56jzx5g6";

  //Lista de Tipos documento
	$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, 
           "accion"=>"generarFacturaMinka", //
           "idEmpresa"=>2, //ID de empresa, otorgado por minkasoftware
           "nitEmpresa"=>'315910027', //Nit de empresa
           "sucursal"=>$sucursal,
           "tipoTabla"=>$tipoTabla,
           "idRecibo"=>$idRecibo,
           "fecha"=>$fecha,
           "idPersona"=>$idPersona,
           "monto_total"=>$monto_total,
           "descuento"=>$descuento,
           "monto_final"=>$monto_final,
           "id_usuario"=>$id_usuario,//***
           "nitCliente"=>$nitCliente,
           "nombreFactura"=>$nombreFactura,
           "NombreEstudiante"=>$NombreEstudiante,
           "Concepto"=>$Concepto,
           "tipoPago"=>$tipoPago,
           "nroTarjeta"=>$nroTarjeta,
           "tipoDocumento"=>$tipoDocumento,
           "complementoDocumento"=>$complementoDocumento,
           "periodoFacturado"=>$periodoFacturado//***
       );  
    
	$url="http://localhost:8090/minka_siat/wsminka/ws_generarFactura.php";
	$jsons=callService($parametros, $url);
	//print_r($jsons);
  
$obj=json_decode($jsons);//decodificando json
header('Content-type: application/json');  
print_r($jsons); 

// if(isset($obj->estado)){
//   $estado=$obj->estado;
//   $mensaje=$obj->mensaje;
//   if(isset($obj->idTransaccion)){
//     $idTransaccion=$obj->idTransaccion;
//     $nroFactura=$obj->nroFactura;
//   }else{
//     $idTransaccion=0;
//     $nroFactura=0;
//   }
  
//   echo "SIAT: ".$mensaje." * NroFactura: ".$nroFactura." * IdTransaccion: ".$idTransaccion;
// }else{
//   echo "Hubo algun error";
// }






      
  
?>
