<?php
class Pedidos_plato extends DataMapper{
	var $table = 'pedidos_platos';
	var $has_one= array(
	'pedido',
	'plato'); 
	var $has_many = array(
	'extrasdetalle'=> array(
						'class'=>'extrasdetalle',
						'other_field' => 'pedidos_plato',		
			            'join_self_as' => 'pedidos_platos',		
			            'join_other_as' => 'extrasdetalle',	
			            'join_table' => 'pedido_plato_extra'),
	'opcionesdetalle'=> array(
						'class'=>'opcionesdetalle',
						'other_field' => 'pedidos_plato',		
			            'join_self_as' => 'pedidos_platos',		
			            'join_other_as' => 'opcionesdetalle',	
			            'join_table' => 'pedido_plato_opciones'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>