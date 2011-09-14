<?php 
class Plato extends DataMapper {
	var $table = 'platos';
	var $has_one= array('tiendascomida'); 
	var $has_many = array(
	'promocion',
	'imagen',
	'calificacionesproducto',
	'favoritosusuario',
	'pedidos_plato');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}

?>