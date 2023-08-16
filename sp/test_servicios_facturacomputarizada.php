<?php 
// error_reporting(E_ALL);
    // ini_set('display_errors', '1');  

require_once("../funciones.php");
//LLAVES DE ACCESO AL WS
$sIde = "MinkaSw123*";
$sKey = "rrf656nb2396k6g6x44434h56jzx5g6";

$sucursal=1;
$tipoTabla="2";
$idRecibo="-1";
$fecha="2023-08-15";
$idPersona="15069";
$idPlan="";
$cuota="";
$monto_total="50";
$descuento=0;
$monto_final="50";
$gestion="2023";
$id_usuario=12;
$usuario="ESTER GUARDIA";
$nitCliente="4790203";
$nombreFactura="MARAu00d1ON";
$NombreEstudiante="CARDENAS MARAu00d1ON DONNA JOE (14275-4)";
$Concepto="PAGO POR CARNET UNIVERSITARIO carnet";
$tipoPago="1";
$nroTarjeta=0;
$tipoDocumento=1;
$complementoDocumento="";
$periodoFacturado="08-2023";
$correo="donnajoecardenas@gmail.com";
$accion="generarFacturaMinka";
$sIdentificador="MinkaSw123*";
$sKey="rrf656nb2396k6g6x44434h56jzx5g6";


//Lista de Tipos documento
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, 
           "accion"=>"generarFacturaMinka", //
           // "nitEmpresa"=>'10916889016', //Nit de empresa
           "sucursal"=>$sucursal,
           "tipoTabla"=>$tipoTabla,
           "idCodigoPago"=>'30',
           "idRecibo"=>$idRecibo,
           "fecha"=>$fecha,
           "idPersona"=>$idPersona,
           "monto_total"=>$monto_total,
           "descuento"=>$descuento,
           "monto_final"=>$monto_final,
           "id_usuario"=>$id_usuario,//***
           "usuario"=>$usuario,//***
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
  
?>
