<?php 
class Imagen extends DataMapper {
	var $table = 'imagenes';
	var $has_one = array(
	'plato',
	'promocion',
	'extrasplato',
	'tiendascomida');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}
?>