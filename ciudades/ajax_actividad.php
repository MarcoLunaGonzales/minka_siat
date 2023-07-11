<?php

require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");
ob_clean(); // Limpiar el búfer de salida

$cod_entidad = $_POST['cod_entidad'];

/**
 * Lista de Actividades
 */
$sql_select = "SELECT ssa.codigoCaeb, ssa.descripcion
                FROM siat_sincronizaractividades ssa 
                WHERE ssa.cod_entidad='$cod_entidad'
                ORDER BY 2";
$result = mysqli_query($enlaceCon, $sql_select);
$data   = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode(array(
    'status'  => true,
    'message' => 'Lista de actividades SIAT.',
    'data'    => $data
));
?>