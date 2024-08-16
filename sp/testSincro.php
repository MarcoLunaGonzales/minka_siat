<?php 
// error_reporting(E_ALL);
    // ini_set('display_errors', '1');  

require_once("../funciones.php");
require_once '../siat_folder/funciones_siat.php';


$codSucursal=1;
$codigoSucursal=0;

/*VARIAR ESTE DATO*/
$codigoPuntoVenta=1;


$cod_entidad=1;


for($i=1;$i<=1;$i++){
  $response=sincronizarParametrosSiat('',0);
  echo $response."<br>";
}


?>
