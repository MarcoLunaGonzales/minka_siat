<?php

require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");
ob_clean(); // Limpiar el búfer de salida

$cod_entidad   = $_POST['cod_entidad'];
$cod_actividad = $_POST['cod_actividad'];

$sql_select = "SELECT sp.codigoProducto, CONCAT(LEFT(sp.descripcionProducto, 90),'...') as descripcionProducto
                FROM siat_sincronizarlistaproductosservicios sp 
                WHERE sp.cod_entidad='$cod_entidad'
                AND sp.codigoActividad='$cod_actividad'
                ORDER BY 2";
$result = mysqli_query($enlaceCon, $sql_select);
$data   = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode(array(
    'status'  => true,
    'message' => 'Lista de actividades SIAT.',
    'data'    => $data
));
?>