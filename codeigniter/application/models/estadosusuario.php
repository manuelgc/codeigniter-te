<?php
class Estadosusuario extends DataMapper {
	var $table = 'estadosusuario';
	var $has_many= array('usuario'); 
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}
?>