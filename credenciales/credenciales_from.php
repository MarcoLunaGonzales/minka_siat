<?php
require("../estilos_almacenes.inc");

$nombre_sistema = "";
$codigo_sistema = "";
$tipo_sistema   = "";
$nit            = "";
$token          = "";
$fecha_limite   = "";
$razon_social   = "";
?>

<div class="content">
  <div class="container-fluid">
    <div class="col-md-12">
      <form id="form1" class="form-horizontal" action="credenciales_save.php" method="post" >
      <div class="card" style="background:  #e8daef ">
        <div class="card-header  card-header-text">
        <div class="card-text">
          <h4 class="card-title">Registro de Credenciales</h4>
        </div>
        </div>
        <div class="card-body ">
        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Nombre Sistema (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" name="nombre_sistema" id="nombre_sistema" required="true" value="<?=$nombre_sistema;?>" required="true"/>
            </div>
            </div>
            <!--fin campo  -->
            <label style="color:#566573;" class="col-sm-2 col-form-label">Codigo Sistema (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" name="codigo_sistema" id="codigo_sistema" required="true" value="<?=$codigo_sistema;?>"/>
            </div>
            </div>
        </div><!--fin campo  -->

        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Tipo Sistema (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" name="tipo_sistema" id="tipo_sistema" required="true" value="<?=$tipo_sistema;?>" required="true" placeholder="PROPIO, PROVEEDOR"/>
            </div>
            </div>
            <!--fin campo  -->
            <label style="color:#566573;" class="col-sm-2 col-form-label">Nit (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" name="nit" id="nit" required="true" value="<?=$nit;?>"/>
            </div>
            </div>
        </div><!--fin campo  --> 

        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Razon Social (*)</label>
            <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="razon_social" id="razon_social" required="true" value="<?=$razon_social;?>" required="true"/>
                </div>
            </div>
            <label style="color:#566573;" class="col-sm-2 col-form-label">Empresa (*)</label>
            <div class="col-sm-4">
                <select class="selectpicker form-control" data-style="btn btn-primary" name="empresa" id="empresa" data-live-search="true" required="true">
                    <option disabled selected value="">Seleccionar Empresa</option>
                    <?php
                        $sql="select e.cod_empresa, e.nombre from datos_empresa e order by 2";
                        $resp=mysqli_query($enlaceCon, $sql);
                        while ($dat = mysqli_fetch_array($resp)) {
                            $codigoX=$dat[0];
                            $nombreX=$dat[1];
                        ?>
                        <option value="<?=$codigoX;?>"><?=$nombreX;?></option>  
                        <?php
                        }
                        ?>
                </select>
            </div>
        </div><!--fin campo  -->           

        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Fecha Limite (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="date" name="fecha_limite" id="fecha_limite" required="true" value="<?=$fecha_limite;?>" required="true"/>
            </div>
            </div>

            <label style="color:#566573;" class="col-sm-2 col-form-label">Modalidad (*)</label>
            <div class="col-sm-4">
                <select class="selectpicker form-control" data-style="btn btn-primary" name="modalidad" id="modalidad" data-live-search="true" required="true">
                    <option disabled selected value="">Seleccionar Modalidad</option>
                    <?php
                        $sql="select codigo, nombre from tipos_modalidadfacturacion order by 2";
                        $resp=mysqli_query($enlaceCon, $sql);
                        while ($dat = mysqli_fetch_array($resp)) {
                            $codigoX=$dat[0];
                            $nombreX=$dat[1];
                        ?>
                        <option value="<?=$codigoX;?>"><?=$nombreX;?></option>  
                        <?php
                        }
                        ?>
                </select>
            </div>            
        </div><!--fin campo  -->           

        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Token delegado (*)</label>
            <div class="col-sm-10">
            <div class="form-group">
                <textarea class="form-control"  type="text" name="token" id="token" required="true"><?=$token;?></textarea>                
            </div>
            </div>            
        </div><!--fin campo  -->       

        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Archivo Llave Publica</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" name="llave_publica" id="llave_publica"/>
            </div>
            </div>
            <!--fin campo  -->
            <label style="color:#566573;" class="col-sm-2 col-form-label">Archivo Llave Privada</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" name="llave_privada" id="llave_privada"/>
            </div>
            </div>
        </div><!--fin campo  --> 
    

        </div>
        <div class="card-footer ml-auto mr-auto">
        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
          </div>
      </div>
      </form>
    </div>
  
  </div>
</div>