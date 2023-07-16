<?php 
// error_reporting(E_ALL);
    // ini_set('display_errors', '1');  

require_once("../funciones.php");
require_once '../siat_folder/funciones_siat.php';


$codSucursal=0;
$codigoSucursal=0;
$codigoPuntoVenta=1;
$cod_entidad=1;

/*$resp=abrirPuntoVenta(0,$codigoSucursal,5,"Punto 2",$cod_entidad);
echo $resp;*/

$resp=cerrarPuntoVenta(1, 0, 1);
echo $resp;

?>
