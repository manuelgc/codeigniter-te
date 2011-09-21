<?php
class Favoritosusuario extends DataMapper{
	var $table = 'favoritosusuario';
	var $has_one = array(
	'usuario'=> array(
            'class' => 'usuario',
            'other_field' => 'favoritosusuario'),
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'favoritosusuario'));
		
	function __construct($id = NULL) {
		parent::__construct($id);
	}
	
}
?>