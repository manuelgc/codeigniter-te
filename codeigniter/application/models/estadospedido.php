<?php
class Estadospedido extends DataMapper{
	var $table = 'estadospedido';
	var $has_many = array(
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'estadospedido'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>