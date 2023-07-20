<?php
require("../conexionmysqli.inc");
require("../estilos_almacenes.inc");

$globalIdEntidad = $_COOKIE['globalIdEntidad'];

$cod_ciudad = $_GET['codigo']; // Sucursal

$datos = array(
    'nombre'      => '',
    'sucursal'    => '',
    'direccion'   => '',
    'telefono'    => '',
    'ciudad'      => '',
    'txt1'        => '',
    'txt2'        => '',
    'txt3'        => '',
    'nit'         => '',
    'propietario' => '',
    'test'        => ''
);

$sql  = "SELECT tipo, valor
         FROM configuracion_facturas
         WHERE cod_ciudad = '$cod_ciudad'";
$resp = mysqli_query($enlaceCon, $sql);
while ($data = mysqli_fetch_array($resp)) {
    $tipo  = $data['tipo'];
    $valor = $data['valor'];
    if (array_key_exists($tipo, $datos)) {
        $datos[$tipo] = $valor;
    }
}

// Ahora puedes acceder a los valores de cada campo utilizando el arreglo asociativo $datos
$nombre      = $datos['nombre'];
$sucursal    = $datos['sucursal'];
$direccion   = $datos['direccion'];
$telefono    = $datos['telefono'];
$ciudad      = $datos['ciudad'];
$txt1        = $datos['txt1'];
$txt2        = $datos['txt2'];
$txt3        = $datos['txt3'];
$nit         = $datos['nit'];
$propietario = $datos['propietario'];
$test        = $datos['test'];

?>

<div class="content">
  <div class="container-fluid">
    <div class="col-md-12">
      <form id="form1" class="form-horizontal" action="config_sucursal_update.php" method="post" >

        <!-- Registor de Modificación -->
        <input type="hidden" value="<?=$cod_ciudad;?>" name="codigo">

      <div class="card" style="background:  #e8daef ">
        <div class="card-header  card-header-text">
            <div class="card-text">
                <h4 class="card-title">Configuración de Sucursal</h4>
            </div>
        </div>
        <div class="card-body ">
            <div class="row">
                <label style="color:#566573;" class="col-sm-2 col-form-label">Nombre (*)</label>
                <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="nombre" id="nombre" required="true" value="<?=$nombre;?>" placeholder="Ingrese el nombre" required="true"/>
                </div>
                </div>
                <label style="color:#566573;" class="col-sm-2 col-form-label">Sucursal (*)</label>
                <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="sucursal" id="sucursal" required="true" value="<?=$sucursal;?>" required="true" placeholder="Ingrese sucursal"/>
                </div>
                </div>
            </div>
            <div class="row">
                <label style="color:#566573;" class="col-sm-2 col-form-label">Dirección (*)</label>
                <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="direccion" id="direccion" required="true" value="<?=$direccion;?>" placeholder="Ingrese el direccion" required="true"/>
                </div>
                </div>
                <label style="color:#566573;" class="col-sm-2 col-form-label">Teléfono (*)</label>
                <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="telefono" id="telefono" required="true" value="<?=$telefono;?>" required="true" placeholder="Ingrese teléfono"/>
                </div>
                </div>
            </div>
            <div class="row">
                <label style="color:#566573;" class="col-sm-2 col-form-label">Ciudad (*)</label>
                <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="ciudad" id="ciudad" required="true" value="<?=$ciudad;?>" placeholder="Ingrese el ciudad" required="true"/>
                </div>
                </div>
                <label style="color:#566573;" class="col-sm-2 col-form-label">Descripción 1 (*)</label>
                <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="txt1" id="txt1" required="true" value="<?=$txt1;?>"required="true" placeholder="Ingrese descripcion"/>
                </div>
                </div>
            </div>
            <div class="row">
                <label style="color:#566573;" class="col-sm-2 col-form-label">Descripción 2 (*)</label>
                <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="txt2" id="txt2" required="true" value="<?=$txt2;?>" placeholder="Ingrese texto" required="true"/>
                </div>
                </div>
                <label style="color:#566573;" class="col-sm-2 col-form-label">Pie de página (*)</label>
                <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="txt3" id="txt3" required="true" value="<?=$txt3;?>" required="true" placeholder="Ingrese descripción"/>
                </div>
                </div>
            </div>
            <div class="row">
                <label style="color:#566573;" class="col-sm-2 col-form-label">NIT (*)</label>
                <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="nit" id="nit" required="true" value="<?=$nit;?>" placeholder="Ingrese nit" required="true"/>
                </div>
                </div>
                <label style="color:#566573;" class="col-sm-2 col-form-label">Propietario (*)</label>
                <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="propietario" id="propietario" required="true" value="<?=$propietario;?>" required="true" placeholder="Ingrese propietario"/>
                </div>
                </div>
            </div>
            <div class="row">
                <label style="color:#566573;" class="col-sm-2 col-form-label">Descripción 3 (*)</label>
                <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="test" id="test" required="true" value="<?=$test;?>" placeholder="Ingrese texto" required="true"/>
                </div>
                </div>
            </div>

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