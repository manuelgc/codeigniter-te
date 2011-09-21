<?php
class Calificacionesproducto extends DataMapper{
	var $table = 'calificacionesproducto';
	var $has_one = array(
	'usuario'=> array(
            'class' => 'usuario',
            'other_field' => 'calificacionesproducto'),
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'calificacionesproducto'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}

}
?>