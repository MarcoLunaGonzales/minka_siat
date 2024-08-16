<?php
namespace SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices;

use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\DocumentTypes;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\conexionSiatUrl;

class CompraVenta extends SiatInvoice
{
	public function __construct()
	{
		parent::__construct();
		$this->classAlias 						= 'facturaComputarizadaHospitalClinica'; // HospitalClinica
		$this->cabecera->codigoDocumentoSector 	= 17;
		$this->endpoint=conexionSiatUrl::wsdlFacturacionComputarizada;
	}
	public function validate()
	{
		parent::validate();
	}
}
