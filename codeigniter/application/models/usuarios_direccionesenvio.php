<?php
class Usuarios_direccionesenvio extends DataMapper{
	var $table = 'usuarios_direccionesenvio';
	var $has_one= array(
	'usuario',
	'direccionesenvio'); 
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}
?>