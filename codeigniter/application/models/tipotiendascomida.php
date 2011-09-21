<?php
class Tipotiendascomida extends DataMapper{ 	
var $table = 'tipotiendascomida';
	var $has_many = array(
	'tiendascomida'=> array(
						'class'=>'tiendascomida',
						'other_field' => 'tipotiendascomida',	
			            'join_self_as' => 'tipotiendascomida',	
			            'join_other_as' => 'tiendascomida',		
			            'join_table' => 'tiendascomida_tipotiendascomida')
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}