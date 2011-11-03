<?php
class Impuesto extends Datamapper{
	var $table = 'impuesto';
	var $has_many = array(
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'impuesto',
			'join_self_as' => 'impuesto')

	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}
?>