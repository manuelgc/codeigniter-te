<?php
class Extrasdetalle extends DataMapper{
	var $table = 'extrasdetalle';
	var $has_one= array(
	'extra'=> array(
            'class' => 'extra',
            'other_field' => 'extrasdetalle',
			'join_other_as' => 'extras',
			'join_self_as' => 'extrasdetalle')); 
	var $has_many = array(
	'pedidos_plato'=> array(
						'class'=>'pedidos_plato',
						'other_field' => 'extrasdetalle',		
			            'join_self_as' => 'extrasdetalle',		
			            'join_other_as' => 'pedidos_platos',	
			            'join_table' => 'pedido_plato_extra'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>