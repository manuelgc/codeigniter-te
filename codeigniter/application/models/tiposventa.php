<?php
class Tiposventa extends DataMapper{
	var $table = 'tiposventa';
	var $has_many = array('pedido');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>