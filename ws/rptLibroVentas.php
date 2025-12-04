<?php
ini_set('memory_limit','1G');
header('Content-Type: application/json');
require('../function_formatofecha.php');
require('../conexionmysqli.inc');
require('../funcion_nombres.php');

$codAnio        = $_GET['codAnio'] ?? '';
$codMes         = $_GET['codMes'] ?? '';
$rpt_territorio = $_GET['codTipoTerritorio'] ?? '';
$tipo           = $_GET['tipo'] ?? '';
$fecha_reporte  = date("d/m/Y");

// Obtener configuración
$sqlConf   = "SELECT id, valor FROM configuracion_facturas WHERE id=1";
$respConf  = mysqli_query($enlaceCon, $sqlConf);
$nombreTxt = mysqli_result($respConf, 0, 1);

$sqlConf  = "SELECT id, valor FROM configuracion_facturas WHERE id=9";
$respConf = mysqli_query($enlaceCon, $sqlConf);
$nitTxt   = mysqli_result($respConf, 0, 1);

if ($tipo > 0) {
    $sqlTipo = $tipo == 1 ? " AND s.cod_tipo_doc='1' " : " AND s.cod_tipo_doc='4' ";
} else {
    $sqlTipo = "";
}

$sql = "SELECT s.nro_correlativo, s.fecha, s.monto_final, s.razon_social, s.nit, 
            s.siat_cuf AS nro_autorizacion, s.salida_anulada, '0' AS cod_control, 
            (SELECT c.descripcion FROM ciudades c, almacenes a WHERE a.cod_ciudad=c.cod_ciudad AND a.cod_almacen=s.cod_almacen) AS nombre_ciudad, 
            s.cod_tipo_doc, s.siat_complemento, s.siat_usuario 
        FROM salida_almacenes s 
        WHERE YEAR(s.fecha)='$codAnio' AND MONTH(s.fecha)='$codMes' ";

if(!empty($rpt_territorio)){
    $sql .= " AND s.cod_almacen IN (SELECT a.cod_almacen FROM almacenes a WHERE a.cod_ciudad IN ($rpt_territorio)) ";
}

$sql .= " AND s.siat_estado_facturacion = 1 ORDER BY s.nro_correlativo";
// ob_clean();
// echo $sql;
// exit;

$resp = mysqli_query($enlaceCon, $sql);

$detalleVentas  = [];
$ventasTotales  = 0;
$totalImpuestos = 0;

while ($datos = mysqli_fetch_array($resp)) {
    $nroFactura           = $datos['nro_correlativo'];
    $fecha                = $datos['fecha'];
    $importe              = $datos['monto_final'];
    $razonSocial          = $datos['razon_social'];
    $nit                  = $datos['nit'];
    $nroAutorizacion      = $datos['nro_autorizacion'];
    $nombreEstado         = $datos['salida_anulada'] == 0 ? "V" : "A";
    $codigoControl        = $datos['cod_control'];
    $montoVentaFormat     = number_format($importe, 2, ".", ",");
    $montoIVA             = $importe * 0.13;
    $montoIVAFormat       = number_format($montoIVA, 2, ".", ",");
    $nombreCiudad         = $datos['nombre_ciudad'];
    $codTipoDoc           = $datos['cod_tipo_doc'];
    $nomTipo              = $codTipoDoc == 1 ? "A" : ($codTipoDoc == 4 ? "M" : "");
    $complementoDocumento = $datos['siat_complemento'];
    $usuarioCaja          = $datos['siat_usuario'];

    $ventasTotales  += $importe;
    $totalImpuestos += $montoIVA;

    $detalleVentas[] = [
        "fecha"                => $fecha,
        "nroFactura"           => $nroFactura,
        "nroAutorizacion"      => $nroAutorizacion,
        "nit"                  => $nit,
        "complementoDocumento" => $complementoDocumento,
        "razonSocial"          => $razonSocial,
        'importeTotalVenta'    => $montoVentaFormat,
        "ice"           => 0,
        "iehd"          => 0,
        "ipj"           => 0,
        "tasa"          => 0,
        "otros"         => 0,
        "exportacionesExentas" => 0,
        'ventasTasaCero' 	   => 0,
        "subtotal"             => $montoVentaFormat,
        'descuentos' 		   => 0,
        "giftcard"             => 0,
        "importeBaseDebitoFiscal" => $montoVentaFormat,
        "debitoFiscal"            =>  $montoIVAFormat,
        "estado"                  => $nombreEstado,
        "codigoControl"           => $codigoControl,
        "tipoVenta"               => "OTROS",
		"derechoCreditoFiscal"	  => "SI",
		"estadoConsolidacion"	  => "PENDIENTE",
		"area"					  => "CLÍNICA",




        // "montoVenta"    => $montoVentaFormat,
        // "ventagrabada"  => 0,
        // "descuentos"    => 0,
        // "usuario"       => $usuarioCaja,
        // "nombreCiudad"  => $nombreCiudad
    ];
}

$resultado = [
    "fechaReporte"      => $fecha_reporte,
    "nombreRazonSocial" => $nombreTxt,
    "nit"               => $nitTxt,
    "ventasTotales"     => number_format($ventasTotales, 2, ".", ","),
    "totalImpuestos"    => number_format($totalImpuestos, 2, ".", ","),
    "detalleVentas"     => $detalleVentas
];
ob_clean();
echo json_encode($resultado, JSON_PRETTY_PRINT);
?>
