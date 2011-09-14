<?php
class Calificacionesproducto extends DataMapper{
	var $table = 'calificacionesproducto';
	var $has_one = array('usuario',
	'plato');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}

}
?>