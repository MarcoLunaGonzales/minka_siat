<?php

// SERVICIO WEB PARA FACTURAS
if ($_SERVER['REQUEST_METHOD'] == 'POST') {//verificamos  metodo conexion
    $datos = json_decode(file_get_contents("php://input"), true); 
    //Parametros de consulta
    $accion=NULL;
    if(isset($datos['accion'])&&isset($datos['sIdentificador'])&&isset($datos['sKey'])){//verificamos existencia de datos de conexion
        if($datos['sIdentificador']=="MinkaSw123*"&&$datos['sKey']=="rrf656nb2396k6g6x44434h56jzx5g6"){//verificamos datos de conexion
            $accion=$datos['accion']; //recibimos la accion
            // $codPersonal=$datos['codPersonal'];//recibimos el codigo personal
            $estado=0;
            $mensaje="";
            if($accion=="verificarComunicacion"){//obtenemos las ciudades del cliente
                // try{
                    require_once '../conexionmysqli2.inc';
                    if(isset($datos['idEmpresa'])){
                        $idEmpresa=$datos['idEmpresa'];//
                        $nitEmpresa=$datos['nitEmpresa'];//
                        if(verificarExistenciaEmpresa($idEmpresa,$nitEmpresa,$enlaceCon)){
                            $DatosConexion=verificarComunicacion($idEmpresa,$nitEmpresa);//
                            if($DatosConexion[0]==1){
                                $resultado=array(
                                    "estado"=>1,
                                    "mensaje"=>"Conexion Establecida");
                            }else{
                                $resultado=array(
                                    "estado"=>2,
                                    "mensaje"=>"ERROR en servicio SIAT : ".$DatosConexion[1]);
                            }
                        }else{
                            $resultado=array(
                            "estado"=>4,
                            "mensaje"=>"ERROR. IdEmpresa o nitEmpresa inexistente");
                        }
                    }else{
                        $resultado=array(
                        "estado"=>4,
                        "mensaje"=>"ERROR. Variables incompletos");
                    }
                // }catch(Exception $e){
                //    $resultado=array(
                //     "estado"=>5,
                //     "mensaje"=>"Hubo un error al momento de consultar BD");
                // }
            }elseif($accion=="sincronizarParametricaTipoMetodoPago"){
                require_once '../conexionmysqli2.inc';
                if(isset($datos['nitEmpresa']) && isset($datos['nitEmpresa'])){                    
                    $idEmpresa=$datos['idEmpresa'];//
                    $nitEmpresa=$datos['nitEmpresa'];//
                    if(verificarExistenciaEmpresa($idEmpresa,$nitEmpresa,$enlaceCon)){
                        $listAccion=sincronizarParametros($accion,$idEmpresa,$enlaceCon);//
                        $totalComponentes=count($listAccion);
                        $resultado=array(
                            "estado"=>true,
                            "mensaje"=>"Tipos de pago obtenido correctamente", 
                            "datosPersonal"=>$listAccion, 
                            "totalComponentes"=>$totalComponentes
                            );
                    }else{
                        $resultado=array(
                        "estado"=>4,
                        "mensaje"=>"ERROR. IdEmpresa o nitEmpresa inexistente");
                    }
                }else{
                    $resultado=array(
                    "estado"=>4,
                    "mensaje"=>"ERROR. Variables incompletos");
                }

            }elseif($accion=="sincronizarParametricaTipoDocumentoIdentidad"){
                require_once '../conexionmysqli2.inc';
                if(isset($datos['nitEmpresa']) && isset($datos['nitEmpresa'])){                    
                    $idEmpresa=$datos['idEmpresa'];//
                    $nitEmpresa=$datos['nitEmpresa'];//
                    if(verificarExistenciaEmpresa($idEmpresa,$nitEmpresa,$enlaceCon)){
                        $listAccion=sincronizarParametros($accion,$idEmpresa,$enlaceCon);//
                        $totalComponentes=count($listAccion);
                        $resultado=array(
                            "estado"=>true,
                            "mensaje"=>"Tipos de pago obtenido correctamente", 
                            "datosPersonal"=>$listAccion, 
                            "totalComponentes"=>$totalComponentes
                            );
                    }else{
                        $resultado=array(
                        "estado"=>4,
                        "mensaje"=>"ERROR. IdEmpresa o nitEmpresa inexistente");
                    }
                }else{
                    $resultado=array(
                    "estado"=>4,
                    "mensaje"=>"ERROR. Variables incompletos");
                }

            }else{
                $resultado=array(
                    "estado"=>4,
                    "mensaje"=>"ERROR. No existe la Accion Solicitada.", 
                    "lstPlanillasRetroactivo"=>null, 
                    "totalComponentes"=>0
                    );
            }
        }else{
            $resultado=array(
                "estado"=>3,
                "mensaje"=>"ACCESO DENEGADO!. Credenciales Incorrectos.");
        }
    }else{
        $resultado=array(
                "estado"=>3,
                "mensaje"=>"ACCESO DENEGADO!. Usted no tiene permiso para ver este contenido.");
    }
    header('Content-type: application/json');
    echo json_encode($resultado); 
}else{
    $resultado=array(
                "estado"=>3,
                "mensaje"=>"ACCESO DENEGADO!. Usted no tiene permiso para ver este contenido.");
    header('Content-type: application/json');
    echo json_encode($resultado);
}



function verificarExistenciaEmpresa($idEmpresa,$nitEmpresa,$enlaceCon){  
  require_once '../conexionmysqli2.inc';  
  $cons = "SELECT cod_empresa from datos_empresa where nit='$nitEmpresa' and cod_empresa='$idEmpresa'";
  $respCons = mysqli_query($enlaceCon,$cons);
  $value=false;
  while ($datCons = mysqli_fetch_array($respCons)) {
    $value=true;
  }
  return $value;
}

function verificarComunicacion($idEmpresa,$nitEmpresa){
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');  
  // require_once '../siat_folder/funciones_siat.php';
  $DatosConexion=verificarConexion();
  // if($DatosConexion[0]==1){
  //   return array(2,'Conexion Establecida');
  // }else{
  //   return array(2,'Error en serivcio SIAT');
  // }
  return $DatosConexion;
}
function sincronizarParametros($act,$cod_entidad,$enlaceCon){    
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');  
    // require_once '../siat_folder/funciones_siat.php';
    // sincronizarParametrosSiat($act,$cod_entidad);//sincroizamos desde el siat
    // echo $act;
    switch ($act) {
        case 'sincronizarActividades':                      
             $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizaractividades where cod_entidad=$cod_entidad order by codigo;";
               // echo $sql;
        break;
        case 'sincronizarListaActividadesDocumentoSector':
             $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizarlistaactividadesdocumentosector where cod_entidad=$cod_entidad order by codigo;";
                
        break;
        case 'sincronizarListaLeyendasFactura':
                 $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizarListaLeyendasFactura where (codigoActividad=$cod_entidad order by codigo;";
        break;
        case 'sincronizarListaMensajesServicios':
            $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizarlistamensajesservicios where cod_entidad=$cod_entidad order by codigo;";
                
               
        break;
        case 'sincronizarListaProductosServicios':
            $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizarlistaproductosservicios where cod_entidad=$cod_entidad order by codigo;";
                
             
        break;
        case 'sincronizarParametricaEventosSignificativos':
             $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizarparametricaeventossignificativos where cod_entidad=$cod_entidad order by codigo;";
                
                
        break;
        case 'sincronizarParametricaMotivoAnulacion':
             $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizarparametricamotivoanulacion where cod_entidad=$cod_entidad order by codigo;";
                
             
        break;
        case 'sincronizarParametricaTipoDocumentoIdentidad':
             $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizarparametricatipodocumentoidentidad where cod_entidad=$cod_entidad order by codigo;";
                
             
        break;
        case 'sincronizarParametricaTipoDocumentoSector':
            $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizarparametricatipodocumentosector where cod_entidad=$cod_entidad order by codigo;";
                
              
        break;
        case 'sincronizarParametricaTipoEmision':
            $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizarparametricatipoemision where cod_entidad=$cod_entidad order by codigo;";
                
              
        break;
        case 'sincronizarParametricaTipoMetodoPago':
             $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizarparametricatipometodopago where cod_entidad=$cod_entidad order by codigo;";
                
             
        break;
        case 'sincronizarParametricaTipoMoneda':
             $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizarparametricatipomoneda where cod_entidad=$cod_entidad order by codigo;";
        break;              
        default:
            // code...
            break;
    }
    // $sql="SELECT codigo,codigoClasificador,descripcion from siat_sincronizarparametricatipometodopago where cod_entidad=$cod_entidad order by codigo;";
    // echo $sql;
    $resp=mysqli_query($enlaceCon,$sql);
    $ff=0;
    $datos=[];
    while ($dat = mysqli_fetch_array($resp)) {
        $datos[$ff]['codigo']=$dat['codigo'];
        $datos[$ff]['codigoClasificador']=$dat['codigoClasificador'];
        $datos[$ff]['descripcion']=$dat['descripcion'];        
        $ff++;
    }    
    return $datos;
}




