<?php
class Categoriaplato extends Datamapper{
	var $table = 'categoriaplatos';
	var $has_many = array(
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'categoriaplato')

	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}
	
}
?>