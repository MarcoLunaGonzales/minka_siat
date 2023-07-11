<?php

require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");

$codigo                 = $_POST['codigo'];

$nombre_sistema         = $_POST['nombre_sistema'];
$codigo_sistema         = $_POST['codigo_sistema'];
$tipo_sistema           = $_POST['tipo_sistema'];

$nit                    = $_POST['nit'];
$razon_social           = $_POST['razon_social'];
$token                  = $_POST['token'];
$fecha_limite           = $_POST['fecha_limite'];

$modalidad_facturacion  = $_POST['modalidad'];
$empresa                = $_POST['empresa'];

$llave_publica          = $_POST['llave_publica'];
$llave_privada          = $_POST['llave_privada'];

$sql_upd = "UPDATE siat_credenciales SET 
            nombre_sistema = '$nombre_sistema',
            codigo_sistema = '$codigo_sistema',
            tipo_sistema = '$tipo_sistema',
            nit = '$nit',
            razon_social = '$razon_social',
            token_delegado = '$token',
            cod_entidad = '$empresa',
            fecha_limite = '$fecha_limite',
            modalidad = '$modalidad',
            cert_privatekey = '$llave_privada',
            cert_publickey = '$llave_publica'
            WHERE id='$codigo'";


mysqli_query($enlaceCon,$sql_upd);

echo "<script language='Javascript'>
    alert('El proceso se completo correctamente.');
    location.href='credenciales_list.php';
    </script>";
?>