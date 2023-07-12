<?php

require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");

$codigo              = $_POST['codigo'];

$nombre = $_POST['nombre'];
$nit = $_POST['nit'];
$direccion = $_POST['direccion'];

$sqlUpdate = "UPDATE datos_empresa SET nombre = '$nombre', nit = '$nit', direccion = '$direccion' 
            WHERE cod_empresa = '$codigo'";
mysqli_query($enlaceCon,$sqlUpdate);

echo "<script language='Javascript'>
        alert('Los datos se actualizaron.');
        location.href='empresas_list.php';
    </script>";
?>