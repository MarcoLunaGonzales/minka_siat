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
            <h4 class="card-title"><b>CONFIGURACIÓN</b></h4>            
          </div>
          <div class="card-body">  
            <div class="table-responsive">
              <table id="tablePaginatorHeaderFooter" class="table table-bordered table-condensed table-striped " style="width:100%">
                <thead>                  
                    <tr class='bg-dark text-white'>
                      <th>ID Configuración</th>
                      <th>Valor</th>
                      <th>Glosa</th>
                      <th>Descripción</th>
                      <th></th></tr>
                </thead>
                <tbody>
                  <?php
                  $index=0;
                  $cod_tipoEmision=2;//tipo emision OFFLINE
                   $sql="SELECT c.id_configuracion, c.valor_configuracion, c.glosa, c.descripcion
                        FROM configuraciones c";
                  
                  $resp=mysqli_query($enlaceCon,$sql);
                  while($row=mysqli_fetch_array($resp)){
                    $id_configuracion    = $row['id_configuracion'];
                    $valor_configuracion = $row['valor_configuracion'];
                    $glosa               = $row['glosa'];
                    $descripcion         = $row['descripcion'];
                      ?>
                    <tr>
                      <td class="text-center small"><?=$id_configuracion;?></td>
                      <td class="text-left small"><?=$valor_configuracion;?></td>
                      <td class="text-left small"><?=$glosa;?></td>
                      <td class="text-left small"><?=$descripcion;?></td>
                      <td class="td-actions">                       
                        <a href='#' class="btn btn-info btn-sm" onClick="location.href='form_edit.php?codigo=<?=$id_configuracion;?>'"><i class="material-icons">edit</i>Editar</a>
                      </td>
                    </tr>
                    <?php   
                    
                  }?>
                </tbody>
              </table>              
            </div>
          </div>
          <div class="card-footer ">
            <button class="btn btn-sm btn-success" onClick="location.href='form_register.php'">Nuevo</button>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>