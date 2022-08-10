<?php 
//LLAVES DE ACCESO AL WS
$sIde = "MinkaSw123*";
$sKey = "rrf656nb2396k6g6x44434h56jzx5g6";

///verificar conexion
  // $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, 
  //           "accion"=>"verificarComunicacion", //Nuevo contacto de empresa
  //           "idEmpresa"=>2, //ID de empresa, otorgado por minkasoftware
  //           "nitEmpresa"=>'10916889016' //nit  de empresa
  //         );  


  //Lista de Tipos de Pago

  // $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, 
  //           "accion"=>"sincronizarParametricaTipoMetodoPago", //
  //           "idEmpresa"=>2, //ID de empresa, otorgado por minkasoftware
  //           "nitEmpresa"=>'10916889016' //nit  de empresa
  //         );

  //Lista de Tipos documento

  // $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, 
  //         "accion"=>"sincronizarParametricaTipoDocumentoIdentidad", //
  //         "idEmpresa"=>2, //ID de empresa, otorgado por minkasoftware
  //         "nitEmpresa"=>'10916889016' //nit  de empresa
  //       );  


  //VERIFICACION CUFD
  $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, 
          "accion"=>"verificarCUFDEmpresa", //
          "idEmpresa"=>2, //ID de empresa, otorgado por minkasoftware
          "nitEmpresa"=>'10916889016', //nit  de empresa
          "codSucursal"=>'1' //COD SUCURSAL
        );  

    

    $datos=json_encode($parametros);
    // abrimos la sesión cURL
    $ch = curl_init();
    // definimos la URL a la que hacemos la petición  
    curl_setopt($ch, CURLOPT_URL,"http://localhost:8090/minka_siat/wsminka/ws_operaciones.php"); // local
    // indicamos el tipo de petición: POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    // cerramos la sesión cURL
    curl_close ($ch);
    // imprimir en formato JSON
    header('Content-type: application/json');   
    print_r($remote_server_output);   



      
  
?>
