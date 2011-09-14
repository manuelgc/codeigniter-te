<?php
class Extrasplato_pedido extends DataMapper{
	var $table = 'extrasplato_pedido';
	var $has_one= array(
	'extrasplato',
	'pedido'); 
	
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>