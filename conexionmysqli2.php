<?php

require_once 'config.php';

set_time_limit(0);
error_reporting(0);

if(isset($cod_entidad)){
	// echo "si:".$cod_entidad;
	if (!isset($_SESSION['globalEntidadSes'])) {
		$_SESSION['globalEntidadSes']=$cod_entidad;
		
	}
	
}

$enlaceCon=mysqli_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);


if (mysqli_connect_errno())
{
    echo "Error en la conexión: " . mysqli_connect_error();
}
mysqli_set_charset($enlaceCon,"utf8");


if (!function_exists('mysqli_result')) {
    function mysqli_result($result, $number, $field=0) {
        mysqli_data_seek($result, $number);
        $row = mysqli_fetch_array($result);
        return $row[$field];
    }
}
?>
