<?php
class Estadospedido extends DataMapper{
	var $table = 'estadospedido';
	var $has_many = array('pedido');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>