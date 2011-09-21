<?php
class Extrasplato extends DataMapper{ 
	var $table = 'extrasplato';
	var $has_one= array(
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'extrasplato')
	); 
	var $has_many = array(
	'imagen'=> array(
            'class' => 'imagen',
            'other_field' => 'extrasplato'),
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'extrasplato'
			'join_self_as' => 'extrasplato',		
			'join_other_as' => 'pedido',	
			'join_table' => 'extrasplato_pedido'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}