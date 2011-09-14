<?php
class Favoritosusuario extends DataMapper{
	var $table = 'favoritosusuario';
	var $has_one = array('usuario',
	'plato');
		
	function __construct($id = NULL) {
		parent::__construct($id);
	}
	
}
?>