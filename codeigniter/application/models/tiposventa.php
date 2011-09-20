<?php
class Tiposventa extends DataMapper{
	var $table = 'tiposventa';
	var $has_many = array('pedido',
//	'tiendascomida_tiposventa'
	'tiendascomida'=> array(
						'class'=>'tiendascomida',
						'other_field' => 'tiposventa',		
			            'join_self_as' => 'tiposventa',		
			            'join_other_as' => 'tiendascomida',	
			            'join_table' => 'tiendascomida_tiposventa'),
	
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>