<?php

// if ($_SERVER['REQUEST_METHOD'] == 'GET') {//verificamos  metodo conexion
    
    // $idTabla=$_GET['t'];
    // $idRecibo=$_GET['i'];
    $arrayAnulacionEstado=array("estado"=>1);
    // $arrayAnulacionEstado=array("estado"=>"error al anular");
    // $arrayAnulacion=array("0"=>$arrayAnulacionEstado);
    $resultado=array("anula"=>$arrayAnulacionEstado);

    header('Content-type: application/json');
    echo json_encode($resultado); 
// }else{
//     $resultado=array(
//                 "estado"=>3,
//                 "mensaje"=>"ACCESO DENEGADO!. Usted no tiene permiso para ver este contenido.");
//     header('Content-type: application/json');
//     echo json_encode($resultado);
// }

