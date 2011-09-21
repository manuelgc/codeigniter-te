<?php
class Pedido extends DataMapper{
	var $table = 'pedidos';
	var $has_one= array(
	'usuario'=> array(
            'class' => 'usuario',
            'other_field' => 'pedido'),
	'direccionesenvio'=> array(
            'class' => 'direccionesenvio',
            'other_field' => 'pedido'),
	'tipospago'=> array(
            'class' => 'tipospago',
            'other_field' => 'pedido'),
	'tiposventa'=> array(
            'class' => 'tiposventa',
            'other_field' => 'pedido'),
	'estadospedido'=> array(
            'class' => 'estadospedido',
            'other_field' => 'pedido'),
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'pedido')); 
	var $has_many = array(
	'plato'=> array(
			'class'=>'plato',
			'other_field' => 'pedido',		
	        'join_self_as' => 'pedido',		
	        'join_other_as' => 'plato',	
	        'join_table' => 'pedidos_platos'),
	'extrasplato'=> array(
            'class' => 'extrasplato',
            'other_field' => 'pedido',
			'join_self_as' => 'pedido',		
			'join_other_as' => 'extrasplato',	
			'join_table' => 'extrasplato_pedido'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>