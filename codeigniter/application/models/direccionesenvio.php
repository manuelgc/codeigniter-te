<?php
class Direccionesenvio extends DataMapper {
	var $table = 'direccionesenvio';
	var $has_one= array(
	'zona',
	'ciudad',
	'estado'); 
	var $has_many = array(
	'usuarios_direccionesenvio',
	'pedido');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}
?>