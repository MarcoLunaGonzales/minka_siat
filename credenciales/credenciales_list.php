<script type="text/javascript">
 
</script>

<?php //ESTADO FINALIZADO
require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");
$globalEntidad=$_COOKIE['globalIdEntidad'];
?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-icon">
            <div class="card-icon">              
              <i class="material-icons">account_balance_wallet</i>
            </div>
            <h4 class="card-title"><b>MIS CREDENCIALES</b></h4>            
          </div>
          <div class="card-body">  
            <div class="table-responsive">
              <table id="tablePaginatorHeaderFooter" class="table table-bordered table-condensed table-striped " style="width:100%">
                <thead>                  
                    <tr class='bg-dark text-white'>
                      <th>-</th>
                      <th>Nombre Sis</th>
                      <th>Codigo Sis</th>
                      <th>Nit</th>
                      <th>Razon Social</th>
                      <th>Empresa</th>
                      <th>Modalidad</th>
                      <!--th>Token</th-->
                      <th>Fecha Limite</th>
                      <th>Llave Publica</th>
                      <th>Llave Privada</th>
                      <th>Estado</th>
                      <th></th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                  $index=0;
                  $cod_tipoEmision=2;//tipo emision OFFLINE
                   $sql="SELECT s.id,s.nombre_sistema,s.codigo_sistema,s.tipo_sistema,s.nit,s.razon_social,s.token_delegado,s.fecha_limite,s.cod_estado, (select e.nombre from datos_empresa e where e.cod_empresa=s.cod_entidad)as empresa, (select mf.nombre from tipos_modalidadfacturacion mf where mf.codigo=s.modalidad)as modalidad, s.cert_publickey, s.cert_privatekey
                    from siat_credenciales s where cod_estado=1 order by fecha_limite";
                  
                  //echo $sql;
                  
                  $resp=mysqli_query($enlaceCon,$sql);
                  while($row=mysqli_fetch_array($resp)){ 
                    // echo "***";
                    $id=$row['id'];
                    $nombre_sistema=$row['nombre_sistema'];
                    $codigo_sistema=$row['codigo_sistema'];
                    $tipo_sistema=$row['tipo_sistema'];
                    $nit=$row['nit'];
                    $razon_social=$row['razon_social'];
                    $token_delegado=$row['token_delegado'];
                    $fecha_limite=$row['fecha_limite'];
                    $cod_estado=$row['cod_estado'];
                    $nombreEmpresa=$row['empresa'];
                    $nombreModalidad=$row['modalidad'];
                    $llavePublica=$row['cert_publickey'];
                    $llavePrivada=$row['cert_privatekey'];

                    switch ($cod_estado) {
                      case 1://activo
                      $nombre_estado="Activo";
                      $label="style='color:green;'";
                      break;
                      case 2://registro       
                      $nombre_estado="Registrado";                 
                      $label="style='color:blue;'";
                      break;
                      case 3://vencido          
                      $nombre_estado="Inactivo";              
                      $label="style='color:red;'";
                      break;
                    }                    
                    $index++;
                      ?>
                    <tr>                      
                      <td class="text-center small"><?=$index;?></td>
                      <td class="text-left small"><?=$nombre_sistema;?>(<?=$tipo_sistema?>)</td>
                      <td class="text-left small"><?=$codigo_sistema;?></td>
                      <td class="text-center small"><?=$nit;?></td>
                      <td class="text-left small"><?=$razon_social;?></td>
                      <td class="text-left small"><?=$nombreEmpresa;?></td>
                      <td class="text-left small"><?=$nombreModalidad;?></td>
                      <!-- <td class="text-left small"><?=$token_delegado;?></td> -->
                      <td class="text-left small"><?=$fecha_limite;?></td>
                      <td class="text-left small"><?=$llavePublica;?></td>
                      <td class="text-left small"><?=$llavePrivada;?></td>
                      <td class="text-left small" <?=$label?>><b><?=$nombre_estado;?></b></td>
                      <td class="td-actions">                        
                        <a href='credenciales_form_edit.php?codigo=<?=$id?>' class="btn btn-warning btn-sm"><i class="material-icons">edit</i>Editar</a>
                        <a href='#' class="btn btn-danger btn-sm estado_registro" data-codigo="<?=$id?>"><i class="material-icons">delete</i>Borrar</a>
                      </td>
                    </tr>
                    <?php   
                    
                  }?>
                </tbody>
              </table>              
            </div>
          </div>
          <div class="card-footer ">           
            <button class="btn btn-sm btn-success" onClick="location.href='credenciales_from.php?codigo=0'">Nuevo</button>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<script>
    /**
     * Modificación de Estado
     */
    $('body').on('click','.estado_registro', function(){
        let formData = new FormData();
        formData.append('codigo', $(this).data('codigo'));
        swal({
            title: '¿Estas seguro de cambiar estado?',
            text: "Se realizará modificará el estado.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            buttonsStyling: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url:"credenciales_estado.php",
                    type:"POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    success:function(response){
                    let resp = JSON.parse(response);
                    if(resp.status){
                        Swal.fire({
                            type: 'success',
                            title: 'Correcto!',
                            text: 'El proceso se completo correctamente!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(function(){
                            location.reload()
                        }, 2000);
                    }else{
                        Swal.fire('ERROR!','El proceso tuvo un problema!. Contacte con el administrador!','error'); 
                        }
                    }
                });
            }
        });
    });
</script>