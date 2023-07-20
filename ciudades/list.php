<script type="text/javascript">
 function activar_input_salida_almacen(index){
  var check=document.getElementById("factura_seleccionada"+index);
  if(check.checked){
    document.getElementById("factura_seleccionada_s"+index).value=1;
  }else{
    document.getElementById("factura_seleccionada_s"+index).value=0;
  }
}
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
              <i class="material-icons">account_balance</i>
            </div>
            <h4 class="card-title"><b>MIS SUCURSALES</b></h4>            
          </div>
          <div class="card-body">  
            <div class="table-responsive">
              <table id="tablePaginatorHeaderFooter" class="table table-bordered table-condensed table-striped " style="width:100%">
                <thead>                  
                    <tr class='bg-dark text-white'>
                      <th>Codigo</th>
                      <th>Sucursal</th>
                      <th>Dirección</th>
                      <th>Ciudad</th>
                      <th>Entidad</th>
                      <th>Cod Impuestos<br></th>
                      <th>Actividad</th>
                      <th>Producto</th>
                      <th>Unidad</th>
                      <th></th></tr>
                </thead>
                <tbody>
                  <?php
                  $index=0;
                  $cod_tipoEmision=2;//tipo emision OFFLINE
                   $sql="SELECT c.codigo, c.cod_impuestos,c.cod_ciudad,c.descripcion,c.direccion,c.siat_codigoActividad,c.nombre_ciudad as ciudad,
                            de.nombre as entidad, c.siat_codigoProducto, c.siat_unidadProducto
                        FROM ciudades c 
                        LEFT JOIN datos_empresa de ON de.cod_empresa = c.cod_entidad
                        WHERE c.cod_entidad=$globalEntidad
                        AND c.cod_estado = 1";
                  
                  //echo $sql;
                  
                  $resp=mysqli_query($enlaceCon,$sql);
                  while($row=mysqli_fetch_array($resp)){ 
                    // echo "***";
                    $codigo = $row['codigo'];
                    $cod_ciudad=$row['cod_ciudad'];
                    $descripcion=$row['descripcion'];
                    $direccion=$row['direccion'];
                    $ciudad=$row['ciudad'];
                    $entidad=$row['entidad'];
                    $cod_impuestos=$row['cod_impuestos'];
                    $siat_codigoActividad=$row['siat_codigoActividad'];
                    $entidad=$row['entidad'];
                    $siat_codigoProducto=$row['siat_codigoProducto'];
                    $siat_unidadProducto=$row['siat_unidadProducto'];
                    $index++;
                      ?>
                    <tr>
                      <!-- <td class="td-actions text-right">                      
                        <input type="checkbox"  data-toggle="toggle" title="Seleccionar" id="input_seleccionado<?=$index?>" name="input_seleccionado<?=$index?>" >
                      </td> -->
                      <td class="text-center small"><?=$cod_ciudad;?></td>
                      <td class="text-left small"><?=$descripcion;?></td>
                      <td class="text-left small"><?=$direccion;?></td>
                      <td class="text-left small"><?=$ciudad;?></td>
                      <td class="text-left small"><?=$entidad;?></td>
                      <td class="text-center small"><?=$cod_impuestos;?></td>
                      <td class="text-center small"><?=$siat_codigoActividad;?></td>
                      <td class="text-center small"><?=$siat_codigoProducto;?></td>
                      <td class="text-center small"><?=$siat_unidadProducto;?></td>
                      <td class="td-actions">                       
                        <a href='#' class="btn btn-info btn-sm" onClick="location.href='config_form_edit.php?codigo=<?=$codigo;?>'"><i class="material-icons">settings</i>Config.</a>                       
                        <a href='#' class="btn btn-warning btn-sm" onClick="location.href='form_edit.php?codigo=<?=$codigo;?>'"><i class="material-icons">edit</i>Editar</a>
                        <a href='#' class="btn btn-danger btn-sm estado_registro" data-codigo="<?=$codigo;?>"><i class="material-icons">delete</i>Borrar</a>
                      </td>
                    </tr>
                    <?php   
                    
                  }?>
                </tbody>
              </table>              
            </div>
          </div>
          <div class="card-footer ">           
            <!-- <button class="btn btn-sm btn-success">Sincronizar</button> -->
            <button class="btn btn-sm btn-success" onClick="location.href='form_register.php'">Nuevo</button>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>


<script type="text/javascript">
    function valida(f) {
        var ok = true;
            // Swal.fire("Informativo!","PROCESANDO..", "warning");
            $(".cargar-ajax").removeClass("d-none");
            $("#texto_ajax_titulo").html("Procesando datos..");
        return ok;
    }
</script>

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
                    url:"sucursal_estado.php",
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