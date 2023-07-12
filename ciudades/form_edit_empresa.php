<?php
require("../estilos_almacenes.inc");

$codigo              = $_GET['codigo'];

$cod_ciudad          = '';
$descripcion         = '';
$direccion           = '';

$sql  = "SELECT cod_empresa, nombre, nit, direccion FROM datos_empresa WHERE cod_empresa = '$codigo'";
$resp = mysqli_query($enlaceCon, $sql);
while ($data = mysqli_fetch_array($resp)) {
    $nombre = $data['nombre'];
    $nit = $data['nit'];
    $direccion = $data['direccion'];
}

?>

<div class="content">
  <div class="container-fluid">
    <div class="col-md-12">
      <form id="form1" class="form-horizontal" action="empresa_update.php" method="post" >

        <!-- Registor de Modificación -->
        <input type="hidden" value="<?=$codigo;?>" name="codigo">

      <div class="card" style="background:  #e8daef ">
        <div class="card-header  card-header-text">
        <div class="card-text">
          <h4 class="card-title">Actualizar Datos de Empresa</h4>
        </div>
        </div>
        <div class="card-body ">
        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Nombre (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" name="nombre" id="nombre" required="true" value="<?=$nombre;?>" placeholder="Ingrese el nombre de la empresa" required="true"/>
            </div>
            </div>
            <label style="color:#566573;" class="col-sm-2 col-form-label">NIT (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="number" name="nit" id="nit" required="true" value="<?=$nit;?>" placeholder="Ingrese el NIT" required="true"/>
            </div>
            </div>
        </div><!--fin campo  -->

        <div class="row">
            <!--fin campo  -->
            <label style="color:#566573;" class="col-sm-2 col-form-label">Dirección (*)</label>
            <div class="col-sm-8">
            <div class="form-group">
                <input class="form-control" type="text" name="direccion" id="direccion" required="true" value="<?=$direccion;?>" placeholder="Ingresar dirección"/>
            </div>
            </div>
        </div><!--fin campo  -->  


        </div>
        <div class="card-footer ml-auto mr-auto">
        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
        <button type="button" class="btn btn-danger btn-sm" onClick="location.href='empresas_list.php'">Volver</button>
          </div>
      </div>
      </form>
    </div>
  
  </div>
</div>