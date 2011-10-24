<?php
class Plato_extra extends DataMapper{
	var $table = 'plato_extra';
	var $has_one= array(
	'extra'=> array(
            'class' => 'extra',
            'other_field' => 'plato_extra',
			'join_other_as' => 'extras',
			'join_self_as' => 'plato_extra'),
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'plato_extra',
			'join_other_as' => 'platos',
			'join_self_as' => 'plato_extra')); 
	var $has_many = array(
	'pedidos_plato'=> array(
						'class'=>'pedidos_plato',
						'other_field' => 'plato_extra',		
			            'join_self_as' => 'plato_extra',		
			            'join_other_as' => 'pedidos_plato',	
			            'join_table' => 'pedido_plato_extra'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>