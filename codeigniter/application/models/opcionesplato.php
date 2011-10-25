<?php
class Opcionesplato extends DataMapper{ 
	var $table = 'opcionesplato';

	var $has_one= array(
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'opcionesplato',
			'join_other_as' => 'platos',
			'join_self_as' => 'opcionesplato'));
	
	var $has_many = array(
	'opcionesdetalle'=> array(
            'class' => 'opcionesdetalle',
            'other_field' => 'opcionesplato',
			'join_self_as' => 'opcionesplato'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}
?>