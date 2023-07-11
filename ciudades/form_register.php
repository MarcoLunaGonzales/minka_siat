<?php
require("../estilos_almacenes.inc");

$globalIdEntidad = $_COOKIE['globalIdEntidad'];

$descripcion = "";

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
      <form id="form1" class="form-horizontal" action="sucursal_save.php" method="post" >
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
                <input class="form-control" type="text" name="descripcion" id="descripcion" required="true" placeholder="Ingrese el nombre de la sucursal" required="true"/>
            </div>
            </div>
            <label style="color:#566573;" class="col-sm-2 col-form-label">Cod Sucursal (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="number" name="cod_ciudad" id="cod_ciudad" required="true" placeholder="Ingrese el codigo de sucursal" required="true" placeholder="PROPIO, PROVEEDOR"/>
            </div>
            </div>
        </div><!--fin campo  -->

        <div class="row">
            <!--fin campo  -->
            <label style="color:#566573;" class="col-sm-2 col-form-label">Dirección (*)</label>
            <div class="col-sm-4">
            <div class="form-group">
                <input class="form-control" type="text" name="direccion" id="direccion" required="true" placeholder="Ingresar dirección"/>
            </div>
            </div>
            <label style="color:#566573;" class="col-sm-2 col-form-label">Ciudad (*)</label>
            <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="nombre_ciudad" id="nombre_ciudad" required="true" placeholder="Ingresar el nombre de la ciudad" required="true"/>
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
                        <option value="<?=$codigoX;?>"><?=$nombreX;?></option>  
                        <?php
                        }
                        ?>
                </select>
            </div>
            <label style="color:#566573;" class="col-sm-2 col-form-label">Codigo Actividad (*)</label>
            <div class="col-sm-4">
                <select class="selectpicker form-control" data-style="btn btn-primary" name="siat_codigoActividad" id="siat_codigoActividad" data-live-search="true" required="true">
                    <option value="">Seleccione Actividad</option>
                </select>
            </div>
        </div><!--fin campo  -->   
        
        <div class="row">
            <label style="color:#566573;" class="col-sm-2 col-form-label">Codigo Producto (*)</label>
            <div class="col-sm-4">
                <select class="selectpicker form-control" data-style="btn btn-primary" name="siat_codigoProducto" id="siat_codigoProducto" data-live-search="true" required="true">
                    <option value="">Seleccione Producto</option>
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
                        <option value="<?=$codigoX;?>"><?=$nombreX;?></option>  
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
                    <input class="form-control" type="text" name="siat_unidadProducto" id="siat_unidadProducto" required="true" required="true" placeholder="Ingresar descripción de Unidad de Medida"/>
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