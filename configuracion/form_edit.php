<?php
require("../estilos_almacenes.inc");

$globalIdEntidad = $_COOKIE['globalIdEntidad'];

$codigo              = $_GET['codigo'];

$id_configuracion    = '';
$valor_configuracion = '';
$glosa               = '';
$descripcion         = '';

$sql  = "SELECT c.id_configuracion, c.valor_configuracion, c.glosa, c.descripcion
            FROM configuraciones c
            WHERE id_configuracion = '$codigo'";
$resp = mysqli_query($enlaceCon, $sql);
while ($data = mysqli_fetch_array($resp)) {
    $id_configuracion    = $data['id_configuracion'];
    $valor_configuracion = $data['valor_configuracion'];
    $glosa               = $data['glosa'];
    $descripcion         = $data['descripcion'];
}
?>

<div class="content">
  <div class="container-fluid">
    <div class="col-md-12">
      <form id="form1" class="form-horizontal" action="update.php" method="post" >

        <!-- Registor de Modificación -->
        <input type="hidden" value="<?=$codigo;?>" name="codigo">

      <div class="card" style="background:  #e8daef ">
        <div class="card-header  card-header-text">
        <div class="card-text">
          <h4 class="card-title">Editar Valores</h4>
        </div>
        </div>
        <div class="card-body ">
        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Valor Config. (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" name="valor_configuracion" id="valor_configuracion" required="true" value="<?=$valor_configuracion;?>" placeholder="Ingrese el valor de configuración" required="true"/>
            </div>
            </div>
            <label style="color:#566573;" class="col-sm-2 col-form-label">Glosa (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" readonly="true" name="glosa" id="glosa" required="true" value="<?=$glosa;?>" placeholder="Ingrese glosa"/>
            </div>
            </div>
        </div><!--fin campo  -->

        <div class="row">
            <!--fin campo  -->
            <label style="color:#566573;" class="col-sm-2 col-form-label">Descripción (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" readonly="true" name="descripcion" id="descripcion" required="true" value="<?=$descripcion;?>" placeholder="Ingrese descripción"/>
            </div>
            </div>
        </div><!--fin campo  --> 

        </div>
        <div class="card-footer ml-auto mr-auto">
        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
        <button type="button" class="btn btn-danger btn-sm" onClick="location.href='list.php'">Volver</button>
          </div>
      </div>
      </form>
    </div>
  
  </div>
</div>