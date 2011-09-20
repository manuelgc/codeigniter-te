<?php
class Tiendascomida extends DataMapper{
	var $table = 'tiendascomida';
	var $has_one= array(
	'estado',
	'ciudad',
	'zona'); 
	var $has_many = array(
	'clasificacionestienda',
	'plato',
	'imagen',
	'extrasplato',
	'horariosdespacho',
	'direccionesentrega',
	'pedido',
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
			            'join_table' => 'tiendascomida_tiposventa')
	
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>