<?php
require "../siat_folder/funciones_siat.php";
require "../conexionmysqli.inc";

$fecha = date('Y-m-d');

// Consulta para obtener los datos
$sql = "SELECT pv.cod_ciudad, pv.codigoPuntoVenta, pv.cod_entidad 
        FROM siat_puntoventa pv";
$resp = mysqli_query($enlaceCon, $sql);

if ($resp) {
    // Almacena los resultados en un array
    $index = 0;
    while ($row = mysqli_fetch_assoc($resp)) {
        $cod_ciudad       = $row['cod_ciudad'];
        $codigoPuntoVenta = $row['codigoPuntoVenta'];
        $cod_entidad      = $row['cod_entidad'];

        $sql_ciudad = "SELECT c.cod_impuestos,
                            pv.codigoPuntoVenta,
                            (SELECT cfd.cufd
                                FROM siat_cufd cfd
                                WHERE cfd.estado = 1
                                AND cfd.cod_entidad = '$cod_entidad'
                                AND cfd.cod_ciudad = c.cod_ciudad
                                AND DATE(cfd.fecha) = '$fecha'
                                ORDER BY cfd.created_at DESC
                                LIMIT 1) as cufd
                        FROM ciudades c 
                        LEFT JOIN siat_puntoventa pv ON pv.cod_ciudad = c.cod_ciudad
                        WHERE c.cod_ciudad = '$cod_ciudad' 
                        AND c.cod_entidad = '$cod_entidad'";
        // echo $sql_ciudad."<br>";
        $resp_ciudad = mysqli_query($enlaceCon, $sql_ciudad);
        $row_ciudad  = mysqli_fetch_array($resp_ciudad);
        $cod_impuestos    = $row_ciudad['cod_impuestos'];
        $codigoPuntoVenta = $row_ciudad['codigoPuntoVenta'];
        $cuis             = obtenerCuis_vigente_BD($cod_ciudad, $cod_entidad);

        /*******************************
         * ? VERIFICA SI YA EXISTE CUFD
         *******************************/
        if(empty($row_ciudad['cufd']) || is_null($row_ciudad['cufd'])){
            $index++;
            deshabilitarCufd($cod_ciudad, $cuis, $fecha, $cod_entidad);
            generarCufd($cod_ciudad, $cod_impuestos, $codigoPuntoVenta, $cod_entidad);
            echo "<br> <b>[$index] * CUFD </b>generado exitosamente para ciudad: $cod_ciudad, entidad: $cod_entidad <br>";
        }
    }
    echo "<br><b>Finalizó proceso de 'Generación de CUFD' | Cantidad: $index</b>";
} else {
    // Manejo de error en caso de fallo en la consulta
    echo "Error en la consulta: " . mysqli_error($enlaceCon);
}

