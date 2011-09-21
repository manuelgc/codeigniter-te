<?php
class Clasificacionestienda extends DataMapper{
	var $table = 'clasificacionestienda';
	var $has_one = array(
	'usuario'=> array(
            'class' => 'usuario',
            'other_field' => 'clasificacionestienda'),
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'clasificacionestienda'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}

}
?>