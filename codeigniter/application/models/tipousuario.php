<?php
class Tipousuario extends DataMapper {
	var $table = 'tipousuarios';
	var $has_many = array('usuario');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
	
}
?>