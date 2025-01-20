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
	public	$cantidad;
	public	$unidadMedida;
	public	$precioUnitario;
	public	$montoDescuento;
	public	$subTotal;
	
	// public	$numeroSerie;//se quito esto para educacion
	// public	$numeroImei;//se quito esto para educacion
	//update isp
	public	$numeroSerie;
	public	$numeroImei;

	public function __construct()
	{
		// $this->unidadMedida	= 57;
		$this->unidadMedida	= 58;//update isp
	}
	public function validate()
	{
		
	}
}