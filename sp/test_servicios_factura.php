<?php 
// error_reporting(E_ALL);
    // ini_set('display_errors', '1');  

require_once("../funciones.php");
//LLAVES DE ACCESO AL WS
$sIde = "MinkaSw123*";
$sKey = "rrf656nb2396k6g6x44434h56jzx5g6";


// $sucursal="0";
// $tipoTabla="3";
// $idRecibo="28626";
// $fecha="2022-08-26";
// $idPersona="-28626";
// // $monto="550";
// $gestion="2022";
// $usuario="Alison Ala";
// $nitCliente="123456";
// $nombreFactura="Lopes ";
// $NombreEstudiante="juan calle";
// $Concepto="inscripcion taller motos taller motos";
// $tipoPago="1";
// $nroTarjeta=0;
// $tipoDocumento="1";
// $complementoDocumento="";
// $monto_total=550;
// $descuento=0;
// $monto_final=$monto_total-$descuento;
// $id_usuario=1000;
// $periodoFacturado="JUNIO - 2022";


// $sucursal="1";
// $tipoTabla="1";
// $idRecibo="300520";
// $fecha="2022-09-13";
// $idPersona="15069";
// $idPlan="36";
// $cuota="9";
// $monto_total="850";
// $descuento=540;
// $monto_final="310";
// $gestion="2022";
// $id_usuario="1000";
// $usuario="Elizabeth Vergara";
// $nitCliente="4790203";
// $nombreFactura="MARANON";
// $NombreEstudiante="CARDENAS MARA\u00d1ON DONNA JOE (14275-4)";
// $Concepto="Pago cuota:8 Gestion:2022 Plan:36";
// $tipoPago="1";
// $nroTarjeta=0;
// $tipoDocumento="1";
// $complementoDocumento="";
// $periodoFacturado="JULIO-2022";


/*$sucursal="0";
$tipoTabla="3";
$idRecibo="28644";
$fecha="2022-09-28";
$idPersona="-28644";
$idPlan="36";
$cuota="9";
$monto_total="300";
$descuento=100;
$monto_final="200";
$gestion="2022";
$id_usuario="1000";
$usuario="ester guardia";
$nitCliente="4868422";
$nombreFactura="CRISTIANO RONALDO";
$NombreEstudiante="CRISTIANO RONALDO";
$Concepto="PAGO DE CANCHA,DEL 1 AL 3 DEL MES";
$tipoPago="1";
$nroTarjeta=0;
$tipoDocumento="1";
$complementoDocumento="";
$periodoFacturado="JULIO-2022";*/


$sucursal=0;
$tipoTabla="1";
$idRecibo="311129";
$fecha="2023-06-29";
$idPersona="16178";
$idPlan="36";
$cuota="12";
$monto_total="670";
$descuento=0;
$monto_final="670";
$gestion="2022";
$id_usuario=11;
$usuario="GUILLERMO SUAREZ";
$nitCliente="4868422016";
$nombreFactura="MARCO ANTONIO LUNA";
$NombreEstudiante="LUNA";
$Concepto="Cuota 1";
$tipoPago="1";
$nroTarjeta=0;
$tipoDocumento="5";
$complementoDocumento="";
$periodoFacturado="11-2022";
$correo="";

$sIdentificador="MinkaSw123*";
$sKey="rrf656nb2396k6g6x44434h56jzx5g6";


//Lista de Tipos documento
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, 
           "accion"=>"generarFacturaElectronica", //
           // "idEmpresa"=>3, //ID de empresa, otorgado por minkasoftware
           // "nitEmpresa"=>'10916889016', //Nit de empresa
           "sucursal"=>$sucursal,
           // "tipoTabla"=>$tipoTabla,
           // "idRecibo"=>$idRecibo,
           "fecha"=>$fecha,
           "idPersona"=>$idPersona,
           "monto_total"=>$monto_total,
           "descuento"=>$descuento,
           "monto_final"=>$monto_final,
           "id_usuario"=>$id_usuario,//***
           "usuario"=>$usuario,//***
           "nitCliente"=>$nitCliente,
           "nombreFactura"=>$nombreFactura,
           
           "Concepto"=>$Concepto,
           "tipoPago"=>$tipoPago,
           "nroTarjeta"=>$nroTarjeta,
           "tipoDocumento"=>$tipoDocumento,
           "complementoDocumento"=>$complementoDocumento
           //***
       );  
    
	$url="http://localhost:8090/minka_siat/wsminka/ws_generarFactura.php";
	$jsons=callService($parametros, $url);
	//print_r($jsons);
  
$obj=json_decode($jsons);//decodificando json
header('Content-type: application/json');  
print_r($jsons); 
  
?>
