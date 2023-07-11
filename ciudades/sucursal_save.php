<?php

require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");

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


$sqlInsert="INSERT INTO ciudades (cod_ciudad,descripcion,tipo,cod_impuestos,direccion,nombre_ciudad,siat_codigoActividad,siat_codigoProducto,siat_unidadProducto,cod_entidad,cod_externo,siat_unidadMedida) 
            VALUES ('$cod_ciudad','$descripcion','$tipo','$cod_impuestos','$direccion','$nombre_ciudad','$siat_codigoActividad','$siat_codigoProducto','$siat_unidadProducto','$cod_entidad','$cod_externo','$siat_unidadMedida')";

mysqli_query($enlaceCon,$sqlInsert);

echo "<script language='Javascript'>
    alert('El proceso se completo correctamente.');
    location.href='list.php';
    </script>";
?>