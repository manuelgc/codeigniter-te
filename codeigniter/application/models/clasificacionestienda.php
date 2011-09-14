<?php
class Clasificacionestienda extends DataMapper{
	var $table = 'clasificacionestienda';
	var $has_one = array('usuario',
	'tiendascomida');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}

}
?>