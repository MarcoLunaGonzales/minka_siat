<?php
require("conexionmysqli.inc");
require("estilos_almacenes.inc");
?>

<script language='JavaScript'>
</script>

<?php
$fecha_rptdefault=date("Y-m-d");

$variableAdmin=$_GET["variableAdmin"];
if($variableAdmin!=1){
	$variableAdmin=0;
}
echo "<h1>Reporte Ventas x Sucursal</h1><br>";

echo"<form method='post' action='rptVentasCarreras.php'>";

	echo"\n<table class='texto' align='center' cellSpacing='0' width='50%'>\n";
	
	echo "<tr><th align='left'>Sucursal</th>
		<td>
			<select name='rpt_carreras[]' data-live-search='true' id='rpt_carreras' data-style='select-with-transition' data-actions-box='true' data-size='10' class='selectpicker form-control' multiple required>";

	$globalAgencia=$_COOKIE["global_agencia"];
   
   	$sql="SELECT c.codigo, c.idEspecialidad, c.Especialidad from configuraciones_tablas_carreras c order by 3;";
	$resp=mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp))
	{	$codigoCiudad=$dat[0];
		$idEspecialidad=$dat[1];
		$nombreCarrera=$dat[2];
	   	echo "<option value='$idEspecialidad' selected>$nombreCarrera</option>";	
	}
	echo "</select></td></tr>";

	echo "<tr><th align='left' class='text-muted'>Fecha inicio:</th>";
			echo" <td><input type='date' class='form-control' value='$fecha_rptdefault' id='fecha_ini' size='10' name='fecha_ini' required >";
    		echo"  </th>";
	echo "</tr>";
	echo "<tr><th align='left' class='text-muted'>Fecha final:</th>";
			echo"<td><input type='date' class='form-control' value='$fecha_rptdefault' id='fecha_fin' size='10' name='fecha_fin' required>";
    		echo"  </th>";
	echo "</tr>";
	
	echo"\n </table><br>";

	echo "<center>
			<input type='submit' name='reporte_detalle'  class='boton-verde' value='Ver Reporte x Mes' class='btn btn-success'>
	</center><br>";
	echo"</form>";
	echo "</div>";
?>