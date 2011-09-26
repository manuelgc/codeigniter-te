<?php
class Direccionesenvio extends DataMapper {
	var $table = 'direccionesenvio';
	var $has_one= array(
	'zona'=> array(
            'class' => 'zona',
            'other_field' => 'direccionesenvio'),
	'ciudad'=> array(
            'class' => 'ciudad',
            'other_field' => 'direccionesenvio'),
	'estado'=> array(
            'class' => 'estado',
            'other_field' => 'direccionesenvio'),
	'usuario'=> array(
						'class'=>'usuario',
						'other_field' => 'direccionesenvio',		
			            'join_other_as' => 'usuario')); 
	var $has_many = array(
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'direccionesenvio')	
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}
?>