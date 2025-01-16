<html>
<head>
	<meta charset="utf-8" />
</head>
<body>
<?php
set_time_limit(0);

require('estilos_reportes_almacencentral.php');
require('function_formatofecha.php');
require('conexionmysqli.inc');
require('funcion_nombres.php');
require('funciones.php');

//  error_reporting(E_ALL);
//  ini_set('display_errors', '1');

$fecha_ini=$_POST['fecha_ini'];
$fecha_fin=$_POST['fecha_fin'];
$codCarreras=$_POST['rpt_carreras'];

$stringCarreras=implode(',',$codCarreras);

//desde esta parte viene el reporte en si
$fecha_iniconsulta=$fecha_ini;
$fecha_finconsulta=$fecha_fin;

$diaPrimerMes=explode("-",$fecha_iniconsulta)[2];
$diaUltimoMes=explode("-",$fecha_finconsulta)[2];

$fecha_reporte=date("d/m/Y");

?><style type="text/css"> 
        thead tr th { 
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #ffffff;
        }
    
        .table-responsive { 
            height:200px;
            overflow:scroll;
        }
    </style>
<table style='margin-top:-90 !important' align='center' class='textotit' width='70%'><tr><td align='center'>Reporte Ventas x Carrera
	<br> De: <?=$fecha_ini?> A: <?=$fecha_fin?>
	<br>Fecha Reporte: <?=$fecha_reporte?></tr></table>
<?php

setlocale(LC_ALL, 'es_ES');
$tiempoInicio = strtotime($fecha_iniconsulta);//obtener tiempo de inicio
$tiempoFin = strtotime(date("Y-m-t", strtotime($fecha_finconsulta)).""); //obtener el tiempo final pero al ultimo día, para que muestre todos los meses

?>

<br>
<center><table align='center' class='texto' width='70%' id='ventasSucursal'>
	<thead>
<tr><th width="5%">N.</th><th><small>Carrera</small></th>
<?php
$cantidadMes=0;
while($tiempoInicio <= $tiempoFin){
	$fechaActual = date("Y-m-d", $tiempoInicio);
	?><th><small><?=strftime('%b %Y', strtotime($fechaActual))?></small></th>

  <?php
	$tiempoInicio += strtotime("+1 month","$fechaActual");
	$cantidadMes++;
}
?>
<th>Totales</th>
</tr>
</thead>
<tbody>
<?php

$sqlCarreras="select c.codigo, c.idEspecialidad, c.Especialidad from configuraciones_tablas_carreras c 
              where c.idEspecialidad in ($stringCarreras) order by 3;";
$respCarreras=mysqli_query($enlaceCon,$sqlCarreras);
$index=0;

while($datosCarreras=mysqli_fetch_array($respCarreras)){
  $totalesHorizontal=0;
  $index++;
	$codigoCarrera=$datosCarreras[1];
	$nombreCarrera=$datosCarreras[2];

	?>
  <tr>
    <th><?=$index;?></th>
    <th><?=$nombreCarrera;?></th>
  
  <?php
  
  $tiempoInicio2 = strtotime($fecha_iniconsulta);
  $sw_meses=0;
  $cantidadMes2=0;
  while($tiempoInicio2 <= $tiempoFin){
    $cantidadMes2++;
  	//obtener rangos del mes
  	$dateInicio = date("Y-m", $tiempoInicio2)."-01";
  	$dateFin = date("Y-m-t", $tiempoInicio2);
  	//para listar desde el dia escogido en el primer y ultimo mes
  	if($cantidadMes2==1){
      $sw_meses=1;
  		$dateInicio=date('Y-m', strtotime($fecha_iniconsulta))."-".$diaPrimerMes;
  	}
    if($cantidadMes2==$cantidadMes){
      $dateFin=date('Y-m', strtotime($fecha_finconsulta))."-".$diaUltimoMes;
    }
    
    //echo $dateInicio."...".$dateFin."<br>";
    $montoVenta=0;
    $sqlMontoVenta="SELECT sum(s.monto_final) from salida_almacenes s where s.salida_anulada=0 and s.fecha BETWEEN '$dateInicio' and '$dateFin' and s.id_carrera='$codigoCarrera'";
    $respMontoVenta=mysqli_query($enlaceCon, $sqlMontoVenta);
    if($datMontoVenta=mysqli_fetch_array($respMontoVenta)){
      $montoVenta=$datMontoVenta[0];
    }  

    $totalesHorizontal+=number_format($montoVenta,2,'.','');
  	if($montoVenta>0){//if($dateInicio==date("Y-m")."-01"){ ?>
      <td class="text-right"><?=number_format($montoVenta,2,'.',',')?></td><?php
  	}else{ ?>
        <td class='text-muted text-right'><?=number_format($montoVenta,2,'.',',')?></td><?php 
  	}
    // para sumar mes
  	$fechaActual = date("Y-m-d", $tiempoInicio2);  	
  	$tiempoInicio2 += strtotime("+1 month","$fechaActual");
  } 
  ?>
    <th class="text-right"><?=number_format($totalesHorizontal,2,'.',',')?></th>
  </tr> <?php
}

?>
</tbody><tfoot><tr></tr></tfoot></table></center></br>

<script type="text/javascript">
  totalesTablaVertical('ventasSucursal',2,1);
</script>
</body></html>