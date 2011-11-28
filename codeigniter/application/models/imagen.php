<?php 
class Imagen extends DataMapper {
	var $table = 'imagenes';
	var $has_one = array(
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'imagen',
			'join_other_as' => 'plato',
			'join_self_as' => 'imagenes'),
	'promocion'=> array(
            'class' => 'promocion',
            'other_field' => 'imagen'),
	'extrasplato'=> array(
            'class' => 'extrasplato',
            'other_field' => 'imagen'),
	'tiendascomida' => array(
            'class' => 'tiendascomida',
            'other_field' => 'imagen',			
			'join_other_as' => 'tiendascomida'
			)
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}
?>