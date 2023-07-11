<?php

require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");

$codigo              = $_POST['codigo'];

$cod_ciudad          = $_POST['cod_ciudad'];
$descripcion         = $_POST['descripcion'];
$tipo                = 1;
$cod_impuestos       = 0;
$direccion           = $_POST['direccion'];
$nombre_ciudad       = $_POST['nombre_ciudad'];
$siat_codigoActividad= $_POST['siat_codigoActividad'];
$siat_codigoProducto = $_POST['siat_codigoProducto'];
$siat_unidadProducto = $_POST['siat_unidadProducto'];
$cod_entidad         = $_POST['cod_entidad'];
$cod_externo         = 0;
$siat_unidadMedida   = $_POST['siat_unidadMedida'];


$sqlUpdate = "UPDATE ciudades SET 
                cod_ciudad = '$cod_ciudad',
                descripcion = '$descripcion',
                tipo = '$tipo',
                cod_impuestos = '$cod_impuestos',
                direccion = '$direccion',
                nombre_ciudad = '$nombre_ciudad',
                siat_codigoActividad = '$siat_codigoActividad',
                siat_codigoProducto = '$siat_codigoProducto',
                siat_unidadProducto = '$siat_unidadProducto',
                cod_entidad = '$cod_entidad',
                cod_externo = '$cod_externo',
                siat_unidadMedida = '$siat_unidadMedida'
            WHERE codigo = '$codigo'";


mysqli_query($enlaceCon,$sqlUpdate);

echo "<script language='Javascript'>
    alert('El proceso se completo correctamente.');
    location.href='list.php';
    </script>";
?>