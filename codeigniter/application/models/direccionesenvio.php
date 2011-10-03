<?php
class Direccionesenvio extends DataMapper {
	var $table = 'direccionesenvio';
	var $has_one= array(
	'zona'=> array(
            'class' => 'zona',
            'other_field' => 'direccionesenvio',
			'join_other_as' => 'zona'),
	'ciudad'=> array(
            'class' => 'ciudad',
            'other_field' => 'direccionesenvio',
			'join_other_as' => 'ciudades'),
	'estado'=> array(
            'class' => 'estado',
            'other_field' => 'direccionesenvio',
			'join_other_as' => 'estado'),
	'usuario'=> array(
						'class'=>'usuario',
						'other_field' => 'direccionesenvio',		
			            'join_other_as' => 'usuarios')); 
	var $has_many = array(
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'direccionesenvio',
			'join_other_as' => 'direccionesenvio',
			'join_self_as' => 'direccionenvio')	
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
	
}
?>