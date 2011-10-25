<?php
class Opcionesdetalle extends DataMapper{
	var $table = 'opcionesdetalle';
	var $has_one= array(
	'opcionesplato'=> array(
            'class' => 'opcionesplato',
            'other_field' => 'opcionesdetalle',
			'join_other_as' => 'opcionesplato',
			'join_self_as' => 'opcionesdetalle')); 
	var $has_many = array(
	'pedidos_plato'=> array(
						'class'=>'pedidos_plato',
						'other_field' => 'opcionesdetalle',		
			            'join_self_as' => 'opcionesdetalle',		
			            'join_other_as' => 'pedidos_platos',	
			            'join_table' => 'pedido_plato_opciones'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>