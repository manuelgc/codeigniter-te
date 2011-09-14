<?php
class Pedido extends DataMapper{
	var $table = 'pedidos';
	var $has_one= array(
	'usuario',
	'direccionesenvio',
	'tipospago',
	'tiposventa',
	'estadospedido',
	'tiendascomida'); 
	var $has_many = array(
	'pedidos_plato',
	'extrasplato_pedido');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>