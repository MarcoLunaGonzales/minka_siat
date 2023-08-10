<?php
	
require("conexionmysqli.inc");
require("estilos_administracion.inc");

echo "<form action='rptComprobantePorMes.php' method='post' target='_blank'>";

echo "<h6 align='center'>Reporte Ventas x Tipo de Pago (Verificación para Contabilización)</h6>";

echo "<center><table class='table table-bordered'>";

echo "<tr class='bg-info text-white'><th>Año</th><th>Mes</th><th>Sucursal</th></tr>";

echo "<tr>

<td align='center' width='15%'><select name='cod_anio' id='cod_anio' class='selectpicker'>";
for($i=2018; $i<=date("Y"); $i++){
	if($i==date("Y")){
	    echo "<option value='$i' selected>$i</option>";	
	}else{
		echo "<option value='$i'>$i</option>";
	}
	
}
echo "</select></td>";
echo "<td align='center' width='20%'><select name='cod_mes' id='cod_mes' class='selectpicker'>";
$meses=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
for ($i=0; $i < count($meses); $i++) { 
	$me=$i+1;
	$nombreMes=$meses[$i];
	 if($me==date("m")){
	    echo "<option value='$me' selected>$nombreMes</option>";	
	}else{
		echo "<option value='$me'>$nombreMes</option>";
	}
}
echo "</select></td>";
echo "<td width='50%'><select name='rpt_territorio' data-live-search='true' title='-- Elija una sucursal --'  id='rpt_territorio' multiple data-actions-box='true' data-style='select-with-transition' data-actions-box='true' data-size='10' class='selectpicker form-control' required>";	
	$globalAgencia=$_COOKIE["global_agencia"];
   	
   	$sql="select cod_ciudad, descripcion from ciudades where cod_ciudad>0 order by descripcion";    
	
	$resp=mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_ciudad=$dat[0];
		$nombre_ciudad=$dat[1];
		if($codigo_ciudad==$globalAgencia){
           echo "<option value='$codigo_ciudad' selected>$nombre_ciudad</option>";
		}else{
		   echo "<option value='$codigo_ciudad'>$nombre_ciudad</option>";	
		}		
	}
echo "</select></td></tr>";
echo "</table></center>";

echo "<div class=''>

<button class='boton' type='submit'>Generar Reporte</button>";

echo "</form>";
?>