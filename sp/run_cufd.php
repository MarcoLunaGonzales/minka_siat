<?php 
// error_reporting(E_ALL);
    // ini_set('display_errors', '1');  

require_once("../funciones.php");
require_once '../siat_folder/funciones_siat.php';


$codCiudad=1;
$codigoSucursal=0;
$codigoPuntoVenta=0;
$cod_entidad=1;

for($i=1;$i<=100;$i++){
    generarCufd($codCiudad,$codigoSucursal,$codigoPuntoVenta,$cod_entidad);
}



?>
