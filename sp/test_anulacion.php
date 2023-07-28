<?php 


    require_once("../conexionmysqli.inc");
    require_once("../estilos_almacenes.inc");
    require_once("../siat_folder/funciones_siat.php");
    require_once("../enviar_correo/php/send-email_anulacion.php");

 error_reporting(E_ALL);
 ini_set('display_errors', '1');  

$codSucursal=0;
$codigoSucursal=0;
$codigoPuntoVenta=1;
$cod_entidad=1;

/*$cuis="4A005D14";
$cufd="QUF8Q8KsRXdBQQ==MTZGQkEwQ0YzNDY=Q8KhPTNsT1BDWFVCNzcwNDUyMEREMDk2";
$cuf="20E0644AD405F2D0AAD7ED61A3B2260DEE2CEA06AB65B1C4C7C54FD74";
*/

$sql="select s.cod_salida_almacenes, s.siat_cuis, sc.cufd, s.siat_cuf from salida_almacenes s, siat_cufd sc 
where s.siat_codigocufd=sc.codigo and s.salida_anulada=0 and s.cod_salida_almacenes between 135 and 400;";
echo $sql;
$resp=mysqli_query($enlaceCon, $sql);
while($dat=mysqli_fetch_array($resp)){
  echo "entra";
  
  $codVenta=$dat[0];
  $cuis=$dat[1];
  $cufd=$dat[2];
  $cuf=$dat[3];
  
  $respEvento=anulacionFactura_siat($codigoPuntoVenta,$codigoSucursal,$cuis,$cufd,$cuf);
  $mensaje=$respEvento[1];
  if($respEvento[0]==1){
    echo "anulado ".$codVenta." ".$mensaje;
  }

}
