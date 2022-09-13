<?php 
// error_reporting(E_ALL);
    // ini_set('display_errors', '1');  

require_once("../funciones.php");
//LLAVES DE ACCESO AL WS
$sIde = "MinkaSw123*";
$sKey = "rrf656nb2396k6g6x44434h56jzx5g6";


$sucursal="1";
$tipoTabla="1";
$idRecibo="300520";
$fecha="2022-09-13";
$idPersona="15069";
$idPlan="36";
$cuota="9";
$monto_total="850";
$descuento=540;
$monto_final="310";
$gestion="2022";
$id_usuario="1000";
$usuario="Elizabeth Vergara";
$nitCliente="4790203";
$nombreFactura="MARANON";
$NombreEstudiante="CARDENAS MARA\u00d1ON DONNA JOE (14275-4)";
$Concepto="Pago cuota:8 Gestion:2022 Plan:36";
$tipoPago="1";
$nroTarjeta=0;
$tipoDocumento="1";
$complementoDocumento="";
$periodoFacturado="JULIO-2022";



  //Lista de Tipos documento
	$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, 
           "accion"=>"generarFacturaMinka", //
           // "idEmpresa"=>2, //ID de empresa, otorgado por minkasoftware
           // "nitEmpresa"=>'10916889016', //Nit de empresa
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
    
	$url="http://localhost/minka_siat/wsminka/ws_generarFactura.php";
	$jsons=callService($parametros, $url);
	//print_r($jsons);
  
$obj=json_decode($jsons);//decodificando json
header('Content-type: application/json');  
print_r($jsons); 



      
  
?>
