<?php
require("conexionmysqli.inc");
require("estilos_almacenes.inc");
require("siat_folder/funciones_siat.php");
require("funciones.php");
require("enviar_correo/php/send-email_anulacion.php");

ob_clean();
$enviar_correo   = $_GET["enviar_correo"] ?? ($_POST["enviar_correo"] ?? '');
$correo_destino  = $_GET["correo_destino"] ?? ($_POST["correo_destino"] ?? '');
$codigo_registro = $_GET["codigo_registro"] ?? ($_POST["codigo_registro"] ?? '');

// datos de factura para anulacion siat
$anulado = 0;
$fecha_X = date('Y-m-d');
$cufd = 0;
$cuis = 0;
$sql = "SELECT s.fecha, 
            s.siat_cuf, 
            s.cod_almacen, 
            s.salida_anulada, 
            (SELECT cod_impuestos FROM ciudades WHERE cod_ciudad = a.cod_ciudad) AS cod_impuestos, 
            a.cod_ciudad, 
            s.nro_correlativo, 
            (SELECT p.nombre_cliente FROM clientes p WHERE p.cod_cliente = s.cod_cliente) AS cliente, 
            s.cod_cliente, 
            s.siat_cuf, 
            s.nit, 
            (SELECT nombre_ciudad FROM ciudades WHERE cod_ciudad = (SELECT cod_ciudad FROM almacenes WHERE cod_almacen = s.cod_almacen)) AS nombre_ciudad, 
            s.siat_codigotipodocumentoidentidad, 
            s.siat_estado_facturacion, 
            s.siat_complemento, 
            s.siat_fechaemision, 
            s.idtabla, 
            s.idrecibo 
        FROM salida_almacenes s 
        JOIN almacenes a ON s.cod_almacen = a.cod_almacen 
        WHERE s.cod_salida_almacenes IN ($codigo_registro)";
$resp_verif = mysqli_query($enlaceCon, $sql);
while ($dat_verif = mysqli_fetch_assoc($resp_verif)) {
    $anulado             = $dat_verif['salida_anulada'];
    $cuf                 = $dat_verif['siat_cuf'];
    $cod_impuestos       = intval($dat_verif['cod_impuestos']);
    $cod_ciudad          = $dat_verif['cod_ciudad'];
    $codigoPuntoVenta    = obtenerPuntoVenta_BD($cod_ciudad);
    $cuis                = obtenerCuis_vigente_BD($cod_ciudad, $cod_impuestos);
    $cufd                = obtenerCufd_vigente_BD($cod_ciudad, $fecha_X, $cuis);

    $nitCliente          = ($dat_verif['siat_codigotipodocumentoidentidad'] == 5) 
                            ? $dat_verif['nit'] 
                            : trim($dat_verif['nit'] . " " . $dat_verif['siat_complemento']);
    $sucursalCliente     = $dat_verif['nombre_ciudad'];
    $estado_siatCliente  = $dat_verif['siat_estado_facturacion'];
    $fechaCliente        = date("d/m/Y", strtotime($dat_verif['siat_fechaemision']));
    $nro_correlativo     = $dat_verif['nro_correlativo'];
    $proveedor           = $dat_verif['cliente'];
    $idproveedor         = $dat_verif['cod_cliente'];
    $idTabla             = $dat_verif['idtabla'];
    $idRecibo            = $dat_verif['idrecibo'];
}

// ob_end_clean();
// echo json_encode([
//     'message' => $cufd,
//     'status'  => false,
//     'type' 	  => 'success'
// ]);

// exit;

if ($anulado == 0) {
    if ($cufd != "0" && $cuis != "0") {
        $respEvento = anulacionFactura_siat($codigoPuntoVenta, $cod_ciudad, $cuis, $cufd, $cuf);
        $mensaje = $respEvento[1];
        
        if ($respEvento[0] == 1) {
            $sql = "UPDATE salida_almacenes SET salida_anulada = 1, estado_salida = 3 WHERE cod_salida_almacenes = '$codigo_registro'";
            $resp = mysqli_query($enlaceCon, $sql);
            
            // $estado_envio = $enviar_correo ? envio_facturaanulada($idproveedor, $proveedor, $nro_correlativo, $cuf, $nitCliente, $sucursalCliente, $estado_siatCliente, $fechaCliente, $correo_destino, $enlaceCon) : null;

            // if ($enviar_correo && $estado_envio == 1) {
            //     $data = [
            //         'message' => 'SE ENVIÓ EL CORREO CON EXITO.',
			// 		'status'  => false,
            //         'type' 	  => 'success'
            //     ];
            // } elseif ($enviar_correo && $estado_envio == 0) {
            //     $data = [
            //         'message' => 'EL CLIENTE NO TIENE UN CORREO REGISTRADO',
			// 		'status'  => false,
            //         'type' 	  => 'warning'
            //     ];
            // } else {
            //     $data = [
            //         'message' => 'Ocurrió un error al enviar el correo.',
			// 		'status'  => false,
            //         'type' 	  => 'error'
            //     ];
            // }

            // Servicio de anulación de recibo
            // $anularServicio = solicitarAnulacionServicio($enlaceCon, $idTabla, $idRecibo);
            // if (isset($anularServicio->anula->estado) && $anularServicio->anula->estado == 1) {
            //     // $data['anulacion_servicio'] = 'Servicio de anulación de Recibo OK';
            //     $data = [
            //         'message' => 'Factura anulada exitosamente.',
			// 		'status'  => true,
            //         'type' 	  => 'success'
            //     ];
            // }
			
            ob_end_clean();
            $data = [
                'message' => 'Factura anulada exitosamente.',
                'status'  => true,
                'type' 	  => 'success'
            ];
            echo json_encode($data);
        } else {
            ob_end_clean();
            echo json_encode([
                'message' => $mensaje 
                    ?? 'Hubo un error al intentar anular la factura en el sistema SIAT. Por favor, intente nuevamente o contacte al administrador.',
                'status'  => false,
                'type' 	  => 'error'
            ]);
        }
    } else {
        ob_end_clean();
        echo json_encode([
            'message' => 'CUFD invalido para la Fecha de Emisión',
			'status'  => false,
            'type' 	  => 'error'
        ]);
    }
} else {
    ob_end_clean();
    echo json_encode([
        'message' => 'FACTURA YA ANULADA',
		'status'  => false,
        'type' 	  => 'error'
    ]);
}
?>
