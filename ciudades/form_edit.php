<?php
require("../estilos_almacenes.inc");

$globalIdEntidad = $_COOKIE['globalIdEntidad'];

$codigo              = $_GET['codigo'];

$cod_ciudad          = '';
$descripcion         = '';
$tipo                = '';
$cod_impuestos       = '';
$direccion           = '';
$nombre_ciudad       = '';
$siat_codigoActividad= '';
$siat_codigoProducto = '';
$siat_unidadProducto = '';
$cod_entidad         = '';
$cod_externo         = '';
$siat_unidadMedida   = '';

$sql  = "SELECT cod_ciudad,descripcion,tipo,cod_impuestos,direccion,nombre_ciudad,siat_codigoActividad,
            siat_codigoProducto,siat_unidadProducto,cod_entidad,cod_externo,siat_unidadMedida
        FROM ciudades
        WHERE codigo = '$codigo'";
$resp = mysqli_query($enlaceCon, $sql);
while ($data = mysqli_fetch_array($resp)) {
    $cod_ciudad           = $data['cod_ciudad'];
    $descripcion          = $data['descripcion'];
    $tipo                 = $data['tipo'];
    $cod_impuestos        = $data['cod_impuestos'];
    $direccion            = $data['direccion'];
    $nombre_ciudad        = $data['nombre_ciudad'];
    $siat_codigoActividad = $data['siat_codigoActividad'];
    $siat_codigoProducto  = $data['siat_codigoProducto'];
    $siat_unidadProducto  = $data['siat_unidadProducto'];
    $cod_entidad          = $data['cod_entidad'];
    $cod_externo          = $data['cod_externo'];
    $siat_unidadMedida    = $data['siat_unidadMedida'];
}
?>

<div class="content">
  <div class="container-fluid">
    <div class="col-md-12">
      <form id="form1" class="form-horizontal" action="sucursal_update.php" method="post" >

        <!-- Registor de Modificación -->
        <input type="hidden" value="<?=$codigo;?>" name="codigo">

      <div class="card" style="background:  #e8daef ">
        <div class="card-header  card-header-text">
        <div class="card-text">
          <h4 class="card-title">Registro de Credenciales</h4>
        </div>
        </div>
        <div class="card-body ">
        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Sucursal (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" name="descripcion" id="descripcion" required="true" value="<?=$descripcion;?>" placeholder="Ingrese el nombre de la sucursal" required="true"/>
            </div>
            </div>
            <label style="color:#566573;" class="col-sm-2 col-form-label">Cod Sucursal (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="number" name="cod_ciudad" id="cod_ciudad" required="true" value="<?=$cod_ciudad;?>" placeholder="Ingrese el codigo de sucursal" required="true" placeholder="PROPIO, PROVEEDOR"/>
            </div>
            </div>
        </div><!--fin campo  -->

        <div class="row">
            <!--fin campo  -->
            <label style="color:#566573;" class="col-sm-2 col-form-label">Dirección (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" name="direccion" id="direccion" required="true" value="<?=$direccion;?>" placeholder="Ingresar dirección"/>
            </div>
            </div>
            <label style="color:#566573;" class="col-sm-2 col-form-label">Ciudad (*)</label>
            <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="nombre_ciudad" id="nombre_ciudad" required="true" value="<?=$nombre_ciudad;?>" placeholder="Ingresar el nombre de la ciudad" required="true"/>
                </div>
            </div>
        </div><!--fin campo  --> 

        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Entidad (*)</label>
            <div class="col-sm-4">
                <select class="selectpicker form-control" data-style="btn btn-primary" name="cod_entidad" id="cod_entidad" data-live-search="true" required="true">
                    <option value="">Seleccione Entidad</option>
                    <?php
                        $sql="select e.cod_empresa, e.nombre from datos_empresa e order by 2";
                        $resp=mysqli_query($enlaceCon, $sql);
                        while ($dat = mysqli_fetch_array($resp)) {
                            $codigoX=$dat[0];
                            $nombreX=$dat[1];
                        ?>
                        <option value="<?=$codigoX;?>" <?=$codigoX==$cod_entidad?'selected':'';?>><?=$nombreX;?></option>  
                        <?php
                        }
                        ?>
                </select>
            </div>
            <label style="color:#566573;" class="col-sm-2 col-form-label">Codigo Actividad (*)</label>
            <div class="col-sm-4">
                <select class="selectpicker form-control" data-style="btn btn-primary" name="siat_codigoActividad" id="siat_codigoActividad" data-live-search="true" required="true">
                    <option value="">Seleccione Actividad</option>
                    <?php
                        $sql="SELECT ssa.codigoCaeb, ssa.descripcion
                                FROM siat_sincronizaractividades ssa 
                                WHERE ssa.cod_entidad='$cod_entidad'
                                ORDER BY 2";
                        $resp=mysqli_query($enlaceCon, $sql);
                        while ($dat = mysqli_fetch_array($resp)) {
                            $codigoX=$dat['codigoCaeb'];
                            $nombreX=$dat['descripcion'];
                        ?>
                        <option value="<?=$codigoX;?>" <?=$codigoX==$siat_codigoActividad?'selected':'';?>><?=$nombreX;?></option>  
                        <?php
                        }
                        ?>
                </select>
            </div>
        </div><!--fin campo  -->   
        
        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Codigo Producto (*)</label>
            <div class="col-sm-4">
                <select class="selectpicker form-control" data-style="btn btn-primary" name="siat_codigoProducto" id="siat_codigoProducto" data-live-search="true" required="true">
                    <option value="">Seleccione Producto</option>
                    <?php
                        $sql="SELECT sp.codigoProducto, CONCAT(LEFT(sp.descripcionProducto, 90),'...') as descripcionProducto
                                FROM siat_sincronizarlistaproductosservicios sp 
                                WHERE sp.cod_entidad='$cod_entidad'
                                AND sp.codigoActividad='$siat_codigoActividad'
                                ORDER BY 2";
                        $resp=mysqli_query($enlaceCon, $sql);
                        while ($dat = mysqli_fetch_array($resp)) {
                            $codigoX=$dat['codigoProducto'];
                            $nombreX=$dat['descripcionProducto'];
                        ?>
                        <option value="<?=$codigoX;?>" <?=$codigoX==$siat_codigoProducto?'selected':'';?>><?=$nombreX;?></option>  
                        <?php
                        }
                        ?>
                </select>
            </div>
            <label style="color:#566573;" class="col-sm-2 col-form-label">Unidad Medida (*)</label>
            <div class="col-sm-4">
                <select class="selectpicker form-control" data-style="btn btn-primary" name="siat_unidadMedida" id="siat_unidadMedida" data-live-search="true" required="true">
                    <option value="">Seleccione Unidad de Medida</option>
                    <?php
                        $sql="SELECT u.codigoClasificador, u.descripcion 
                                FROM siat_sincronizarparametricaunidadmedida u
                                ORDER BY 2";
                        $resp=mysqli_query($enlaceCon, $sql);
                        while ($dat = mysqli_fetch_array($resp)) {
                            $codigoX=$dat['codigoClasificador'];
                            $nombreX=$dat['descripcion'];
                        ?>
                        <option value="<?=$codigoX;?>" <?=$codigoX==$siat_unidadMedida?'selected':'';?>><?=$nombreX;?></option>  
                        <?php
                        }
                        ?>
                </select>
            </div>
        </div><!--fin campo  -->         

        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Descripción Unidad (*)</label>
            <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="siat_unidadProducto" id="siat_unidadProducto" required="true" value="<?=$siat_unidadProducto;?>" required="true" placeholder="Ingresar descripción de Unidad de Medida"/>
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
<script>
    /**
     * Lista de Actividad
     */
    $("#cod_entidad").change(function() {
        // Obtener los elementos de los selects
        var codActividadSelect = $("#siat_codigoActividad");
        var codProductoSelect  = $("#siat_codigoProducto");
        // Limpiar los selects
        codActividadSelect.empty();
        codProductoSelect.empty();

        let formData = new FormData();
        formData.append('cod_entidad', $(this).val());
        $.ajax({
            url:"ajax_actividad.php",
            type:"POST",
            contentType: false,
            processData: false,
            data: formData,
            success:function(response){
                let json = JSON.parse(response);
                console.log(json)
                
                // Leer el JSON y llenar los selects
                let option = $("<option>").val('')
                            .text('Seleccione una Actividad');
                codActividadSelect.append(option);
                $.each(json.data, function(index, actividad) {
                    let option = $("<option>")
                                    .val(actividad.codigoCaeb)
                                    .text(actividad.descripcion);
                    codActividadSelect.append(option);
                });
                
                // Actualizar los selectpicker
                codActividadSelect.selectpicker('refresh');
                codProductoSelect.selectpicker('refresh');
            }

        });
    });
    /**
     * Lista de Codigos de Productos
     */
    $("#siat_codigoActividad").change(function() {
        // Obtener los elementos de los selects
        var codProductoSelect  = $("#siat_codigoProducto");
        // Limpiar los selects
        codProductoSelect.empty();

        let formData = new FormData();
        formData.append('cod_entidad', $('#cod_entidad').val());
        formData.append('cod_actividad', $(this).val());
        $.ajax({
            url:"ajax_producto.php",
            type:"POST",
            contentType: false,
            processData: false,
            data: formData,
            success:function(response){
                let json = JSON.parse(response);
                console.log(json)
                
                // Leer el JSON y llenar los selects
                let option = $("<option>").val('')
                            .text('Seleccione Producto');
                codProductoSelect.append(option);
                $.each(json.data, function(index, actividad) {
                    let option = $("<option>")
                                    .val(actividad.codigoProducto)
                                    .text(actividad.descripcionProducto);
                    codProductoSelect.append(option);
                });
                
                // Actualizar los selectpicker
                codProductoSelect.selectpicker('refresh');
            }

        });
    });
    /**
     * Texto unidad de medida
     */
    $("#siat_unidadMedida").change(function() {
        var selectedText  = $(this).find("option:selected").text();
        var selectedValue = $(this).find("option:selected").val();
        if(selectedValue > 0){
            $("#siat_unidadProducto").val(selectedText);
        }else{
            $("#siat_unidadProducto").val('');
        }
        
    });

</script>