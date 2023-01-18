<?php
ini_set('memory_limit','1G');
require('function_formatofecha.php');
require('conexionmysqli.inc');
require('funcion_nombres.php');

$codAnio=$_GET['codAnio'];
$codMes=$_GET['codMes'];
$rpt_territorio=$_GET['codTipoTerritorio'];
$tipo=$_GET['tipo'];
$fecha_reporte=date("d/m/Y");

echo "<center><h3>Libro de Ventas Gestion: $codAnio Mes: $codMes </h3></center>";

$sqlConf="select id, valor from configuracion_facturas where id=1";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$nombreTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=9";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$nitTxt=mysqli_result($respConf,0,1);

//echo "<h3>Periodo Año: $codAnio  Mes: $codMes</h3>";
//echo "<h3>Nombre o Razon Social: $nombreTxt  NIT: $nitTxt</h3>";
if($tipo>0){
	if($tipo==1){
		$sqlTipo=" and s.cod_tipo_doc='1' ";
	}else{
		$sqlTipo=" and s.cod_tipo_doc='4' ";
	}	
}


$sql="select s.nro_correlativo, DATE_FORMAT(s.fecha, '%d/%m/%Y'), s.monto_final, s.razon_social, s.nit, s.siat_cuf as nro_autorizacion, s.salida_anulada, '0' as cod_control, 
(SELECT c.cod_ciudad FROM ciudades c, almacenes a where a.cod_ciudad=c.cod_ciudad and a.cod_almacen=s.cod_almacen)nombre_ciudad, s.cod_tipo_doc, s.siat_complemento, s.siat_usuario from salida_almacenes s where YEAR(s.fecha)='$codAnio' and MONTH(s.fecha)='$codMes' and 
s.cod_almacen in (select a.cod_almacen from almacenes a where a.cod_ciudad in ($rpt_territorio)) and s.siat_estado_facturacion=1 order by nombre_ciudad, s.nro_correlativo";

//echo $sql;

$resp=mysqli_query($enlaceCon,$sql);
echo "<br><table align='center' class='table table-condensed' width='70%'>
<thead>
<tr class='bg-primary text-white'>
<th class='bg-primary text-white'><small><small>FECHA FACTURA</small></small></th>
<th class='bg-primary text-white'><small><small>NRO. FACTURA</small></small></th>
<th class='bg-primary text-white'><small><small>NRO. AUTORIZACION</small></small></th>
<th class='bg-primary text-white'><small><small>NIT/CI CLIENTE</small></small></th>
<th class='bg-primary text-white'><small><small>COMPLEMENTO</small></small></th>
<th class='bg-primary text-white'><small><small>NOMBRE O RAZON SOCIAL</small></small></th>
<th class='bg-primary text-white'><small><small>IMPORTE TOTAL VENTA</small></small></th>
<th class='bg-primary text-white'><small><small>ESTADO</small></small></th>
<th class='bg-primary text-white'><small><small>SUCURSAL</small></small></th>
<th class='bg-primary text-white'><small><small>USUARIO</small></small></th>
</tr></thead><tbody>";

$indice=1;
$totalFacturacion=0;

while($datos=mysqli_fetch_array($resp)){	
	$nroFactura=$datos[0];
	$fecha=$datos[1];
	$fechaAnulacion=$datos['fecha_anulacion'];
	$importe=$datos[2];
	$razonSocial=$datos[3];
	$nit=$datos[4];
	$nroAutorizacion=$datos[5];
	$nombreEstado=$datos[6];

	$codigoControl=$datos[7];
	
	$importe=number_format($importe,1,".","");
	$montoVentaFormat=number_format($importe,2,".",",");
	$montoIVA=$importe*0.13;
	$montoIVAFormat=number_format($montoIVA,2,".",",");
	$nombreCiudad=$datos['nombre_ciudad'];
	$codTipoDoc=$datos['cod_tipo_doc'];
	$nomTipo="";
	if($codTipoDoc==1){
		$nomTipo="A";
	}else{
		if($codTipoDoc==4){
		  $nomTipo="M";	
		}		
	}
	$complementoDocumento=$datos["siat_complemento"];
	$usuarioCaja=$datos["siat_usuario"];

	if($nombreEstado==0){
		$nombreEstadoF="V";
	}elseif($nombreEstado==1){
		$nombreEstadoF="A";
		$importe=0;
		$montoVentaFormat=number_format($importe,2,".",",");
	}

	$totalFacturacion+=$importe;

	echo "<tr>
	<td>$fecha</td>
	<td>$nroFactura</td>
	<td>$nroAutorizacion</td>
	<td>$nit</td>
	<td>$complementoDocumento</td>
	<td>$razonSocial</td>
	<td>$montoVentaFormat</td>
	<td>$nombreEstadoF</td>
	<td>$nombreCiudad</td>
	<td>$usuarioCaja</td>
	</tr>";
	$indice++;
}
$totalFacturacionF=number_format($totalFacturacion,2,".",",");
echo "<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><b>$totalFacturacionF</b></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>";
echo "</tbody></table></br>";
?>