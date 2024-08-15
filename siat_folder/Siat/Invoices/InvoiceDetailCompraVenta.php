<?php
namespace SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices;

use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Message;


//este archivo se queda
class InvoiceDetailCompraVenta extends Message
{
	public	$actividadEconomica;
	public	$codigoProductoSin;
	public	$codigoProducto;
	public	$descripcion;
	// Datos de Sector Hospitales Clínicas
	public  $especialidad;
	public  $especialidadDetalle;
	public  $nroQuirofanoSalaOperaciones;
	public  $especialidadMedico;
	public  $nombreApellidoMedico;
	public  $nitDocumentoMedico;
	public  $nroMatriculaMedico;
	public  $nroFacturaMedico;
	
	public	$cantidad;
	public	$unidadMedida;
	public	$precioUnitario;
	public	$montoDescuento;
	public	$subTotal;

	public function __construct()
	{
		$this->unidadMedida	= 58; // UNIDAD (SERVICIOS)
	}
	public function validate()
	{
		
	}
}