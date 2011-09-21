<?php
class Horariosdespacho extends DataMapper{
	var $table = 'horariosdespacho';
	var $has_one= array(
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'horariosdespacho')); 
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}