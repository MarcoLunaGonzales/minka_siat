<?php
require("../conexionmysqli.inc");
require("../funciones.php");
require("../siat_folder/funciones_siat.php");

ob_clean();
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('America/La_Paz');

function responderJson($status, $message, $extra = [])
{
    echo json_encode(array_merge([
        'status'  => $status,
        'message' => $message
    ], $extra));
    exit;
}

function obtenerMensajeRespuestaSiat($respuesta)
{
    if (is_array($respuesta)) {
        if (isset($respuesta[1])) {
            return $respuesta[1];
        }

        if (isset($respuesta[0]->RespuestaServicioFacturacion->codigoDescripcion)) {
            return $respuesta[0]->RespuestaServicioFacturacion->codigoDescripcion;
        }
    }

    if (is_object($respuesta)) {
        if (isset($respuesta->RespuestaServicioFacturacion->codigoDescripcion)) {
            return $respuesta->RespuestaServicioFacturacion->codigoDescripcion;
        }
    }

    return 'Respuesta SIAT no identificada.';
}

function anulacionConfirmadaSiat($respuesta)
{
    /*
     * Compatibilidad con respuesta antigua:
     * $respEvento[0] == 1
     */
    if (is_array($respuesta) && isset($respuesta[0]) && $respuesta[0] == 1) {
        return true;
    }

    /*
     * Compatibilidad con respuesta tipo:
     * stdClass Object (
     *   [RespuestaServicioFacturacion] => stdClass Object (
     *      [codigoDescripcion] => ANULACION CONFIRMADA
     *      [codigoEstado] => 905
     *      [transaccion] => 1
     *   )
     * )
     */
    $obj = null;

    if (is_object($respuesta)) {
        $obj = $respuesta;
    } elseif (is_array($respuesta) && isset($respuesta[0]) && is_object($respuesta[0])) {
        $obj = $respuesta[0];
    }

    if ($obj && isset($obj->RespuestaServicioFacturacion)) {
        $resp = $obj->RespuestaServicioFacturacion;

        $transaccion = isset($resp->transaccion) ? (int)$resp->transaccion : 0;
        $descripcion = isset($resp->codigoDescripcion) ? strtoupper(trim($resp->codigoDescripcion)) : '';

        if ($transaccion === 1) {
            return true;
        }

        if ($descripcion === 'ANULACION CONFIRMADA') {
            return true;
        }
    }

    return false;
}

try {
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true);

    if (!is_array($data)) {
        $data = $_POST;
    }

    $sIdentificador = isset($data['sIdentificador']) ? trim($data['sIdentificador']) : '';
    $sKey           = isset($data['sKey']) ? trim($data['sKey']) : '';
    $accion         = isset($data['accion']) ? trim($data['accion']) : '';
    $idTransaccion  = isset($data['idTransaccion_siat']) ? (int)$data['idTransaccion_siat'] : 0;

    if ($sIdentificador !== 'MinkaSw123*' || $sKey !== 'rrf656nb2396k6g6x44434h56jzx5g6') {
        responderJson(false, 'Credenciales inválidas.');
    }

    if ($accion !== 'anularFacturaElectronica') {
        responderJson(false, 'Acción inválida.');
    }

    if ($idTransaccion <= 0) {
        responderJson(false, 'No se recibió un idTransaccion_siat válido.');
    }

    $fechaActual = date('Y-m-d');

    $sql = "
        SELECT 
            s.cod_salida_almacenes,
            s.fecha,
            s.siat_cuf,
            s.cod_almacen,
            s.salida_anulada,
            s.nro_correlativo,
            s.cod_cliente,
            s.nit,
            s.siat_codigotipodocumentoidentidad,
            s.siat_estado_facturacion,
            s.siat_complemento,
            s.siat_fechaemision,
            s.idtabla,
            s.idrecibo,
            a.cod_ciudad,
            (
                SELECT c.cod_impuestos 
                FROM ciudades c 
                WHERE c.cod_ciudad = a.cod_ciudad
            ) AS cod_impuestos,
            (
                SELECT c.nombre_ciudad 
                FROM ciudades c 
                WHERE c.cod_ciudad = a.cod_ciudad
            ) AS nombre_ciudad,
            (
                SELECT cli.nombre_cliente 
                FROM clientes cli 
                WHERE cli.cod_cliente = s.cod_cliente
            ) AS cliente
        FROM salida_almacenes s
        INNER JOIN almacenes a ON s.cod_almacen = a.cod_almacen
        WHERE s.cod_salida_almacenes = '$idTransaccion'
        LIMIT 1
    ";

    $resp = mysqli_query($enlaceCon, $sql);

    if (!$resp) {
        responderJson(false, 'Error al consultar la transacción SIAT: ' . mysqli_error($enlaceCon));
    }

    if (mysqli_num_rows($resp) == 0) {
        responderJson(false, 'No se encontró la transacción SIAT indicada.');
    }

    $dat = mysqli_fetch_assoc($resp);

    if ((int)$dat['salida_anulada'] === 1) {
        responderJson(true, 'La factura SIAT ya se encontraba anulada.', [
            'already_annulled' => true,
            'idTransaccion_siat' => $idTransaccion
        ]);
    }

    $cuf = trim($dat['siat_cuf']);

    if ($cuf === '') {
        responderJson(false, 'La transacción SIAT no tiene CUF registrado.');
    }

    $codCiudad    = (int)$dat['cod_ciudad'];
    $codImpuestos = (int)$dat['cod_impuestos'];

    $codigoPuntoVenta = obtenerPuntoVenta_BD($codCiudad);
    $cuis             = obtenerCuis_siat($codigoPuntoVenta, $codImpuestos);
    $cufd             = obtenerCufd_Vigente_BD($codCiudad, $fechaActual, $cuis);

    if ($cuis == '0' || $cufd == '0' || $cuis == '' || $cufd == '') {
        responderJson(false, 'CUIS o CUFD inválido para la fecha actual.');
    }

    $respuestaSiat = anulacionFactura_siat(
        $codigoPuntoVenta,
        $codImpuestos,
        $cuis,
        $cufd,
        $cuf
    );

    $mensajeSiat = obtenerMensajeRespuestaSiat($respuestaSiat);
    $okSiat      = anulacionConfirmadaSiat($respuestaSiat);

    if (!$okSiat) {
        responderJson(false, 'SIAT rechazó la anulación: ' . $mensajeSiat, [
            'respuesta_siat' => $respuestaSiat
        ]);
    }

    $sqlUpdate = "
        UPDATE salida_almacenes 
        SET 
            salida_anulada = 1,
            estado_salida = 3
        WHERE cod_salida_almacenes = '$idTransaccion'
    ";

    $respUpdate = mysqli_query($enlaceCon, $sqlUpdate);

    if (!$respUpdate) {
        responderJson(false, 'SIAT anuló la factura, pero falló la actualización local SIAT: ' . mysqli_error($enlaceCon));
    }

    responderJson(true, $mensajeSiat, [
        'idTransaccion_siat' => $idTransaccion,
        'respuesta_siat' => $respuestaSiat
    ]);

} catch (Exception $e) {
    responderJson(false, 'Error: ' . $e->getMessage());
}