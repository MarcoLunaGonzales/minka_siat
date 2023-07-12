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
            <h4 class="card-title"><b>Mi Empresa</b></h4>            
          </div>
          <div class="card-body">  
            <div class="table-responsive">
              <table id="tablePaginatorHeaderFooter" class="table table-bordered table-condensed table-striped " style="width:100%">
                <thead>                  
                    <tr class='bg-dark text-white'>
                      <th>Codigo</th>
                      <th>Nombre Empresa</th>
                      <th>NIT</th>
                      <th>Direccion</th>
                      <th></th></tr>
                </thead>
                <tbody>
                  <?php
                  $index=0;
                  $cod_tipoEmision=2;//tipo emision OFFLINE
                  $sql="SELECT e.cod_empresa, e.nombre, e.nit, e.direccion from datos_empresa e";
                  // echo $sql;
                  $resp=mysqli_query($enlaceCon,$sql);
                  while($row=mysqli_fetch_array($resp)){ 
                    // echo "***";
                    $codigo = $row['cod_empresa'];
                    $descripcion=$row['nombre'];
                    $nit=$row['nit'];
                    $direccion=$row['direccion'];
                    $index++;
                      ?>
                    <tr>
                      <td class="text-center small"><?=$codigo;?></td>
                      <td class="text-left small"><?=$descripcion;?></td>
                      <td class="text-left small"><?=$nit;?></td>
                      <td class="text-center small"><?=$direccion;?></td>
                      <td class="td-actions">                        
                        <a href='#' class="btn btn-warning btn-sm" onClick="location.href='form_edit_empresa.php?codigo=<?=$codigo;?>'"><i class="material-icons">edit</i>Editar</a>
                      </td>
                    </tr>
                    <?php   
                    
                  }?>
                </tbody>
              </table>              
            </div>
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