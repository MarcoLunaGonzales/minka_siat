<?php
namespace SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices;

use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\DocumentTypes;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\conexionSiatUrl;

class CompraVenta extends SiatInvoice
{
	public function __construct()
	{
		parent::__construct();
		//Update isp - sector educacion
		// $this->classAlias 				= 'facturaComputarizadaSectorEducativo';
		// $this->cabecera->codigoDocumentoSector 	= 11;
		$this->classAlias 				= 'facturaComputarizadaCompraVenta';
		$this->cabecera->codigoDocumentoSector 	= DocumentTypes::FACTURA_COMPRA_VENTA;
		$this->endpoint=conexionSiatUrl::wsdlFacturacionComputarizada;
	}
	public function validate()
	{
		parent::validate();
	}
}
