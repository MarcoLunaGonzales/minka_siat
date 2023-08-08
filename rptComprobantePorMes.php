<?php

require('conexionmysqli.inc');

$codAnio  	 = $_POST['cod_anio'];
$codMes   	 = $_POST['cod_mes'];
$codSucursal = $_POST['rpt_territorio'];
// Sucursal
$filtrar_sucursal = '';
foreach ($codSucursal as $opcion) {
	$filtrar_sucursal .= ' AND cod_sucursal = '.$opcion;
}

$fecha_inicio = date("Y-m-d", strtotime("$codAnio-$codMes-01"));
$fecha_fin    = date("Y-m-t", strtotime("$codAnio-$codMes-01"));
/**
 * Obtiene nombre del MES
 */
function obtenerNombreMes($numeroMes) {
    $nombresMeses = array(
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    );

    if (array_key_exists($numeroMes, $nombresMeses)) {
        return $nombresMeses[$numeroMes];
    } else {
        return "Mes inválido";
    }
}

echo "<table align='center' class='table table-condensed' width='70%'>
<thead style='position: sticky; top: 0; backgnumber_format-color: #333 !important; color: white;'>
<tr class='bg-primary text-white'>
<th class='bg-primary text-white'><small><small>#</small></small></th>
	<th class='bg-primary text-white'><small><small>Tipo Pago</small></small></th>
	<th class='bg-primary text-white'><small><small>Carrera</small></small></th>
	<th class='bg-primary text-white'><small><small>MES Concepto</small></small></th>
	<th class='bg-primary text-white'><small><small>Monto</small></small></th>
</tr></thead><tbody>";

// SUMATORIA GLOBAL
$suma_total_global = 0;
/*************************************************
 REGISTRO DE COMPROBANTE | CUOTAS Y MATRICULAS 
*************************************************/
$query = "SELECT s.id_carrera, 
				s.cod_tipopago, 
				CASE WHEN s.siat_periodoFacturado LIKE '0-%' THEN '0' ELSE '1' END as periodoFacturado, 
				sum(s.monto_final) as monto,
				tp.nombre_tipopago,
				a.Especialidad
		FROM salida_almacenes s 
		LEFT JOIN tipos_pago tp ON tp.cod_tipopago = s.cod_tipopago
		LEFT JOIN configuraciones_tablas_carreras a ON a.idEspecialidad = s.id_carrera
		WHERE s.salida_anulada=0 
		AND s.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' 
		AND s.idtabla=1
		GROUP BY s.id_carrera, s.cod_tipopago, periodoFacturado";

echo "<tr style='background-color: #CCCCC8;'>
		<td colspan='5'>CUOTAS Y MATRICULAS</td>
	</tr>";

$resp=mysqli_query($enlaceCon,$query);
$indice=1;
$suma_total = 0;
while($datos=mysqli_fetch_array($resp)){
	$nombre_carrera = $datos[5];
	$nombre_pago 	= $datos[4];
	$monto 			= number_format($datos[3], 2);
	$nombre_mes  	= obtenerNombreMes($codMes);
	echo "<tr>
		<td>$indice</td>
		<td>$nombre_pago</td>
		<td style='text-align: left;'>$nombre_carrera</td>
		<td>$nombre_mes</td>
		<td style='text-align: left;'>$monto</td>
	</tr>";
	$indice++;
	$suma_total += $monto;

	// Suma Global
	$suma_total_global += $monto;
}
echo "<tr style='backgnumber_format-color: #f2f2f2;'>
		<td colspan='4' style='text-align: right;color:red;'>Total:</td>
		<td style='text-align: left;'".(number_format($suma_total, 2))."/td>
	</tr>
</tbody></br>";

/***************************************************
 REGISTRO DE COMPROBANTE | OTROS INGRESOS POR CARRERAS 
***************************************************/
$query = "SELECT s.id_carrera, 
				s.cod_tipopago, 
				sum(s.monto_final) as monto,
				tp.nombre_tipopago,
				a.Especialidad
		FROM salida_almacenes s 
		LEFT JOIN tipos_pago tp ON tp.cod_tipopago = s.cod_tipopago
		LEFT JOIN configuraciones_tablas_carreras a ON a.idEspecialidad = s.id_carrera
		WHERE s.salida_anulada=0 
		AND s.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' 
		AND s.idtabla=2 
		GROUP BY s.id_carrera, s.cod_tipopago";

echo "<tr style='background-color: #CCCCC8;'>
		<td colspan='5'>OTROS INGRESOS POR CARRERAS</td>
	</tr>";
$resp=mysqli_query($enlaceCon,$query);
$indice=1;
$suma_total = 0;
while($datos=mysqli_fetch_array($resp)){
	$nombre_carrera = $datos[4];
	$nombre_pago 	= $datos[3];
	$monto 			= number_format($datos[2], 2);
	$nombre_mes  	= obtenerNombreMes($codMes);
	echo "<tr>
		<td>$indice</td>
		<td>$nombre_pago</td>
		<td style='text-align: left;'>$nombre_carrera</td>
		<td>$nombre_mes</td>
		<td style='text-align: left;'>$monto</td>
	</tr>";
	$indice++;
	$suma_total += $monto;

	// Suma Global
	$suma_total_global += $monto;
}
echo "<tr style='backgnumber_format-color: #f2f2f2;'  colspan='5'>
		<td colspan='4' style='text-align: right;color:red;'>Total:</td>
		<td style='text-align: left;'".(number_format($suma_total, 2))."/td>
	</tr>
</tbody></br>";

/*************************************************
 REGISTRO DE COMPROBANTE | OTROS INGRESOS GENERAL 
*************************************************/
$query = "SELECT s.id_carrera, 
				s.cod_tipopago, 
				sum(s.monto_final) as monto,
				tp.nombre_tipopago,
				a.Especialidad
		FROM salida_almacenes s 
		LEFT JOIN tipos_pago tp ON tp.cod_tipopago = s.cod_tipopago
		LEFT JOIN configuraciones_tablas_carreras a ON a.idEspecialidad = s.id_carrera
		WHERE s.salida_anulada=0 
		AND s.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' 
		AND s.idtabla=3
		GROUP BY s.id_carrera, s.cod_tipopago";

echo "<tr style='background-color: #CCCCC8;'>
		<td colspan='5'> INGRESOS GENERAL 
		</td>
	</tr>";
$resp=mysqli_query($enlaceCon,$query);
$indice=1;
$suma_total = 0;
while($datos=mysqli_fetch_array($resp)){
	$nombre_carrera = $datos[4];
	$nombre_pago 	= $datos[3];
	$monto 			= number_format($datos[2], 2);
	$nombre_mes  	= obtenerNombreMes($codMes);
	echo "<tr>
		<td>$indice</td>
		<td>$nombre_pago</td>
		<td style='text-align: left;'>$nombre_carrera</td>
		<td>$nombre_mes</td>
		<td style='text-align: left;'>$monto</td>
	</tr>";
	$indice++;
	$suma_total += $monto;

	// Suma Global
	$suma_total_global += $monto;
}
echo "<tr style='backgnumber_format-color: #f2f2f2;'>
		<td colspan='4' style='text-align: right;color:red;'>Total:</td>
		<td style='text-align: left;'".(number_format($suma_total, 2))."/td>
	</tr>
</tbody></br>";
// Sumatoria Total Global
echo "<tfoot style='backgnumber_format-color: #E6F7FF;'>
	<tr>
		<td colspan='4' style='text-align: right;color:red;'>Suma Total:</td>
		<td style='text-align: left;'>".number_format($suma_total_global, 2)."</td>
	</tr>
</tfoot></table>";
?>