<?php
$home = 1;
ob_start();

include "dFacturaElectronicaAllPdf.php";
$html = ob_get_clean();

$sqlDatosVenta = "select s.siat_cuf
                 from `salida_almacenes` s
                 where s.`cod_salida_almacenes`='$codigoVenta'";
$respDatosVenta = mysqli_query($enlaceCon, $sqlDatosVenta);
$cuf = "";
while ($datDatosVenta = mysqli_fetch_array($respDatosVenta)) {
    $cuf = $datDatosVenta['siat_cuf'];
}

if (isset($sw_correo)) {
    $sw = true;
    $nombreFile = "../siat_folder/Siat/temp/Facturas-XML/$cuf.pdf";
} else {
    $sw = false;
    $nombreFile = "siat_folder/Siat/temp/Facturas-XML/$cuf.pdf";  
}

unlink($nombreFile);

guardarPDFArqueoCajaVerticalFactura($cuf, $html, $nombreFile, $codigoVenta);

if (!isset($sw_correo)) {
    if (isset($_GET["ds"])) {
        ?><script type="text/javascript">
            window.location.href = '<?=$nombreFile?>';
        </script><?php
    } else {
        // Mostrar el PDF en el navegador
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $cuf . '.pdf"');
        readfile($nombreFile);
    }
}
?>
