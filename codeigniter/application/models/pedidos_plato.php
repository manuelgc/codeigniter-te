<?php
class Pedidos_plato extends DataMapper{
	var $table = 'pedidos_platos';
	var $has_one= array(
	'pedido',
	'plato'); 

	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>