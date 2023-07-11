<?php

require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");

$nombre_sistema=$_POST['nombre_sistema'];
$codigo_sistema=$_POST['codigo_sistema'];
$tipo_sistema=$_POST['tipo_sistema'];

$nit=$_POST['nit'];
$razon_social=$_POST['razon_social'];
$token=$_POST['token'];
$fecha_limite=$_POST['fecha_limite'];

$modalidad_facturacion=$_POST['modalidad'];
$empresa=$_POST['empresa'];

$llave_publica=$_POST['llave_publica'];
$llave_privada=$_POST['llave_privada'];

$sqlInsert="INSERT INTO siat_credenciales (nombre_sistema,codigo_sistema,tipo_sistema,nit,razon_social,token_delegado,fecha_limite,cod_estado, cod_entidad, modalidad, cert_privatekey, cert_publickey) VALUES ('$nombre_sistema','$codigo_sistema','$tipo_sistema','$nit','$razon_social','$token','$fecha_limite',1,'$empresa','$modalidad_facturacion','$llave_privada','$llave_publica')";

//echo  $sqlInsert;

mysqli_query($enlaceCon,$sqlInsert);

/*echo "<script language='Javascript'>
    alert('El proceso se completo correctamente.');
    location.href='credenciales_list.php';
    </script>";
*/
?>