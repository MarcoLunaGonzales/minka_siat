<?php

require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");

$cod_ciudad  = $_POST['codigo'];

$nombre      = $_POST['nombre'];
$sucursal    = $_POST['sucursal'];
$direccion   = $_POST['direccion'];
$telefono    = $_POST['telefono'];
$ciudad      = $_POST['ciudad'];
$txt1        = $_POST['txt1'];
$txt2        = $_POST['txt2'];
$txt3        = $_POST['txt3'];
$nit         = $_POST['nit'];
$propietario = $_POST['propietario'];
$test        = $_POST['test'];

// Limpiar
$sqlDelete = "DELETE FROM configuracion_facturas WHERE cod_ciudad = $cod_ciudad";
mysqli_query($enlaceCon,$sqlDelete);

$datos = array(
    'nombre'      => $_POST['nombre'],
    'sucursal'    => $_POST['sucursal'],
    'direccion'   => $_POST['direccion'],
    'telefono'    => $_POST['telefono'],
    'ciudad'      => $_POST['ciudad'],
    'txt1'        => $_POST['txt1'],
    'txt2'        => $_POST['txt2'],
    'txt3'        => $_POST['txt3'],
    'nit'         => $_POST['nit'],
    'propietario' => $_POST['propietario'],
    'test'        => $_POST['test'],
);

// Inicializar el contador de ID
$id = 1;
// Array para almacenar las consultas de inserción
$sqlInserts = array();

// Generar las consultas de inserción 
foreach ($datos as $tipo => $valor) {
    $sqlInserts[] = "INSERT INTO configuracion_facturas (id, tipo, valor, codigo, cod_ciudad)
                     VALUES ('$id', '$tipo', '$valor', '$id', '$cod_ciudad')";
    $id++;
}
// Ejecutar las consultas de inserción en la base de datos
foreach ($sqlInserts as $sqlInsert) {
    mysqli_query($enlaceCon, $sqlInsert);
}

echo "<script language='Javascript'>
    alert('El proceso se completo correctamente.');
    location.href='list.php';
    </script>";
?>