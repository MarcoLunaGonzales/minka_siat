<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$home=1;
ob_start();

include "dFacturaElectronicaAllPdf.php";
$html = ob_get_clean();

$sqlDatosVenta="select s.siat_cuf
        from `salida_almacenes` s
        where s.`cod_salida_almacenes`='$codigoVenta'";
$respDatosVenta=mysqli_query($enlaceCon,$sqlDatosVenta);
$cuf="";
while($datDatosVenta=mysqli_fetch_array($respDatosVenta)){
    $cuf=$datDatosVenta['siat_cuf'];
}
$nombreFile="siat_folder/Siat/temp/Facturas-XML/$cuf.pdf";
// unlink($nombreFile);	
// echo $html;
// guardarPDFArqueoCajaVerticalFactura($cuf,$html,$nombreFile,$codigoVenta);
descargarPDFFacturasCopiaCliente($nombreFile,$html,$codigoVenta)


// if(isset($_GET["ds"])){
//     ?><script type="text/javascript">
//         var link = document.createElement('a');
//         link.href = '<?=$nombreFile?>';
//         link.download = '<?=$cuf?>.pdf';
//         link.dispatchEvent(new MouseEvent('click'));window.location.href='deleteFile.php?file=<?=$nombreFile?>';</script><?php
// }else{
//     echo $cuf.".pdf";
// }






