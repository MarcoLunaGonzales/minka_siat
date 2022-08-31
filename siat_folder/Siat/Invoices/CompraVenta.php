<?php
namespace SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices;

use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\DocumentTypes;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\conexionSiatUrl;

class CompraVenta extends SiatInvoice
{
	public function __construct()
	{
		parent::__construct();
		$this->classAlias 				= 'facturaComputarizadaSectorEducativo';
		$this->cabecera->codigoDocumentoSector 	= 11;
		// $this->endpoint					= 'https://pilotosiatservicios.impuestos.gob.bo/v2/ServicioFacturacionCompraVenta?wsdl';
		$this->endpoint=conexionSiatUrl::wsdlCompraVenta;
	}
	public function validate()
	{
		parent::validate();
	}
}
