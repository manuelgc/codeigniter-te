<?php
class Tiendascomida extends DataMapper{
	var $table = 'tiendascomida';
	var $has_one= array(
	'estado'=> array(
            'class' => 'estado',
            'other_field' => 'tiendascomida'),
	'ciudad'=> array(
            'class' => 'ciudad',
            'other_field' => 'tiendascomida'),
	'zona'=> array(
            'class' => 'zona',
            'other_field' => 'tiendascomida')); 
	var $has_many = array(
	'clasificacionestienda'=> array(
            'class' => 'clasificacionestienda',
            'other_field' => 'tiendascomida'),
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'tiendascomida'),
	'imagen' => array(
            'class' => 'imagen',
            'other_field' => 'tiendascomida'),
	'extrasplato'=> array(
            'class' => 'extrasplato',
            'other_field' => 'tiendascomida'),
	'horariosdespacho'=> array(
            'class' => 'horariosdespacho',
            'other_field' => 'tiendascomida'),
	'direccionesentrega'=> array(
            'class' => 'direccionesentrega',
            'other_field' => 'tiendascomida'),
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'tiendascomida'),
	'tipotiendascomida'=> array(
						'class'=>'tipotiendascomida',
						'other_field' => 'tiendascomida',		
			            'join_self_as' => 'tiendascomida',		
			            'join_other_as' => 'tipotiendascomida',	
			            'join_table' => 'tiendascomida_tipotiendascomida'),
	'tiposventa'=> array(
						'class'=>'tiposventa',
						'other_field' => 'tiendascomida',		
			            'join_self_as' => 'tiendascomida',		
			            'join_other_as' => 'tiposventa',	
			            'join_table' => 'tiendascomida_tiposventa'),		
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>