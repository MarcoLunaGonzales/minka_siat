<?php

require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");
ob_clean(); // Limpiar el búfer de salida

$codigo  = $_POST['codigo'];

$sql_upd = "UPDATE siat_credenciales 
            SET cod_estado = 2 
            WHERE id='$codigo'";
mysqli_query($enlaceCon,$sql_upd);

echo json_encode(array(
    'status'  => true,
    'message' => 'Estado modificado exitosamente.',
));
?>