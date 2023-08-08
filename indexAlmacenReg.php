<html>
<head>
	<meta charset="utf-8" />
	<title>MinkaSoftware</title> 
	    <link rel="shortcut icon" href="imagenes/icon_farma.ico" type="image/x-icon">
	<link type="text/css" rel="stylesheet" href="menuLibs/css/demo.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
	<style>  
	.boton-rojo
{
    text-decoration: none !important;
    padding: 10px !important;
    font-weight: 600 !important;
    font-size: 12px !important;
    color: #ffffff !important;
    background-color: #E73024 !important;
    border-radius: 3px !important;
    border: 2px solid #E73024 !important;
}
.boton-rojo:hover{
    color: #000000 !important;
    background-color: #ffffff !important;
  }
</style>
     <link rel="stylesheet" href="dist/css/demo.css" />
     <link rel="stylesheet" href="dist/mmenu.css" />
	 <link rel="stylesheet" href="dist/demo.css" />		
</head>
<body>
<?php
include("datosUsuario.php");
?>

<div id="page">
		
	<div class="" style='position: absolute;top:0px;left:0;width: 100%;background:  #5dade2 ;z-index:999999;'>
		<span style="color:white">
			<b><?=$nombreTiendaRopa;?>	</b>
		</span>
		
		
		<div style="position:absolute; width:95%; height:50px; text-align:right; top:0px; font-size: 11px; font-weight: bold; color: #fff;">
			<?php echo " ".$nombreUsuarioSesion?> <a href="reloj.php" target="contenedorPrincipal">[<?php echo $fechaSistemaSesion?>  <?php echo $horaSistemaSesion;?>]</a>
			<button onclick="location.href='salir.php'" style="position:relative;z-index:99999;right:0px;" class="boton-azul">Salir</button>          
		</div>
	</div>

	<div class="content">
		<iframe src="inicio_almacenes.php" name="contenedorPrincipal" id="mainFrame"  style="top:50px;" border="1"></iframe>	
	</div>
	<nav id="menu">
		<div id="panel-menu" >
			<ul>
				<li><span>Datos Generales</span>
					<ul>
						<li><a href="ciudades/empresas_list.php" target="contenedorPrincipal">Empresa</a></li>
						<li><a href="credenciales/credenciales_list.php" target="contenedorPrincipal">Credenciales</a></li>
						<li><a href="ciudades/list.php" target="contenedorPrincipal">Sucursales</a></li>
						<li><span>Adicionales</span>
						<ul>
							<li><a href="configuracion/list.php" target="contenedorPrincipal">Otras Configuraciones</a></li>
						</ul>
					</ul>	
				</li>
				<li><span>SIAT</span>
					<ul>
						<li><a href="siat_folder/siat_facturacion_offline/facturas_sincafc_list.php" target="contenedorPrincipal">Facturas Off-line</a></li>
						<li><a href="siat_folder/siat_facturacion_offline/facturas_cafc_list.php" target="contenedorPrincipal">Facturas Off-line CAFC</a></li>
						<li><a href="siat_folder/siat_sincronizacion/index.php" target="contenedorPrincipal">Sincronización</a></li>
						<li><a href="siat_folder/siat_puntos_venta/index.php" target="contenedorPrincipal">Puntos Venta</a></li>
						<li><a href="siat_folder/siat_cuis_cufd/index.php" target="contenedorPrincipal">Generación CUIS y CUFD</a></li>
					</ul>	
				</li>

				<li><span>Facturas SIAT</span>
				<ul>
					<li><a href="navegadorVentas.php" target="contenedorPrincipal">Listado de Ventas</a></li>
					<!-- <li><a href="registrar_salidaventas_manuales.php" target="_blank">Factura Manual de Contigencia</a></li> -->
				</ul>
				<li><span>Reportes SIAT</span>
				<ul>
					<li><a href="rptOpComprobantePorMes.php" target="contenedorPrincipal">Comprobantes</a></li>
					<!-- Ventas -->
					<li><a href="rptOpLibroVentas.php" target="contenedorPrincipal">Libro de Ventas</a></li>
					<!-- <li><a href="registrar_salidaventas_manuales.php" target="_blank">Factura Manual de Contigencia</a></li> -->
				</ul>				
			</li>
			</ul>
		</div>			
	</nav>
</div>
<script src="dist/mmenu.polyfills.js"></script>
<script src="dist/mmenu.js"></script>
<script src="dist/demo.js"></script>
	</body>
</html>