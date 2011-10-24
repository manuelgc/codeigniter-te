<?php
class Pedidos_plato extends DataMapper{
	var $table = 'pedidos_platos';
	var $has_one= array(
	'pedido',
	'plato'); 
	var $has_many = array(
	'plato_extra'=> array(
						'class'=>'plato_extra',
						'other_field' => 'pedidos_plato',		
			            'join_self_as' => 'pedidos_plato',		
			            'join_other_as' => 'plato_extra',	
			            'join_table' => 'pedido_plato_extra'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>