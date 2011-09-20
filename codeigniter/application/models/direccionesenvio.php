<?php
class Direccionesenvio extends DataMapper {
	var $table = 'direccionesenvio';
	var $has_one= array(
	'zona',
	'ciudad',
	'estado'); 
	var $has_many = array(
	'pedido',
	'usuario'=> array(
						'class'=>'usuario',
						'other_field' => 'direccionesenvio',		
			            'join_self_as' => 'direccionesenvio',		
			            'join_other_as' => 'usuario',	
			            'join_table' => 'usuarios_direccionesenvio')
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}
?>