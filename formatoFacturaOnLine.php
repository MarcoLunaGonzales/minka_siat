
<?php
$home=1;
ob_start();

include "conexionmysqli.inc";
require_once('funciones.php');
require('funcion_nombres.php');
require('NumeroALetras.php');
include('phpqrcode/qrlib.php'); 

if(isset($_GET["codVenta"])){
    $codigoVenta=$_GET["codVenta"];
}else{
    $codigoVenta=$codigoVenta;
}

$cod_ciudad=$_COOKIE["global_agencia"];

//OBTENEMOS EL LOGO Y EL NOMBRE DEL SISTEMA
$logoEnvioEmail=obtenerValorConfiguracion($enlaceCon,13);
$nombreSistemaEmail=obtenerValorConfiguracion($enlaceCon,12);

$sqlConf="select id, valor from configuracion_facturas where id=1 and cod_ciudad='$cod_ciudad'";
// echo $sqlConf;
$respConf=mysqli_query($enlaceCon,$sqlConf);
$nombreTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=10 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$nombreTxt2=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=2 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$sucursalTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=3 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$direccionTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=4 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$telefonoTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=5 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$ciudadTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=6 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$txt1=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from siat_leyendas where id=1";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$txt2=mysqli_result($respConf,0,1);


$sqlConf="select id, valor from configuracion_facturas where id=9 and cod_ciudad='$cod_ciudad'";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$nitTxt=mysqli_result($respConf,0,1);


$sqlDatosFactura="select '' as nro_autorizacion, '', '' as codigo_control, f.nit, f.razon_social, DATE_FORMAT(f.siat_fechaemision, '%d/%m/%Y'),f.siat_nombreEstudiante,f.siat_periodoFacturado 
from salida_almacenes f
    where f.cod_salida_almacenes=$codigoVenta";
    
//echo $sqlDatosFactura;
$respDatosFactura=mysqli_query($enlaceCon,$sqlDatosFactura);
$nroAutorizacion=mysqli_result($respDatosFactura,0,0);
$fechaLimiteEmision=mysqli_result($respDatosFactura,0,1);
$codigoControl=mysqli_result($respDatosFactura,0,2);
$nitCliente=mysqli_result($respDatosFactura,0,3);
$razonSocialCliente=mysqli_result($respDatosFactura,0,4);
$razonSocialCliente=strtoupper($razonSocialCliente);
$fechaFactura=mysqli_result($respDatosFactura,0,5);

$nombreEstudiante=mysqli_result($respDatosFactura,0,6);
$periodoFacturado=mysqli_result($respDatosFactura,0,7);



$cod_funcionario=$_COOKIE["global_usuario"];
//datos documento
$sqlDatosVenta="select DATE_FORMAT(s.fecha, '%d/%m/%Y'), t.`nombre`, 'cliente', s.`nro_correlativo`, s.descuento, s.hora_salida,s.monto_total,s.monto_final,s.monto_efectivo,s.monto_cambio,s.cod_chofer,s.cod_tipopago,s.cod_tipo_doc,s.fecha,(SELECT cod_ciudad from almacenes where cod_almacen=s.cod_almacen)as cod_ciudad,s.cod_cliente,s.siat_cuf,s.siat_complemento,(SELECT nombre_tipopago from tipos_pago where cod_tipopago=s.cod_tipopago) as nombre_pago,s.siat_fechaemision,s.siat_codigotipoemision,s.siat_codigoPuntoVenta,(SELECT descripcionLeyenda from siat_sincronizarlistaleyendasfactura where codigo=s.siat_cod_leyenda) as leyenda,(SELECT siat_unidadProducto from ciudades where cod_ciudad in (select cod_ciudad from almacenes where cod_almacen=s.cod_almacen)) as unidad_medida
        from `salida_almacenes` s, `tipos_docs` t, `clientes` c
        where s.`cod_salida_almacenes`='$codigoVenta' and s.cod_tipo_doc=t.codigo";
        // echo $sqlDatosVenta;
$respDatosVenta=mysqli_query($enlaceCon,$sqlDatosVenta);
$siat_complemento="";
while($datDatosVenta=mysqli_fetch_array($respDatosVenta)){
    $cuf=$datDatosVenta['siat_cuf'];
    $fechaVenta=$datDatosVenta[0];
    $nombreTipoDoc=$datDatosVenta[1];
    $nombreCliente=$datDatosVenta[2];
    $nroDocVenta=$datDatosVenta[3];
    $descuentoVenta=$datDatosVenta[4];
    $descuentoVenta=redondear2($descuentoVenta);
    $horaFactura=$datDatosVenta[5];
    $montoTotal2=$datDatosVenta['monto_total'];
    $montoFinal2=$datDatosVenta['monto_final'];
    $montoEfectivo2=$datDatosVenta['monto_efectivo'];
    $montoCambio2=$datDatosVenta['monto_cambio'];
    $montoTotal2=redondear2($montoTotal2);
    $montoFinal2=redondear2($montoFinal2);

    $montoEfectivo2=redondear2($montoEfectivo2);
    $montoCambio2=redondear2($montoCambio2);

    $descuentoCabecera=$datDatosVenta['descuento'];
    $cod_funcionario=$datDatosVenta['cod_chofer'];
    $tipoPago=$datDatosVenta['cod_tipopago'];
    $tipoDoc=$datDatosVenta['nombre'];
    $codTipoDoc=$datDatosVenta['cod_tipo_doc'];

    $fecha_salida=$datDatosVenta['fecha'];
    $hora_salida=$datDatosVenta['hora_salida'];
    $cod_ciudad_salida=$datDatosVenta['cod_ciudad'];
    $cod_cliente=$datDatosVenta['cod_cliente'];

    $siat_complemento=$datDatosVenta['siat_complemento'];

    $siat_codigotipoemision=$datDatosVenta['siat_codigotipoemision'];
    $siat_codigopuntoventa=$datDatosVenta['siat_codigoPuntoVenta'];

    $unidad_medida=$datDatosVenta['unidad_medida'];

    $nombrePago=$datDatosVenta['nombre_pago'];
    $txt3=$datDatosVenta['leyenda'];
    $fechaFactura=date("d/m/Y H:i:s",strtotime($datDatosVenta['siat_fechaemision']));
    // $nombrePago="EFECTIVO";
    // if($tipoPago!=1){
    //     $nombrePago="TARJETA/OTROS";
    // }
}

if($siat_codigotipoemision==2){
    $sqlConf="select id, valor from siat_leyendas where id=3";
}else{
    $sqlConf="select id, valor from siat_leyendas where id=2";
}
$respConf=mysqli_query($enlaceCon,$sqlConf);
$txtLeyendaFin=mysqli_result($respConf,0,1);
ob_start();
?>

<html>
    <head>
        <!-- CSS Files -->
        <!-- <link rel="icon" type="image/png" href="../assets/img/favicon.png"> -->
        <link href="assets/libraries/plantillaPDFFactura.css" rel="stylesheet" type="text/css" />
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   </head>

<body>
<div  style="height: 49.4%">
        <table  style="width: 100%;">
            <tr>
                <td align="center" width="45%"><br><br>
                    </small></small>
                </td>
                
                <td >
                    <div style="width:100%;text-align: left;font-size: 14px"><p><b>FACTURA</b><br><small><small>(Con Derecho a Crédito Fiscal)</small></small></p></div><br>
                    <table style="width: 100%;border: black 1px solid;text-align: left;">
                        
                        <tr align="left">
                          <td width="40%"><b>
                              NIT : <br>
                              FACTURA N° : <br>
                              CÓD. AUTORIZACIÓN : </b>
                          </td>
                          <td>
                              <?=$nitTxt?><br>
                              <?=$nroDocVenta?><br>
                          </td>
                        </tr>

                        <tr><td colspan="2"><?=$cuf?></td></tr>
                        <tr><td colspan="2">
                            <b>FECHA FACTURA : </b> <?=$fechaFactura?><br>
                        </td></tr>
                    </table>
                    
                </td>
            </tr>
        </table>

        <table class="table">
            <tr >
                <td class="td-border-none text-left" width="15%" ><b>Nombre/Razón Social : </b></td>
                <td class="td-border-none" width="43%"><?=$razonSocialCliente?></td>
                <td class="td-border-none text-right" width="15%"><b>NIT/CI/CEX:</b></td>
                <td class="td-border-none">&nbsp;&nbsp;&nbsp;<?=$nitCliente." ".$siat_complemento?></td>
            </tr>
            <tr >
              <td class="td-border-none text-left" width="25%" ><b>Nombre Estudiante : </b></td>
              <td class="td-border-none" ><?=$nombreEstudiante?></td>
              <td class="td-border-none text-right" ><b>Cod. Cliente :</b></td>
              <td class="td-border-none">&nbsp;&nbsp;&nbsp;<?=$cod_cliente?></td>
            </tr>
            <tr >
              <td class="td-border-none text-left" width="25%" ></td>
              <td class="td-border-none" ></td>
              <td class="td-border-none text-right" ><b>Periodo Facturado :</b></td>
              <td class="td-border-none">&nbsp;&nbsp;&nbsp;<?=$periodoFacturado?></td>
            </tr>
        </table>
        <table class="table2">
            <tr>
                <td width="8%" class="text-center">Codigo<br>Servicio</td>
                <td width="40%" class="text-center">DESCRIPCIÓN</td>
                <td width="8%" class="text-center">Unidad Medida</td>
                <td width="8%" class="text-center">Cantidad</td>
                <td class="text-center">Precio Unitario</td>
                <td class="text-center">Descuento</td>
                <td class="text-center">Subtotal</td>
            </tr>
            <?php
            $suma_total=0;
            ?>
            
            <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <?php

                $contador_items=0;                    
                $cantidad_por_defecto=8;//cantidad de items por defect

                $sqlDetalle="SELECT m.codigo_material, s.orden_detalle,m.descripcion_material,s.observaciones,s.precio_unitario,sum(s.cantidad_unitaria) as cantidad_unitario,
                sum(s.descuento_unitario) as descuento_unitario, sum(s.monto_unitario) as monto_unitario
                from salida_detalle_almacenes s, material_apoyo m 
                where m.codigo_material=s.cod_material and s.cod_salida_almacen=$codigoVenta
                group by m.codigo_material, s.orden_detalle,m.descripcion_material, s.observaciones,s.precio_unitario
                order by s.orden_detalle;";
                $respDetalle=mysqli_query($enlaceCon,$sqlDetalle);

                $yyy=65;
                $montoTotal=0;$descuentoVentaProd=0;
                while($datDetalle=mysqli_fetch_array($respDetalle)){                        
                    $observaciones=$datDetalle['observaciones'];
                    if($datDetalle['observaciones']==null){
                        $observaciones="";
                    }
                    $codInterno=$datDetalle['codigo_material'];
                    $cantUnit=$datDetalle['cantidad_unitario'];
                    $nombreMat=$datDetalle['descripcion_material']." ".$observaciones;;
                    $precioUnit=$datDetalle['precio_unitario'];
                    $descUnit=$datDetalle['descuento_unitario'];
                    //$montoUnit=$datDetalle[5];
                    $montoUnit=($cantUnit*$precioUnit)-$descUnit;
                    
                    //recalculamos el precio unitario para mostrar en la factura.
                    //$precioUnitFactura=$montoUnit/$cantUnit;
                    $precioUnitFactura=($cantUnit*$precioUnit)/$cantUnit;
                    $cantUnit=redondear2($cantUnit);
                    $precioUnit=redondear2($precioUnit);
                    $montoUnit=redondear2($montoUnit);
                    
                    $precioUnitFactura=redondear2($precioUnitFactura);
                    // $precioUnitFactura=number_format($precioUnitFactura,2);

                    // - $descUnit
                    $descUnit=redondear2($descUnit);  
                    // $descUnit=number_format($descUnit,2);  
                    $descuentoVentaProd+=$descUnit;
                    $montoUnitProd=($cantUnit*$precioUnit);

                    $montoUnitProdDesc=$montoUnitProd-$descUnit;
                    $montoUnitProdDesc=redondear2($montoUnitProdDesc);
                    // $montoUnitProdDesc=number_format($montoUnitProdDesc,2);

                    $montoUnitProd=redondear2($montoUnitProd);

                    ?>
                    <tr>
                        <td class="text-left" valign="top" style="padding-top: 0px;padding-bottom: 0px; border-bottom: hidden;border-top: hidden; font-size: 8px;"><?=$codInterno?></td>
                        <td class="text-left" valign="top" style="padding-top: 0px;padding-bottom: 0px; border-bottom: hidden;border-top: hidden; font-size: 8px;">
                            <?=$nombreMat;?>
                        </td>
                        <td style="padding-top: 0px;padding-bottom: 0px; border-bottom: hidden;border-top: hidden; font-size: 8px;"><small><?=$unidad_medida?></small></td>
                        <td style="padding-top: 0px;padding-bottom: 0px; border-bottom: hidden;border-top: hidden; font-size: 8px;"><?=$cantUnit?></td>
                        <td style="padding-top: 0px;padding-bottom: 0px; border-bottom: hidden;border-top: hidden; font-size: 8px;"><?=number_format($precioUnitFactura,2)?></td>
                        <td style="padding-top: 0px;padding-bottom: 0px; border-bottom: hidden;border-top: hidden; font-size: 8px;"><?=number_format($descUnit,2)?></td>
                        <td style="padding-top: 0px;padding-bottom: 0px; border-bottom: hidden;border-top: hidden; font-size: 8px;"><?=number_format($montoUnitProdDesc,2)?></td>
                    </tr>
                    
                    <?php $contador_items++;
                }
                
                for($i=$contador_items;$i<$cantidad_por_defecto;$i++){ ?>
                    <tr>
                        <td style="padding-top: 0px;padding-bottom: 0px; border-top: hidden;">&nbsp;</td>
                        <td style="padding-top: 0px;padding-bottom: 0px; border-top: hidden;"></td>
                        <td style="padding-top: 0px;padding-bottom: 0px; border-top: hidden;"></td>
                        <td style="padding-top: 0px;padding-bottom: 0px; border-top: hidden;"></td>
                        <td style="padding-top: 0px;padding-bottom: 0px; border-top: hidden;"></td>
                        <td style="padding-top: 0px;padding-bottom: 0px; border-top: hidden;"></td>
                        <td style="padding-top: 0px;padding-bottom: 0px; border-top: hidden;"></td>
                    </tr>
                <?php 
                }
                $montoTotal=$montoTotal+$montoUnitProdDesc; 
                $yyy=$yyy+6;

            // echo $montoTotal;
            $descuentoVenta=number_format($descuentoVenta,2,'.','');
            //$montoFinal=$montoTotal-$descuentoVenta-$descuentoVentaProd;
            $montoFinal=$montoTotal-$descuentoVenta;
            //$montoTotal=number_format($montoTotal,1,'.','')."0";
            $montoFinal=number_format($montoFinal,2,'.','');

            $arrayDecimal=explode('.', $montoFinal);
            if(count($arrayDecimal)>1){
                list($montoEntero, $montoDecimal) = explode('.', $montoFinal);
            }else{
                list($montoEntero,$montoDecimal)=array($montoFinal,0);
            }

            if($montoDecimal==""){
                $montoDecimal="00";
            }
            $txtMonto=NumeroALetras::convertir($montoEntero);

            ?>

            <?php
            
             $sqlDir="select valor_configuracion from configuraciones where id_configuracion=46";
            $respDir=mysqli_query($enlaceCon,$sqlDir);
            $urlDir=mysqli_result($respDir,0,0);
                       
            $cadenaQR=$urlDir."/consulta/QR?nit=$nitTxt&cuf=$cuf&numero=$nroDocVenta&t=2";
            $codeContents = $cadenaQR; 

            $fechahora=date("dmy.His");
            $fileName="qrs/".$fechahora.$nroDocVenta.".png"; 
                
            QRcode::png($codeContents, $fileName,QR_ECLEVEL_L, 3);

            ?>
            <!-- <img src="<?=$fileName?>" style="margin: 0px;padding: 0;"> -->
            <?php

            $sqlGlosa="select cod_tipopreciogeneral from `salida_almacenes` s where s.`cod_salida_almacenes`=$codigoVenta";
            $respGlosa=mysqli_query($enlaceCon,$sqlGlosa);
            $codigoPrecio=mysqli_result($respGlosa,0,0);
            $txtGlosaDescuento="";
            $sql1="SELECT glosa_factura from tipos_preciogeneral where codigo=$codigoPrecio and glosa_estado=1";
            $resp1=mysqli_query($enlaceCon,$sql1);
            while($filaDesc=mysqli_fetch_array($resp1)){    
                    $txtGlosaDescuento=iconv('utf-8', 'windows-1252', $filaDesc[0]);        
            }
                    ?>
            <tr>
                <td rowspan="2" align="center" style="margin: 0px;">
                    <img src="<?=$fileName?>"/>
                </td>
                <td  colspan="6">
                    <table class="table">
                        <tr ><td style="padding: 0px;margin: 0px;border-right: hidden;border-bottom: hidden;border-top: hidden;border-left: hidden;" valign="top">
                            <?php
                        $entero=floor(round($importe,2));
                        $decimal=$importe-$entero;
                        $centavos=round($decimal*100);
                        if($centavos<10){
                            $centavos="0".$centavos;
                        }?>
                        <span class="bold table-title" valign="bottom"><small>Son: <?="$txtMonto"." ".$montoDecimal."/100 Bolivianos"?></small></span>
                        </td>
                            <td align="right" style="border-left: hidden;border-bottom: hidden; border-top: hidden;border-right: hidden;" valign="bottom">
                                <table class="table" style="font-size: 9px;" >
                                    <tr>
                                        <td align="right" style="border-left: hidden;border-bottom: hidden; border-top: hidden;border-right: hidden;" valign="bottom">SUBTOTAL Bs:</td>
                                        <td align="right" style="border-left: hidden;border-bottom: hidden; border-top: hidden;border-right: hidden;" valign="bottom"><?=number_format($montoTotal,2)?></td>
                                    </tr>

                                    <tr>
                                        <td align="right" style="border-left: hidden;border-bottom: hidden; border-top: hidden;border-right: hidden;" valign="bottom">DESCUENTO Bs:</td>
                                        <td align="right" style="border-left: hidden;border-bottom: hidden; border-top: hidden;border-right: hidden;" valign="bottom"><?=number_format($descuentoVenta,2)?></td>
                                    </tr>
                                    <tfoot>
                                        <tr>
                                            <td align="right" style="border-left: hidden;border-bottom: hidden; border-top: hidden;border-right: hidden;" valign="bottom">TOTAL Bs:</td>
                                            <td align="right" style="border-left: hidden;border-bottom: hidden; border-top: hidden;border-right: hidden;" valign="bottom"><?=number_format($montoFinal,2)?></td>
                                        </tr>
                                        <tr>
                                            <td align="right" style="border-left: hidden;border-bottom: hidden; border-top: hidden;border-right: hidden;" valign="bottom"><b>MONTO A PAGAR Bs:</b></td>
                                            <td align="right" style="border-left: hidden;border-bottom: hidden; border-top: hidden;border-right: hidden;" valign="bottom"><?=number_format($montoFinal,2)?></td>
                                        </tr>
                                        <tr>
                                            <td align="right" style="border-left: hidden;border-bottom: hidden; border-top: hidden;border-right: hidden;" valign="bottom"><b>IMPORTE BASE CRÉDITO FISCAL:</b></td>
                                            <td align="right" style="border-left: hidden;border-bottom: hidden; border-top: hidden;border-right: hidden;" valign="bottom"><?=number_format($montoFinal,2)?></td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </td>
                        <tr >
                    </table >
                </td>
            </tr>
            
            <tr><td colspan="6" style="border-top:hidden;" valign="bottom"><span style="padding: 0px;margin: 0px;"><small><small>Forma de Pago: <?=$nombrePago?></small></small></span></td></tr>
            
        </table>
        <table class="table3" >
            <tr align="center"><td>&quot;<?=$txt2?>&quot;<br>&quot;<?=$txt3?>&quot;<br>&quot;<?=$txtLeyendaFin?>&quot;</td></tr>
        </table>
    </div>    

</body>
</html>


<?php

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
unlink($nombreFile);	
// echo $html;
guardarPDFArqueoCajaVerticalFactura($cuf,$html,$nombreFile,$codigoVenta);




    ?><script type="text/javascript">
        var link = document.createElement('a');
        link.href = '<?=$nombreFile?>';
        link.download = '<?=$cuf?>.pdf';
        link.dispatchEvent(new MouseEvent('click'));window.location.href='deleteFile.php?file=<?=$nombreFile?>';</script><?php




 // descargarPDFFacturasCopiaCliente($cuf,$html,$codigoVenta,$nombreFile);