<?php
if(isset($_GET['codVenta'])){
	$codSalida=$_GET['codVenta'];
}else{
	$codSalida=$codigoVenta;
}

require "conexionmysqli2.php";
require_once "siat_folder/funciones_siat.php";  

  // error_reporting(E_ALL);
  //    ini_set('display_errors', '1');

$facturaImpuestos=generarXMLFacturaVentaImpuestos($codSalida);

$sqlDatosVenta="select s.siat_cuf
        from `salida_almacenes` s
        where s.`cod_salida_almacenes`='$codSalida'";
$respDatosVenta=mysqli_query($enlaceCon,$sqlDatosVenta);
$cuf="";
while($datDatosVenta=mysqli_fetch_array($respDatosVenta)){
    $cuf=$datDatosVenta['siat_cuf'];

}
if(isset($sw_correo)){
    $nombreFile="../siat_folder/Siat/temp/Facturas-XML/$cuf.xml";
}else{
    $nombreFile="siat_folder/Siat/temp/Facturas-XML/$cuf.xml";
}

// unlink($nombreFile);	
$archivo = fopen($nombreFile,'a');    
fputs($archivo,$facturaImpuestos);
fclose($archivo);

if(isset($sw_correo)){
	
}else{
	if(!isset($_GET["email"])){
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=\"$cuf.xml\"");
		readfile($nombreFile);	
		unlink($nombreFile);
	}else{
		echo $cuf.".xml";
	}	
}





