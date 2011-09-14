<?php
class Tiendascomida extends DataMapper{
	var $table = 'tiendascomida';
	var $has_one= array(
	'estado',
	'ciudad',
	'zona'); 
	var $has_many = array(
	'clasificacionestienda',
	'plato',
	'imagen',
	'extrasplato',
	'horariosdespacho',
	'tiendascomida_tipotiendascomida',
	'direccionesentrega',
	'pedido');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>