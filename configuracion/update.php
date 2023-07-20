<?php

require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");

$codigo              = $_POST['codigo'];

$valor_configuracion = $_POST['valor_configuracion'];
$glosa               = $_POST['glosa'];
$descripcion         = $_POST['descripcion'];

// Actualizar Valores
$sqlUpdate = "UPDATE configuraciones SET 
                valor_configuracion = '$valor_configuracion',
                glosa = '$glosa',
                descripcion = '$descripcion'
            WHERE id_configuracion = '$codigo'";
mysqli_query($enlaceCon,$sqlUpdate);

echo "<script language='Javascript'>
    alert('El proceso se completo correctamente.');
    location.href='list.php';
    </script>";
?>